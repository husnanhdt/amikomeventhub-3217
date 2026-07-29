@extends('layouts.admin')

@section('title', 'Laporan Transaksi - Admin')
@section('page_title', 'Laporan Transaksi')
@section('page_subtitle', 'Pantau arus kas dan penjualan tiket Anda.')

@section('content')
<!-- Header dengan Tombol di Kanan -->
<header class="flex justify-end items-center mb-10">
    <div class="flex gap-4">
        <!-- ✅ UBAH MENJADI LINK (A) DENGAN ROUTE -->
        <a href="{{ route('admin.transactions.export.excel', request()->query()) }}" class="px-6 py-3 border-2 border-slate-200 rounded-2xl font-bold hover:bg-white hover:border-indigo-600 hover:text-indigo-600 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Ekspor Excel
        </a>

        <a href="{{ route('admin.transactions.export.pdf', request()->query()) }}" class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg hover:bg-indigo-700 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            Unduh PDF
        </a>
    </div>
</header>

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <!-- Search & Filter -->
    <div class="px-8 py-6 bg-slate-50/50 border-b flex flex-wrap gap-4 items-center">

        <!-- 🔍 Search Form -->
        <div class="flex-1 min-w-[300px] flex gap-2">
            <form method="GET" action="{{ route('admin.transactions.index') }}" class="flex-1 flex gap-2">
                <input type="text" name="search" placeholder="Cari Order ID, Nama, atau Email..."
                    value="{{ request('search') }}"
                    class="flex-1 px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition text-sm font-medium">
                <button type="submit" class="px-4 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">Cari</button>
            </form>
        </div>

        <!-- 🎛️ Filter Controls -->
        <div class="flex gap-2">

            <!-- ✅ Status Filter (Form yang berfungsi) -->
            <form method="GET" action="{{ route('admin.transactions.index') }}" class="flex gap-2">
                <input type="hidden" name="search" value="{{ request('search') }}">

                <select name="status" onchange="this.form.submit()" class="px-5 py-3 rounded-xl border-slate-200 border bg-white outline-none text-sm font-bold cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }} class="text-orange-600">Pending</option>
                    <option value="Success" {{ request('status') == 'Success' ? 'selected' : '' }} class="text-green-600">Success</option>
                    <option value="Expired" {{ request('status') == 'Expired' ? 'selected' : '' }} class="text-rose-600">Expired</option>
                </select>
            </form>

            <!--  Date Filter (Form yang berfungsi) -->
<form method="GET" action="{{ route('admin.transactions.index') }}" class="flex gap-2">
    <input type="hidden" name="search" value="{{ request('search') }}">
    <input type="hidden" name="status" value="{{ request('status') }}">
    
    <select name="date_filter" onchange="this.form.submit()" class="px-5 py-3 rounded-xl border-slate-200 border bg-white outline-none text-sm font-bold cursor-pointer">
        <option value="" {{ request('date_filter') == '' ? 'selected' : '' }}>Semua Waktu</option>
        <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
        <option value="month" {{ request('date_filter') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
        <option value="last_month" {{ request('date_filter') == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
        <option value="year" {{ request('date_filter') == 'year' ? 'selected' : '' }}>Tahun {{ date('Y') }}</option>
    </select>
</form>
        </div>
    </div>

    <!-- Table dengan Layout Mirip Events -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">NO</th>
                    <th class="px-8 py-4">ORDER ID</th>
                    <th class="px-8 py-4">DETAIL PEMBELI</th>
                    <th class="px-8 py-4">EVENT</th>
                    <th class="px-8 py-4">TGL TRANSAKSI</th>
                    <th class="px-8 py-4">STATUS</th>
                    <th class="px-8 py-4">TOTAL TAGIHAN</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($transactions as $index => $trx)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6 font-bold text-slate-400">
                        {{ $transactions->firstItem() + $index }}
                    </td>
                    <td class="px-8 py-6">
                        <span class="font-mono font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg text-sm">
                            #{{ $trx->order_id }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold text-slate-800">{{ $trx->customer_name }}</p>
                        <p class="text-xs text-slate-500">{{ $trx->customer_email }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-medium text-slate-700">{{ $trx->event->title ?? '-' }}</p>
                    </td>
                    <td class="px-8 py-6 text-sm text-slate-500">
                        {{ \Carbon\Carbon::parse($trx->created_at)->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }}
                    </td>
                    <td class="px-8 py-6">
                        @php
                        // Ubah status jadi huruf kecil semua agar pengecekan lebih akurat
                        $statusLower = strtolower($trx->status);
                        @endphp

                        {{-- Jika statusnya success, settlement, atau capture, tampilkan HIJAU --}}
                        @if(in_array($statusLower, ['success', 'settlement', 'capture']))
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase ring-1 ring-green-200">
                            Success
                        </span>

                        {{-- Jika statusnya pending, tampilkan ORANYE --}}
                        @elseif(in_array($statusLower, ['pending']))
                        <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-bold uppercase ring-1 ring-orange-200">
                            Pending
                        </span>

                        {{-- Selain itu (expire, cancel, deny, failed), tampilkan MERAH --}}
                        @else
                        <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-xs font-bold uppercase ring-1 ring-rose-200">
                            {{ ucfirst($statusLower) }}
                        </span>
                        @endif
                    </td>
                    <td class="px-8 py-6 text-right">
                        <p class="font-black text-slate-900">Rp{{ number_format($trx->total_price, 0, ',', '.') }}</p>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-8 py-10 text-center text-slate-500">
                        Belum ada transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-8 py-6 bg-slate-50/50 border-t flex justify-between items-center">
        <p class="text-sm text-slate-500 font-medium">
            Menampilkan {{ $transactions->firstItem() ?? 0 }} - {{ $transactions->lastItem() ?? 0 }} dari {{ $transactions->total() }} transaksi
        </p>
        <div class="flex gap-2">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection