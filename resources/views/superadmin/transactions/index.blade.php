@extends('layouts.superadmin')

@section('title', 'Transaksi Global')
@section('page_title', 'Laporan Transaksi')
@section('page_subtitle', 'Pantau arus kas, penjualan tiket, dan riwayat pembayaran secara real-time.')

@section('content')

<!-- 1. ENHANCED STATS CARDS dengan Gradients -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Transaksi -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 rounded-2xl text-white shadow-lg shadow-blue-200 hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <span class="text-xs font-bold bg-white/20 px-2 py-1 rounded-full">All Time</span>
        </div>
        <p class="text-blue-100 text-sm font-medium mb-1">Total Transaksi</p>
        <h3 class="text-3xl font-black">{{ number_format($totalTransactions) }}</h3>
    </div>

    <!-- Total Pendapatan -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 p-6 rounded-2xl text-white shadow-lg shadow-green-200 hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-xs font-bold bg-white/20 px-2 py-1 rounded-full">+15%</span>
        </div>
        <p class="text-green-100 text-sm font-medium mb-1">Total Pendapatan</p>
        <h3 class="text-2xl font-black">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
    </div>

    <!-- Transaksi Hari Ini -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-6 rounded-2xl text-white shadow-lg shadow-purple-200 hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <span class="text-xs font-bold bg-white/20 px-2 py-1 rounded-full">Hari Ini</span>
        </div>
        <p class="text-purple-100 text-sm font-medium mb-1">Transaksi Hari Ini</p>
        <h3 class="text-3xl font-black">{{ number_format($transactionsToday ?? 0) }}</h3>
    </div>

    <!-- Pendapatan Hari Ini -->
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-6 rounded-2xl text-white shadow-lg shadow-orange-200 hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-xs font-bold bg-white/20 px-2 py-1 rounded-full">Today</span>
        </div>
        <p class="text-orange-100 text-sm font-medium mb-1">Pendapatan Hari Ini</p>
        <h3 class="text-2xl font-black">Rp {{ number_format($revenueToday ?? 0, 0, ',', '.') }}</h3>
    </div>
</div>

