<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $partnerId = $user->partner_id;

        if (!$partnerId) {
            return redirect()->route('home')->with('error', 'Anda belum terhubung dengan organisasi manapun.');
        }

        // 1. Ambil semua ID event milik partner (organizer) ini
        $eventIds = Event::where('partner_id', $partnerId)->pluck('id');

        // 2. Ambil transaksi berdasarkan event tersebut, urutkan dari yang terbaru
        $transactions = Transaction::whereIn('event_id', $eventIds)
            ->with(['event', 'user']) // Load relasi agar performa cepat
            ->latest()
            ->paginate(15); // Pagination 15 per halaman

        return view('organizer.transactions.index', compact('transactions'));
    }
}