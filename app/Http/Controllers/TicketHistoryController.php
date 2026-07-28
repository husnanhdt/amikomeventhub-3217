<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketHistoryController extends Controller
{
    public function index()
    {
        // Ambil semua tiket milik user yang sedang login
        $tickets = Ticket::where('user_id', Auth::id())
            ->with(['event', 'transaction'])
            ->latest()
            ->get();
        
        return view('user.ticket-history', compact('tickets'));
    }
}