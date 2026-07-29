<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Partner;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Dasar
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_organizers' => User::where('role', 'organizer')->count(),
            'pending_organizers' => Partner::where('status', 'pending')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_events' => Event::count(),
            'total_revenue' => Transaction::whereIn('status', ['success', 'paid', 'settlement'])->sum('total_price'),
            'total_transactions' => Transaction::count(),
        'revenue_today' => Transaction::whereDate('created_at', today())
            ->whereIn('status', ['success', 'paid', 'settlement'])
            ->sum('total_price'),
        ];

        // 2. Data untuk Tabel (Organisasi Pending & Recent Events)
        $pendingOrganizations = Partner::with('user')->where('status', 'pending')->latest()->take(5)->get();
        $recentEvents = Event::with(['partner.user', 'category'])->latest()->take(5)->get();

        return view('superadmin.dashboard', compact('stats', 'pendingOrganizations', 'recentEvents'));
    }
}