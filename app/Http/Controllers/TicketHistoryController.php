<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketHistoryController extends Controller
{
    public function index()
    {
        $tickets = Auth::user()->tickets()->with('event')->latest()->get();
        return view('user.ticket-history', compact('tickets'));
    }
}