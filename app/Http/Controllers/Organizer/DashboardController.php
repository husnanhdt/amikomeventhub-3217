<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // 🔒 MULTI-TENANT CORE: Ambil data HANYA untuk partner milik user ini
        $partnerId = $user->partner_id;
        
        if (!$partnerId) {
            return redirect()->route('home')->with('error', 'Anda belum terhubung dengan organisasi manapun.');
        }

        // 1. Ambil semua event milik partner ini
        $events = Event::where('partner_id', $partnerId)->get();
        $eventIds = $events->pluck('id');

        // 2. Analitik Pendapatan (Hanya dari transaksi yang sudah lunas/sukses)
        // Kita tambahkan 'Success' dan 'success' untuk jaga-jaga perbedaan huruf besar/kecil di database
        $totalRevenue = Transaction::whereIn('event_id', $eventIds)
            ->whereIn('status', ['success', 'Success', 'paid', 'settlement'])
            ->sum('total_price');

        // ✅ 3. TIKET TERJUAL: Hitung dari JUMLAH TRANSAKSI yang sukses
        // Karena 1 transaksi = 1 tiket (sesuai logika auto-create di EventController), 
        // menghitung transaksi sukses jauh lebih akurat dan real-time daripada menghitung tabel tickets.
        $totalTicketsSold = Transaction::whereIn('event_id', $eventIds)
            ->whereIn('status', ['success', 'Success', 'paid', 'settlement'])
            ->count();

        // 4. Event Terbaru (Maksimal 5)
        $recentEvents = Event::where('partner_id', $partnerId)
            ->latest()
            ->take(5)
            ->get();

        // 5. Transaksi Terbaru (Maksimal 5, beserta data event-nya)
        $recentTransactions = Transaction::whereIn('event_id', $eventIds)
            ->with('event')
            ->latest()
            ->take(5)
            ->get();

        // 6. Kirim data ke view
        return view('organizer.dashboard', compact(
            'totalRevenue',
            'totalTicketsSold',
            'recentEvents',
            'recentTransactions'
        ));
    }
}