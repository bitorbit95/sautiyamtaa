@extends('layouts.guest')

@section('title', 'Blog - ' . config('app.name'))
@section('description', 'Latest blog posts and articles')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Hero Section with Featured Posts -->
    @if($featuredPosts->count() > 0)
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-6">Featured Posts</h2>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            @foreach($featuredPosts as $featured)
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                @if($featured->featured_image)
                <div class="aspect-w-16 aspect-h-9">
                    <img src="{{ asset($featured->featured_image) }}" alt="{{ $featured->title }}" class="w-full h-48 object-cover">
                </div>
                @endif
                <div class="p-6">
                    <div class="flex items-center mb-3">
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                            {{ $featured->category->name }}
                        </span>
                        <span class="mx-2 text-gray-300">•</span>
                        <time class="text-sm text-gray-500">
                            {{ $featured->published_at->format('M j, Y') }}
                        </time>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2 hover:text-blue-600 transition-colors">
                        <a href="{{ route('blog.show', $featured->slug) }}">{{ $featured->title }}</a>
                    </h3>
                    <p class="text-gray-600 mb-4">{{ $featured->excerpt }}</p>
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            @if($featured->author->avatar)
                            <img class="w-8 h-8 rounded-full" src="{{ asset($featured->author->avatar) }}" alt="{{ $featured->author->name }}">
                            @else
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                <span class="text-xs font-medium text-gray-700">{{ substr($featured->author->name, 0, 1) }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ $featured->author->name }}</p>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-3">
            <!-- Search and Filters -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Search Form -->
                    <form action="{{ route('blogs.index') }}" method="GET" class="flex-1">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Search posts..." 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if(request('tag'))
                                <input type="hidden" name="tag" value="{{ request('tag') }}">
                            @endif
                        </div>
                    </form>

                    <!-- Category Filter -->
                    <div class="sm:w-48">
                        <select onchange="filterByCategory(this.value)" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                {{ $category->name }} ({{ $category->published_posts_count }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Active Filters -->
                @if(request('search') || request('category') || request('tag'))
                <div class="mt-4 flex items-center gap-2">
                    <span class="text-sm text-gray-600">Active filters:</span>
                    @if(request('search'))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Search: "{{ request('search') }}"
                        <a href="{{ route('blogs.index', array_except(request()->query(), 'search')) }}" class="ml-2 text-blue-600 hover:text-blue-800">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    @endif
                    @if(request('category'))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Category: {{ $categories->where('slug', request('category'))->first()->name ?? request('category') }}
                        <a href="{{ route('blogs.index', array_except(request()->query(), 'category')) }}" class="ml-2 text-green-600 hover:text-green-800">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    @endif
                    @if(request('tag'))
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        Tag: {{ request('tag') }}
                        <a href="{{ route('blogs.index', array_except(request()->query(), 'tag')) }}" class="ml-2 text-purple-600 hover:text-purple-800">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    @endif
                    <a href="{{ route('blogs.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Clear all</a>
                </div>
                @endif
            </div>

            <!-- Posts Grid -->
            @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                @foreach($posts as $post)
                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    @if($post->featured_image)
                    <div class="aspect-w-16 aspect-h-9">
                        <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                    </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <a href="{{ route('blog.category', $post->category->slug) }}" class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full hover:bg-blue-200 transition-colors">
                                {{ $post->category->name }}
                            </a>
                            <span class="mx-2 text-gray-300">•</span>
                            <time class="text-sm text-gray-500">
                                {{ $post->published_at->format('M j, Y') }}
                            </time>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-2 hover:text-blue-600 transition-colors">
                            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                        </h2>
                        <p class="text-gray-600 mb-4">{{ $post->excerpt }}</p>
                        
                        <!-- Tags -->
                        @if($post->tags->count() > 0)
                        <div class="mb-4">
                            @foreach($post->tags->take(3) as $tag)
                            <a href="{{ route('blog.tag', $tag->slug) }}" class="inline-block text-xs text-gray-500 hover:text-blue-600 mr-2">
                                #{{ $tag->name }}
                            </a>
                            @endforeach
                        </div>
                        @endif

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if($post->author->avatar)
                                    <img class="w-8 h-8 rounded-full" src="{{ asset($post->author->avatar) }}" alt="{{ $post->author->name }}">
                                    @else
                                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-medium text-gray-700">{{ substr($post->author->name, 0, 1) }}</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $post->author->name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-eye mr-1"></i>
                                {{ $post->views_count ?? 0 }}
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $posts->appends(request()->query())->links() }}
            </div>
            @else
            <div class="text-center py-12">
                <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No posts found</h3>
                <p class="text-gray-600 mb-4">Try adjusting your search or filter criteria.</p>
                <a href="{{ route('blogs.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    View all posts
                </a>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Categories Widget -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Categories</h3>
                <ul class="space-y-2">
                    @foreach($categories as $category)
                    <li>
                        <a href="{{ route('blog.category', $category->slug) }}" class="flex items-center justify-between text-gray-700 hover:text-blue-600 transition-colors">
                            <span>{{ $category->name }}</span>
                            <span class="text-sm text-gray-500">({{ $category->published_posts_count }})</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Popular Tags Widget -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Popular Tags</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($popularTags as $tag)
                    <a href="{{ route('blog.tag', $tag->slug) }}" class="inline-block px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full hover:bg-blue-100 hover:text-blue-700 transition-colors">
                        #{{ $tag->name }}
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Newsletter Widget -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-md p-6 text-white">
                <h3 class="text-lg font-semibold mb-2">Stay Updated</h3>
                <p class="text-blue-100 mb-4 text-sm">Get the latest posts delivered right to your inbox.</p>
                <form class="space-y-3">
                    <input type="email" placeholder="Your email address" class="w-full px-3 py-2 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <button type="submit" class="w-full bg-white text-blue-600 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition-colors">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function filterByCategory(categorySlug) {
    const url = new URL(window.location);
    if (categorySlug) {
        url.searchParams.set('category', categorySlug);
    } else {
        url.searchParams.delete('category');
    }
    window.location.href = url.toString();
}
</script>
@endsection