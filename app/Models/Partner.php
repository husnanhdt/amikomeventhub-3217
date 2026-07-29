<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'description',
        'user_id', 
        'status'
    ];

    // ✅ LOGIKA ASLI KAMU: Getter untuk URL Logo (DIPERTAHANKAN)
    public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            return 'https://placehold.co/100x100/e2e8f0/64748b?text=NO+IMG';
        }

        if (Storage::disk('public')->exists($this->logo)) {
            return Storage::url($this->logo);
        }

        return asset('storage/' . $this->logo);
    }

    // ✅ INI YANG KURANG: Relasi ke User (Pemilik Partner)
    // Ini yang dipanggil oleh Controller saat menulis: Partner::with('user')
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Events (DIPERTAHANKAN)
    public function events()
    {
        return $this->hasMany(Event::class, 'partner_id');
    }

    // Relasi tambahan kamu (DIPERTAHANKAN)
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id'); 
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}