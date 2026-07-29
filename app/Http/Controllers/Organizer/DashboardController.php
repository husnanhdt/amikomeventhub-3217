<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $partnerId = auth()->user()->partner_id;

        // 1. Statistik Dasar
        $totalEvents = Event::where('partner_id', $partnerId)->count();
        $activeEvents = Event::where('partner_id', $partnerId)->where('date', '>=', now())->count();
        
        $totalTickets = Transaction::whereIn('status', ['success', 'paid', 'settlement'])
            ->whereHas('event', function($query) use ($partnerId) {
                $query->where('partner_id', $partnerId);
            })
            ->count();

        $totalRevenue = Transaction::whereIn('status', ['success', 'paid', 'settlement'])
            ->whereHas('event', function($query) use ($partnerId) {
                $query->where('partner_id', $partnerId);
            })
            ->sum('total_price');

        // 2. Data untuk Grafik Penjualan Tiket (6 Bulan Terakhir)
        $ticketSalesLabels = [];
        $ticketSalesData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $ticketSalesLabels[] = $date->format('M Y');
            
            $ticketSalesData[] = Transaction::whereIn('status', ['success', 'paid', 'settlement'])
                ->whereHas('event', function($query) use ($partnerId) {
                    $query->where('partner_id', $partnerId);
                })
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
        }

        // 3. Data untuk Grafik Pendapatan per Event (Top 5)
        $topEvents = Event::where('partner_id', $partnerId)
            ->withSum(['transactions as revenue' => function($query) {
                $query->whereIn('status', ['success', 'paid', 'settlement']);
            }], 'total_price')
            ->orderByDesc('revenue')
            ->take(5)
            ->get();

        // Pastikan selalu array, meski kosong
        $revenueByEventLabels = $topEvents->pluck('title')->toArray() ?: ['Belum ada data'];
        $revenueByEventData = $topEvents->pluck('revenue')->toArray() ?: [0];

        // 4. Event Terbaru untuk Tabel
        $recentEvents = Event::where('partner_id', $partnerId)
            ->withCount(['transactions as sold_tickets' => function($query) {
                $query->whereIn('status', ['success', 'paid', 'settlement']);
            }])
            ->withSum(['transactions as revenue' => function($query) {
                $query->whereIn('status', ['success', 'paid', 'settlement']);
            }], 'total_price')
            ->latest()
            ->take(5)
            ->get();

        return view('organizer.dashboard', compact(
            'totalEvents',
            'totalTickets',
            'totalRevenue',
            'activeEvents',
            'ticketSalesLabels',
            'ticketSalesData',
            'revenueByEventLabels',
            'revenueByEventData',
            'recentEvents'
        ));
    }
}