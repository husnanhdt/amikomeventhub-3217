<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EventController extends Controller
{
    /**
     * Tampilkan detail event
     */
    public function show($id)
    {
        $event = Event::with('category')->findOrFail($id);
        $categories = Category::all(); // Untuk menu footer
        
        return view('event-detail', compact('event', 'categories'));
    }
    
    /**
     * Tampilkan halaman checkout
     */
    public function checkout($id)
    {
        $event = Event::findOrFail($id);
        $categories = Category::all(); // Untuk menu footer

        return view('checkout.create', compact('event', 'categories'));
    }

    /**
     * Proses checkout dan generate Snap Token Midtrans
     */
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

        // ✅ 3. Generate Order ID Unik
        $orderId = 'TRX-' . time() . '-' . Str::random(5);
        $totalPrice = $event->price + 5000; // Harga + Biaya admin

        // ✅ 4. Simpan transaksi dengan status PENDING
        $transaction = Transaction::create([
            'event_id'       => $event->id,
            'order_id'       => $orderId,
            'customer_name'  => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'total_price'    => $totalPrice,
            'status'         => 'Pending', 
            'snap_token'     => null, 
        ]);

        // ✅ 5. Kurangi stok event segera
        $event->decrement('stock');

        // --- INTEGRASI SNAP MIDTRANS ---
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false; // Mode Sandbox
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

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
            // Generate Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Update record dengan token
            $transaction->update(['snap_token' => $snapToken]);

            // Redirect ke halaman pembayaran
            return redirect()->route('checkout.payment', $transaction->order_id);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran jaringan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan halaman tiket dengan QR Code
     */
    public function ticket($id = null)
    {
        $transaction = null;

        // 1. Coba ambil dari database dulu
        if ($id) {
            $transaction = Transaction::with('event')->find($id);
        }

        // 2. Fallback ke session jika tidak ada ID
        if (!$transaction) {
            $transaction = session('transaction');
            if ($transaction && is_object($transaction)) {
                $transaction->load('event');
            }
        }

        // 3. Jika tetap tidak ditemukan, redirect ke home
        if (!$transaction) {
            return redirect('/')->with('error', 'Data transaksi tidak ditemukan');
        }

        // ✅ Data khusus untuk generate QR Code (LOGIKA KAMU YANG BAGUS INI DIPERTAHANKAN)
        $qrData = [
            'order_id' => $transaction->order_id,
            'event' => $transaction->event->title ?? 'Event',
            'customer' => $transaction->customer_name,
            'date' => $transaction->event->date ?? now(),
        ];

        return view('ticket', compact('transaction', 'qrData'));
    }

    /**
     * Tampilkan halaman pembayaran Midtrans
     */
    public function payment($order_id)
    {
        $categories = Category::all();
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        
        return view('checkout.payment', compact('transaction', 'categories'));
    }

    /**
     * Halaman sukses & Fallback Webhook (Jika webhook telat masuk)
     */
    public function success($order_id)
    {
        $categories = Category::all();
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();

        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        try {
            // Cek status langsung ke API Midtrans
            $status = \Midtrans\Transaction::status($order_id);

            if ($status) {
                $trx_status = is_array($status) ? ($status['transaction_status'] ?? '') : ($status->transaction_status ?? '');

                // Jika API Midtrans mengonfirmasi bahwa transaksi telah berhasil
                if (in_array($trx_status, ['settlement', 'capture'])) {
                    
                    // Hanya lakukan update jika status di database lokal masih 'pending' 
                    // (Ini mencegah double processing jika webhook sudah berjalan)
                    if (strtolower($transaction->status) === 'pending') {
                        $transaction->update(['status' => 'Success']);

                        // ✅ LOGIKA PENGIRIMAN EMAIL FALLBACK KAMU DIPERTAHANKAN
                        if ($transaction->event && $transaction->event->stock > 0) {
                            try {
                                Mail::to($transaction->customer_email)
                                    ->send(new \App\Mail\EventTicketMail($transaction));
                            } catch (\Exception $e) {
                                // Gunakan Log facade yang sudah di-import
                                Log::error('Gagal mengirim email E-Ticket secara manual (Bypass): ' . $e->getMessage());
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Jika gagal cek ke Midtrans, tetap tampilkan halaman sukses agar user tidak panic
            Log::warning('Gagal verifikasi status Midtrans di halaman success: ' . $e->getMessage());
        }

        return view('checkout.success', compact('transaction', 'categories'));
    }
}