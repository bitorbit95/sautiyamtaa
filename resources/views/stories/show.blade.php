@extends('layouts.guest')

@section('title', $story->getLocalizedTitle() . ' - ' . __('Stories'))

@section('meta')
<meta name="description" content="{{ $story->getLocalizedMetaDescription() ?: $story->getLocalizedExcerpt() }}">
<meta property="og:title" content="{{ $story->getLocalizedTitle() }}">
<meta property="og:description" content="{{ $story->getLocalizedMetaDescription() ?: $story->getLocalizedExcerpt() }}">
@if($story->getFeaturedImageUrl())
<meta property="og:image" content="{{ $story->getFeaturedImageUrl() }}">
@endif
<meta property="og:type" content="article">
<meta property="og:url" content="{{ request()->url() }}">
@endsection

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-black via-red-900 to-black text-white overflow-hidden">
    @if($story->getFeaturedImageUrl())
        <div class="absolute inset-0">
            <img src="{{ $story->getFeaturedImageUrl() }}" alt="{{ $story->getLocalizedTitle() }}" class="w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-black/30"></div>
        </div>
    @endif
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors">{{ __('Home') }}</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li><a href="{{ route('stories') }}" class="text-gray-300 hover:text-white transition-colors">{{ __('Stories') }}</a></li>
                <li><span class="text-gray-400">/</span></li>
                <li class="text-red-400">{{ $story->getLocalizedTitle() }}</li>
            </ol>
        </nav>

        <div class="max-w-4xl">
            <!-- Story Type Badge -->
            <div class="flex items-center space-x-4 mb-6">
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
                    @if($story->getTypeConfig()['color'] === 'red') bg-red-600 text-white
                    @else bg-gray-700 text-white
                    @endif">
                    @if($story->getTypeConfig()['icon'] === 'heart')
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                        </svg>
                    @elseif($story->getTypeConfig()['icon'] === 'quote')
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    @elseif($story->getTypeConfig()['icon'] === 'trophy')
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    @else
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                        </svg>
                    @endif
                    {{ $story->getLocalizedTypeLabel() }}
                </span>
                
                @if($story->is_featured)
                    <span class="bg-yellow-500 text-black px-4 py-2 rounded-full text-sm font-semibold">
                        <svg class="w-4 h-4 mr-2 inline" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        {{ __('Featured') }}
                    </span>
                @endif
            </div>

            <h1 class="text-4xl md:text-6xl font-bold mb-6 bg-gradient-to-r from-white to-red-300 bg-clip-text text-transparent">
                {{ $story->getLocalizedTitle() }}
            </h1>

            <p class="text-xl md:text-2xl text-gray-200 mb-8 leading-relaxed">
                {{ $story->getLocalizedExcerpt() }}
            </p>

            <!-- Story Meta Info -->
            <div class="flex flex-wrap items-center space-x-6 text-gray-300">
                @if($story->getFormattedStoryDate())
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $story->getFormattedStoryDate() }}
                    </div>
                @endif
                
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $story->getReadingTime() }} {{ __('min read') }}
                </div>
                
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    {{ $story->views }} {{ __('views') }}
                </div>

                @if($story->getLocalizedLocation())
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $story->getLocalizedLocation() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Story Content -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Author Info -->
                @if($story->author_name)
                <div class="bg-gradient-to-r from-red-50 to-gray-50 border-l-4 border-red-600 rounded-lg p-6 mb-8">
                    <div class="flex items-center">
                        @if($story->getAuthorImageUrl())
                            <img src="{{ $story->getAuthorImageUrl() }}" alt="{{ $story->author_name }}" class="w-16 h-16 rounded-full mr-4">
                        @else
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-red-600 to-red-700 flex items-center justify-center mr-4">
                                <span class="text-white font-bold text-xl">{{ substr($story->author_name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $story->author_name }}</h3>
                            @if($story->getLocalizedAuthorTitle())
                                <p class="text-gray-600">{{ $story->getLocalizedAuthorTitle() }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Video Embed -->
                @if($story->hasVideo())
                <div class="mb-8">
                    {!! $story->getEmbeddedVideo() !!}
                </div>
                @endif

                <!-- Story Content -->
                <div class="prose prose-lg max-w-none mb-12">
                    <div class="text-gray-800 leading-relaxed">
                        {!! nl2br(e($story->getLocalizedContent())) !!}
                    </div>
                </div>

                <!-- Gallery -->
                @if($story->getGalleryUrls() && count($story->getGalleryUrls()) > 0)
                <div class="mb-12">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 border-l-4 border-red-600 pl-4">{{ __('Gallery') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($story->getGalleryUrls() as $image)
                        <div class="aspect-square bg-gray-200 rounded-lg overflow-hidden cursor-pointer hover:opacity-90 transition-opacity group">
                            <img src="{{ $image }}" alt="{{ $story->getLocalizedTitle() }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Tags -->
                @if($story->tags && count($story->tags) > 0)
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Tags') }}</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($story->tags as $tag)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 hover:bg-red-200 transition-colors">
                            #{{ $tag }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Share Section -->
                <div class="border-t border-gray-200 pt-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Share This Story') }}</h3>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                           target="_blank" 
                           class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($story->getLocalizedTitle()) }}" 
                           target="_blank" 
                           class="flex items-center px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                            Twitter
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($story->getLocalizedTitle() . ' - ' . request()->url()) }}" 
                           target="_blank" 
                           class="flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                            WhatsApp
                        </a>
                        <button onclick="copyToClipboard()" 
                                class="flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            {{ __('Copy Link') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Story Info Card -->
                <div class="bg-white rounded-xl shadow-lg border-t-4 border-red-600 p-6 mb-8 sticky top-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">{{ __('Story Details') }}</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600">{{ __('Type') }}</span>
                            <span class="font-semibold text-red-600">{{ $story->getLocalizedTypeLabel() }}</span>
                        </div>
                        
                        @if($story->getFormattedStoryDate())
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600">{{ __('Date') }}</span>
                            <span class="font-medium">{{ $story->getFormattedStoryDate() }}</span>
                        </div>
                        @endif
                        
                        @if($story->getLocalizedLocation())
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600">{{ __('Location') }}</span>
                            <span class="font-medium">{{ $story->getLocalizedLocation() }}</span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between items-center py-2 border-b border-gray-100">
                            <span class="text-gray-600">{{ __('Reading Time') }}</span>
                            <span class="font-medium">{{ $story->getReadingTime() }} {{ __('minutes') }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-600">{{ __('Views') }}</span>
                            <span class="font-medium">{{ number_format($story->views) }}</span>
                        </div>
                    </div>
                    
                    <!-- Call to Action -->
                    <div class="mt-8 space-y-3">
                        <a href="{{ route('contact') }}?story={{ $story->slug }}" 
                           class="block w-full bg-gradient-to-r from-red-600 to-red-700 text-white text-center px-6 py-3 rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 font-semibold transform hover:scale-105">
                            {{ __('Share Your Story') }}
                        </a>
                        <a href="{{ route('programs') }}" 
                           class="block w-full border-2 border-red-600 text-red-600 text-center px-6 py-3 rounded-lg hover:bg-red-50 transition-colors">
                            {{ __('Join Our Programs') }}
                        </a>
                    </div>
                </div>

                <!-- Related Stories Preview -->
                @if($relatedStories->count() > 0)
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">{{ __('Related Stories') }}</h3>
                    <div class="space-y-4">
                        @foreach($relatedStories->take(3) as $relatedStory)
                        <a href="{{ route('stories.show', $relatedStory->slug) }}" 
                           class="block group">
                            <div class="flex">
                                @if($relatedStory->getFeaturedImageUrl())
                                    <img src="{{ $relatedStory->getFeaturedImageUrl() }}" alt="{{ $relatedStory->getLocalizedTitle() }}" class="w-16 h-16 rounded-lg object-cover flex-shrink-0">
                                @else
                                    <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-red-600 to-black flex-shrink-0"></div>
                                @endif
                                <div class="ml-3 flex-1">
                                    <h4 class="text-sm font-semibold text-gray-900 group-hover:text-red-600 transition-colors line-clamp-2">
                                        {{ $relatedStory->getLocalizedTitle() }}
                                    </h4>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $relatedStory->getLocalizedTypeLabel() }}
                                    </p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <a href="{{ route('stories') }}" 
                       class="block mt-6 text-center text-red-600 hover:text-red-700 font-semibold">
                        {{ __('View All Stories') }} →
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Related Stories -->
@if($relatedStories->count() > 0)
<section class="py-20 bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-white mb-4">{{ __('More Stories Like This') }}</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-red-500 to-red-300 rounded mx-auto"></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($relatedStories as $relatedStory)
            <div class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-red-500/20 transition-all duration-300 transform hover:-translate-y-2">
                @if($relatedStory->getFeaturedImageUrl())
                    <img src="{{ $relatedStory->getFeaturedImageUrl() }}" alt="{{ $relatedStory->getLocalizedTitle() }}" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                @else
                    <div class="h-48 bg-gradient-to-r from-red-600 to-black"></div>
                @endif
                <div class="p-6">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold mb-3
                        @if($relatedStory->getTypeConfig()['color'] === 'red') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ $relatedStory->getLocalizedTypeLabel() }}
                    </span>
                    <h3 class="text-xl font-bold mb-3 text-gray-900 group-hover:text-red-600 transition-colors">
                        {{ $relatedStory->getLocalizedTitle() }}
                    </h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $relatedStory->getLocalizedExcerpt() }}</p>
                    <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                        @if($relatedStory->getFormattedStoryDate())
                            <span>{{ $relatedStory->getFormattedStoryDate() }}</span>
                        @endif
                        <span>{{ $relatedStory->getReadingTime() }} {{ __('min read') }}</span>
                    </div>
                    <a href="{{ route('stories.show', $relatedStory->slug) }}" 
                       class="block w-full bg-gradient-to-r from-red-600 to-red-700 text-white text-center px-6 py-2 rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-300 font-semibold">
                        {{ __('Read Story') }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('stories') }}" 
               class="inline-block bg-white text-red-600 px-8 py-3 rounded-lg hover:bg-red-50 transition-colors font-bold">
                {{ __('View All Stories') }}
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

@push('scripts')
<script>
function copyToClipboard() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        // You could add a toast notification here
        alert('{{ __("Link copied to clipboard!") }}');
    });
}
</script>
@endpush