<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoryController extends Controller
{
    /**
     * Display a listing of the stories.
     */
    public function index(Request $request): View
    {
        // Check if this is an admin request
        if ($request->is('admin/*')) {
            return $this->adminIndex($request);
        }

        $query = Story::published()->ordered();

        // Filter by story type
        if ($request->has('type') && in_array($request->type, array_keys(Story::getStoryTypes()))) {
            $query->ofType($request->type);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('title_sw', 'like', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                  ->orWhere('excerpt_sw', 'like', "%{$searchTerm}%")
                  ->orWhere('author_name', 'like', "%{$searchTerm}%")
                  ->orWhere('location', 'like', "%{$searchTerm}%")
                  ->orWhere('location_sw', 'like', "%{$searchTerm}%");
            });
        }

        $stories = $query->paginate(12);
        $featuredStories = Story::published()->featured()->ordered()->limit(3)->get();
        $storyTypes = Story::getStoryTypes();

        return view('stories.index', compact('stories', 'featuredStories', 'storyTypes'));
    }

    /**
     * Display the specified story.
     */
    public function show(Story $story): View
    {
        // Check if story is published
        if ($story->status !== 'published') {
            abort(404);
        }

        // Increment view count
        $story->incrementViews();

        // Get related stories (same type or featured)
        $relatedStories = Story::published()
            ->where('id', '!=', $story->id)
            ->where(function ($query) use ($story) {
                $query->where('story_type', $story->story_type)
                      ->orWhere('is_featured', true);
            })
            ->ordered()
            ->limit(3)
            ->get();

        // If no related stories found, get any other published stories
        if ($relatedStories->count() < 3) {
            $additionalStories = Story::published()
                ->where('id', '!=', $story->id)
                ->whereNotIn('id', $relatedStories->pluck('id'))
                ->ordered()
                ->limit(3 - $relatedStories->count())
                ->get();

            $relatedStories = $relatedStories->merge($additionalStories);
        }

        return view('stories.show', compact('story', 'relatedStories'));
    }

    /**
     * Display stories by type.
     */
    public function type(Request $request, $type): View
    {
        if (!array_key_exists($type, Story::getStoryTypes())) {
            abort(404);
        }

        $stories = Story::published()
            ->ofType($type)
            ->ordered()
            ->paginate(12);

        $storyTypes = Story::getStoryTypes();
        $currentType = $storyTypes[$type];

        return view('stories.type', compact('stories', 'storyTypes', 'currentType', 'type'));
    }

    /**
     * Display a listing of stories for admin.
     */
    protected function adminIndex(Request $request): View
    {
        $query = Story::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('title_sw', 'like', "%{$searchTerm}%")
                  ->orWhere('author_name', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by story type
        if ($request->has('story_type') && $request->story_type !== '') {
            $query->where('story_type', $request->story_type);
        }

        // Filter by featured
        if ($request->has('featured') && $request->featured !== '') {
            $query->where('is_featured', $request->featured);
        }

        $stories = $query->ordered()->paginate(15);
        $storyTypes = Story::getStoryTypes();

        return view('admin.stories.index', compact('stories', 'storyTypes'));
    }

    /**
     * Show the form for creating a new story (Admin only).
     */
    public function create(): View
    {
        $storyTypes = Story::getStoryTypes();
        return view('admin.stories.create', compact('storyTypes'));
    }

    /**
     * Store a newly created story (Admin only).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_sw' => 'nullable|string|max:255',
            'excerpt' => 'required|string',
            'excerpt_sw' => 'nullable|string',
            'content' => 'required|string',
            'content_sw' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'story_type' => 'required|in:' . implode(',', array_keys(Story::getStoryTypes())),
            'author_name' => 'nullable|string|max:255',
            'author_title' => 'nullable|string|max:255',
            'author_title_sw' => 'nullable|string|max:255',
            'author_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'location' => 'nullable|string|max:255',
            'location_sw' => 'nullable|string|max:255',
            'story_date' => 'nullable|date',
            'status' => 'required|in:published,draft,archived',
            'is_featured' => 'boolean',
            'sort_order' => 'required|integer|min:0',
            'tags' => 'nullable|array',
            'video_url' => 'nullable|url',
            'meta_description' => 'nullable|string|max:160',
            'meta_description_sw' => 'nullable|string|max:160'
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('stories', 'public');
        }

        // Handle author image upload
        if ($request->hasFile('author_image')) {
            $validated['author_image'] = $request->file('author_image')->store('stories/authors', 'public');
        }

        // Handle gallery upload
        if ($request->hasFile('gallery')) {
            $galleryImages = [];
            foreach ($request->file('gallery') as $file) {
                $galleryImages[] = $file->store('stories/gallery', 'public');
            }
            $validated['gallery'] = $galleryImages;
        }

        $story = Story::create($validated);

        return redirect()->route('admin.stories.index')
            ->with('success', 'Story created successfully.');
    }

    /**
     * Show the form for editing the specified story (Admin only).
     */
    public function edit(Story $story): View
    {
        $storyTypes = Story::getStoryTypes();
        return view('admin.stories.edit', compact('story', 'storyTypes'));
    }

    /**
     * Update the specified story (Admin only).
     */
    public function update(Request $request, Story $story)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_sw' => 'nullable|string|max:255',
            'excerpt' => 'required|string',
            'excerpt_sw' => 'nullable|string',
            'content' => 'required|string',
            'content_sw' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'story_type' => 'required|in:' . implode(',', array_keys(Story::getStoryTypes())),
            'author_name' => 'nullable|string|max:255',
            'author_title' => 'nullable|string|max:255',
            'author_title_sw' => 'nullable|string|max:255',
            'author_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'location' => 'nullable|string|max:255',
            'location_sw' => 'nullable|string|max:255',
            'story_date' => 'nullable|date',
            'status' => 'required|in:published,draft,archived',
            'is_featured' => 'boolean',
            'sort_order' => 'required|integer|min:0',
            'tags' => 'nullable|array',
            'video_url' => 'nullable|url',
            'meta_description' => 'nullable|string|max:160',
            'meta_description_sw' => 'nullable|string|max:160'
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($story->featured_image) {
                \Storage::disk('public')->delete($story->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('stories', 'public');
        }

        // Handle author image upload
        if ($request->hasFile('author_image')) {
            // Delete old image
            if ($story->author_image) {
                \Storage::disk('public')->delete($story->author_image);
            }
            $validated['author_image'] = $request->file('author_image')->store('stories/authors', 'public');
        }

        // Handle gallery upload
        if ($request->hasFile('gallery')) {
            // Delete old gallery images
            if ($story->gallery) {
                foreach ($story->gallery as $image) {
                    \Storage::disk('public')->delete($image);
                }
            }
            
            $galleryImages = [];
            foreach ($request->file('gallery') as $file) {
                $galleryImages[] = $file->store('stories/gallery', 'public');
            }
            $validated['gallery'] = $galleryImages;
        }

        $story->update($validated);

        return redirect()->route('admin.stories.index')
            ->with('success', 'Story updated successfully.');
    }

    /**
     * Remove the specified story (Admin only).
     */
    public function destroy(Story $story)
    {
        // Delete associated images
        if ($story->featured_image) {
            \Storage::disk('public')->delete($story->featured_image);
        }

        if ($story->author_image) {
            \Storage::disk('public')->delete($story->author_image);
        }

        if ($story->gallery) {
            foreach ($story->gallery as $image) {
                \Storage::disk('public')->delete($image);
            }
        }

        $story->delete();

        return redirect()->route('admin.stories.index')
            ->with('success', 'Story deleted successfully.');
    }

    /**
     * Toggle featured status of a story (Admin only).
     */
    public function toggleFeatured(Story $story)
    {
        $story->update([
            'is_featured' => !$story->is_featured
        ]);

        $status = $story->is_featured ? 'featured' : 'unfeatured';
        
        return redirect()->back()->with('success', "Story has been {$status} successfully.");
    }
}