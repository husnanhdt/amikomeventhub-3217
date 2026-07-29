@extends('layouts.superadmin')

@section('title', 'Detail Transaksi')
@section('page_title', 'Detail Transaksi')
@section('page_subtitle', 'Informasi lengkap transaksi #' . $transaction->order_id)

@section('content')

<div class="max-w-6xl mx-auto">
    <!-- Back Button -->
    <a href="{{ route('superadmin.transactions.index') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-800 mb-6">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali ke Daftar Transaksi
    </a>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        
        <!-- Info Transaksi (2/3) -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-purple-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg">Informasi Transaksi</h3>
                        <p class="text-sm text-slate-500">Order ID: <span class="font-mono font-bold text-indigo-600">#{{ $transaction->order_id }}</span></p>
                    </div>
                    @php
                        $statusConfig = [
                            'success' => ['bg' => 'bg-green-500', 'label' => 'Berhasil'],
                            'paid' => ['bg' => 'bg-green-500', 'label' => 'Dibayar'],
                            'settlement' => ['bg' => 'bg-green-500', 'label' => 'Selesai'],
                            'pending' => ['bg' => 'bg-yellow-500', 'label' => 'Menunggu'],
                            'failed' => ['bg' => 'bg-red-500', 'label' => 'Gagal'],
                            'expired' => ['bg' => 'bg-red-500', 'label' => 'Kadaluarsa'],
                        ];
                        $config = $statusConfig[$transaction->status] ?? ['bg' => 'bg-slate-400', 'label' => ucfirst($transaction->status)];
                    @endphp
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-bold {{ $config['bg'] }} text-white shadow-md">
                        {{ $config['label'] }}
                    </span>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Tanggal Transaksi</p>
                        <p class="font-semibold text-slate-800">{{ $transaction->created_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Metode Pembayaran</p>
                        <p class="font-semibold text-slate-800">{{ $transaction->payment_method ?? 'Midtrans' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Total Harga</p>
                        <p class="font-bold text-2xl text-green-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Jumlah Tiket</p>
                        <p class="font-semibold text-slate-800">{{ $transaction->quantity ?? 1 }} Tiket</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Pembeli (1/3) -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-cyan-50">
                <h3 class="font-bold text-slate-800 text-lg">Info Pembeli</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-2xl">
                        {{ strtoupper(substr($transaction->user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-lg">{{ $transaction->user->name ?? 'N/A' }}</h4>
                        <p class="text-sm text-slate-500">{{ $transaction->user->email ?? '-' }}</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-slate-500">Nomor Telepon</p>
                        <p class="font-medium text-slate-800">{{ $transaction->user->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Tanggal Lahir</p>
                        <p class="font-medium text-slate-800">{{ $transaction->user->birth_date ? \Carbon\Carbon::parse($transaction->user->birth_date)->format('d M Y') : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Event -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-purple-50 to-pink-50">
            <h3 class="font-bold text-slate-800 text-lg">Detail Event</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <h4 class="font-bold text-slate-800 text-xl mb-2">{{ $transaction->event->title ?? '-' }}</h4>
                    <p class="text-slate-600 mb-4">{{ $transaction->event->description ?? 'Tidak ada deskripsi' }}</p>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-500">Kategori</p>
                            <p class="font-medium text-slate-800">{{ $transaction->event->category->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Lokasi</p>
                            <p class="font-medium text-slate-800">{{ $transaction->event->location ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Tanggal Event</p>
                            <p class="font-medium text-slate-800">{{ $transaction->event->date ? \Carbon\Carbon::parse($transaction->event->date)->format('d M Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Penyelenggara</p>
                            <p class="font-medium text-slate-800">{{ $transaction->event->partner->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 text-white">
                    <p class="text-indigo-100 text-sm mb-1">Harga Tiket</p>
                    <h3 class="text-3xl font-black mb-4">Rp {{ number_format($transaction->event->price ?? 0, 0, ',', '.') }}</h3>
                    
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-indigo-100">Subtotal</span>
                            <span class="font-bold">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-indigo-100">Biaya Admin</span>
                            <span class="font-bold">Rp 0</span>
                        </div>
                        <div class="border-t border-white/20 pt-2 mt-2 flex justify-between">
                            <span class="font-bold">Total</span>
                            <span class="font-black text-xl">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-4">
        <a href="{{ route('superadmin.transactions.print', $transaction->id) }}" class="px-6 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition flex items-center gap-2 shadow-lg shadow-green-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Cetak Tiket PDF
        </a>
        <a href="{{ route('superadmin.transactions.index') }}" class="px-6 py-3 bg-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-300 transition">
            Kembali
        </a>
    </div>
</div>

@endsection