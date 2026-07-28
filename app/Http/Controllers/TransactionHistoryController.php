<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionHistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Pastikan query mengambil transaksi MILIK USER YANG LOGIN
        $transactions = Transaction::where('user_id', $user->id)
            ->with(['event', 'user'])
            ->latest()
            ->get();
        
        return view('user.transaction-history', compact('transactions'));
    }
}