<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Partner extends Model
{
    protected $fillable = [
        'name',
        'logo', // Bukan logo_url lagi
    ];

     public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            return null;
        }
        
        // Untuk cloud storage, langsung return path dengan prefix storage
        return asset('storage/' . $this->logo);
    }
}