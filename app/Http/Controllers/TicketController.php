<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('user_id', Auth::id())
            ->with('event')
            ->latest()
            ->get();
        
        return view('user.tickets', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        // Pastikan user hanya bisa lihat tiketnya sendiri
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('user.ticket-detail', compact('ticket'));
    }

    // Method untuk check-in tiket (scan QR)
    public function checkIn(Ticket $ticket)
    {
        // Hanya panitia yang bisa check-in
        if (!Auth::user()->isOrganizer()) {
            abort(403);
        }
        
        if ($ticket->isUsed()) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket sudah digunakan!'
            ], 400);
        }
        
        $ticket->markAsUsed();
        
        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil!'
        ]);
    }
}