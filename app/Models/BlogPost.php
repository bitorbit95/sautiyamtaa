<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'author_id',
        'category_id',
        'status',
        'published_at',
        'meta_description',
        'is_featured',
        'reading_time'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    protected $dates = ['deleted_at'];

    // Relationships
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tags');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $categorySlug)
    {
        return $query->whereHas('category', function ($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }

    public function scopeByTag($query, $tagSlug)
    {
        return $query->whereHas('tags', function ($q) use ($tagSlug) {
            $q->where('slug', $tagSlug);
        });
    }

    // Accessors
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getExcerptAttribute($value)
    {
        return $value ?: Str::limit(strip_tags($this->content), 150);
    }

    public function getReadingTimeAttribute($value)
    {
        if ($value) {
            return $value;
        }

        $wordCount = str_word_count(strip_tags($this->content));
        return ceil($wordCount / 200); // Average reading speed: 200 words per minute
    }

    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image 
            ? asset('storage/' . $this->featured_image)
            : asset('images/default-blog-image.jpg');
    }

    // Mutators
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = $this->createUniqueSlug($value);
    }

    // Helper Methods
    private function createUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->where('id', '!=', $this->id ?? 0)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function isPublished()
    {
        return $this->status === 'published' && $this->published_at <= now();
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'published' => '<span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Published</span>',
            'draft' => '<span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">Draft</span>',
            'scheduled' => '<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Scheduled</span>',
            default => '<span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">Unknown</span>',
        };
    }
}