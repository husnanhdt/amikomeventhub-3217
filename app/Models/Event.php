<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Event extends Model
{
    protected $fillable = [
        'partner_id',       // ← PASTIKAN ADA
        'category_id',
        'title',
        'description',
        'date',
        'end_date',
        'location',
        'price',
        'stock',
        'poster_path'
    ];

    protected $casts = [
        'date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Relasi ke Partner (WAJIB!)
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke Reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Accessors
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }

    public function canBeReviewed()
    {
        return $this->end_date && $this->end_date->diffInDays(Carbon::now()) >= 1;
    }

    public function getPosterUrlAttribute()
    {
        if (!$this->poster_path) {
            return 'https://placehold.co/400x600/6366f1/ffffff?text=No+Image';
        }
        return asset('storage/' . $this->poster_path);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
