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

        // --- INTEGRASI SNAP MIDTRANS ---

        // Konfigurasi Kredensial Environment Midtrans
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false; // Mode Sandbox!
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Susun Paket Array Data Transaksi
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
            ],
        ];

        try {
            // Perintah Tembak Generate Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Update rekaman kita bahwa transaksi terkait sudah memiliki id token pelunasan
            $transaction->update(['snap_token' => $snapToken]);

            // Redirect ke halaman antarmuka pembayaran final pelanggan
            return redirect()->route('checkout.payment', $transaction->order_id);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran jaringan: ' . $e->getMessage());
        }
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

    public function payment($order_id)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();

        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        return view('checkout.payment', compact('transaction', 'categories'));
    }

    public function success($order_id)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = \App\Models\Category::all();

        $transaction = Transaction::where('order_id', $order_id)->firstOrFail();

        // Validasi status pembayaran asli dari Midtrans (Mencegah manipulasi URL)
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false; // Mode Sandbox

        try {
            // Cek status transaksi langsung dari Midtrans
            $midtransStatus = \Midtrans\Transaction::status($order_id);

            // Cast ke object untuk memenuhi type hint
            $midtransStatus = (object) $midtransStatus;

            // Update status jadi 'Success' hanya jika Midtrans konfirmasi pembayaran lunas
            if (in_array($midtransStatus->transaction_status, ['capture', 'settlement'])) {
                $transaction->update(['status' => 'Success']);
            }
        } catch (\Exception $e) {
            // Jika error (transaksi tidak ditemukan / koneksi putus), redirect ke home
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan atau gagal diproses.');
        }

        // Tampilkan halaman sukses dengan data transaksi
        return view('checkout.success', compact('transaction', 'categories'));
    }
}
