<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    // Relationships
    public function posts()
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_tags');
    }

    public function publishedPosts()
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_tags')
                    ->where('blog_posts.status', 'published')
                    ->where('blog_posts.published_at', '<=', now());
    }

    // Accessors
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getPostsCountAttribute()
    {
        return $this->publishedPosts()->count();
    }

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = $this->createUniqueSlug($value);
    }

    // Helper Methods
    private function createUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->where('id', '!=', $this->id ?? 0)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}