<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\User; // ✅ TAMBAHKAN untuk grafik user
use Illuminate\Support\Facades\DB; // ✅ TAMBAHKAN untuk raw query
use Carbon\Carbon; // ✅ TAMBAHKAN untuk manipulasi tanggal

class DashboardController extends Controller
{
    public function index()
    {
        // ============================================
        // LOGIKA ASLI ANDA (DIPERTAHANKAN 100%)
        // ============================================
        
        // 1. Menjumlahkan semua nominal total_price dari kolom Transaksi Lunas
        $totalRevenue = Transaction::whereIn('status', ['settlement', 'success'])->sum('total_price');
        
        // 2. Menghitung Berapa orang tamu yang tiketnya sudah Lunas
        $ticketsSold = Transaction::whereIn('status', ['settlement', 'success'])->count();
        
        // 3. Menghitung Jumlah Acara Mendatang yang aktif diselenggarakan
        $activeEvents = Event::where('date', '>=', now())->count();
        
        // 4. Menghitung Transaksi Ngadat (Status belum dibayar pelanggan / Expired)
        $pendingOrders = Transaction::where('status', 'pending')->count();
        
        // 5. Menyertakan 5 daftar riwayat pesanan (History) paling mutakhir di panel
        $recentTransactions = Transaction::with('event')->latest()->take(5)->get();

        // ============================================
        // ✅ DATA BARU UNTUK GRAFIK (TAMBAHAN)
        // ============================================

        // 1. Grafik Pertumbuhan User (6 bulan terakhir)
        $userGrowth = User::select(
                DB::raw('COUNT(*) as count'),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Format untuk Chart.js
        $userGrowthLabels = $userGrowth->pluck('month')->map(function($month) {
            return Carbon::parse($month . '-01')->format('M Y');
        })->toArray();

        $userGrowthData = $userGrowth->pluck('count')->toArray();

        // 2. Grafik Pendapatan per Event (Top 5)
        $revenueByEvent = Transaction::select(
                'events.title as event_title',
                DB::raw('SUM(transactions.total_price) as total_revenue')
            )
            ->join('events', 'transactions.event_id', '=', 'events.id')
            ->whereIn('transactions.status', ['settlement', 'success'])
            ->groupBy('events.title')
            ->orderByDesc('total_revenue')
            ->take(5)
            ->get();

        $revenueByEventLabels = $revenueByEvent->pluck('event_title')->toArray();
        $revenueByEventData = $revenueByEvent->pluck('total_revenue')->toArray();

        // 3. Grafik Status Transaksi (Pie Chart)
        $transactionStatus = Transaction::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        $statusLabels = $transactionStatus->pluck('status')->toArray();
        $statusData = $transactionStatus->pluck('count')->toArray();

        // ============================================
        // KIRIM SEMUA DATA KE VIEW
        // ============================================
        return view('admin.dashboard', compact(
            // Data asli Anda
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'pendingOrders',
            'recentTransactions',
            // Data grafik tambahan
            'userGrowthLabels',
            'userGrowthData',
            'revenueByEventLabels',
            'revenueByEventData',
            'statusLabels',
            'statusData'
        ));
    }
}