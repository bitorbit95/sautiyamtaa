@extends('layouts.guest')

@section('title', __('navigation.programs'))

@section('content')
<!-- Page Header -->
<section class="bg-green-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold mb-4">{{ __('navigation.programs') }}</h1>
            <p class="text-xl">Discover our comprehensive programs designed to empower and transform lives</p>
        </div>
    </div>
</section>

<!-- Programs Grid -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($programs as $program)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="h-64 bg-gradient-to-r from-blue-500 to-green-500"></div>
                <div class="p-6">
                    <h3 class="text-2xl font-semibold mb-3">
                        {{ app()->getLocale() == 'sw' ? $program['title_sw'] : $program['title'] }}
                    </h3>
                    <p class="text-gray-600 mb-4">
                        {{ app()->getLocale() == 'sw' ? $program['description_sw'] : $program['description'] }}
                    </p>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm text-gray-500">
                            Duration: {{ app()->getLocale() == 'sw' ? $program['duration_sw'] : $program['duration'] }}
                        </span>
                        <span class="text-sm text-blue-600 font-semibold">
                            {{ $program['participants'] }} participants
                        </span>
                    </div>
                    <a href="{{ route('programs.show', $program['slug']) }}" 
                       class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors inline-block">
                        {{ __('messages.learn_more') }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection