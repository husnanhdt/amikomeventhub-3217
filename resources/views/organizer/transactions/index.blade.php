@extends('layouts.organizer')

@section('page_title', 'Riwayat Transaksi')
@section('page_subtitle', 'Pantau semua transaksi masuk untuk event yang Anda kelola.')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    @if($transactions->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold">
                <tr>
                    <th class="px-6 py-4">Order ID</th>
                    <th class="px-6 py-4">Event</th>
                    <th class="px-6 py-4">Pembeli</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($transactions as $trx)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 font-mono text-sm text-slate-600">{{ $trx->order_id }}</td>
                    <td class="px-6 py-4 font-semibold text-slate-900 max-w-xs truncate">{{ $trx->event->title ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        <div class="font-medium">{{ $trx->customer_name }}</div>
                        <div class="text-xs text-slate-400">{{ $trx->customer_email }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 whitespace-nowrap">{{ $trx->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4 font-bold text-indigo-600 whitespace-nowrap">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @php
                            $status = strtolower($trx->status);
                        @endphp
                        @if(in_array($status, ['success', 'paid', 'settlement']))
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase">Success</span>
                        @elseif($status === 'pending')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold uppercase">Pending</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold uppercase">{{ $trx->status }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $transactions->links() }}
    </div>
    @else
    <!-- Empty State -->
    <div class="text-center py-16 px-6">
        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
        </div>
        <h4 class="text-lg font-bold text-slate-900 mb-2">Belum Ada Transaksi</h4>
        <p class="text-slate-500 max-w-sm mx-auto">Belum ada transaksi yang masuk untuk event-event yang Anda kelola.</p>
    </div>
    @endif
</div>
@endsection