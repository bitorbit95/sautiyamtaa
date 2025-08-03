@extends('layouts.guest')

@section('title', $program->getLocalizedTitle() . ' - ' . __('navigation.programs'))

@section('content')
<!-- Hero Section -->
<section class="relative bg-gray-900 text-white">
    @if($program->getImageUrl())
        <div class="absolute inset-0">
            <img src="{{ $program->getImageUrl() }}" alt="{{ $program->getLocalizedTitle() }}" class="w-full h-full object-cover opacity-50">
        </div>
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-red-600 to-black opacity-90"></div>
    @endif
    
    <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="max-w-2xl">
            <!-- Breadcrumb -->
            <nav class="mb-4">
                <ol class="flex items-center space-x-2 text-xs">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white">{{ __('Home') }}</a></li>
                    <li><span class="text-gray-400">/</span></li>
                    <li><a href="{{ route('programs') }}" class="text-gray-300 hover:text-white">{{ __('navigation.programs') }}</a></li>
                    <li><span class="text-gray-400">/</span></li>
                    <li class="text-white">{{ $program->getLocalizedTitle() }}</li>
                </ol>
            </nav>

            <div class="flex items-center gap-3 mb-4">
                <h1 class="text-2xl md:text-3xl font-bold">{{ $program->getLocalizedTitle() }}</h1>
                @if($program->is_featured)
                    <span class="bg-red-400 text-white px-2 py-1 rounded-full text-xs font-semibold">
                        {{ __('Featured') }}
                    </span>
                @endif
            </div>

            <p class="text-lg text-gray-100 mb-6 font-medium">{{ $program->getLocalizedDescription() }}</p>

            <!-- Program Status -->
            @if($program->start_date)
                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                    @if($program->isUpcoming()) bg-blue-100 text-blue-800
                    @elseif($program->isOngoing()) bg-red-100 text-red-800
                    @elseif($program->isCompleted()) bg-gray-100 text-gray-800
                    @else bg-white text-gray-800
                    @endif">
                    @if($program->isUpcoming()) 
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                        {{ __('Upcoming') }}
                    @elseif($program->isOngoing())
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ __('Ongoing') }}
                    @elseif($program->isCompleted())
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        {{ __('Completed') }}
                    @else
                        {{ __('Open') }}
                    @endif
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Program Details -->
<section class="py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Program Description -->
                @if($program->getLocalizedFullDescription())
                <div class="prose prose-lg max-w-none mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('About This Program') }}</h2>
                    <div class="text-gray-800 leading-relaxed">
                        {!! nl2br(e($program->getLocalizedFullDescription())) !!}
                    </div>
                </div>
                @endif

                <!-- Program Objectives -->
                @if($program->objectives && count($program->objectives) > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('Program Objectives') }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($program->objectives as $objective)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-5 h-5 bg-red-100 rounded-full flex items-center justify-center mt-0.5 mr-2">
                                <svg class="w-3 h-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <p class="text-gray-800 text-sm font-medium">{{ $objective }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Program Requirements -->
                @if($program->requirements && count($program->requirements) > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('Requirements') }}</h2>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <ul class="space-y-2">
                            @foreach($program->requirements as $requirement)
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-red-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-800 text-sm font-medium">{{ $requirement }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <!-- Gallery -->
                @if($program->getGalleryUrls() && count($program->getGalleryUrls()) > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">{{ __('Gallery') }}</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($program->getGalleryUrls() as $image)
                        <div class="aspect-square bg-gray-200 rounded-lg overflow-hidden cursor-pointer hover:opacity-90 transition-opacity">
                            <img src="{{ $image }}" alt="{{ $program->getLocalizedTitle() }}" class="w-full h-full object-cover">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Program Info Card -->
                <div class="bg-white rounded-lg shadow-lg p-4 mb-6 sticky top-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Program Information') }}</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-700 text-sm font-medium">{{ __('Duration') }}</span>
                            <span class="font-semibold text-sm text-gray-900">{{ $program->getLocalizedDuration() }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-700 text-sm font-medium">{{ __('Participants') }}</span>
                            <span class="font-bold text-red-600 text-sm">{{ $program->participants }}</span>
                        </div>
                        
                        @if($program->getLocalizedLocation())
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-700 text-sm font-medium">{{ __('Location') }}</span>
                            <span class="font-semibold text-sm text-gray-900">{{ $program->getLocalizedLocation() }}</span>
                        </div>
                        @endif
                        
                        @if($program->cost)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-700 text-sm font-medium">{{ __('Cost') }}</span>
                            <span class="font-semibold text-sm text-gray-900">${{ number_format($program->cost, 2) }}</span>
                        </div>
                        @endif
                        
                        @if($program->start_date)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-700 text-sm font-medium">{{ __('Start Date') }}</span>
                            <span class="font-semibold text-sm text-gray-900">{{ $program->start_date->format('M d, Y') }}</span>
                        </div>
                        @endif
                        
                        @if($program->end_date)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-700 text-sm font-medium">{{ __('End Date') }}</span>
                            <span class="font-semibold text-sm text-gray-900">{{ $program->end_date->format('M d, Y') }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Call to Action -->
                    <div class="mt-6 space-y-2">
                        <a href="{{ route('contact') }}?program={{ $program->slug }}" 
                           class="block w-full bg-red-600 text-white text-center px-4 py-2 rounded-md hover:bg-red-700 transition-colors font-semibold text-sm">
                            {{ __('Join This Program') }}
                        </a>
                        <a href="{{ route('contact') }}" 
                           class="block w-full border border-gray-400 text-gray-800 bg-gray-50 text-center px-4 py-2 rounded-md hover:bg-gray-100 hover:border-gray-500 transition-colors text-sm font-medium">
                            {{ __('Get More Info') }}
                        </a>
                    </div>
                </div>

                <!-- Share -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ __('Share This Program') }}</h3>
                    <div class="flex space-x-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                           target="_blank" 
                           class="flex-1 bg-blue-600 text-white text-center py-2 rounded text-xs hover:bg-blue-700 transition-colors">
                            Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($program->getLocalizedTitle()) }}" 
                           target="_blank" 
                           class="flex-1 bg-blue-400 text-white text-center py-2 rounded text-xs hover:bg-blue-500 transition-colors">
                            Twitter
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($program->getLocalizedTitle() . ' - ' . request()->url()) }}" 
                           target="_blank" 
                           class="flex-1 bg-green-500 text-white text-center py-2 rounded text-xs hover:bg-green-600 transition-colors">
                            WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Programs -->
