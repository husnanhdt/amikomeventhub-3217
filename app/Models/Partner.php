<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Partner extends Model
{
    protected $fillable = ['name', 'logo'];

    // ✅ GANTI DENGAN INI
    public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            return 'https://placehold.co/100x100/e2e8f0/64748b?text=NO+IMG';
        }

        // Untuk Laravel Cloud, coba akses langsung
        if (Storage::disk('public')->exists($this->logo)) {
            return Storage::url($this->logo);
        }

        // Fallback ke asset
        return asset('storage/' . $this->logo);
    }
}