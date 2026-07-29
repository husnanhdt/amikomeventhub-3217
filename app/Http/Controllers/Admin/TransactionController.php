<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon; // ✅ WAJIB ADA INI

// ✅ IMPORT LIBRARY EXPORT
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['event']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'Success') {
                $query->whereIn('status', ['success', 'settlement', 'capture', 'paid']);
            } elseif ($status === 'Pending') {
                $query->where('status', 'pending');
            } elseif ($status === 'Expired') {
                $query->whereIn('status', ['expire', 'cancel', 'deny', 'failed']);
            }
        }

        // ✅ FITUR BARU: Filter Tanggal
        if ($request->filled('date_filter')) {
            $dateFilter = $request->date_filter;
            
            if ($dateFilter === 'today') {
                $query->whereDate('created_at', Carbon::today());
            } elseif ($dateFilter === 'month') {
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
            } elseif ($dateFilter === 'last_month') {
                $query->whereMonth('created_at', Carbon::now()->subMonth()->month)
                      ->whereYear('created_at', Carbon::now()->year);
            } elseif ($dateFilter === 'year') {
                $query->whereYear('created_at', Carbon::now()->year);
            }
        }

        $transactions = $query->latest()->paginate(20);
        $categories = Category::all();

        return view('admin.transactions.index', compact('transactions', 'categories'));
    }

    // ✅ Export Excel - Update dengan filter tanggal
    public function exportExcel(Request $request)
    {
        $query = Transaction::with(['event']);

        // Terapkan filter yang sama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'Success') {
                $query->whereIn('status', ['success', 'settlement', 'capture', 'paid']);
            } elseif ($status === 'Pending') {
                $query->where('status', 'pending');
            } elseif ($status === 'Expired') {
                $query->whereIn('status', ['expire', 'cancel', 'deny', 'failed']);
            }
        }

        // ✅ Terapkan filter tanggal
        if ($request->filled('date_filter')) {
            $dateFilter = $request->date_filter;
            
            if ($dateFilter === 'today') {
                $query->whereDate('created_at', Carbon::today());
            } elseif ($dateFilter === 'month') {
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
            } elseif ($dateFilter === 'last_month') {
                $query->whereMonth('created_at', Carbon::now()->subMonth()->month)
                      ->whereYear('created_at', Carbon::now()->year);
            } elseif ($dateFilter === 'year') {
                $query->whereYear('created_at', Carbon::now()->year);
            }
        }

        $transactions = $query->latest()->get();
        return Excel::download(new TransactionsExport($transactions), 'Laporan-Transaksi-' . now()->format('Y-m-d') . '.xlsx');
    }

    // ✅ Export PDF - Update dengan filter tanggal
    public function exportPdf(Request $request)
    {
        $query = Transaction::with(['event']);

        // Terapkan filter yang sama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'Success') {
                $query->whereIn('status', ['success', 'settlement', 'capture', 'paid']);
            } elseif ($status === 'Pending') {
                $query->where('status', 'pending');
            } elseif ($status === 'Expired') {
                $query->whereIn('status', ['expire', 'cancel', 'deny', 'failed']);
            }
        }

        // ✅ Terapkan filter tanggal
        if ($request->filled('date_filter')) {
            $dateFilter = $request->date_filter;
            
            if ($dateFilter === 'today') {
                $query->whereDate('created_at', Carbon::today());
            } elseif ($dateFilter === 'month') {
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
            } elseif ($dateFilter === 'last_month') {
                $query->whereMonth('created_at', Carbon::now()->subMonth()->month)
                      ->whereYear('created_at', Carbon::now()->year);
            } elseif ($dateFilter === 'year') {
                $query->whereYear('created_at', Carbon::now()->year);
            }
        }

        $transactions = $query->latest()->get();
        $pdf = Pdf::loadView('admin.transactions.pdf', compact('transactions'));
        return $pdf->download('Laporan-Transaksi-' . now()->format('Y-m-d') . '.pdf');
    }
}