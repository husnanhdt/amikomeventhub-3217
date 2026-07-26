<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionHistoryController extends Controller
{
    public function index()
    {
        $transactions = Auth::user()->transactions()->latest()->get();
        return view('user.transaction-history', compact('transactions'));
    }
}