@if($relatedPrograms->count() > 0)
<section class="py-12 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-center mb-8 text-gray-900">{{ __('Related Programs') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($relatedPrograms as $relatedProgram)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                @if($relatedProgram->getImageUrl())
                    <img src="{{ $relatedProgram->getImageUrl() }}" alt="{{ $relatedProgram->getLocalizedTitle() }}" class="w-full h-32 object-cover">
                @else
                    <div class="h-32 bg-gradient-to-r from-red-500 to-black"></div>
                @endif
                <div class="p-4">
                    <h3 class="text-lg font-semibold mb-2">{{ $relatedProgram->getLocalizedTitle() }}</h3>
                    <p class="text-gray-700 mb-3 text-sm line-clamp-2 font-medium">{{ $relatedProgram->getLocalizedDescription() }}</p>
                    <div class="flex justify-between items-center mb-3 text-xs">
                        <span class="text-gray-600 font-medium">{{ $relatedProgram->getLocalizedDuration() }}</span>
                        <span class="text-red-600 font-bold">{{ $relatedProgram->participants }} {{ __('participants') }}</span>
                    </div>
                    <a href="{{ route('programs.show', $relatedProgram->slug) }}" 
                       class="block w-full bg-red-600 text-white text-center px-4 py-2 rounded-md hover:bg-red-700 transition-colors text-sm">
                        {{ __('messages.learn_more') }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('programs') }}" 
               class="inline-block bg-black text-white px-6 py-2 rounded-md hover:bg-gray-800 transition-colors text-sm">
                {{ __('View All Programs') }}
            </a>
        </div>
    </div>
</section>
@endif
@endsection

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush