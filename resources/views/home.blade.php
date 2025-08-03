@extends('layouts.guest')

@section('title', __('navigation.home'))

@section('content')
  {{-- Include the Hero Section --}}
    @include('components.hero')


<!-- Stats Section -->
<section class="py-16 bg-gradient-to-br from-gray-900 to-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div class="bg-gradient-to-br from-red-900 to-black p-6 rounded-lg shadow-lg border border-red-400/20 stat-card-hover">
                <div class="text-3xl font-bold text-red-400 mb-2">{{ number_format($stats['youth_empowered']) }}+</div>
                <div class="text-red-200">{{ __('messages.youth') }} {{ __('messages.empowerment') }}</div>
            </div>
            <div class="bg-gradient-to-br from-red-900 to-black p-6 rounded-lg shadow-lg border border-red-400/20 stat-card-hover">
                <div class="text-3xl font-bold text-red-400 mb-2">{{ $stats['programs_running'] }}+</div>
                <div class="text-red-200">{{ __('navigation.programs') }}</div>
            </div>
            <div class="bg-gradient-to-br from-red-900 to-black p-6 rounded-lg shadow-lg border border-red-400/20 stat-card-hover">
                <div class="text-3xl font-bold text-red-400 mb-2">{{ $stats['communities_served'] }}+</div>
                <div class="text-red-200">{{ __('messages.communities') }}</div>
            </div>
            <div class="bg-gradient-to-br from-red-900 to-black p-6 rounded-lg shadow-lg border border-red-400/20 stat-card-hover">
                <div class="text-3xl font-bold text-red-400 mb-2">{{ $stats['years_of_service'] }}+</div>
                <div class="text-red-200">Years of Service</div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Programs -->
<section class="py-16 bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white mb-4">{{ __('navigation.programs') }}</h2>
            <p class="text-red-200 max-w-2xl mx-auto">Discover our impactful programs designed to empower youth and transform communities.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featuredPrograms as $program)
            <div class="bg-gradient-to-br from-red-900 to-black rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:scale-105 border border-red-400/20">
                <div class="h-48 bg-gradient-to-r from-red-600 to-red-800 relative overflow-hidden">
                    <div class="absolute inset-0 bg-black/20"></div>
                    <div class="absolute bottom-4 left-4 right-4">
                        <div class="w-full h-1 bg-red-400 rounded"></div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-3 text-white">
                        {{ app()->getLocale() == 'sw' ? $program['title_sw'] : $program['title'] }}
                    </h3>
                    <p class="text-red-200 mb-4">
                        {{ app()->getLocale() == 'sw' ? $program['description_sw'] : $program['description'] }}
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-red-400 font-semibold">{{ $program['participants'] }} participants</span>
                        <a href="{{ route('programs.show', $program['id']) }}" class="text-red-400 hover:text-red-300 font-semibold transition-colors">
                            {{ __('messages.learn_more') }} →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('programs') }}" class="bg-gradient-to-r from-red-600 to-red-500 text-white px-6 py-3 rounded-lg hover:from-red-500 hover:to-red-400 transition-all duration-300 transform hover:scale-105 font-semibold">
                {{ __('messages.view_all') }} {{ __('navigation.programs') }}
            </a>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-16 bg-gradient-to-br from-gray-900 to-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white mb-4">{{ __('messages.testimonials') }}</h2>
            <p class="text-red-200">Hear from those whose lives have been transformed</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($testimonials as $testimonial)
            <div class="bg-gradient-to-br from-red-900 to-black p-6 rounded-lg shadow-lg border border-red-400/20 hover:shadow-2xl transition-all duration-300">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-600 to-red-800 rounded-full mr-4 flex items-center justify-center">
                        <span class="text-white font-bold text-lg">{{ substr($testimonial['name'], 0, 1) }}</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-white">{{ $testimonial['name'] }}</h4>
                        <p class="text-sm text-red-200">
                            {{ app()->getLocale() == 'sw' ? $testimonial['role_sw'] : $testimonial['role'] }}
                        </p>
                    </div>
                </div>
                <p class="text-red-100 italic">
                    "{{ app()->getLocale() == 'sw' ? $testimonial['quote_sw'] : $testimonial['quote'] }}"
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-gradient-to-r from-red-600 via-red-700 to-red-800 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">{{ __('messages.get_involved') }}</h2>
        <p class="text-xl mb-8 text-red-100">Join us in empowering youth and transforming communities</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ route('donate.index') }}" class="bg-white text-red-600 px-8 py-3 rounded-full font-semibold hover:bg-red-50 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                {{ __('messages.donate_now') }}
            </a>
            <a href="{{ route('contact') }}" class="bg-black text-white px-8 py-3 rounded-full font-semibold hover:bg-gray-900 transition-all duration-300 transform hover:scale-105 hover:shadow-xl border-2 border-white">
                {{ __('messages.volunteer') }}
            </a>
        </div>
    </div>
</section>
@endsection
