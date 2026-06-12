<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function show($id)
    {
        $event = Event::with('category')->findOrFail($id);
        $categories = Category::all(); // Untuk menu footer
        
        return view('event-detail', compact('event', 'categories'));
    }


public function checkout($id)
    {
        $event = Event::findOrFail($id);
        $categories = Category::all(); // Untuk menu footer
        
        return view('checkout.create', compact('event', 'categories'));
    }

    public function process(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // ✅ 1. Validasi input
        $validated = $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        // ✅ 2. CEK STOK (wajib)
        if ($event->stock <= 0) {
            return back()->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
        }

        // ✅ 3. Generate Order ID
        $orderId = 'TRX-' . time() . '-' . Str::random(5);

        $totalPrice = $event->price + 5000;

        // ✅ 4. Simpan transaksi dengan status PENDING
        $transaction = Transaction::create([
            'event_id'       => $event->id,
            'order_id'       => $orderId,
            'customer_name'  => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'total_price'    => $totalPrice,
            'status'         => 'Pending', // ✅ Status awal harus 'Pending'
            'snap_token'     => null, // Akan diisi jika integrasi Midtrans
        ]);

        // ✅ TAMBAHKAN INI: Kurangi stok event
        $event->decrement('stock');

        // ✅ 5. Redirect ke halaman tiket (sementara, nanti diarahkan ke Midtrans)
        return redirect()->route('ticket', ['id' => $transaction->id])
            ->with('success', 'Pesanan berhasil dibuat. Silakan lanjutkan pembayaran.');
    }

    public function ticket($id = null)  // ✅ FIX: Terima parameter opsional
    {
        $transaction = null;

        // 1. Coba dari database dulu
        if ($id) {
            $transaction = Transaction::with('event')->find($id);
        }

        // 2. Fallback ke session
        if (!$transaction) {
            $transaction = session('transaction');
            if ($transaction && is_object($transaction)) {
                $transaction->load('event');
            }
        }

        if (!$transaction) {
            return redirect('/')->with('error', 'Data transaksi tidak ditemukan');
        }

        $qrData = [
            'order_id' => $transaction->order_id,
            'event' => $transaction->event->title ?? 'Event',
            'customer' => $transaction->customer_name,
            'date' => $transaction->event->date ?? now(),
        ];

        return view('ticket', compact('transaction', 'qrData'));
    }
}
