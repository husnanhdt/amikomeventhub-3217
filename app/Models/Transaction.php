<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // GABUNGAN: Field lama (untuk Midtrans) + Field baru (untuk relasi User)
    protected $fillable = [
        'user_id',          // ✅ BARU: Wajib ada untuk fitur Riwayat Transaksi
        'event_id',
        'order_id',
        'customer_name',    // (Pertahankan jika form checkout kamu masih pakai ini)
        'customer_email',   // (Pertahankan jika form checkout kamu masih pakai ini)
        'customer_phone',   // (Pertahankan jika form checkout kamu masih pakai ini)
        'total_price',      // (Sesuaikan dengan nama kolom di database kamu, bisa juga 'total')
        'status',           // pending, paid, expired, dll
        'snap_token',       // ✅ PENTING: Jangan dihapus, ini untuk token Midtrans
        'payment_url',      // (Opsional, jika kamu menyimpan URL pembayaran)
    ];

    protected $casts = [
        'total_price' => 'decimal:2', // Pastikan nama ini sesuai dengan kolom di database
    ];

    // ✅ RELASI KE USER (WAJIB untuk fitur Riwayat Transaksi)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // ✅ RELASI KE TIKET (WAJIB, karena 1 transaksi bisa menghasilkan banyak tiket)
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}