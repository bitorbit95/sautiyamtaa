@extends('layouts.guest')

@section('title', __('navigation.donate'))

@section('content')
<!-- Hero Header -->
<section class="bg-gradient-to-br from-red-600 via-red-700 to-black text-white py-12 relative overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="max-w-6xl mx-auto px-4 relative z-10">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">
                {{ __('navigation.donate') }}
            </h1>
            <p class="text-lg md:text-xl opacity-90 max-w-2xl mx-auto">
                Your support empowers youth and communities across Kenya
            </p>
            <div class="mt-6 flex items-center justify-center space-x-2 text-sm">
                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>Secure M-Pesa payments</span>
                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>SSL Encrypted</span>
            </div>
        </div>
    </div>
</section>

<!-- Alert Messages -->
@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-400 p-4 mx-4 mt-4 rounded-r-lg">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border-l-4 border-red-400 p-4 mx-4 mt-4 rounded-r-lg">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
    </div>
</div>
@endif

<!-- Main Content -->
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Quick Donation Options -->
            <div class="lg:col-span-4">
                <div class="sticky top-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center lg:text-left">
                        Quick Amounts
                    </h2>
                    <div class="space-y-4">
                        @foreach($donationOptions as $option)
                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 hover:border-red-500 hover:shadow-lg transition-all duration-300 cursor-pointer transform hover:scale-[1.02]"
                             onclick="selectAmount({{ $option['amount'] }})">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-lg">KSh</span>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="text-2xl font-bold text-red-600 mb-1">
                                        {{ number_format($option['amount']) }}
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                        {{ app()->getLocale() == 'sw' ? $option['title_sw'] : $option['title'] }}
                                    </h3>
                                    <p class="text-sm text-gray-600 leading-relaxed">
                                        {{ app()->getLocale() == 'sw' ? $option['description_sw'] : $option['description'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        <!-- Custom Amount Option -->
                        <div class="bg-gradient-to-br from-gray-50 to-white p-5 rounded-xl border-2 border-dashed border-gray-300 hover:border-red-500 transition-all duration-300 cursor-pointer"
                             onclick="focusCustomAmount()">
                            <div class="text-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </div>
                                <div class="text-lg font-bold text-gray-700 mb-1">Custom Amount</div>
                                <p class="text-sm text-gray-600">Enter your preferred amount</p>
                            </div>
                        </div>
                    </div>

                    <!-- M-Pesa Info -->
                    <div class="mt-8 bg-green-50 p-4 rounded-xl border border-green-200">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-green-800">Pay with M-Pesa</h3>
                                <p class="text-sm text-green-700">Secure and instant mobile payments</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Donation Form -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Complete Your Donation</h2>
                        <p class="text-gray-600">Fill in your details below to make a difference</p>
                    </div>
                    
                    <form method="POST" action="{{ route('donate.store') }}" class="space-y-6" id="donationForm">
                        @csrf
                        
                        <!-- Amount Input -->
                        <div class="bg-red-50 p-6 rounded-xl border border-red-200">
                            <label for="amount" class="block text-lg font-bold text-gray-900 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.51-1.31c-.562-.649-1.413-1.076-2.353-1.253V5z" clip-rule="evenodd"/>
                                    </svg>
                                    Donation Amount (KSh) *
                                </span>
                            </label>
                            <input type="number" id="amount" name="amount" min="100" max="1000000" required
                                   value="{{ old('amount') }}"
                                   class="w-full px-4 py-4 text-2xl font-bold border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-red-500/20 focus:border-red-500 bg-white text-gray-900 placeholder-gray-400 transition-all duration-200"
                                   placeholder="Enter amount (minimum KSh 100)">
                            @error('amount')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Personal Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">
                                    Full Name *
                                </label>
                                <input type="text" id="name" name="name" required
                                       value="{{ old('name') }}"
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-red-500/20 focus:border-red-500 bg-white text-gray-900 placeholder-gray-400 transition-all duration-200"
                                       placeholder="Enter your full name">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">
                                    Email Address *
                                </label>
                                <input type="email" id="email" name="email" required
                                       value="{{ old('email') }}"
                                       class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-red-500/20 focus:border-red-500 bg-white text-gray-900 placeholder-gray-400 transition-all duration-200"
                                       placeholder="your@email.com">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-900 mb-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                    </svg>
                                    M-Pesa Phone Number *
                                </span>
                            </label>
                            <input type="tel" id="phone" name="phone" required
                                   value="{{ old('phone') }}"
                                   class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-red-500/20 focus:border-red-500 bg-white text-gray-900 placeholder-gray-400 transition-all duration-200"
                                   placeholder="0712 345 678 or +254712345678">
                            <p class="mt-2 text-sm text-gray-600 flex items-center">
                                <svg class="w-4 h-4 mr-1 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                We'll send a payment prompt to this number
                            </p>
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-semibold text-gray-900 mb-2">
                                Message (Optional)
                            </label>
                            <textarea id="message" name="message" rows="3"
                                      class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-red-500/20 focus:border-red-500 bg-white text-gray-900 placeholder-gray-400 resize-none transition-all duration-200"
                                      placeholder="Leave a message or dedication...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Donation Type -->
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                            <label class="block text-sm font-semibold text-gray-900 mb-4">Donation Type</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex items-center p-4 bg-white rounded-lg border-2 border-gray-200 cursor-pointer hover:border-red-500 transition-all duration-200">
                                    <input type="radio" name="donation_type" value="one_time" 
                                           {{ old('donation_type', 'one_time') == 'one_time' ? 'checked' : '' }}
                                           class="text-red-600 focus:ring-red-500 focus:ring-2">
                                    <div class="ml-3">
                                        <div class="font-semibold text-gray-900">One-time Donation</div>
                                        <div class="text-sm text-gray-600">Make a single donation</div>
                                    </div>
                                </label>
                                <label class="flex items-center p-4 bg-white rounded-lg border-2 border-gray-200 cursor-pointer hover:border-red-500 transition-all duration-200">
                                    <input type="radio" name="donation_type" value="monthly"
                                           {{ old('donation_type') == 'monthly' ? 'checked' : '' }}
                                           class="text-red-600 focus:ring-red-500 focus:ring-2">
                                    <div class="ml-3">
                                        <div class="font-semibold text-gray-900">Monthly Donation</div>
                                        <div class="text-sm text-gray-600">Recurring monthly support</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" id="submitBtn"
                                    class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-[1.02] focus:ring-4 focus:ring-red-500/20 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                                <span class="flex items-center justify-center" id="btnContent">
                                    <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"/>
                                    </svg>
                                    {{ __('messages.donate_now') ?? 'Donate Now with M-Pesa' }}
                                </span>
                                <span class="hidden" id="btnLoading">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Processing...
                                </span>
                            </button>
                        </div>

                        <!-- Security Notice -->
                        <div class="text-center pt-4">
                            <div class="flex items-center justify-center space-x-6 text-sm text-gray-500">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                    </svg>
                                    SSL Encrypted
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Secure Processing
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Impact Statement -->
        <div class="mt-12 bg-white rounded-2xl shadow-lg p-8 border-l-4 border-red-500">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="h-6 w-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Every Donation Makes a Difference</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Your contribution directly supports our community programs and helps us reach more youth in need. 
                        Together, we're building stronger communities and brighter futures across Kenya.
                    </p>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="font-semibold text-gray-900">Direct Impact</div>
                            <div class="text-gray-600">100% goes to programs</div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="font-semibold text-gray-900">Tax Deductible</div>
                            <div class="text-gray-600">Receipt provided</div>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="font-semibold text-gray-900">Monthly Updates</div>
                            <div class="text-gray-600">See your impact</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function selectAmount(amount) {
    const amountInput = document.getElementById('amount');
    amountInput.value = amount;
    amountInput.focus();
    
    // Add visual feedback
    amountInput.classList.add('ring-4', 'ring-red-500/20', 'border-red-500');
    setTimeout(() => {
        amountInput.classList.remove('ring-4', 'ring-red-500/20');
    }, 2000);
}

function focusCustomAmount() {
    const amountInput = document.getElementById('amount');
    amountInput.value = '';
    amountInput.focus();
    amountInput.placeholder = 'Enter your custom amount';
}

// Form submission handling
document.getElementById('donationForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const btnContent = document.getElementById('btnContent');
    const btnLoading = document.getElementById('btnLoading');
    
    // Show loading state
    submitBtn.disabled = true;
    btnContent.classList.add('hidden');
    btnLoading.classList.remove('hidden');
});

// Auto-format amount input
document.getElementById('amount').addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^\d]/g, '');
    if (value) {
        // Add commas for thousands
        const formatted = parseInt(value).toLocaleString();
        if (e.target !== document.activeElement || !e.target.value.includes(',')) {
            e.target.value = value;
        }
    }
});

