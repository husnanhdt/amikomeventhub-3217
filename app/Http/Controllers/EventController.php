<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Tampilkan detail event
     */
    public function show($id)
    {
        $event = Event::with('category')->findOrFail($id);
        $categories = Category::all();

        return view('event-detail', compact('event', 'categories'));
    }

    /**
     * Tampilkan halaman checkout
     */
    public function checkout($id)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('message', 'Silakan login terlebih dahulu untuk melakukan pemesanan.');
        }

        // Lanjutkan proses checkout...
        $event = Event::findOrFail($id);
        $user = Auth::user();

        return view('checkout.create', compact('event', 'user'));
    }

    /**
     * Proses checkout dan generate Snap Token Midtrans
     * ✅ DIPERBARUI: Menambahkan bypass untuk acara gratis (Rp 0)
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

        // ============================================
        // ✅ 4. BYPASS UNTUK ACARA GRATIS (Rp 0)
        // ============================================
        if ($event->price == 0) {
            // Buat transaksi langsung SUCCESS (tanpa Midtrans & tanpa biaya admin)
            $transaction = Transaction::create([
                'user_id'        => Auth::id(),
                'event_id'       => $event->id,
                'order_id'       => $orderId,
                'customer_name'  => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'total_price'    => 0, // Gratis total
                'status'         => 'Success', // Langsung sukses
                'snap_token'     => null,
            ]);

            // Auto-create tiket dengan status paid
            Ticket::create([
                'ticket_code'    => 'TKT-' . strtoupper(substr($orderId, 5, 8)) . '-' . strtoupper(Str::random(1)),
                'user_id'        => Auth::id(),
                'event_id'       => $event->id,
                'transaction_id' => $transaction->id,
                'quantity'       => 1,
                'price'          => 0,
                'status'         => 'paid',
            ]);

            // Kurangi stok
            $event->decrement('stock');

            // Kirim email E-Ticket
            try {
                Mail::to($validated['customer_email'])
                    ->send(new \App\Mail\EventTicketMail($transaction));
            } catch (\Exception $e) {
                Log::error('Gagal mengirim email untuk acara gratis: ' . $e->getMessage());
            }

            // Redirect ke halaman sukses
            return redirect()->route('checkout.success', $transaction->order_id)
                ->with('success', 'Pendaftaran berhasil! E-Ticket telah dikirim ke email Anda.');
        }

        // ============================================
        // ✅ 5. LOGIKA NORMAL UNTUK ACARA BERBAYAR
        // ============================================
        $totalPrice = $event->price + 5000; // Harga + Biaya admin (Hanya dihitung jika acara berbayar)

        // Simpan transaksi dengan status PENDING
        $transaction = Transaction::create([
            'user_id'        => Auth::id(),
            'event_id'       => $event->id,
            'order_id'       => $orderId,
            'customer_name'  => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'total_price'    => $totalPrice,
            'status'         => 'Pending',
            'snap_token'     => null,
        ]);

        // Auto-create tiket
        Ticket::create([
            'ticket_code'    => 'TKT-' . strtoupper(substr($orderId, 5, 8)) . '-' . strtoupper(Str::random(1)),
            'user_id'        => Auth::id(),
            'event_id'       => $event->id,
            'transaction_id' => $transaction->id,
            'quantity'       => 1,
            'price'          => $totalPrice,
            'status'         => 'pending',
        ]);

        // Kurangi stok event segera
        $event->decrement('stock');

        // --- INTEGRASI SNAP MIDTRANS ---
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
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

        // ✅ Data khusus untuk generate QR Code
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

        // Normalisasi status jadi huruf kecil
        $statusLower = strtolower($transaction->status);

        // Cek apakah transaksi sudah expired atau dibatalkan
        if (in_array($statusLower, ['expired', 'cancelled', 'deny', 'failure'])) {
            return redirect()->route('transaction.history')
                ->with('error', 'Transaksi Anda telah ' . $transaction->status . '. Silakan buat pesanan baru.');
        }

        // Cek apakah transaksi sudah lunas/dibayar
        if (in_array($statusLower, ['success', 'paid', 'settlement', 'capture'])) {
            return redirect()->route('checkout.success', $order_id);
        }

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Generate Snap Token jika belum ada
        if (!$transaction->snap_token) {
            $params = [
                'transaction_details' => [
                    'order_id' => $transaction->order_id,
                    'gross_amount' => $transaction->total_price,
                ],
                'customer_details' => [
                    'first_name' => $transaction->customer_name,
                    'email' => $transaction->customer_email,
                    'phone' => $transaction->customer_phone,
                ],
            ];

            try {
                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $transaction->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                return redirect()->route('transaction.history')
                    ->with('error', 'Gagal memproses pembayaran. Silakan coba lagi.');
            }
        }

        return view('checkout.payment', compact('transaction', 'categories'));
    }

    /**
     * Halaman sukses & Fallback Webhook
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
                    if (strtolower($transaction->status) === 'pending') {
                        $transaction->update(['status' => 'Success']);

                        // ✅ TAMBAHKAN INI: Update status tiket jadi 'paid'
                        $transaction->tickets()->update(['status' => 'paid']);

                        // LOGIKA PENGIRIMAN EMAIL FALLBACK
                        if ($transaction->event && $transaction->event->stock > 0) {
                            try {
                                Mail::to($transaction->customer_email)
                                    ->send(new \App\Mail\EventTicketMail($transaction));
                            } catch (\Exception $e) {
                                Log::error('Gagal mengirim email E-Ticket: ' . $e->getMessage());
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::warning('Gagal verifikasi status Midtrans di halaman success: ' . $e->getMessage());
        }

        return view('checkout.success', compact('transaction', 'categories'));
    }
}
