<?php

use App\Services\MpesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| M-Pesa API Routes
|--------------------------------------------------------------------------
*/

// M-Pesa STK Push Callback - This must be publicly accessible
Route::post('/mpesa/callback', function (Request $request) {
    try {
        // Log the incoming callback for debugging
        Log::info('M-Pesa Callback Received', [
            'headers' => $request->headers->all(),
            'body' => $request->all(),
            'raw_body' => $request->getContent(),
            'ip' => $request->ip()
        ]);

        // Get the callback data
        $callbackData = $request->all();
        
        // Validate that we have the expected structure
        if (!isset($callbackData['Body']['stkCallback'])) {
            Log::warning('Invalid M-Pesa callback structure', $callbackData);
            return response()->json(['ResultCode' => '1', 'ResultDesc' => 'Invalid callback structure']);
        }

        // Process the callback using MpesaService
        $mpesaService = new MpesaService();
        $mpesaService->handleCallback($callbackData);

        // Return success response to M-Pesa
        return response()->json([
            'ResultCode' => '0',
            'ResultDesc' => 'Success'
        ]);

    } catch (\Exception $e) {
        Log::error('M-Pesa callback processing error', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'request_data' => $request->all()
        ]);

        // Still return success to M-Pesa to avoid retries
        return response()->json([
            'ResultCode' => '0',
            'ResultDesc' => 'Processed'
        ]);
    }
})->name('mpesa.callback');

// Test endpoints (remove in production)
Route::get('/mpesa/test-connection', function () {
    try {
        $mpesaService = new MpesaService();
        $result = $mpesaService->testConnection();
        
        return response()->json([
            'status' => $result['success'] ? 'success' : 'error',
            'message' => $result['message'],
            'config_check' => [
                'consumer_key' => !empty(config('mpesa.consumer_key')),
                'consumer_secret' => !empty(config('mpesa.consumer_secret')),
                'business_short_code' => !empty(config('mpesa.business_short_code')),
                'passkey' => !empty(config('mpesa.passkey')),
                'callback_url' => config('mpesa.callback_url'),
                'environment' => config('mpesa.environment'),
            ],
            'timestamp' => now()->toDateTimeString()
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => app()->environment('local') ? $e->getTraceAsString() : null
        ], 500);
    }
});

// Test callback endpoint 
Route::post('/mpesa/test-callback', function (Request $request) {
    Log::info('Test M-Pesa Callback', $request->all());
    
    return response()->json([
        'message' => 'Test callback received',
        'data' => $request->all(),
        'timestamp' => now()->toDateTimeString()
    ]);
});

// Callback URL validation endpoint
Route::get('/mpesa/callback', function () {
    return response()->json([
        'message' => 'M-Pesa callback endpoint is active',
        'timestamp' => now()->toDateTimeString(),
        'environment' => config('mpesa.environment')
    ]);
});