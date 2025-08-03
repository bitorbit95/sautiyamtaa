@extends('layouts.guest')

@section('title', 'Donation Status - ' . $donation->transaction_id)

@section('content')
<section class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12">
    <div class="max-w-4xl mx-auto px-4">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Donation Status</h1>
            <p class="text-gray-600">Transaction ID: <span class="font-mono font-semibold">{{ $donation->transaction_id }}</span></p>
        </div>

        <!-- Status Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            
            <!-- Status Header -->
            <div class="status-header px-8 py-6 text-white" id="statusHeader">
                <div class="flex items-center justify-center space-x-3">
                    <div class="status-icon" id="statusIcon">
                        <!-- Dynamic icon will be inserted here -->
                    </div>
                    <div class="text-center">
                        <h2 class="text-2xl font-bold" id="statusTitle">
                            <!-- Dynamic status title -->
                        </h2>
                        <p class="text-lg opacity-90" id="statusMessage">
                            <!-- Dynamic status message -->
                        </p>
                    </div>
                </div>
            </div>

            <!-- Donation Details -->
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <!-- Donation Information -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-bold text-gray-900 border-b border-gray-200 pb-2">
                            Donation Details
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600">Amount:</span>
                                <span class="text-2xl font-bold text-green-600">{{ $donation->formatted_amount }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600">Type:</span>
                                <span class="font-semibold capitalize">
                                    {{ str_replace('_', ' ', $donation->donation_type) }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600">Payment Method:</span>
                                <span class="font-semibold flex items-center">
                                    @if($donation->payment_method === 'mpesa')
                                        <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                        </svg>
                                    @endif
                                    {{ strtoupper($donation->payment_method) }}
                                </span>
                            </div>
                            
                            <div class="flex justify-between items-start py-2">
                                <span class="text-gray-600">Donor:</span>
                                <div class="text-right">
                                    <div class="font-semibold">{{ $donation->name }}</div>
                                    <div class="text-sm text-gray-600">{{ $donation->email }}</div>
                                    @if($donation->phone)
                                        <div class="text-sm text-gray-600">{{ $donation->phone }}</div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600">Created:</span>
                                <span class="font-semibold">{{ $donation->created_at->format('M j, Y g:i A') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-bold text-gray-900 border-b border-gray-200 pb-2">
                            Payment Information
                        </h3>
                        
                        <div class="space-y-4" id="paymentInfo">
                            <!-- Dynamic payment info will be inserted here -->
                        </div>

                        @if($donation->message)
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <h4 class="font-semibold text-blue-900 mb-2">Message:</h4>
                            <p class="text-blue-800">{{ $donation->message }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center" id="actionButtons">
                    <!-- Dynamic action buttons will be inserted here -->
                </div>
            </div>
        </div>

        <!-- Progress Indicator for Pending Payments -->
        <div class="mt-8 bg-white rounded-xl shadow-lg p-6" id="progressSection" style="display: none;">
            <h3 class="text-lg font-bold text-gray-900 mb-4 text-center">Payment Progress</h3>
            <div class="relative">
                <!-- Progress bar -->
                <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                    <div class="progress-bar bg-gradient-to-r from-blue-500 to-blue-600 h-full rounded transition-all duration-1000" 
                         style="width: 0%"></div>
                </div>
                <div class="flex justify-between text-xs text-gray-600 mt-2">
                    <span>Payment Initiated</span>
                    <span>Processing</span>
                    <span>Completed</span>
                </div>
            </div>
            <p class="text-center text-sm text-gray-600 mt-4">
                <span class="animate-pulse">●</span> Waiting for payment confirmation...
            </p>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Need Help?</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <svg class="w-8 h-8 mx-auto mb-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                    </svg>
                    <h4 class="font-semibold text-gray-900 mb-1">Payment Issues</h4>
                    <p class="text-gray-600">Having trouble with your payment? Contact our support team.</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <svg class="w-8 h-8 mx-auto mb-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                    </svg>
                    <h4 class="font-semibold text-gray-900 mb-1">Receipt</h4>
                    <p class="text-gray-600">You'll receive an email receipt once payment is confirmed.</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <svg class="w-8 h-8 mx-auto mb-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z" clip-rule="evenodd"/>
                    </svg>
                    <h4 class="font-semibold text-gray-900 mb-1">Track Impact</h4>
                    <p class="text-gray-600">See how your donation is making a difference in our community.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
let checkInterval;
const donation = @json($donation);

function updateStatus() {
    fetch(`{{ route('donate.check-status', $donation->transaction_id) }}`)
        .then(response => response.json())
        .then(data => {
            const statusHeader = document.getElementById('statusHeader');
            const statusIcon = document.getElementById('statusIcon');
            const statusTitle = document.getElementById('statusTitle');
            const statusMessage = document.getElementById('statusMessage');
            const paymentInfo = document.getElementById('paymentInfo');
            const actionButtons = document.getElementById('actionButtons');
            const progressSection = document.getElementById('progressSection');

            // Update status display based on current status
            switch(data.status) {
                case 'pending':
                    statusHeader.className = 'status-header px-8 py-6 text-white bg-gradient-to-r from-yellow-500 to-orange-500';
                    statusIcon.innerHTML = `
                        <svg class="w-12 h-12 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    `;
                    statusTitle.textContent = 'Payment Pending';
                    statusMessage.textContent = 'Waiting for payment confirmation';
                    
                    // Show progress section
                    progressSection.style.display = 'block';
                    updateProgressBar(50);
                    
                    // Show resend button if M-Pesa
                    actionButtons.innerHTML = `
                        <button onclick="resendSTK()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                            Resend M-Pesa Prompt
                        </button>
                        <a href="{{ route('donate.manual', $donation->transaction_id) }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors text-center">
                            Manual Payment
                        </a>
                    `;
                    
                    paymentInfo.innerHTML = `
                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                            <h4 class="font-semibold text-yellow-900 mb-2">Payment Status:</h4>
                            <p class="text-yellow-800">Awaiting M-Pesa payment confirmation</p>
                        </div>
                        <div class="text-sm text-gray-600">
                            <p>• Check your phone for M-Pesa payment prompt</p>
                            <p>• Enter your M-Pesa PIN to complete payment</p>
                            <p>• You'll receive SMS confirmation from M-Pesa</p>
                        </div>
                    `;
                    break;

                case 'completed':
                    statusHeader.className = 'status-header px-8 py-6 text-white bg-gradient-to-r from-green-500 to-green-600';
                    statusIcon.innerHTML = `
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    `;
                    statusTitle.textContent = 'Payment Successful!';
                    statusMessage.textContent = 'Thank you for your generous donation';
                    
                    // Hide progress section
                    progressSection.style.display = 'none';
                    
                    // Show success actions
                    actionButtons.innerHTML = `
                        <a href="{{ route('donate.success', $donation->transaction_id) }}" 
                           class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                            View Receipt
                        </a>
                        <a href="{{ route('donate.index') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                            Donate Again
                        </a>
                    `;
                    
                    paymentInfo.innerHTML = `
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <h4 class="font-semibold text-green-900 mb-2">Payment Completed!</h4>
                            <p class="text-green-800">Your donation has been successfully processed.</p>
                        </div>
                        ${data.receipt_number ? `
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600">M-Pesa Receipt:</span>
                            <span class="font-mono font-semibold">${data.receipt_number}</span>
                        </div>
                        ` : ''}
                        ${data.completed_at ? `
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600">Completed:</span>
                            <span class="font-semibold">${data.completed_at}</span>
                        </div>
                        ` : ''}
                        <div class="text-sm text-gray-600 mt-4">
                            <p>• Receipt has been sent to your email</p>
                            <p>• You'll receive updates on how your donation is used</p>
                            <p>• Thank you for making a difference!</p>
                        </div>
                    `;
                    
                    // Stop checking status
                    if (checkInterval) {
                        clearInterval(checkInterval);
                    }
                    break;

                case 'failed':
                    statusHeader.className = 'status-header px-8 py-6 text-white bg-gradient-to-r from-red-500 to-red-600';
                    statusIcon.innerHTML = `
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    `;
                    statusTitle.textContent = 'Payment Failed';
                    statusMessage.textContent = 'There was an issue processing your payment';
                    
                    // Hide progress section
                    progressSection.style.display = 'none';
                    
                    // Show retry actions
                    actionButtons.innerHTML = `
                        <button onclick="resendSTK()" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                            Try Again
                        </button>
                        <a href="{{ route('donate.manual', $donation->transaction_id) }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors text-center">
                            Manual Payment
                        </a>
                    `;
                    
                    paymentInfo.innerHTML = `
                        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                            <h4 class="font-semibold text-red-900 mb-2">Payment Failed</h4>
                            <p class="text-red-800">Your payment could not be processed. Please try again.</p>
                        </div>
                        <div class="text-sm text-gray-600">
                            <p>Common reasons for payment failure:</p>
                            <p>• Insufficient M-Pesa balance</p>
                            <p>• Incorrect PIN entry</p>
                            <p>• Network connectivity issues</p>
                            <p>• Transaction timeout</p>
                        </div>
                    `;
                    
                    // Stop checking status
                    if (checkInterval) {
                        clearInterval(checkInterval);
                    }
                    break;
            }
        })
        .catch(error => {
            console.error('Error checking status:', error);
        });
}

function updateProgressBar(percentage) {
    const progressBar = document.querySelector('.progress-bar');
    if (progressBar) {
        progressBar.style.width = percentage + '%';
    }
}

function resendSTK() {
    const button = event.target;
    const originalText = button.textContent;
    
    button.disabled = true;
    button.innerHTML = `
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Sending...
    `;
    
    fetch(`{{ route('donate.resend-stk', $donation->transaction_id) }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('M-Pesa prompt sent! Please check your phone.');
            // Restart status checking
            if (checkInterval) {
                clearInterval(checkInterval);
            }
            checkInterval = setInterval(updateStatus, 5000);
        } else {
            alert(data.message || 'Failed to send M-Pesa prompt. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Network error. Please try again.');
    })
    .finally(() => {
        button.disabled = false;
        button.textContent = originalText;
    });
}

// Initialize status on page load
document.addEventListener('DOMContentLoaded', function() {
    updateStatus();
    
    // Start checking status every 5 seconds if pending
    if (donation.status === 'pending') {
        checkInterval = setInterval(updateStatus, 5000);
        
        // Stop checking after 10 minutes
        setTimeout(() => {
            if (checkInterval) {
                clearInterval(checkInterval);
            }
        }, 600000); // 10 minutes
    }
});

// Cleanup interval when page is unloaded
window.addEventListener('beforeunload', function() {
    if (checkInterval) {
        clearInterval(checkInterval);
    }
});
</script>

@push('styles')
<style>
.status-header {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
}

.progress-bar {
    transition: width 1s ease-in-out;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: .5;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Ensure good contrast for all text */
.bg-white {
    background-color: #ffffff !important;
}

.text-gray-900 {
    color: #111827 !important;
}

.text-gray-600 {
    color: #4b5563 !important;
}

/* Button hover effects */
button:hover, a:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

button:active, a:active {
    transform: translateY(0);
}

/* Mobile responsive adjustments */
@media (max-width: 640px) {
    .grid.grid-cols-1.md\:grid-cols-2 {
        gap: 1.5rem;
    }
    
    .text-3xl {
        font-size: 1.875rem;
        line-height: 2.25rem;
    }
    
    .px-8 {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
</style>
@endpush
@endsection