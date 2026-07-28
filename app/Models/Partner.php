<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Partner extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'status'
    ];

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

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    // Relasi: Partner ini memiliki User (Manager) mana
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id'); // Opsional, jika ada kolom manager_id
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
