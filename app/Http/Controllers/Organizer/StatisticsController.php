<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    public function index()
    {
        $partnerId = Auth::user()->partner_id;

        $events = Event::where('partner_id', $partnerId)
            ->withCount(['transactions as ticket_sold' => function ($query) {
                $query->whereIn('status', ['success', 'paid', 'settlement']);
            }])
            ->withSum(['transactions as revenue' => function ($query) {
                $query->whereIn('status', ['success', 'paid', 'settlement']);
            }], 'total_price')
            ->latest()
            ->get();

        $totalRevenue = $events->sum('revenue');
        $totalTickets = $events->sum('ticket_sold');
        $totalEvents = $events->count();

        return view('organizer.statistics.index', compact('events', 'totalRevenue', 'totalTickets', 'totalEvents'));
    }
}