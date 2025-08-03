<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Services\MpesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DonationController extends Controller
{
    protected $mpesaService;

    public function __construct(MpesaService $mpesaService)
    {
        $this->mpesaService = $mpesaService;
    }

    /**
     * Show the donation form
     */
    public function index()
    {
        $donationOptions = [
            [
                'amount' => 500,
                'title' => 'Feed a Child',
                'title_sw' => 'Lisha Mtoto',
                'description' => 'Provide a nutritious meal for one child',
                'description_sw' => 'Toa chakula chenye lishe kwa mtoto mmoja'
            ],
            [
                'amount' => 1000,
                'title' => 'School Supplies',
                'title_sw' => 'Vifaa vya Shule',
                'description' => 'Books and materials for learning',
                'description_sw' => 'Vitabu na vifaa vya kujifunzia'
            ],
            [
                'amount' => 2500,
                'title' => 'Health Support',
                'title_sw' => 'Msaada wa Afya',
                'description' => 'Medical care and health services',
                'description_sw' => 'Huduma za kimatibabu na afya'
            ],
            [
                'amount' => 5000,
                'title' => 'Education Fund',
                'title_sw' => 'Mfuko wa Elimu',
                'description' => 'Support a child\'s education for a month',
                'description_sw' => 'Msaada wa elimu kwa mtoto kwa mwezi'
            ],
            [
                'amount' => 10000,
                'title' => 'Youth Program',
                'title_sw' => 'Mradi wa Vijana',
                'description' => 'Empower youth with skills training',
                'description_sw' => 'Teua vijana kwa mafunzo ya ujuzi'
            ],
            [
                'amount' => 25000,
                'title' => 'Community Impact',
                'title_sw' => 'Athari ya Jamii',
                'description' => 'Make a significant community difference',
                'description_sw' => 'Tengeneza mabadiliko makubwa ya kijamii'
            ],
        ];

        return view('donations.index', compact('donationOptions'));
    }

    /**
     * Store a new donation
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:100|max:1000000',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'nullable|string|max:500',
            'donation_type' => 'required|in:one_time,monthly',
            'payment_method' => 'nullable|in:mpesa,card,bank'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please check your input and try again.');
        }

        try {
            // Create donation record
            $donation = Donation::create([
                'transaction_id' => Donation::generateTransactionId(),
                'amount' => $request->amount,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message,
                'donation_type' => $request->donation_type,
                'payment_method' => $request->payment_method ?? 'mpesa',
                'status' => 'pending',
            ]);

            // If no phone number provided, redirect to manual payment instructions
            if (!$request->phone) {
                return redirect()
                    ->route('donate.manual', $donation->transaction_id)
                    ->with('success', 'Donation created! Please complete the payment manually.');
            }

            // Initiate M-Pesa STK push
            $result = $this->mpesaService->initiateSTKPush($donation);

            if ($result['success']) {
                return redirect()
                    ->route('donate.status', $donation->transaction_id)
                    ->with('success', $result['message']);
            } else {
                return back()
                    ->withInput()
                    ->with('error', $result['message']);
            }

        } catch (\Exception $e) {
            Log::error('Donation creation failed', [
                'error' => $e->getMessage(),
                'request_data' => $request->except(['_token'])
            ]);

            return back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Show donation status
     */
    public function status($transactionId)
    {
        $donation = Donation::where('transaction_id', $transactionId)->firstOrFail();
        
        return view('donations.status', compact('donation'));
    }

    /**
     * Show manual payment instructions
     */
    public function manual($transactionId)
    {
        $donation = Donation::where('transaction_id', $transactionId)->firstOrFail();
        
        return view('donations.manual', compact('donation'));
    }

    /**
     * Check donation status via AJAX
     */
    public function checkStatus(Request $request, $transactionId)
    {
        $donation = Donation::where('transaction_id', $transactionId)->firstOrFail();
        
        // If still pending and has M-Pesa checkout request, query status
        if ($donation->isPending() && $donation->mpesa_checkout_request_id) {
            $statusResult = $this->mpesaService->querySTKStatus($donation);
            
            // Update donation based on M-Pesa response if needed
            if (isset($statusResult['ResultCode'])) {
                if ($statusResult['ResultCode'] == 0) {
                    $donation->markAsCompleted($statusResult['MpesaReceiptNumber'] ?? null);
                } elseif ($statusResult['ResultCode'] != 1032) { // 1032 means still pending
                    $donation->markAsFailed();
                }
            }
        }

        return response()->json([
            'status' => $donation->fresh()->status,
            'formatted_amount' => $donation->formatted_amount,
            'receipt_number' => $donation->mpesa_receipt_number,
            'completed_at' => $donation->payment_completed_at?->format('M j, Y g:i A'),
        ]);
    }

    /**
     * Handle M-Pesa callback
     */
    public function mpesaCallback(Request $request)
    {
        Log::info('M-Pesa callback received', $request->all());

        try {
            $this->mpesaService->handleCallback($request->all());
            
            return response()->json([
                'ResultCode' => 0,
                'ResultDesc' => 'Callback processed successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('M-Pesa callback processing error', [
                'error' => $e->getMessage(),
                'callback_data' => $request->all()
            ]);

            return response()->json([
                'ResultCode' => 1,
                'ResultDesc' => 'Callback processing failed'
            ]);
        }
    }

    /**
     * Show donation success page
     */
    public function success($transactionId)
    {
        $donation = Donation::where('transaction_id', $transactionId)
            ->where('status', 'completed')
            ->firstOrFail();
            
        return view('donations.success', compact('donation'));
    }

    /**
     * Resend STK push
     */
    public function resendSTK(Request $request, $transactionId)
    {
        $donation = Donation::where('transaction_id', $transactionId)->firstOrFail();
        
        if (!$donation->isPending()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot resend payment for completed or failed donations.'
            ]);
        }

        if (!$donation->phone) {
            return response()->json([
                'success' => false,
                'message' => 'No phone number available for STK push.'
            ]);
        }

        $result = $this->mpesaService->initiateSTKPush($donation);
        
        return response()->json($result);
    }
}