// Phone number formatting
document.getElementById('phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^\d+]/g, '');
    
    // Format Kenya phone numbers
    if (value.startsWith('0') && value.length === 10) {
        value = '+254' + value.substring(1);
    } else if (value.startsWith('254') && value.length === 12) {
        value = '+' + value;
    }
    
    e.target.value = value;
});

// Radio button styling
document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function() {
        // Remove selected class from all labels
        document.querySelectorAll('label:has(input[type="radio"])').forEach(label => {
            label.classList.remove('border-red-500', 'bg-red-50');
        });
        
        // Add selected class to current label
        if (this.checked) {
            this.closest('label').classList.add('border-red-500', 'bg-red-50');
        }
    });
});

// Initialize selected radio button styling
document.addEventListener('DOMContentLoaded', function() {
    const checkedRadio = document.querySelector('input[type="radio"]:checked');
    if (checkedRadio) {
        checkedRadio.closest('label').classList.add('border-red-500', 'bg-red-50');
    }
});
</script>

@push('styles')
<style>
/* Enhanced focus states for better visibility */
input:focus, textarea:focus, select:focus {
    outline: none !important;
    box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1) !important;
    border-color: #ef4444 !important;
}

/* Ensure text is always visible */
input, textarea, select {
    color: #111827 !important;
    background-color: #ffffff !important;
}

