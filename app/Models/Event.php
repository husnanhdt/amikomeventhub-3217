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

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
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
    // Jika end_date tidak ada, gunakan tanggal event + 1 hari
    $endDate = $this->end_date 
        ? \Carbon\Carbon::parse($this->end_date) 
        : \Carbon\Carbon::parse($this->date)->addDay();
    
    // Cek apakah sekarang sudah lewat minimal 1 hari dari end_date
    // gt() = greater than (lebih besar dari)
    return \Carbon\Carbon::now()->gt($endDate->addDay());
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
