@extends('layouts.organizer')

@section('page_title', 'Dashboard Organizer')
@section('page_subtitle', 'Kelola event dan pantau pendapatan organisasi Anda.')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <p class="text-sm font-semibold text-slate-500 mb-2">Total Event</p>
        <h3 class="text-3xl font-black text-slate-900">{{ $recentEvents->count() }}</h3>
    </div>
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <p class="text-sm font-semibold text-slate-500 mb-2">Tiket Terjual</p>
        <h3 class="text-3xl font-black text-slate-900">{{ $totalTicketsSold }}</h3>
    </div>
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <p class="text-sm font-semibold text-slate-500 mb-2">Pendapatan</p>
        <h3 class="text-3xl font-black text-indigo-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
    </div>
</div>

<!-- Event Terlaris -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-8">
    <h3 class="text-lg font-bold text-slate-900 mb-4">Event Terlaris</h3>
    @if($recentEvents->count() > 0)
    <div class="space-y-4">
        @foreach($recentEvents as $event)
        <div class="flex items-center gap-4 p-4 border border-slate-100 rounded-xl hover:shadow-md transition">
            @if($event->poster_path)
            <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}" class="w-20 h-20 rounded-lg object-cover">
            @else
            <div class="w-20 h-20 bg-slate-100 rounded-lg flex items-center justify-center text-2xl font-bold text-slate-400">
                {{ strtoupper(substr($event->title, 0, 1)) }}
            </div>
            @endif
            <div class="flex-1">
                <h4 class="font-bold text-slate-900">{{ $event->title }}</h4>
                <p class="text-sm text-slate-500">{{ $event->transactions()->whereIn('status', ['success', 'paid', 'settlement'])->count() }} Tiket Terjual</p>
            </div>
            <div class="text-right">
                <p class="font-bold text-indigo-600">Rp {{ number_format($event->transactions()->whereIn('status', ['success', 'paid', 'settlement'])->sum('total_price'), 0, ',', '.') }}</p>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-12 text-slate-500">
        <p>Belum ada event yang dibuat</p>
        <a href="{{ route('organizer.events.create') }}" class="inline-block mt-4 px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
            Buat Event Pertama Anda
        </a>
    </div>
    @endif
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <a href="{{ route('organizer.events.create') }}" class="bg-gradient-to-br from-indigo-600 to-purple-600 p-6 rounded-2xl text-white hover:shadow-xl transition group">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-lg">Buat Event Baru</h4>
                <p class="text-indigo-100 text-sm">Mulai kelola acara Anda sekarang</p>
            </div>
        </div>
    </a>

    <a href="{{ route('organizer.transactions.index') }}" class="bg-white border-2 border-slate-200 p-6 rounded-2xl hover:border-indigo-600 hover:shadow-xl transition group">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 group-hover:scale-110 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-lg text-slate-900">Lihat Transaksi</h4>
                <p class="text-slate-500 text-sm">Pantau semua transaksi masuk</p>
            </div>
        </div>
    </a>
</div>
@endsection