@extends('layouts.guest')

@section('title', __('navigation.programs'))

@section('content')
<!-- Page Header -->
<section class="bg-gradient-to-r from-red-600 to-red-800 text-white py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">{{ __('navigation.programs') }}</h1>
            <p class="text-xl md:text-2xl max-w-3xl mx-auto leading-relaxed opacity-95">
                {{ __('Discover our comprehensive programs designed to empower and transform lives in our community') }}
            </p>
        </div>
    </div>
</section>

<!-- Search and Filter Section -->
<section class="py-8 bg-gray-50 border-b">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('programs') }}" class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="flex-1 max-w-md w-full">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="{{ __('Search programs...') }}" 
                           class="w-full pl-10 pr-4 py-3 text-base border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors bg-white">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="flex gap-4 items-center w-full md:w-auto">
                <select name="status" class="border-2 border-gray-300 rounded-lg px-4 py-3 text-base focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white min-w-0 flex-1 md:flex-none">
                    <option value="">{{ __('All Programs') }}</option>
                    <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>{{ __('Upcoming') }}</option>
                    <option value="ongoing" {{ request('status') === 'ongoing' ? 'selected' : '' }}>{{ __('Ongoing') }}</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                </select>
                
                <button type="submit" class="bg-red-600 text-white px-6 py-3 text-base font-semibold rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors whitespace-nowrap">
                    {{ __('Filter') }}
                </button>
                
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('programs') }}" class="text-red-600 hover:text-red-800 transition-colors text-base font-medium underline whitespace-nowrap">
                        {{ __('Clear') }}
                    </a>
                @endif
            </div>
        </form>
    </div>
</section>

<!-- Featured Programs Section -->
@if($featuredPrograms->count() > 0 && !request()->hasAny(['search', 'status']))
<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-900">{{ __('Featured Programs') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredPrograms as $program)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100">
                <div class="relative">
                    @if($program->getImageUrl())
                        <img src="{{ $program->getImageUrl() }}" alt="{{ $program->getLocalizedTitle() }}" class="w-full h-48 object-cover">
                    @else
                        <div class="h-48 bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center">
                            <svg class="w-16 h-16 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-3 right-3">
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-md">
                            {{ __('Featured') }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-gray-900 leading-tight">{{ $program->getLocalizedTitle() }}</h3>
                    <p class="text-gray-700 mb-4 text-base line-clamp-3 leading-relaxed">{{ $program->getLocalizedDescription() }}</p>
                    <div class="space-y-2 mb-6 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">{{ __('Duration') }}:</span>
                            <span class="text-gray-900 font-semibold">{{ $program->getLocalizedDuration() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">{{ __('Participants') }}:</span>
                            <span class="text-red-600 font-bold">{{ $program->participants }}</span>
                        </div>
                    </div>
                    <a href="{{ route('programs.show', $program->slug) }}" 
                       class="block w-full bg-red-600 text-white text-center px-6 py-3 rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors font-bold text-base">
                        {{ __('messages.learn_more') }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- All Programs Grid -->
<section class="py-16 {{ $featuredPrograms->count() > 0 && !request()->hasAny(['search', 'status']) ? 'bg-gray-50' : 'bg-white' }}">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(request()->hasAny(['search', 'status']))
            <div class="mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">
                    {{ __('Search Results') }} 
                    <span class="text-gray-600 font-normal text-lg">({{ $programs->total() }} {{ __('programs found') }})</span>
                </h2>
            </div>
        @else
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-900">{{ __('All Programs') }}</h2>
        @endif

        @if($programs->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach($programs as $program)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100">
                    <div class="md:flex">
                        <div class="md:w-2/5">
                            @if($program->getImageUrl())
                                <img src="{{ $program->getImageUrl() }}" alt="{{ $program->getLocalizedTitle() }}" class="w-full h-48 md:h-full object-cover">
                            @else
                                <div class="w-full h-48 md:h-full bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="md:w-3/5 p-6">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-xl font-bold text-gray-900 leading-tight flex-1 pr-2">{{ $program->getLocalizedTitle() }}</h3>
                                @if($program->is_featured)
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-bold whitespace-nowrap">
                                        {{ __('Featured') }}
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-gray-700 mb-4 text-base line-clamp-2 leading-relaxed">{{ $program->getLocalizedDescription() }}</p>
                            
                            <div class="space-y-2 mb-6 text-sm">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 font-medium">{{ __('Duration') }}:</span>
                                    <span class="text-gray-900 font-semibold">{{ $program->getLocalizedDuration() }}</span>
                                </div>
                                @if($program->getLocalizedLocation())
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 font-medium">{{ __('Location') }}:</span>
                                    <span class="text-gray-900 font-semibold">{{ $program->getLocalizedLocation() }}</span>
                                </div>
                                @endif
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 font-medium">{{ __('Participants') }}:</span>
                                    <span class="text-red-600 font-bold">{{ $program->participants }}</span>
                                </div>
                                @if($program->start_date)
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600 font-medium">{{ __('Status') }}:</span>
                                    <span class="font-bold
                                        @if($program->isUpcoming()) text-blue-600
                                        @elseif($program->isOngoing()) text-green-600
                                        @elseif($program->isCompleted()) text-gray-600
                                        @endif">
                                        @if($program->isUpcoming()) {{ __('Upcoming') }}
                                        @elseif($program->isOngoing()) {{ __('Ongoing') }}
                                        @elseif($program->isCompleted()) {{ __('Completed') }}
                                        @else {{ __('Open') }}
                                        @endif
                                    </span>
                                </div>
                                @endif
                            </div>
                            
                            <a href="{{ route('programs.show', $program->slug) }}" 
                               class="inline-block bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors font-bold text-base">
                                {{ __('messages.learn_more') }}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $programs->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <svg class="mx-auto h-20 w-20 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('No programs found') }}</h3>
                    <p class="text-gray-600 mb-6 text-base leading-relaxed">{{ __('Try adjusting your search criteria or browse all programs.') }}</p>
                    <a href="{{ route('programs') }}" class="inline-block bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors font-bold text-base">
                        {{ __('View All Programs') }}
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Call to Action -->
<section class="bg-gradient-to-r from-gray-900 to-red-600 text-white py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">{{ __('Ready to Make a Difference?') }}</h2>
        <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto leading-relaxed opacity-95">
            {{ __('Join our programs and be part of the positive change in our community.') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('contact') }}" 
               class="bg-white text-red-600 px-8 py-4 rounded-lg hover:bg-gray-100 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-red-600 transition-colors font-bold text-base">
                {{ __('Get Involved') }}
            </a>
            <a href="{{ route('donate.index') }}" 
               class="border-2 border-white text-white px-8 py-4 rounded-lg hover:bg-white hover:text-red-600 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-red-600 transition-colors font-bold text-base">
                {{ __('Support Our Work') }}
            </a>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.5;
}
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.5;
}

/* Ensure text is visible on all backgrounds */
.text-gray-900 { color: #111827 !important; }
.text-gray-800 { color: #1f2937 !important; }
.text-gray-700 { color: #374151 !important; }
.text-gray-600 { color: #4b5563 !important; }
.text-white { color: #ffffff !important; }
.text-red-600 { color: #dc2626 !important; }
.text-red-800 { color: #991b1b !important; }
.text-blue-600 { color: #2563eb !important; }
.text-green-600 { color: #16a34a !important; }

/* Improve contrast for better visibility */
.bg-white { background-color: #ffffff !important; }
.bg-gray-50 { background-color: #f9fafb !important; }
.bg-gray-100 { background-color: #f3f4f6 !important; }

/* Focus states for accessibility */
input:focus, select:focus, button:focus, a:focus {
    outline: none;
}

/* Ensure buttons are clearly visible */
.bg-red-600 {
    background-color: #dc2626 !important;
    color: #ffffff !important;
}

.bg-red-600:hover {
    background-color: #b91c1c !important;
}

/* Mobile text improvements */
@media (max-width: 640px) {
    .text-sm { font-size: 0.95rem !important; }
    .text-base { font-size: 1.05rem !important; }
    .text-lg { font-size: 1.2rem !important; }
    .text-xl { font-size: 1.3rem !important; }
}
</style>
@endpush