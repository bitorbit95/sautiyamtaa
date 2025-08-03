<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_sw',
        'slug',
        'excerpt',
        'excerpt_sw',
        'content',
        'content_sw',
        'featured_image',
        'gallery',
        'story_type',
        'author_name',
        'author_title',
        'author_title_sw',
        'author_image',
        'location',
        'location_sw',
        'story_date',
        'status',
        'is_featured',
        'views',
        'sort_order',
        'tags',
        'video_url',
        'meta_description',
        'meta_description_sw'
    ];

    protected $casts = [
        'gallery' => 'array',
        'tags' => 'array',
        'story_date' => 'date',
        'is_featured' => 'boolean',
        'views' => 'integer',
        'sort_order' => 'integer'
    ];

    /**
     * Story types configuration
     */
    public static function getStoryTypes()
    {
        return [
            'impact' => [
                'label' => 'Impact Story',
                'label_sw' => 'Hadithi ya Athari',
                'color' => 'red',
                'icon' => 'heart'
            ],
            'testimonial' => [
                'label' => 'Testimonial',
                'label_sw' => 'Ushuhuda',
                'color' => 'black',
                'icon' => 'quote'
            ],
            'success' => [
                'label' => 'Success Story',
                'label_sw' => 'Hadithi ya Mafanikio',
                'color' => 'red',
                'icon' => 'trophy'
            ],
            'community' => [
                'label' => 'Community Story',
                'label_sw' => 'Hadithi ya Jamii',
                'color' => 'black',
                'icon' => 'users'
            ]
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($story) {
            if (empty($story->slug)) {
                $story->slug = Str::slug($story->title);
            }
        });

        static::updating(function ($story) {
            if ($story->isDirty('title') && empty($story->slug)) {
                $story->slug = Str::slug($story->title);
            }
        });
    }

    /**
     * Scope for published stories.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for featured stories.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for ordering by sort order and date.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')
                    ->orderBy('story_date', 'desc')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Scope by story type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('story_type', $type);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get localized title.
     */
    public function getLocalizedTitle()
    {
        return app()->getLocale() === 'sw' && $this->title_sw 
            ? $this->title_sw 
            : $this->title;
    }

    /**
     * Get localized excerpt.
     */
    public function getLocalizedExcerpt()
    {
        return app()->getLocale() === 'sw' && $this->excerpt_sw 
            ? $this->excerpt_sw 
            : $this->excerpt;
    }

    /**
     * Get localized content.
     */
    public function getLocalizedContent()
    {
        return app()->getLocale() === 'sw' && $this->content_sw 
            ? $this->content_sw 
            : $this->content;
    }

    /**
     * Get localized author title.
     */
    public function getLocalizedAuthorTitle()
    {
        return app()->getLocale() === 'sw' && $this->author_title_sw 
            ? $this->author_title_sw 
            : $this->author_title;
    }

    /**
     * Get localized location.
     */
    public function getLocalizedLocation()
    {
        return app()->getLocale() === 'sw' && $this->location_sw 
            ? $this->location_sw 
            : $this->location;
    }

    /**
     * Get localized meta description.
     */
    public function getLocalizedMetaDescription()
    {
        return app()->getLocale() === 'sw' && $this->meta_description_sw 
            ? $this->meta_description_sw 
            : $this->meta_description;
    }

    /**
     * Get the story's featured image URL.
     */
    public function getFeaturedImageUrl()
    {
        return $this->featured_image ? asset('storage/' . $this->featured_image) : null;
    }

    /**
     * Get the author's image URL.
     */
    public function getAuthorImageUrl()
    {
        return $this->author_image ? asset('storage/' . $this->author_image) : null;
    }

    /**
     * Get the story's gallery URLs.
     */
    public function getGalleryUrls()
    {
        if (!$this->gallery) {
            return [];
        }

        return collect($this->gallery)->map(function ($image) {
            return asset('storage/' . $image);
        })->toArray();
    }

    /**
     * Get story type configuration.
     */
    public function getTypeConfig()
    {
        $types = self::getStoryTypes();
        return $types[$this->story_type] ?? $types['impact'];
    }

    /**
     * Get localized story type label.
     */
    public function getLocalizedTypeLabel()
    {
        $config = $this->getTypeConfig();
        return app()->getLocale() === 'sw' ? $config['label_sw'] : $config['label'];
    }

    /**
     * Increment view count.
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Get reading time estimate in minutes.
     */
    public function getReadingTime()
    {
        $content = strip_tags($this->getLocalizedContent());
        $wordCount = str_word_count($content);
        $readingTime = ceil($wordCount / 200); // Average reading speed: 200 words per minute
        return max(1, $readingTime);
    }

    /**
     * Get formatted story date.
     */
    public function getFormattedStoryDate()
    {
        return $this->story_date ? $this->story_date->format('F j, Y') : null;
    }

    /**
     * Check if story has video.
     */
    public function hasVideo()
    {
        return !empty($this->video_url);
    }

    /**
     * Get embedded video HTML.
     */
    public function getEmbeddedVideo()
    {
        if (!$this->hasVideo()) {
            return null;
        }

        // YouTube
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $this->video_url, $matches)) {
            $videoId = $matches[1];
            return '<iframe class="w-full h-64 md:h-96 rounded-lg" src="https://www.youtube.com/embed/' . $videoId . '" frameborder="0" allowfullscreen></iframe>';
        }

        // Vimeo
        if (preg_match('/vimeo\.com\/(\d+)/', $this->video_url, $matches)) {
            $videoId = $matches[1];
            return '<iframe class="w-full h-64 md:h-96 rounded-lg" src="https://player.vimeo.com/video/' . $videoId . '" frameborder="0" allowfullscreen></iframe>';
        }

        return null;
    }
}