@extends('layouts.guest')

@section('title', __('navigation.contact'))

@push('styles')
<style>
    .form-input {
        background: rgba(0, 0, 0, 0.5);
        border: 2px solid rgba(239, 68, 68, 0.3);
        color: white;
        transition: all 0.3s ease;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #ef4444;
        background: rgba(0, 0, 0, 0.7);
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    
    .form-input::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }
    
    .contact-card {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(0, 0, 0, 0.8));
        backdrop-filter: blur(20px);
        border: 1px solid rgba(239, 68, 68, 0.2);
        transition: all 0.3s ease;
    }
    
    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(239, 68, 68, 0.2);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-red-900 via-black to-red-800 text-white py-20">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, #ef4444 0%, transparent 50%), radial-gradient(circle at 75% 75%, #dc2626 0%, transparent 50%);"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-6">
            <span class="bg-gradient-to-r from-red-400 to-white bg-clip-text text-transparent">
                {{ __('navigation.contact') }}
            </span>
        </h1>
        <p class="text-xl md:text-2xl mb-8 text-red-100 max-w-3xl mx-auto">
            {{ __('messages.contact_description', ['default' => 'Get in touch with us. We would love to hear from you.']) }}
        </p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16 bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-8">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-8">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            
            <!-- Contact Form -->
            <div>
                <div class="contact-card rounded-2xl p-8">
                    <h2 class="text-3xl font-bold text-white mb-6">
                        {{ __('messages.send_message', ['default' => 'Send us a Message']) }}
                    </h2>
                    
                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-red-400 text-sm font-semibold mb-2">
                                    {{ __('messages.first_name', ['default' => 'First Name']) }} *
                                </label>
                                <input type="text" name="first_name" 
                                       class="form-input w-full px-4 py-3 rounded-lg @error('first_name') border-red-500 @enderror" 
                                       placeholder="{{ __('messages.enter_first_name', ['default' => 'Enter your first name']) }}" 
                                       value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-red-400 text-sm font-semibold mb-2">
                                    {{ __('messages.last_name', ['default' => 'Last Name']) }} *
                                </label>
                                <input type="text" name="last_name" 
                                       class="form-input w-full px-4 py-3 rounded-lg @error('last_name') border-red-500 @enderror" 
                                       placeholder="{{ __('messages.enter_last_name', ['default' => 'Enter your last name']) }}" 
                                       value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-red-400 text-sm font-semibold mb-2">
                                {{ __('messages.email', ['default' => 'Email Address']) }} *
                            </label>
                            <input type="email" name="email" 
                                   class="form-input w-full px-4 py-3 rounded-lg @error('email') border-red-500 @enderror" 
                                   placeholder="{{ __('messages.enter_email', ['default' => 'Enter your email address']) }}" 
                                   value="{{ old('email') }}" required>
                            @error('email')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-red-400 text-sm font-semibold mb-2">
                                {{ __('messages.phone', ['default' => 'Phone Number']) }}
                            </label>
                            <input type="tel" name="phone" 
                                   class="form-input w-full px-4 py-3 rounded-lg @error('phone') border-red-500 @enderror" 
                                   placeholder="{{ __('messages.enter_phone', ['default' => 'Enter your phone number']) }}" 
                                   value="{{ old('phone') }}">
                            @error('phone')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-red-400 text-sm font-semibold mb-2">
                                {{ __('messages.subject', ['default' => 'Subject']) }} *
                            </label>
                            <input type="text" name="subject" 
                                   class="form-input w-full px-4 py-3 rounded-lg @error('subject') border-red-500 @enderror" 
                                   placeholder="{{ __('messages.enter_subject', ['default' => 'What is this about?']) }}" 
                                   value="{{ old('subject') }}" required>
                            @error('subject')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-red-400 text-sm font-semibold mb-2">
                                {{ __('messages.message', ['default' => 'Message']) }} *
                            </label>
                            <textarea name="message" rows="5" 
                                      class="form-input w-full px-4 py-3 rounded-lg @error('message') border-red-500 @enderror" 
                                      placeholder="{{ __('messages.enter_message', ['default' => 'Tell us more about your inquiry...']) }}" 
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-red-600 to-red-500 text-white py-4 px-8 rounded-lg font-semibold hover:from-red-500 hover:to-red-400 transition-all duration-300 transform hover:scale-105">
                            {{ __('messages.send_message', ['default' => 'Send Message']) }}
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="space-y-6">
                
                <!-- Address -->
                <div class="contact-card rounded-xl p-6">
                    <div class="flex items-start space-x-4">
                        <div class="bg-gradient-to-br from-red-600 to-red-800 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-2">{{ __('messages.our_address', ['default' => 'Our Address']) }}</h3>
                            <p class="text-red-200">
                                123 Youth Empowerment Street<br>
                                Nairobi, Kenya<br>
                                P.O. Box 12345-00100
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Phone -->
                <div class="contact-card rounded-xl p-6">
                    <div class="flex items-start space-x-4">
                        <div class="bg-gradient-to-br from-red-600 to-red-800 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-2">{{ __('messages.phone_number', ['default' => 'Phone']) }}</h3>
                            <p class="text-red-200">
                                <a href="tel:+254123456789" class="hover:text-red-400 transition-colors">+254 123 456 789</a>
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Email -->
                <div class="contact-card rounded-xl p-6">
                    <div class="flex items-start space-x-4">
                        <div class="bg-gradient-to-br from-red-600 to-red-800 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-2">{{ __('messages.email_address', ['default' => 'Email']) }}</h3>
                            <p class="text-red-200">
                                <a href="mailto:info@youthempowerment.org" class="hover:text-red-400 transition-colors">info@youthempowerment.org</a>
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Office Hours -->
                <div class="contact-card rounded-xl p-6">
                    <div class="flex items-start space-x-4">
                        <div class="bg-gradient-to-br from-red-600 to-red-800 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-white mb-2">{{ __('messages.office_hours', ['default' => 'Office Hours']) }}</h3>
                            <p class="text-red-200">
                                Monday - Friday: 8:00 AM - 6:00 PM<br>
                                Saturday: 9:00 AM - 4:00 PM<br>
                                Sunday: Closed
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection