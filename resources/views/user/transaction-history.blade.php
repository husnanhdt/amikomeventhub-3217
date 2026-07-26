@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <h1 class="text-2xl font-bold mb-6">Riwayat Transaksi</h1>
    
    @if($transactions->isEmpty())
        <div class="text-center py-12 bg-slate-50 rounded-2xl">
            <p class="text-lg text-slate-500">Belum ada transaksi.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($transactions as $transaction)
            <div class="bg-white p-6 rounded-xl shadow-md border border-slate-100">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-xl font-bold">{{ $transaction->event->title }}</h2>
                        <p class="text-slate-500 mt-1">{{ $transaction->event->date->format('d M Y') }}</p>
                    </div>
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm font-medium">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </div>
                
                <div class="mt-4 grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-slate-500">Total</p>
                        <p class="font-bold text-lg">Rp {{ number_format($transaction->total, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Metode Pembayaran</p>
                        <p class="font-bold">{{ $transaction->payment_method }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection