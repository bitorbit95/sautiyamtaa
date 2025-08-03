<?php

namespace App\Services;

use App\Models\Donation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class MpesaService
{
    private $consumerKey;
    private $consumerSecret;
    private $businessShortCode;
    private $passkey;
    private $callbackUrl;
    private $environment;

    public function __construct()
    {
        $this->consumerKey = config('mpesa.consumer_key');
        $this->consumerSecret = config('mpesa.consumer_secret');
        $this->businessShortCode = config('mpesa.business_short_code');
        $this->passkey = config('mpesa.passkey');
        $this->callbackUrl = config('mpesa.callback_url');
        $this->environment = config('mpesa.environment', 'sandbox');
    }

    /**
     * Validate M-Pesa configuration
     */
    private function validateConfig(): array
    {
        $errors = [];
        
        if (empty($this->consumerKey)) {
            $errors[] = 'Consumer Key is missing';
        }
        
        if (empty($this->consumerSecret)) {
            $errors[] = 'Consumer Secret is missing';
        }
        
        if (empty($this->businessShortCode)) {
            $errors[] = 'Business Short Code is missing';
        }
        
        if (empty($this->passkey)) {
            $errors[] = 'Passkey is missing';
        }
        
        if (empty($this->callbackUrl)) {
            $errors[] = 'Callback URL is missing';
        }
        
        return $errors;
    }

    /**
     * Get M-Pesa access token with enhanced error handling and caching
     */
    private function getAccessToken(): string
    {
        // Check for cached token first
        $cacheKey = 'mpesa_access_token_' . $this->environment;
        $cachedToken = cache()->get($cacheKey);
        
        if ($cachedToken) {
            Log::info('Using cached M-Pesa access token');
            return $cachedToken;
        }

        // Validate configuration first
        $configErrors = $this->validateConfig();
        if (!empty($configErrors)) {
            throw new Exception('M-Pesa configuration errors: ' . implode(', ', $configErrors));
        }

        $url = $this->environment === 'production' 
            ? 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
            : 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);

        Log::info('Requesting new M-Pesa access token', [
            'url' => $url,
            'environment' => $this->environment,
            'consumer_key' => substr($this->consumerKey, 0, 10) . '...',
            'credentials_length' => strlen($credentials)
        ]);

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Basic ' . $credentials,
                    'Content-Type' => 'application/json',
                    'Cache-Control' => 'no-cache',
                ])
                ->get($url);

            Log::info('M-Pesa token response', [
                'status' => $response->status(),
                'response_body' => $response->body(),
                'content_type' => $response->header('Content-Type')
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                
                if (isset($responseData['access_token'])) {
                    $accessToken = trim($responseData['access_token']); // Trim any whitespace
                    $expiresIn = $responseData['expires_in'] ?? 3600; // Default 1 hour
                    
                    // Validate token format
                    if (empty($accessToken) || strlen($accessToken) < 10) {
                        throw new Exception('Invalid access token format received');
                    }
                    
                    // Cache the token for slightly less time than its expiry to be safe
                    $cacheTime = ($expiresIn - 300); // 5 minutes buffer
                    cache()->put($cacheKey, $accessToken, $cacheTime);
                    
                    Log::info('M-Pesa access token obtained and cached', [
                        'expires_in' => $expiresIn,
                        'cache_time' => $cacheTime,
                        'token_length' => strlen($accessToken),
                        'token_preview' => substr($accessToken, 0, 8) . '...'
                    ]);
                    
                    return $accessToken;
                } else {
                    Log::error('M-Pesa token response missing access_token', [
                        'response' => $responseData
                    ]);
                    throw new Exception('Access token not found in response');
                }
            }

            // Handle different HTTP status codes
            $errorMessage = $this->getErrorMessage($response->status(), $response->body());
            
            Log::error('M-Pesa token request failed', [
                'status' => $response->status(),
                'response' => $response->body(),
                'headers' => $response->headers()
            ]);

            throw new Exception($errorMessage);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('M-Pesa connection error', ['error' => $e->getMessage()]);
            throw new Exception('Connection to M-Pesa API failed. Please check your internet connection.');
        } catch (\Illuminate\Http\Client\RequestException $e) {
            Log::error('M-Pesa request error', ['error' => $e->getMessage()]);
            throw new Exception('Request to M-Pesa API failed: ' . $e->getMessage());
        }
    }

    /**
     * Get user-friendly error message based on HTTP status code
     */
    private function getErrorMessage(int $statusCode, string $responseBody): string
    {
        switch ($statusCode) {
            case 400:
                return 'Bad request - Invalid credentials or request format';
            case 401:
                return 'Unauthorized - Invalid consumer key or secret';
            case 403:
                return 'Forbidden - Access denied';
            case 404:
                return 'Not found - Invalid API endpoint';
            case 429:
                return 'Too many requests - Rate limit exceeded';
            case 500:
                return 'Internal server error - M-Pesa service unavailable';
            case 502:
            case 503:
            case 504:
                return 'Service temporarily unavailable - Please try again later';
            default:
                return "HTTP {$statusCode} error: " . (!empty($responseBody) ? $responseBody : 'Unknown error');
        }
    }

    /**
     * Generate password for STK push
     */
    private function generatePassword(): string
    {
        return base64_encode($this->businessShortCode . $this->passkey . date('YmdHis'));
    }

    /**
     * Initiate STK push for donation with enhanced error handling
     */
    public function initiateSTKPush(Donation $donation): array
    {
        try {
            // Validate phone number format
            $phoneNumber = $this->formatPhoneNumber($donation->mpesa_phone);
            if (!$phoneNumber) {
                return [
                    'success' => false,
                    'message' => 'Invalid phone number format. Please use format: 254XXXXXXXXX',
                ];
            }

            $accessToken = $this->getAccessToken();
            
            $url = $this->environment === 'production'
                ? 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest'
                : 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

            $timestamp = date('YmdHis');
            $password = base64_encode($this->businessShortCode . $this->passkey . $timestamp);

            $payload = [
                'BusinessShortCode' => $this->businessShortCode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => (int) $donation->amount,
                'PartyA' => $phoneNumber,
                'PartyB' => $this->businessShortCode,
                'PhoneNumber' => $phoneNumber,
                'CallBackURL' => $this->callbackUrl,
                'AccountReference' => $donation->transaction_id,
                'TransactionDesc' => 'Donation - ' . $donation->name,
            ];

            Log::info('Initiating STK Push', [
                'donation_id' => $donation->id,
                'amount' => $donation->amount,
                'phone' => $phoneNumber,
                'url' => $url,
                'token_length' => strlen($accessToken),
                'token_preview' => substr($accessToken, 0, 8) . '...',
                'headers' => [
                    'Authorization' => 'Bearer ' . substr($accessToken, 0, 8) . '...',
                    'Content-Type' => 'application/json',
                ],
                'payload' => array_merge($payload, ['Password' => '[HIDDEN]']) // Hide password in logs
            ]);

            $response = Http::timeout(60) // Increase timeout for STK push
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ])
                ->post($url, $payload);

            Log::info('STK Push response', [
                'donation_id' => $donation->id,
                'status' => $response->status(),
                'response' => $response->json()
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                
                if (isset($responseData['ResponseCode']) && $responseData['ResponseCode'] === '0') {
                    // Update donation with checkout request ID
                    $donation->update([
                        'mpesa_checkout_request_id' => $responseData['CheckoutRequestID'],
                        'payment_data' => array_merge(
                            $donation->payment_data ?? [],
                            ['stk_push_response' => $responseData]
                        )
                    ]);

                    return [
                        'success' => true,
                        'checkout_request_id' => $responseData['CheckoutRequestID'],
                        'merchant_request_id' => $responseData['MerchantRequestID'],
                        'message' => 'STK push sent successfully. Please check your phone.',
                    ];
                } else {
                    // Handle M-Pesa error codes
                    $errorMessage = $this->getMpesaErrorMessage($responseData['ResponseCode'] ?? '', $responseData['ResponseDescription'] ?? '');
                    
                    return [
                        'success' => false,
                        'message' => $errorMessage,
                        'error' => $responseData
                    ];
                }
            }

            $errorMessage = $this->getErrorMessage($response->status(), $response->body());
            
            Log::error('M-Pesa STK Push failed', [
                'donation_id' => $donation->id,
                'response' => $response->json(),
                'status' => $response->status()
            ]);

            return [
                'success' => false,
                'message' => $errorMessage,
                'error' => $response->json()
            ];

        } catch (Exception $e) {
            Log::error('M-Pesa STK Push exception', [
                'donation_id' => $donation->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Payment service unavailable: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Format phone number to M-Pesa format
     */
    private function formatPhoneNumber(string $phone): ?string
    {
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Handle different formats
        if (strlen($phone) === 10 && substr($phone, 0, 1) === '0') {
            // Convert 07XXXXXXXX to 2547XXXXXXXX
            return '254' . substr($phone, 1);
        } elseif (strlen($phone) === 9) {
            // Convert 7XXXXXXXX to 2547XXXXXXXX
            return '254' . $phone;
        } elseif (strlen($phone) === 12 && substr($phone, 0, 3) === '254') {
            // Already in correct format
            return $phone;
        }
        
        return null; // Invalid format
    }

    /**
     * Get user-friendly M-Pesa error message
     */
    private function getMpesaErrorMessage(string $responseCode, string $responseDescription): string
    {
        $errorMessages = [
            '1' => 'Insufficient funds in your M-Pesa account',
            '2' => 'Less than minimum transaction value',
            '3' => 'More than maximum transaction value',
            '4' => 'Would exceed daily transfer limit',
            '5' => 'Would exceed minimum balance',
            '6' => 'Unresolved primary party',
            '7' => 'Unresolved receiver party',
            '8' => 'Would exceed maximum balance',
            '11' => 'Debit account invalid',
            '12' => 'Credit account invalid',
            '13' => 'Unresolved debit account',
            '14' => 'Unresolved credit account',
            '15' => 'Duplicate detected',
            '17' => 'Internal failure',
            '20' => 'Unresolved initiator',
            '26' => 'Traffic blocking condition in place',
            '1032' => 'Request cancelled by user',
            '1037' => 'DS timeout',
        ];

        return $errorMessages[$responseCode] ?? $responseDescription ?: 'Payment failed. Please try again.';
    }

    /**
     * Handle M-Pesa callback
     */
    public function handleCallback(array $callbackData): void
    {
        try {
            Log::info('Received M-Pesa callback', $callbackData);
            
            $stkCallback = $callbackData['Body']['stkCallback'] ?? null;
            
            if (!$stkCallback) {
                Log::warning('Invalid M-Pesa callback structure', $callbackData);
                return;
            }

            $checkoutRequestId = $stkCallback['CheckoutRequestID'];
            $resultCode = $stkCallback['ResultCode'];
            
            $donation = Donation::where('mpesa_checkout_request_id', $checkoutRequestId)->first();
            
            if (!$donation) {
                Log::warning('Donation not found for checkout request', [
                    'checkout_request_id' => $checkoutRequestId
                ]);
                return;
            }

            // Update payment data
            $donation->update([
                'payment_data' => array_merge(
                    $donation->payment_data ?? [],
                    ['callback_response' => $stkCallback]
                )
            ]);

            if ($resultCode == 0) {
                // Payment successful
                $callbackMetadata = $stkCallback['CallbackMetadata']['Item'] ?? [];
                $receiptNumber = collect($callbackMetadata)
                    ->firstWhere('Name', 'MpesaReceiptNumber')['Value'] ?? null;

                $donation->markAsCompleted($receiptNumber);
                
                Log::info('Donation completed successfully', [
                    'donation_id' => $donation->id,
                    'receipt_number' => $receiptNumber
                ]);

                // Send confirmation email/SMS here
                $this->sendDonationConfirmation($donation);

            } else {
                // Payment failed
                $donation->markAsFailed();
                
                Log::info('Donation payment failed', [
                    'donation_id' => $donation->id,
                    'result_code' => $resultCode,
                    'result_desc' => $stkCallback['ResultDesc'] ?? 'Unknown error'
                ]);
            }

        } catch (Exception $e) {
            Log::error('M-Pesa callback processing failed', [
                'error' => $e->getMessage(),
                'callback_data' => $callbackData,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Query STK push status
     */
    public function querySTKStatus(Donation $donation): array
    {
        try {
            $accessToken = $this->getAccessToken();
            
            $url = $this->environment === 'production'
                ? 'https://api.safaricom.co.ke/mpesa/stkpushquery/v1/query'
                : 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';

            $timestamp = date('YmdHis');
            $password = base64_encode($this->businessShortCode . $this->passkey . $timestamp);

            $payload = [
                'BusinessShortCode' => $this->businessShortCode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'CheckoutRequestID' => $donation->mpesa_checkout_request_id,
            ];

            $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ])
                ->post($url, $payload);

            if ($response->successful()) {
                return $response->json();
            }

            return [
                'success' => false,
                'message' => 'Failed to query payment status'
            ];

        } catch (Exception $e) {
            Log::error('M-Pesa status query failed', [
                'donation_id' => $donation->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Status query unavailable'
            ];
        }
    }

    /**
     * Test STK Push with a minimal payload (for debugging)
     */
    public function testSTKPush(): array
    {
        try {
            // Get fresh token
            $this->clearTokenCache();
            $accessToken = $this->getAccessToken();
            
            $url = $this->environment === 'production'
                ? 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest'
                : 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';

            // Wait, that's wrong - let me fix the URL
            $url = $this->environment === 'production'
                ? 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest'
                : 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

            $timestamp = date('YmdHis');
            $password = base64_encode($this->businessShortCode . $this->passkey . $timestamp);

            $payload = [
                'BusinessShortCode' => $this->businessShortCode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => 1, // Test with 1 KES
                'PartyA' => '254708374149', // Safaricom test number
                'PartyB' => $this->businessShortCode,
                'PhoneNumber' => '254708374149',
                'CallBackURL' => $this->callbackUrl,
                'AccountReference' => 'TEST_' . time(),
                'TransactionDesc' => 'Test STK Push',
            ];

            Log::info('Testing STK Push with fresh token', [
                'url' => $url,
                'token_preview' => substr($accessToken, 0, 8) . '...',
                'payload' => array_merge($payload, ['Password' => '[HIDDEN]'])
            ]);

            $response = Http::timeout(60)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ])
                ->post($url, $payload);

            Log::info('Test STK Push response', [
                'status' => $response->status(),
                'response' => $response->json(),
                'headers' => $response->headers()
            ]);

            return [
                'success' => $response->successful(),
                'status' => $response->status(),
                'response' => $response->json(),
                'token_used' => substr($accessToken, 0, 8) . '...'
            ];

        } catch (Exception $e) {
            Log::error('Test STK Push failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Clear cached access token (useful for debugging)
     */
    public function clearTokenCache(): bool
    {
        $cacheKey = 'mpesa_access_token_' . $this->environment;
        return cache()->forget($cacheKey);
    }

    /**
     * Test M-Pesa connection and credentials
     */
    public function testConnection(): array
    {
        try {
            // Clear any cached token for fresh test
            $this->clearTokenCache();
            
            $accessToken = $this->getAccessToken();
            
            return [
                'success' => true,
                'message' => 'M-Pesa connection successful',
                'token_length' => strlen($accessToken)
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Send donation confirmation
     */
    private function sendDonationConfirmation(Donation $donation): void
    {
        // Implement email/SMS confirmation logic here
        // You can use Laravel's notification system or mail/SMS services
        
        Log::info('Donation confirmation should be sent', [
            'donation_id' => $donation->id,
            'email' => $donation->email,
            'phone' => $donation->phone
        ]);
    }
}