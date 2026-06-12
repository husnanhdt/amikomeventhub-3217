<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('event')->latest();

        // Search filter (Order ID, Nama, Email)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'LIKE', "%{$search}%")
                    ->orWhere('customer_name', 'LIKE', "%{$search}%")
                    ->orWhere('customer_email', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status (opsional)
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $transactions = $query->paginate(20); // Sesuai modul: 20 per halaman

        return view('admin.transactions.index', compact('transactions'));
    }
}
