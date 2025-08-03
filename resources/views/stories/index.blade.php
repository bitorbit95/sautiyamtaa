@extends('layouts.guest')

@section('title', __('Stories'))

@section('content')
<!-- Hero Section with Red & Black Theme -->
<section class="relative bg-gradient-to-r from-red-900 via-black to-red-800 text-white py-24 overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Cpath d="M30 30c0-11.046-8.954-20-20-20s-20 8.954-20 20 8.954 20 20 20 20-8.954 20-20z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6 bg-gradient-to-r from-red-400 to-white bg-clip-text text-transparent">
                {{ __('Our Stories') }}
            </h1>
            <p class="text-xl md:text-2xl max-w-4xl mx-auto leading-relaxed text-gray-200">
                {{ __('Real stories of transformation, hope, and impact from our community') }}
            </p>
            <div class="mt-8 flex justify-center">
                <div class="w-24 h-1 bg-gradient-to-r from-red-500 to-red-300 rounded"></div>
            </div>
        </div>
    </div>

    <!-- Floating Elements -->
    <div class="absolute top-20 left-10 w-4 h-4 bg-red-500 rounded-full opacity-60 animate-pulse"></div>
    <div class="absolute bottom-20 right-20 w-6 h-6 bg-white rounded-full opacity-40 animate-bounce" style="animation-delay: 1s;"></div>
    <div class="absolute top-1/2 right-10 w-3 h-3 bg-red-400 rounded-full opacity-50 animate-ping" style="animation-delay: 2s;"></div>
</section>

<!-- Search and Filter Section -->
<section class="py-8 bg-gray-100 border-b-4 border-red-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('stories.index') }}" class="flex flex-col lg:flex-row gap-6 items-center justify-between">
            <!-- Search -->
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="{{ __('Search stories...') }}" 
                           class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Story Type Filter -->
            <div class="flex gap-4 items-center flex-wrap">
                <select name="type" class="border-2 border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white shadow-sm">
                    <option value="">{{ __('All Story Types') }}</option>
                    @foreach($storyTypes as $key => $typeConfig)
                        <option value="{{ $key }}" {{ request('type') === $key ? 'selected' : '' }}>
                            {{ app()->getLocale() === 'sw' ? $typeConfig['label_sw'] : $typeConfig['label'] }}
                        </option>
                    @endforeach
                </select>
                
                <button type="submit" class="bg-gradient-to-r from-red-600 to-red-700 text-white px-8 py-3 rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 font-semibold shadow-lg transform hover:scale-105">
                    {{ __('Filter') }}
                </button>
                
                @if(request()->hasAny(['search', 'type']))
                    <a href="{{ route('stories') }}" class="text-gray-600 hover:text-red-600 transition-colors font-medium">
                        {{ __('Clear Filters') }}
                    </a>
                @endif
            </div>
        </form>
    </div>
</section>

<!-- Featured Stories Section -->
@if($featuredStories->count() > 0 && !request()->hasAny(['search', 'type']))
<section class="py-20 bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-white mb-4">{{ __('Featured Stories') }}</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-red-500 to-red-300 rounded mx-auto"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($featuredStories as $story)
            <div class="group bg-white rounded-xl shadow-2xl overflow-hidden hover:shadow-red-500/20 transition-all duration-500 transform hover:-translate-y-2">
                <div class="relative">
                    @if($story->getFeaturedImageUrl())
                        <img src="{{ $story->getFeaturedImageUrl() }}" alt="{{ $story->getLocalizedTitle() }}" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="h-64 bg-gradient-to-br from-red-600 to-black"></div>
                    @endif
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-600 text-white">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            {{ __('Featured') }}
                        </span>
                    </div>
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                            @if($story->getTypeConfig()['color'] === 'red') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $story->getLocalizedTypeLabel() }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-3 text-gray-900 group-hover:text-red-600 transition-colors">
                        {{ $story->getLocalizedTitle() }}
                    </h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $story->getLocalizedExcerpt() }}</p>
                    
                    @if($story->author_name)
                    <div class="flex items-center mb-4">
                        @if($story->getAuthorImageUrl())
                            <img src="{{ $story->getAuthorImageUrl() }}" alt="{{ $story->author_name }}" class="w-10 h-10 rounded-full mr-3">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-red-500 to-red-600 flex items-center justify-center mr-3">
                                <span class="text-white font-semibold text-sm">{{ substr($story->author_name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $story->author_name }}</p>
                            @if($story->getLocalizedAuthorTitle())
                                <p class="text-xs text-gray-500">{{ $story->getLocalizedAuthorTitle() }}</p>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <div class="flex justify-between items-center">
                        <div class="flex items-center text-sm text-gray-500">
                            @if($story->getFormattedStoryDate())
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $story->getFormattedStoryDate() }}
                            @endif
                        </div>
                        <span class="text-xs text-gray-400">{{ $story->getReadingTime() }} {{ __('min read') }}</span>
                    </div>
                    
                    <a href="{{ route('stories.show', $story->slug) }}" 
                       class="block w-full mt-6 bg-gradient-to-r from-red-600 to-red-700 text-white text-center px-6 py-3 rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 font-semibold transform hover:scale-105">
                        {{ __('Read Story') }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- All Stories Grid -->
<section class="py-20 {{ $featuredStories->count() > 0 && !request()->hasAny(['search', 'type']) ? 'bg-gray-50' : 'bg-white' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(request()->hasAny(['search', 'type']))
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900">
                    {{ __('Search Results') }} 
                    <span class="text-gray-600 font-normal text-xl">({{ $stories->total() }} {{ __('stories found') }})</span>
                </h2>
                <div class="w-16 h-1 bg-gradient-to-r from-red-500 to-red-300 rounded mt-2"></div>
            </div>
        @else
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ __('All Stories') }}</h2>
                <div class="w-24 h-1 bg-gradient-to-r from-red-500 to-red-300 rounded mx-auto"></div>
            </div>
        @endif

        @if($stories->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach($stories as $story)
                <div class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border-l-4 border-red-600">
                    <div class="md:flex">
                        <div class="md:w-2/5">
                            @if($story->getFeaturedImageUrl())
                                <img src="{{ $story->getFeaturedImageUrl() }}" alt="{{ $story->getLocalizedTitle() }}" class="w-full h-64 md:h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-64 md:h-full bg-gradient-to-br from-red-600 via-red-700 to-black"></div>
                            @endif
                        </div>
                        <div class="md:w-3/5 p-6">
                            <div class="flex justify-between items-start mb-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    @if($story->getTypeConfig()['color'] === 'red') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $story->getLocalizedTypeLabel() }}
                                </span>
                                @if($story->is_featured)
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">
                                        {{ __('Featured') }}
                                    </span>
                                @endif
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-red-600 transition-colors">
                                {{ $story->getLocalizedTitle() }}
                            </h3>
                            
                            <p class="text-gray-600 mb-4 line-clamp-3">{{ $story->getLocalizedExcerpt() }}</p>
                            
                            @if($story->author_name)
                            <div class="flex items-center mb-4">
                                @if($story->getAuthorImageUrl())
                                    <img src="{{ $story->getAuthorImageUrl() }}" alt="{{ $story->author_name }}" class="w-8 h-8 rounded-full mr-3">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-red-500 to-red-600 flex items-center justify-center mr-3">
                                        <span class="text-white font-semibold text-xs">{{ substr($story->author_name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $story->author_name }}</p>
                                    @if($story->getLocalizedAuthorTitle())
                                        <p class="text-xs text-gray-500">{{ $story->getLocalizedAuthorTitle() }}</p>
                                    @endif
                                </div>
                            </div>
                            @endif
                            
                            <div class="flex justify-between items-center mb-4 text-sm text-gray-500">
                                <div class="flex items-center">
                                    @if($story->getFormattedStoryDate())
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $story->getFormattedStoryDate() }}
                                    @endif
                                </div>
                                <div class="flex items-center space-x-4">
                                    <span>{{ $story->getReadingTime() }} {{ __('min read') }}</span>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        {{ $story->views }}
                                    </div>
                                </div>
                            </div>
                            
                            <a href="{{ route('stories.show', $story->slug) }}" 
                               class="inline-block bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-2 rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 font-semibold transform hover:scale-105">
                                {{ __('Read Story') }}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-16">
                {{ $stories->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <div class="max-w-md mx-auto">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('No stories found') }}</h3>
                    <p class="text-gray-600 mb-8">{{ __('Try adjusting your search criteria or browse all stories.') }}</p>
                    <a href="{{ route('stories.index') }}" class="inline-block bg-gradient-to-r from-red-600 to-red-700 text-white px-8 py-3 rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 font-semibold">
                        {{ __('View All Stories') }}
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Story Types Section -->
<section class="py-20 bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-white mb-4">{{ __('Explore by Story Type') }}</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-red-500 to-red-300 rounded mx-auto"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($storyTypes as $key => $typeConfig)
            <a href="{{ url('stories/type', $key) }}" 
               class="group block bg-gradient-to-br from-gray-900 to-black border-2 border-gray-800 rounded-xl p-8 text-center hover:border-red-500 transition-all duration-300 transform hover:-translate-y-2">
                <div class="mb-6">
                    <div class="w-16 h-16 mx-auto rounded-full bg-gradient-to-r 
                        @if($typeConfig['color'] === 'red') from-red-600 to-red-700
                        @else from-gray-600 to-gray-700
                        @endif 
                        flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        @if($typeConfig['icon'] === 'heart')
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                        @elseif($typeConfig['icon'] === 'quote')
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        @elseif($typeConfig['icon'] === 'trophy')
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @else
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                            </svg>
                        @endif
                    </div>
                </div>
                <h3 class="text-xl font-bold text-white mb-2 group-hover:text-red-400 transition-colors">
                    {{ app()->getLocale() === 'sw' ? $typeConfig['label_sw'] : $typeConfig['label'] }}
                </h3>
                <p class="text-gray-400 text-sm group-hover:text-gray-300 transition-colors">
                    {{ __('Explore stories of transformation') }}
                </p>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="bg-gradient-to-r from-red-600 via-red-700 to-black text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold mb-6">{{ __('Have a Story to Share?') }}</h2>
        <p class="text-xl mb-10 max-w-3xl mx-auto text-red-100">
            {{ __('Your story could inspire others. Share your journey with our community and help spread hope.') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ route('contact') }}" 
               class="bg-white text-red-600 px-8 py-4 rounded-lg hover:bg-red-50 transition-all duration-300 font-bold text-lg transform hover:scale-105 shadow-xl">
                {{ __('Share Your Story') }}
            </a>
            <a href="{{ route('programs') }}" 
               class="border-2 border-white text-white px-8 py-4 rounded-lg hover:bg-white hover:text-red-600 transition-all duration-300 font-bold text-lg transform hover:scale-105">
                {{ __('Join Our Programs') }}
            </a>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Custom pagination styles */
.pagination {
    @apply flex justify-center space-x-2;
}

.pagination .page-link {
    @apply px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-red-50 hover:border-red-300 hover:text-red-600 transition-colors;
}

.pagination .page-item.active .page-link {
    @apply bg-red-600 border-red-600 text-white;
}

.pagination .page-item.disabled .page-link {
    @apply text-gray-400 cursor-not-allowed;
}
</style>
@endpush