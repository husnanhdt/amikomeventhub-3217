<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        $partnerId = Auth::user()->partner_id;

        // ✅ PERUBAHAN: get() diganti paginate(), map() diganti through()
        $events = Event::where('partner_id', $partnerId)
            ->withCount(['transactions as sold_tickets' => function ($query) {
                $query->whereIn('status', ['success', 'paid', 'settlement']);
            }])
            ->latest()
            ->paginate(10)
            ->through(function ($event) {
                // Hitung total tiket yang terjual (semua status sukses)
                $soldTickets = $event->sold_tickets;

                // Stok asli = stok saat ini + yang sudah terjual
                $originalStock = $event->stock + $soldTickets;

                // Sisa stok = stok yang ada di database saat ini
                $remainingStock = $event->stock;

                // Tambahkan atribut computed
                $event->original_stock = $originalStock;
                $event->sold_tickets = $soldTickets;
                $event->remaining_stock = $remainingStock;

                return $event;
            });

        return view('organizer.tickets.index', compact('events'));
    }

    public function show($eventId)
    {
        $event = Event::where('partner_id', Auth::user()->partner_id)->findOrFail($eventId);

        $transactions = Transaction::where('event_id', $eventId)
            ->whereIn('status', ['success', 'paid', 'settlement'])
            ->with('user')
            ->latest()
            ->paginate(20);

        return view('organizer.tickets.show', compact('event', 'transactions'));
    }
}