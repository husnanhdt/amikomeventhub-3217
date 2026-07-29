<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // ✅ WAJIB ADA INI UNTUK FILTER TANGGAL

// ✅ IMPORT LIBRARY EXPORT
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    // ==========================================
    // 1. HALAMAN INDEX (LOGIKA ASLI ANDA DIPERTAHANKAN 100%)
    // ==========================================
    public function index(Request $request)
    {
        $user = Auth::user();
        $partnerId = $user->partner_id;

        if (!$partnerId) {
            return redirect()->route('home')->with('error', 'Anda belum terhubung dengan organisasi manapun.');
        }

        // Ambil semua ID event milik partner (organizer) ini
        $eventIds = Event::where('partner_id', $partnerId)->pluck('id');

        // Query dasar transaksi berdasarkan event tersebut
        $query = Transaction::whereIn('event_id', $eventIds)->with(['event', 'user']);

        // ✅ Fitur Search (Cari berdasarkan Order ID, Nama, atau Email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // ✅ Fitur Filter Status
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

        // ✅ FITUR BARU: Filter Tanggal (DITAMBAHKAN)
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

        // Urutkan dari yang terbaru dan paginate (tetap 15 sesuai kode asli Anda)
        $transactions = $query->latest()->paginate(15);

        return view('organizer.transactions.index', compact('transactions'));
    }

    // ==========================================
    // 2. FITUR BARU: EXPORT EXCEL
    // ==========================================
    public function exportExcel(Request $request)
    {
        $user = Auth::user();
        $partnerId = $user->partner_id;
        
        $eventIds = Event::where('partner_id', $partnerId)->pluck('id');
        $query = Transaction::whereIn('event_id', $eventIds)->with(['event']);

        // Terapkan filter Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // Terapkan filter Status
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

        // ✅ Terapkan filter Tanggal yang SAMA PERSIS
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

        // Gunakan get() agar semua data ter-export
        $transactions = $query->latest()->get();

        return Excel::download(
            new \App\Exports\OrganizerTransactionsExport($transactions), 
            'Laporan-Transaksi-Organizer-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    // ==========================================
    // 3. FITUR BARU: EXPORT PDF
    // ==========================================
    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        $partnerId = $user->partner_id;
        
        $eventIds = Event::where('partner_id', $partnerId)->pluck('id');
        $query = Transaction::whereIn('event_id', $eventIds)->with(['event']);

        // Terapkan filter Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // Terapkan filter Status
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

        // ✅ Terapkan filter Tanggal yang SAMA PERSIS
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

        // Gunakan get() agar semua data ter-export
        $transactions = $query->latest()->get();
        
        $pdf = Pdf::loadView('organizer.transactions.pdf', compact('transactions'));
        return $pdf->download('Laporan-Transaksi-Organizer-' . now()->format('Y-m-d') . '.pdf');
    }
}