<!-- 2. QUICK FILTERS & ACTIONS -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <div class="flex flex-wrap gap-4 items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="text-sm font-semibold text-slate-700">Filter Cepat:</span>
            <a href="{{ route('superadmin.transactions.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ !request('status') ? 'bg-indigo-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Semua
            </a>
            <a href="{{ route('superadmin.transactions.index', ['status' => 'success']) }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request('status') == 'success' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                ✓ Berhasil
            </a>
            <a href="{{ route('superadmin.transactions.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request('status') == 'pending' ? 'bg-yellow-600 text-white' : 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' }}">
                ⏳ Pending
            </a>
            <a href="{{ route('superadmin.transactions.index', ['status' => 'failed']) }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request('status') == 'failed' ? 'bg-red-600 text-white' : 'bg-red-100 text-red-700 hover:bg-red-200' }}">
                ✗ Gagal
            </a>
        </div>

        <div class="flex gap-2">
            <button onclick="window.print()" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-200 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak
            </button>
            <div class="relative">
                <select onchange="if(this.value) window.location.href=this.value" class="pl-10 pr-8 py-2 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition appearance-none cursor-pointer">
                    <option value="">Export Data</option>
                    <option value="{{ route('superadmin.transactions.export.excel') }}"> Excel</option>
                    <option value="{{ route('superadmin.transactions.export.pdf') }}">📄 PDF</option>
                </select>
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- 3. ENHANCED TABLE CONTAINER -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

    <!-- Search Bar -->
    <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white">
        <form method="GET" action="{{ route('superadmin.transactions.index') }}" class="flex gap-3">
            <div class="flex-1 relative">
                <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" name="search" placeholder="Cari Order ID, Nama Pembeli, atau Email..."
                    value="{{ request('search') }}"
                    class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
            </div>
            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition flex items-center gap-2 shadow-lg shadow-indigo-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Cari
            </button>
            @if(request('search') || request('status'))
            <a href="{{ route('superadmin.transactions.index') }}" class="px-6 py-3 bg-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-300 transition">
                Reset
            </a>
            @endif
        </form>
    </div>

    <!-- Enhanced Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gradient-to-r from-slate-50 to-slate-100 text-slate-600 uppercase text-xs font-bold tracking-wider">
                <tr>
                    <th class="px-6 py-4">Order ID</th>
                    <th class="px-6 py-4">Pembeli</th>
                    <th class="px-6 py-4">Event</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($transactions as $trx)
                <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <span class="font-mono text-sm font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg">#{{ $trx->order_id }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($trx->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-slate-800">{{ $trx->user->name ?? 'N/A' }}</div>
                                <div class="text-xs text-slate-500">{{ $trx->user->email ?? '-' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <div class="font-semibold text-slate-800">{{ $trx->event->title ?? '-' }}</div>
                            <div class="text-xs text-slate-500 flex items-center gap-1 mt-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ \Carbon\Carbon::parse($trx->event->date ?? null)->format('d M Y') }}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-slate-800 text-lg">
                            Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                        </div>
                        @if(isset($trx->voucher_discount) && $trx->voucher_discount > 0)
                        <div class="text-xs text-green-600 font-semibold">
                            - Rp {{ number_format($trx->voucher_discount, 0, ',', '.') }}
                        </div>
                        @endif
                    </td>

                    {{-- ✅ BAGIAN STATUS YANG SUDAH DIUPDATE DENGAN WARNA MENCOLOK --}}
                    <td class="px-6 py-4">
                        @php $status = strtolower($trx->status); @endphp
                        @if($status === 'success' || $status === 'paid' || $status === 'settlement')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-bold bg-green-500 text-white shadow-md shadow-green-200 border-2 border-white">
                            <span class="text-sm">✓</span>
                            Berhasil
                        </span>
                        @elseif($status === 'pending')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-bold bg-yellow-500 text-white shadow-md shadow-yellow-200 border-2 border-white">
                            <span class="text-sm">⏳</span>
                            Menunggu
                        </span>
                        @elseif($status === 'failed' || $status === 'expired')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-bold bg-red-500 text-white shadow-md shadow-red-200 border-2 border-white">
                            <span class="text-sm">✗</span>
                            Gagal
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-bold bg-slate-400 text-white shadow-md shadow-slate-200 border-2 border-white">
                            <span class="text-sm">•</span>
                            {{ ucfirst($trx->status) }}
                        </span>
                        @endif
                    </td>
                    {{-- ✅ AKHIR BAGIAN STATUS --}}

                    <td class="px-6 py-4">
                        <div class="text-sm text-slate-700 font-medium">
                            {{ $trx->created_at->format('d M Y') }}
                        </div>
                        <div class="text-xs text-slate-500 flex items-center gap-1 mt-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $trx->created_at->format('H:i') }} WIB
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            {{-- Tombol Detail (Mata) --}}
                            <a href="{{ route('superadmin.transactions.show', $trx->id) }}"
                                class="p-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition"
                                title="Lihat Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>

                            {{-- Tombol Cetak (Print) --}}
                            <a href="{{ route('superadmin.transactions.print', $trx->id) }}"
                                class="p-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition"
                                title="Cetak Tiket">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <p class="text-slate-700 font-bold text-lg mb-2">Belum Ada Transaksi</p>
                        <p class="text-slate-500 text-sm">Transaksi akan muncul di sini setelah ada pembelian.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Enhanced Pagination -->
    <div class="px-6 py-4 border-t border-slate-100 bg-gradient-to-r from-slate-50 to-white flex items-center justify-between">
        <p class="text-sm text-slate-600">
            Menampilkan <span class="font-bold">{{ $transactions->firstItem() ?? 0 }}</span> - <span class="font-bold">{{ $transactions->lastItem() ?? 0 }}</span> dari <span class="font-bold">{{ $transactions->total() }}</span> transaksi
        </p>
        <div class="flex items-center gap-2">
            {{ $transactions->links() }}
        </div>
    </div>
</div>

@endsection