input::placeholder, textarea::placeholder {
    color: #9ca3af !important;
    opacity: 1 !important;
}

/* Amount input special styling */
#amount {
    font-size: 1.5rem !important;
    font-weight: 700 !important;
    color: #111827 !important;
}

/* Smooth transitions */
.transition-all {
    transition: all 0.3s ease-in-out;
}

/* Hover effects for donation cards */
.hover\:scale-\[1\.02\]:hover {
    transform: scale(1.02);
}

/* Radio button styling */
input[type="radio"]:checked {
    background-color: #dc2626 !important;
    border-color: #dc2626 !important;
}

input[type="radio"]:focus {
    ring-color: #dc2626 !important;
    ring-offset-color: #ffffff !important;
}

/* Loading button animation */
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

/* Mobile optimizations */
@media (max-width: 640px) {
    .grid.grid-cols-2 {
        gap: 0.75rem;
    }
    
    .p-5 {
        padding: 1rem;
    }
    
    .text-2xl {
        font-size: 1.25rem;
        line-height: 1.75rem;
    }
    
    #amount {
        font-size: 1.25rem !important;
    }
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Error state styling */
.border-red-500 {
    border-color: #ef4444 !important;
}

.text-red-600 {
    color: #dc2626 !important;
}

/* Success state styling */
.border-green-500 {
    border-color: #10b981 !important;
}

.text-green-600 {
    color: #059669 !important;
}

/* Ensure proper contrast */
.bg-white {
    background-color: #ffffff !important;
}

.text-gray-900 {
    color: #111827 !important;
}

.text-gray-600 {
    color: #4b5563 !important;
}

.text-gray-400 {
    color: #9ca3af !important;
}

/* Button active state */
button:active {
    transform: scale(0.98);
}

/* Form validation styling */
input:invalid:not(:placeholder-shown) {
    border-color: #ef4444;
    background-color: #fef2f2;
}

input:valid:not(:placeholder-shown) {
    border-color: #10b981;
    background-color: #f0fdf4;
}

/* Sticky positioning for sidebar */
.sticky {
    position: -webkit-sticky;
    position: sticky;
}
</style>
@endpush
@endsection