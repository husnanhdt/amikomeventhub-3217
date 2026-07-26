<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',          // Untuk membedakan admin/organizer/user biasa
        'google_id',
        'avatar',
        'gender',
        'birth_date',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    // ==========================================
    // RELASI DATABASE
    // ==========================================

    // Relasi ke Transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Relasi ke Tickets
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // Relasi ke Reviews
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // ==========================================
    // HELPER METHODS
    // ==========================================

    // Cek apakah user sudah review event tertentu
    public function hasReviewedEvent($eventId)
    {
        return $this->reviews()->where('event_id', $eventId)->exists();
    }

    // ✅ METHOD INI YANG HILANG - Cek apakah user adalah organizer/panitia
    public function isOrganizer()
    {
        // Cek berdasarkan role di database
        return $this->role === 'organizer' || $this->role === 'admin';
    }

    // Cek apakah user adalah admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Cek apakah user adalah superadmin
    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }
}