@extends('layouts.guest')

@section('title', __('navigation.donate'))

@section('content')
<!-- Page Header -->
<section class="bg-green-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold mb-4">{{ __('navigation.donate') }}</h1>
            <p class="text-xl">Your support helps us continue our mission of empowering youth and communities</p>
        </div>
    </div>
</section>

<!-- Donation Options -->
<section class="py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            @foreach($donationOptions as $option)
            <div class="bg-white p-6 rounded-lg shadow-md text-center border-2 border-gray-200 hover:border-green-500 transition-colors">
                <div class="text-3xl font-bold text-green-600 mb-2">KSh {{ number_format($option['amount']) }}</div>
                <h3 class="text-xl font-semibold mb-3">
                    {{ app()->getLocale() == 'sw' ? $option['title_sw'] : $option['title'] }}
                </h3>
                <p class="text-gray-600 mb-4">
                    {{ app()->getLocale() == 'sw' ? $option['description_sw'] : $option['description'] }}
                </p>
                <button onclick="selectAmount({{ $option['amount'] }})" 
                        class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors w-full">
                    Select This Amount
                </button>
            </div>
            @endforeach
        </div>

        <!-- Donation Form -->
        <div class="bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-6 text-center">Make a Donation</h2>
            <form method="POST" action="{{ route('donate.store') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Amount (KSh)</label>
                        <input type="number" id="amount" name="amount" min="100" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" id="name" name="name" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="email" name="email" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" id="phone" name="phone"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>
                <div class="mt-6">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message (Optional)</label>
                    <textarea id="message" name="message" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"></textarea>
                </div>
                <div class="mt-8 text-center">
                    <button type="submit" 
                            class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                        {{ __('messages.donate_now') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
function selectAmount(amount) {
    document.getElementById('amount').value = amount;
}
</script>
@endsection