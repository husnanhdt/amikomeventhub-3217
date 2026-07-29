<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Event;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\TransactionsExport;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'event']);

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->paginate(20);

        // Statistik
        $totalRevenue = Transaction::whereIn('status', ['success', 'paid', 'settlement'])->sum('total_price');
        $totalTransactions = Transaction::count();

        // Statistik hari ini
        $transactionsToday = Transaction::whereDate('created_at', today())->count();
        $revenueToday = Transaction::whereDate('created_at', today())
            ->whereIn('status', ['success', 'paid', 'settlement'])
            ->sum('total_price');

        return view('superadmin.transactions.index', compact(
            'transactions',
            'totalRevenue',
            'totalTransactions',
            'transactionsToday',
            'revenueToday'
        ));
    }

    // ✅ EXPORT EXCEL
    public function exportExcel()
    {
        return Excel::download(new TransactionsExport, 'transaksi-' . date('Y-m-d') . '.xlsx');
    }

    // ✅ EXPORT PDF
    public function exportPdf()
    {
        // 1. Ambil semua data transaksi
        $transactions = Transaction::with(['user', 'event'])->latest()->get();

        // 2. Hitung total transaksi
        $totalTransactions = $transactions->count();

        // 3. ✅ PERBAIKAN HITUNG PENDAPATAN: 
        // Kita filter dulu agar case-insensitive (tidak peduli huruf besar/kecil)
        $validTransactions = $transactions->filter(function ($trx) {
            $status = strtolower(trim($trx->status));
            return in_array($status, ['success', 'paid', 'settlement']);
        });

        // 4. Jumlahkan total_price dari transaksi yang valid
        // CATATAN: Pastikan nama kolom di database kamu benar-benar 'total_price'. 
        // Jika di database kamu namanya 'amount' atau 'total_amount', ganti 'total_price' di bawah ini.
        $totalRevenue = $validTransactions->sum('total_price');

        // 5. Generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('superadmin.transactions.export-pdf', compact('transactions', 'totalRevenue', 'totalTransactions'));

        // Opsional: Atur ukuran kertas
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Laporan-Transaksi-' . date('Y-m-d') . '.pdf');
    }

    // ✅ METHOD 1: Tampilkan Detail Transaksi
    public function show($id)
    {
        $transaction = Transaction::with(['user', 'event.partner', 'event.category'])->findOrFail($id);

        return view('superadmin.transactions.show', compact('transaction'));
    }

    // ✅ METHOD 2: Cetak Tiket (PDF)
    public function printTicket($id)
    {
        $transaction = Transaction::with(['user', 'event.partner', 'event.category'])->findOrFail($id);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('superadmin.transactions.print-ticket', compact('transaction'));

        return $pdf->download('Tiket-' . $transaction->order_id . '.pdf');
    }
}
