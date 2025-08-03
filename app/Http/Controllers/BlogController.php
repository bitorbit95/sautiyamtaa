<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display blog index page with posts listing
     */
    public function index(Request $request)
    {
        $query = BlogPost::with(['author', 'category', 'tags'])
                         ->published()
                         ->latest('published_at');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                  ->orWhere('content', 'like', "%{$searchTerm}%");
            });
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        // Tag filter
        if ($request->has('tag') && $request->tag) {
            $query->byTag($request->tag);
        }

        $posts = $query->paginate(12);
        
        // Get featured posts for sidebar/hero
        $featuredPosts = BlogPost::with(['author', 'category'])
                                ->published()
                                ->featured()
                                ->latest('published_at')
                                ->take(3)
                                ->get();
        
        // Get categories for filter
        $categories = BlogCategory::active()
                                 ->withCount('publishedPosts')
                                 ->orderBy('name')
                                 ->get();
        
        // Get popular tags
        $popularTags = BlogTag::withCount('publishedPosts')
    ->where('published_posts_count', '>', 0)
    ->orderBy('published_posts_count', 'desc')
    ->take(10)
    ->get();


        return view('blog.index', compact(
            'posts', 
            'featuredPosts', 
            'categories', 
            'popularTags'
        ));
    }

    /**
     * Display a single blog post
     */
    public function show(BlogPost $post)
    {
        // Check if post is published
        if (!$post->isPublished()) {
            abort(404);
        }

        // Load relationships
        $post->load(['author', 'category', 'tags']);

        // Increment views count
        $post->increment('views_count');

        // Get related posts
        $relatedPosts = BlogPost::with(['author', 'category'])
                               ->published()
                               ->where('id', '!=', $post->id)
                               ->where('category_id', $post->category_id)
                               ->latest('published_at')
                               ->take(3)
                               ->get();

        // If no related posts in same category, get latest posts
        if ($relatedPosts->count() < 3) {
            $additionalPosts = BlogPost::with(['author', 'category'])
                                      ->published()
                                      ->where('id', '!=', $post->id)
                                      ->whereNotIn('id', $relatedPosts->pluck('id'))
                                      ->latest('published_at')
                                      ->take(3 - $relatedPosts->count())
                                      ->get();
            
            $relatedPosts = $relatedPosts->concat($additionalPosts);
        }

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    /**
     * Display posts by category
     */
    public function category(BlogCategory $category)
    {
        $posts = BlogPost::with(['author', 'category', 'tags'])
                        ->published()
                        ->where('category_id', $category->id)
                        ->latest('published_at')
                        ->paginate(12);

        return view('blog.category', compact('category', 'posts'));
    }

    /**
     * Display posts by tag
     */
    public function tag(BlogTag $tag)
    {
        $posts = $tag->publishedPosts()
                    ->with(['author', 'category', 'tags'])
                    ->latest('published_at')
                    ->paginate(12);

        return view('blog.tag', compact('tag', 'posts'));
    }

    /**
     * Search blog posts
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:3|max:100'
        ]);

        $searchTerm = $request->q;
        
        $posts = BlogPost::with(['author', 'category', 'tags'])
                        ->published()
                        ->where(function ($query) use ($searchTerm) {
                            $query->where('title', 'like', "%{$searchTerm}%")
                                  ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                                  ->orWhere('content', 'like', "%{$searchTerm}%");
                        })
                        ->latest('published_at')
                        ->paginate(12);

        return view('blog.search', compact('posts', 'searchTerm'));
    }
}