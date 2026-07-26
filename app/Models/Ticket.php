<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_code',
        'user_id',
        'event_id',
        'transaction_id',
        'quantity',
        'price',
        'status',
        'qr_code_path',
        'used_at',
    ];

    protected $casts = [
        'used_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Event
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    // Relasi ke Transaction
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    // Generate kode tiket unik
    public static function generateTicketCode(): string
    {
        return 'TKT-' . strtoupper(uniqid());
    }

    // Scope untuk tiket yang sudah dibayar
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    // Scope untuk tiket yang sudah digunakan
    public function scopeUsed($query)
    {
        return $query->where('status', 'used');
    }

    // Cek apakah tiket sudah digunakan
    public function isUsed(): bool
    {
        return $this->status === 'used';
    }

    // Mark tiket sebagai digunakan
    public function markAsUsed(): void
    {
        $this->update([
            'status' => 'used',
            'used_at' => now(),
        ]);
    }
}