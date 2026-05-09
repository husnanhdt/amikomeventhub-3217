<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show($id)
    {
        $event = Event::with('category')->findOrFail($id);
        return view('event-detail', compact('event'));
    }

    public function checkout($id)
    {
        $event = Event::findOrFail($id);
        return view('checkout', compact('event'));
    }

    public function process(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        $transaction = Transaction::create([
            'event_id' => $event->id,
            'order_id' => 'TRX-' . date('YmdHis') . '-' . strtoupper(substr(uniqid(), -4)),
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'total_price' => $event->price + 5000,
            'status' => 'Success',
            'snap_token' => null,
        ]);

        // ✅ FIX: Kirim ID sebagai fallback + session
        return redirect()->route('ticket', ['id' => $transaction->id])
            ->with('transaction', $transaction);
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