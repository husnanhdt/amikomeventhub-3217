@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <h1 class="text-3xl font-bold mb-8">Riwayat Transaksi</h1>

    @if($transactions->isEmpty())
    <div class="text-center py-12 bg-slate-50 rounded-2xl">
        <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        <p class="text-lg text-slate-500">Belum ada transaksi.</p>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($transactions as $transaction)
        @php
        // Ubah status jadi huruf kecil semua agar pengecekan lebih akurat
        $statusLower = strtolower($transaction->status);
        @endphp

        <div class="bg-white p-6 rounded-xl shadow-md border border-slate-100 hover:shadow-lg transition">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-slate-900">{{ $transaction->event->title }}</h2>
                    <p class="text-slate-500 text-sm mt-1">
                        {{ \Carbon\Carbon::parse($transaction->event->date)->format('d M Y') }}
                    </p>
                </div>

                <!-- Status Badge dengan Warna yang Benar (SAMA PERSIS dengan Admin) -->
                @if(in_array($statusLower, ['success', 'settlement', 'capture']))
                <span class="px-4 py-1.5 bg-green-100 text-green-700 rounded-full text-sm font-bold">
                    SUCCESS
                </span>
                @elseif(in_array($statusLower, ['pending']))
                <span class="px-4 py-1.5 bg-orange-100 text-orange-700 rounded-full text-sm font-bold">
                    PENDING
                </span>
                @elseif(in_array($statusLower, ['expired', 'cancelled', 'deny', 'failed']))
                <span class="px-4 py-1.5 bg-red-100 text-red-700 rounded-full text-sm font-bold">
                    {{ strtoupper($statusLower) }}
                </span>
                @else
                <span class="px-4 py-1.5 bg-slate-100 text-slate-700 rounded-full text-sm font-bold">
                    {{ strtoupper($statusLower) }}
                </span>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                <div>
                    <p class="text-sm text-slate-500 mb-1">Total Pembayaran</p>
                    <p class="text-2xl font-bold text-indigo-600">
                        Rp {{ number_format($transaction->total_price ?? 0, 0, ',', '.') }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-slate-500 mb-1">Metode Pembayaran</p>
                    <p class="font-semibold text-slate-900">
                        {{ $transaction->payment_method ?? 'Midtrans' }}
                    </p>
                </div>
            </div>

            <!-- Order ID -->
            <div class="mt-4 pt-4 border-t border-slate-100">
                <p class="text-xs text-slate-400">Order ID: <span class="font-mono font-semibold text-slate-600">{{ $transaction->order_id }}</span></p>
                <p class="text-xs text-slate-400 mt-1">
                    Tanggal: {{ $transaction->created_at->format('d M Y, H:i') }}
                </p>
            </div>

            <!-- Tombol Lihat Tiket (jika sudah bayar) -->
            @if(in_array($statusLower, ['success', 'settlement', 'capture']))
            <a href="{{ route('ticket', $transaction->id) }}"
                class="mt-4 inline-block w-full text-center px-4 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                Lihat E-Ticket
            </a>
            @elseif(in_array($statusLower, ['pending']))
            <!-- SESUDAH (BENAR) -->
            <a href="{{ route('checkout.payment', ['order_id' => $transaction->order_id]) }}" class="mt-4 inline-block w-full text-center px-4 py-3 bg-orange-500 text-white rounded-xl font-bold hover:bg-orange-600 transition">
                Bayar Sekarang
            </a>
            @endif
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection