<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Event extends Model
{
    protected $fillable = [
        'category_id', 'title', 'description', 'date', 
        'location', 'price', 'stock', 'poster_path'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ✅ GANTI DENGAN INI
    public function getPosterUrlAttribute()
    {
        if (!$this->poster_path) {
            return 'https://placehold.co/400x600/6366f1/ffffff?text=No+Image';
        }

        // Untuk Laravel Cloud, coba akses langsung
        if (Storage::disk('public')->exists($this->poster_path)) {
            return Storage::url($this->poster_path);
        }

        // Fallback ke asset
        return asset('storage/' . $this->poster_path);
    }
}