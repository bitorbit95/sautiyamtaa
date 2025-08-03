<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_sw',
        'slug',
        'description',
        'description_sw',
        'full_description',
        'full_description_sw',
        'duration',
        'duration_sw',
        'participants',
        'image',
        'gallery',
        'status',
        'sort_order',
        'objectives',
        'requirements',
        'location',
        'location_sw',
        'cost',
        'start_date',
        'end_date',
        'is_featured'
    ];

    protected $casts = [
        'gallery' => 'array',
        'objectives' => 'array',
        'requirements' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_featured' => 'boolean',
        'cost' => 'decimal:2'
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($program) {
            if (empty($program->slug)) {
                $program->slug = Str::slug($program->title);
            }
        });

        static::updating(function ($program) {
            if ($program->isDirty('title') && empty($program->slug)) {
                $program->slug = Str::slug($program->title);
            }
        });
    }

    /**
     * Scope for active programs.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for featured programs.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for ordering by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
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
     * Get localized description.
     */
    public function getLocalizedDescription()
    {
        return app()->getLocale() === 'sw' && $this->description_sw 
            ? $this->description_sw 
            : $this->description;
    }

    /**
     * Get localized full description.
     */
    public function getLocalizedFullDescription()
    {
        return app()->getLocale() === 'sw' && $this->full_description_sw 
            ? $this->full_description_sw 
            : $this->full_description;
    }

    /**
     * Get localized duration.
     */
    public function getLocalizedDuration()
    {
        return app()->getLocale() === 'sw' && $this->duration_sw 
            ? $this->duration_sw 
            : $this->duration;
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
     * Get the program's image URL.
     */
    public function getImageUrl()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * Get the program's gallery URLs.
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
     * Check if program is ongoing.
     */
    public function isOngoing()
    {
        if (!$this->start_date || !$this->end_date) {
            return false;
        }

        $now = now();
        return $now->between($this->start_date, $this->end_date);
    }

    /**
     * Check if program is upcoming.
     */
    public function isUpcoming()
    {
        if (!$this->start_date) {
            return false;
        }

        return now()->lt($this->start_date);
    }

    /**
     * Check if program is completed.
     */
    public function isCompleted()
    {
        if (!$this->end_date) {
            return false;
        }

        return now()->gt($this->end_date);
    }
}