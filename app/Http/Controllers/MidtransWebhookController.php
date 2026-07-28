<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // 1. Ambil raw payload JSON dari Midtrans
        $payload = $request->getContent();
        $notification = json_decode($payload);

        if (!$notification || !isset($notification->order_id)) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // 2. Cari transaksi di database (dengan relasi event dan tickets)
        $transaction = Transaction::with(['event', 'tickets'])->where('order_id', $notification->order_id)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // 3. Cegah proses berulang jika status sudah Success/Lunas
        if (in_array(strtolower($transaction->status), ['success', 'paid', 'settlement'])) {
            return response()->json(['message' => 'Already processed']);
        }

        $status = $notification->transaction_status;
        $fraud = $notification->fraud_status ?? null;

        // 4. Tentukan status final berdasarkan logika Midtrans
        $finalStatus = null;
        if ($status == 'capture') {
            $finalStatus = ($fraud == 'challenge') ? 'Pending' : 'Success';
        } elseif ($status == 'settlement') {
            $finalStatus = 'Success';
        } elseif (in_array($status, ['cancel', 'deny', 'expire'])) {
            $finalStatus = 'Expired';
        } elseif ($status == 'pending') {
            $finalStatus = 'Pending';
        }

        // 5. Update Transaksi DAN Tiket secara dinamis
        if ($finalStatus) {
            // Update status transaksi
            $transaction->update(['status' => $finalStatus]);

            // ✅ UPDATE STATUS TIKET JUGA! (Ini yang membuat history tiket & dashboard organizer muncul)
            $ticketStatus = ($finalStatus == 'Success') ? 'paid' : (($finalStatus == 'Pending') ? 'pending' : 'cancelled');

            $transaction->tickets()->update(['status' => $ticketStatus]);

            // 6. Kirim Email E-Ticket jika pembayaran BERHASIL (Success)
            if ($finalStatus == 'Success') {
                try {
                    Mail::to($transaction->customer_email)->send(new \App\Mail\EventTicketMail($transaction));
                    Log::info('E-Ticket email sent successfully for order: ' . $transaction->order_id);
                } catch (\Exception $e) {
                    Log::error('Gagal mengirim email E-Ticket via Webhook: ' . $e->getMessage());
                }
            }
        }

        // 7. Beri respon ke Midtrans bahwa webhook sudah diterima
        return response()->json(['message' => 'Webhook processed successfully']);
    }
}
