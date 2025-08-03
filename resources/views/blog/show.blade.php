{{-- resources/views/blog/show.blade.php --}}
@extends('layouts.blog')

@section('title', $post->title . ' - ' . config('app.name'))
@section('description', $post->excerpt)

@section('meta')
<!-- Open Graph / Facebook -->
<meta property="og:type" content="article">
<meta property="og:title" content="{{ $post->title }}">
<meta property="og:description" content="{{ $post->excerpt }}">
@if($post->featured_image)
<meta property="og:image" content="{{ asset($post->featured_image) }}">
@endif
<meta property="og:url" content="{{ route('blog.show', $post->slug) }}">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $post->title }}">
<meta name="twitter:description" content="{{ $post->excerpt }}">
@if($post->featured_image)
<meta name="twitter:image" content="{{ asset($post->featured_image) }}">
@endif

<!-- Article meta -->
<meta property="article:published_time" content="{{ $post->published_at->toISOString() }}">
<meta property="article:author" content="{{ $post->author->name }}">
<meta property="article:section" content="{{ $post->category->name }}">
@foreach($post->tags as $tag)
<meta property="article:tag" content="{{ $tag->name }}">
@endforeach
@endsection

@section('content')
<article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-8">
        <a href="{{ route('blog.index') }}" class="hover:text-blue-600 transition-colors">Blog</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('blog.category', $post->category->slug) }}" class="hover:text-blue-600 transition-colors">{{ $post->category->name }}</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-900">{{ $post->title }}</span>
    </nav>

    <!-- Post Header -->
    <header class="mb-8">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 leading-tight">{{ $post->title }}</h1>
        
        <div class="flex flex-wrap items-center gap-4 text-gray-600 mb-6">
            <div class="flex items-center">
                @if($post->author->avatar)
                <img class="w-10 h-10 rounded-full mr-3" src="{{ asset($post->author->avatar) }}" alt="{{ $post->author->name }}">
                @else
                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                    <span class="text-sm font-medium text-gray-700">{{ substr($post->author->name, 0, 1) }}</span>
                </div>
                @endif
                <div>
                    <p class="font-medium text-gray-900">{{ $post->author->name }}</p>
                    <p class="text-sm">{{ $post->author->title ?? 'Author' }}</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-4 text-sm">
                <span class="flex items-center">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    {{ $post->published_at->format('F j, Y') }}
                </span>
                <span class="flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    {{ $post->reading_time ?? '5' }} min read
                </span>
                <span class="flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    {{ $post->views_count ?? 0 }} views
                </span>
            </div>
        </div>

        <!-- Category and Tags -->
        <div class="flex flex-wrap items-center gap-2 mb-6">
            <a href="{{ route('blog.category', $post->category->slug) }}" class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full hover:bg-blue-200 transition-colors">
                {{ $post->category->name }}
            </a>
            @if($post->tags->count() > 0)
            <span class="text-gray-400">•</span>
            @foreach($post->tags as $tag)
            <a href="{{ route('blog.tag', $tag->slug) }}" class="text-sm text-gray-600 hover:text-blue-600 transition-colors">
                #{{ $tag->name }}
            </a>
            @endforeach
            @endif
        </div>

        <!-- Featured Image -->
        @if($post->featured_image)
        <div class="mb-8">
            <img src="{{ asset($post->featured_image) }}" 
                 alt="{{ $post->title }}" 
                 class="w-full h-auto rounded-lg shadow-lg">
            @if($post->featured_image_caption)
            <p class="text-sm text-gray-600 text-center mt-2 italic">{{ $post->featured_image_caption }}</p>
            @endif
        </div>
        @endif
    </header>

    <!-- Post Content -->
    <div class="prose prose-lg max-w-none mb-12">
        {!! $post->content !!}
    </div>

    <!-- Post Footer -->
    <footer class="border-t border-gray-200 pt-8">
        <!-- Share Buttons -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Share this post</h3>
            <div class="flex space-x-3">
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(route('blog.show', $post->slug)) }}" 
                   target="_blank" 
                   class="inline-flex items-center px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition-colors">
                    <i class="fab fa-twitter mr-2"></i>
                    Twitter
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}" 
                   target="_blank" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fab fa-facebook-f mr-2"></i>
                    Facebook
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('blog.show', $post->slug)) }}" 
                   target="_blank" 
                   class="inline-flex items-center px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition-colors">
                    <i class="fab fa-linkedin-in mr-2"></i>
                    LinkedIn
                </a>
                <button onclick="copyToClipboard('{{ route('blog.show', $post->slug) }}')" 
                        class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-link mr-2"></i>
                    Copy Link
                </button>
            </div>
        </div>

        <!-- Author Bio -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8">
            <div class="flex items-start space-x-4">
                @if($post->author->avatar)
                <img class="w-16 h-16 rounded-full" src="{{ asset($post->author->avatar) }}" alt="{{ $post->author->name }}">
                @else
                <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center">
                    <span class="text-lg font-medium text-gray-700">{{ substr($post->author->name, 0, 1) }}</span>
                </div>
                @endif
                <div class="flex-1">
                    <h4 class="text-lg font-semibold text-gray-900 mb-1">{{ $post->author->name }}</h4>
                    @if($post->author->title)
                    <p class="text-blue-600 text-sm mb-2">{{ $post->author->title }}</p>
                    @endif
                    @if($post->author->bio)
                    <p class="text-gray-600 mb-3">{{ $post->author->bio }}</p>
                    @endif
                    @if($post->author->website || $post->author->twitter || $post->author->linkedin)
                    <div class="flex space-x-3">
                        @if($post->author->website)
                        <a href="{{ $post->author->website }}" target="_blank" class="text-gray-500 hover:text-blue-600 transition-colors">
                            <i class="fas fa-globe"></i>
                        </a>
                        @endif
                        @if($post->author->twitter)
                        <a href="{{ $post->author->twitter }}" target="_blank" class="text-gray-500 hover:text-blue-400 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        @endif
                        @if($post->author->linkedin)
                        <a href="{{ $post->author->linkedin }}" target="_blank" class="text-gray-500 hover:text-blue-700 transition-colors">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </footer>
