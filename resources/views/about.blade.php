@extends('layouts.guest')

@section('title', __('navigation.about'))

@section('content')
<!-- Page Header -->
<section class="bg-blue-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold mb-4">{{ __('navigation.about') }}</h1>
            <p class="text-xl">Learn about our mission, vision, and the people behind our work</p>
        </div>
    </div>
</section>

<!-- About Content -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __('messages.our_mission') }}</h2>
                <p class="text-gray-700 mb-6">
                    {{ __('messages.vision') }}
                </p>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-blue-600 rounded-full flex-shrink-0 mt-1 mr-3"></div>
                        <p class="text-gray-700">{{ __('messages.empowerment') }} through education and mentorship</p>
                    </div>
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-green-600 rounded-full flex-shrink-0 mt-1 mr-3"></div>
                        <p class="text-gray-700">{{ __('messages.unity') }} in community development</p>
                    </div>
                    <div class="flex items-start">
                        <div class="w-6 h-6 bg-purple-600 rounded-full flex-shrink-0 mt-1 mr-3"></div>
                        <p class="text-gray-700">Creating sustainable opportunities for growth</p>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-blue-500 to-green-500 h-96 rounded-lg"></div>
        </div>

        <!-- Organization Details -->
        <div class="bg-gray-50 p-8 rounded-lg mb-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('messages.established') }}</h3>
                    <p class="text-gray-600">{{ __('messages.establishment_date') }}</p>
                </div>
                <div class="text-center">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('messages.location') }}</h3>
                    <p class="text-gray-600">{{ __('messages.organization_location') }}</p>
                </div>
                <div class="text-center">
                    <h3 class="font-semibold text-gray-900 mb-2">Legal Status</h3>
                    <p class="text-gray-600">{{ __('messages.legal_status') }}</p>
                </div>
                <div class="text-center">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ __('messages.target_audience') }}</h3>
                    <p class="text-gray-600">{{ __('messages.age_group') }}</p>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Team</h2>
            <p class="text-gray-600">Meet the dedicated individuals working to make a difference</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($teamMembers as $member)
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <div class="w-24 h-24 bg-gray-300 rounded-full mx-auto mb-4"></div>
                <h3 class="text-xl font-semibold mb-2">{{ $member['name'] }}</h3>
                <p class="text-blue-600 font-medium mb-3">
                    {{ app()->getLocale() == 'sw' ? $member['position_sw'] : $member['position'] }}
                </p>
                <p class="text-gray-600 text-sm">
                    {{ app()->getLocale() == 'sw' ? $member['bio_sw'] : $member['bio'] }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
