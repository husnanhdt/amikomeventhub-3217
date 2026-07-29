<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\Partner;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Dasar
        $totalRevenue = Transaction::whereIn('status', ['success', 'paid', 'settlement'])->sum('total_price');
        
        // ✅ DIPERBAIKI: Karena kolom 'quantity' tidak ada di tabel transactions, 
        // kita gunakan count() untuk menghitung jumlah transaksi sukses sebagai tiket terjual.
        // (Menggunakan ?? tidak berhasil mencegah error karena sum() langsung melempar exception jika kolom tidak ada)
        $ticketsSold = Transaction::whereIn('status', ['success', 'paid', 'settlement'])->count();
        
        $activeEvents = Event::where('date', '>=', now())->count();
        $pendingOrders = Transaction::where('status', 'pending')->count();

        // 2. Data untuk Grafik Pertumbuhan User (6 Bulan Terakhir)
        $userGrowthLabels = [];
        $userGrowthData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $userGrowthLabels[] = $date->format('M Y');
            
            $userGrowthData[] = User::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
        }

        // 3. Data untuk Grafik Pendapatan per Event (Top 5)
        $topEvents = Event::withSum(['transactions as revenue' => function($query) {
            $query->whereIn('status', ['success', 'paid', 'settlement']);
        }], 'total_price')
        ->orderByDesc('revenue')
        ->take(5)
        ->get();

        $revenueByEventLabels = $topEvents->pluck('title')->toArray();
        $revenueByEventData = $topEvents->pluck('revenue')->toArray();

        // Fallback jika tidak ada data
        if (empty($revenueByEventLabels)) {
            $revenueByEventLabels = ['Belum ada data'];
            $revenueByEventData = [0];
        }

        // 4. Data untuk Grafik Pie Chart Status Transaksi
        $statusData = [
            Transaction::whereIn('status', ['success', 'settlement'])->count(),
            Transaction::where('status', 'pending')->count(),
            Transaction::whereIn('status', ['expire', 'failed', 'cancel', 'deny'])->count(),
        ];

        $statusLabels = ['Success', 'Pending', 'Failed'];

        // Fallback untuk pie chart
        if (array_sum($statusData) === 0) {
            $statusData = [0, 0, 1];
            $statusLabels = ['Success', 'Pending', 'Failed'];
        }

        // 5. Transaksi Terakhir (10 terbaru)
        $recentTransactions = Transaction::with(['user', 'event'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'pendingOrders',
            'userGrowthLabels',
            'userGrowthData',
            'revenueByEventLabels',
            'revenueByEventData',
            'statusLabels',
            'statusData',
            'recentTransactions'
        ));
    }
}