@extends('layouts.guest')

@section('title', __('navigation.about'))

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-br from-gray-900 via-black to-red-900 text-white py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center">
            <h1 class="text-5xl font-bold mb-6 bg-gradient-to-r from-white to-red-300 bg-clip-text text-transparent">
                {{ __('navigation.about') }}
            </h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto leading-relaxed">
                Learn about our mission, vision, and the people behind our work
            </p>
        </div>
    </div>
</section>

<!-- About Content -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-20">
            <div>
                <h2 class="text-4xl font-bold text-gray-900 mb-8 relative">
                    {{ __('messages.our_mission') }}
                    <div class="absolute -bottom-2 left-0 w-16 h-1 bg-gradient-to-r from-red-600 to-red-800"></div>
                </h2>
                <p class="text-lg text-gray-700 mb-8 leading-relaxed">
                    {{ __('messages.vision') }}
                </p>
                <div class="space-y-6">
                    <div class="flex items-start group">
                        <div class="w-3 h-3 bg-red-600 rounded-full flex-shrink-0 mt-2 mr-4 group-hover:scale-125 transition-transform duration-200"></div>
                        <p class="text-gray-700 text-lg">
                            <span class="font-semibold text-gray-900">{{ __('messages.empowerment') }}</span> through education and mentorship
                        </p>
                    </div>
                    <div class="flex items-start group">
                        <div class="w-3 h-3 bg-gray-900 rounded-full flex-shrink-0 mt-2 mr-4 group-hover:scale-125 transition-transform duration-200"></div>
                        <p class="text-gray-700 text-lg">
                            <span class="font-semibold text-gray-900">{{ __('messages.unity') }}</span> in community development
                        </p>
                    </div>
                    <div class="flex items-start group">
                        <div class="w-3 h-3 bg-red-800 rounded-full flex-shrink-0 mt-2 mr-4 group-hover:scale-125 transition-transform duration-200"></div>
                        <p class="text-gray-700 text-lg">
                            <span class="font-semibold text-gray-900">Creating sustainable opportunities</span> for growth
                        </p>
                    </div>
                </div>
            </div>
            <div class="relative">
                <div class="bg-gradient-to-br from-red-600 via-red-700 to-gray-900 h-96 rounded-2xl shadow-2xl relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    <div class="absolute top-4 right-4 w-20 h-20 bg-white/10 rounded-full"></div>
                    <img src="{{ asset('images/logo2.jpeg') }}" 
                             alt="Background" 
                             class="w-full h-full object-cover" />
                    <div class="absolute bottom-8 left-8 w-32 h-32 bg-red-500/20 rounded-full blur-xl"></div>
                </div>
            </div>
        </div>

        <!-- Organization Details -->
        <div class="bg-gradient-to-r from-gray-50 to-red-50 p-10 rounded-2xl mb-20 border border-red-100">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-600 to-red-700 rounded-xl mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4h6m6 0a2 2 0 01-2 2H6a2 2 0 01-2-2v-6a2 2 0 012-2h12a2 2 0 012 2v6z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2 text-lg">{{ __('messages.established') }}</h3>
                    <p class="text-gray-600">{{ __('messages.establishment_date') }}</p>
                </div>
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2 text-lg">{{ __('messages.location') }}</h3>
                    <p class="text-gray-600">{{ __('messages.organization_location') }}</p>
                </div>
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-600 to-red-700 rounded-xl mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2 text-lg">Legal Status</h3>
                    <p class="text-gray-600">{{ __('messages.legal_status') }}</p>
                </div>
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2 text-lg">{{ __('messages.target_audience') }}</h3>
                    <p class="text-gray-600">{{ __('messages.age_group') }}</p>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-6 relative inline-block">
                Our Team
                <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-gradient-to-r from-red-600 to-red-800"></div>
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Meet the dedicated individuals working to make a difference
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($teamMembers as $member)
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 group hover:-translate-y-2">
                <div class="w-28 h-28 bg-gradient-to-br from-red-600 to-red-700 rounded-full mx-auto mb-6 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-900">{{ $member['name'] }}</h3>
                <p class="text-red-600 font-semibold mb-4 text-lg">
                    {{ app()->getLocale() == 'sw' ? $member['position_sw'] : $member['position'] }}
                </p>
                <p class="text-gray-600 leading-relaxed">
                    {{ app()->getLocale() == 'sw' ? $member['bio_sw'] : $member['bio'] }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection