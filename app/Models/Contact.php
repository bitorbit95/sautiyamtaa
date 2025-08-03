<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'replied_at'
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Mutators
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;
        
        if ($value === 'replied' && !$this->replied_at) {
            $this->attributes['replied_at'] = now();
        }
    }
}