</article>

<!-- Related Posts -->
@if($relatedPosts->count() > 0)
<section class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Related Posts</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($relatedPosts as $relatedPost)
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                @if($relatedPost->featured_image)
                <div class="aspect-w-16 aspect-h-9">
                    <img src="{{ asset($relatedPost->featured_image) }}" alt="{{ $relatedPost->title }}" class="w-full h-48 object-cover">
                </div>
                @endif
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                            {{ $relatedPost->category->name }}
                        </span>
                        <span class="mx-2 text-gray-300">•</span>
                        <time class="text-sm text-gray-500">
                            {{ $relatedPost->published_at->format('M j, Y') }}
                        </time>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 hover:text-blue-600 transition-colors">
                        <a href="{{ route('blog.show', $relatedPost->slug) }}">{{ $relatedPost->title }}</a>
                    </h3>
                    <p class="text-gray-600 text-sm">{{ Str::limit($relatedPost->excerpt, 100) }}</p>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Back to Blog Button -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center">
        <a href="{{ route('blog.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Blog
        </a>
    </div>
</div>
@endsection

@section('styles')
<style>
.prose {
    max-width: none;
}
.prose h1 { @apply text-3xl font-bold text-gray-900 mt-8 mb-4; }
.prose h2 { @apply text-2xl font-bold text-gray-900 mt-6 mb-3; }
.prose h3 { @apply text-xl font-bold text-gray-900 mt-5 mb-3; }
.prose h4 { @apply text-lg font-bold text-gray-900 mt-4 mb-2; }
.prose p { @apply text-gray-700 mb-4 leading-relaxed; }
.prose a { @apply text-blue-600 hover:text-blue-800 underline; }
.prose ul { @apply list-disc pl-6 mb-4; }
.prose ol { @apply list-decimal pl-6 mb-4; }
.prose li { @apply mb-2; }
.prose blockquote { @apply border-l-4 border-blue-500 pl-4 italic text-gray-700 my-6; }
.prose code { @apply bg-gray-100 px-2 py-1 rounded text-sm font-mono; }
.prose pre { @apply bg-gray-900 text-white p-4 rounded-lg overflow-x-auto mb-4; }
.prose pre code { @apply bg-transparent px-0 py-0; }
.prose img { @apply rounded-lg shadow-md my-6; }
.prose table { @apply w-full border-collapse mb-6; }
.prose th { @apply border border-gray-300 px-4 py-2 bg-gray-50 font-semibold text-left; }
.prose td { @apply border border-gray-300 px-4 py-2; }
</style>
@endsection

@section('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check mr-2"></i>Copied!';
        button.classList.add('bg-green-600');
        button.classList.remove('bg-gray-600', 'hover:bg-gray-700');
        
        setTimeout(function() {
            button.innerHTML = originalText;
            button.classList.remove('bg-green-600');
            button.classList.add('bg-gray-600', 'hover:bg-gray-700');
        }, 2000);
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
    });
}
</script>
@endsection