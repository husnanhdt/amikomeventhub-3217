<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // SHOW: Detail event untuk user (public)
    public function show($id)
    {
        $event = Event::with('category')->findOrFail($id);
        return view('event-detail', compact('event'));
    }

    // CHECKOUT: Tampilkan halaman checkout
    public function checkout($id)
    {
        $event = Event::findOrFail($id);
        return view('checkout', compact('event'));
    }

    // ✅ PROCESS: Simpan transaksi ke database
    public function process(Request $request, $id)
{
    $event = Event::findOrFail($id);

    // Validasi
    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'customer_email' => 'required|email|max:255',
        'customer_phone' => 'required|string|max:20',
    ]);

    // Simpan transaksi
    $transaction = Transaction::create([
        'event_id' => $event->id,
        'order_id' => 'TRX-' . date('YmdHis'),
        'customer_name' => $validated['customer_name'],
        'customer_email' => $validated['customer_email'],
        'customer_phone' => $validated['customer_phone'],
        'total_price' => $event->price + 5000,
        'status' => 'Success', // Langsung success untuk simulasi
        'snap_token' => null,
    ]);

    // Redirect ke halaman ticket
    return redirect()->route('ticket')->with('transaction', $transaction);
}

    // TICKET: Tampilkan halaman ticket
    public function ticket()
{
    $transaction = session('transaction');
    
    if (!$transaction) {
        return redirect('/')->with('error', 'Tidak ada data transaksi');
    }

    $transaction->load('event');

    // Data yang akan disimpan di QR Code
    $qrData = [
        'order_id' => $transaction->order_id,
        'event' => $transaction->event->title,
        'customer' => $transaction->customer_name,
        'date' => $transaction->event->date,
    ];

    return view('ticket', compact('transaction', 'qrData'));
}
}