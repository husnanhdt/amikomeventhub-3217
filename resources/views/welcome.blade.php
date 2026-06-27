@extends('layouts.app')

@section('content')
<!-- Hero Section (TIDAK DIUBAH) -->
<section class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12">
    <div class="flex-1 space-y-8">
        <span
            class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">#1
            Event Platform</span>
        <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
            Temukan & Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
        </h1>
        <p class="text-lg text-slate-500 max-w-lg leading-relaxed">
            Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman & cepat dengan
            Midtrans.
        </p>
        <div class="flex gap-4">
            <a href="#events"
                class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
                Mulai Jelajah
            </a>
            <a href="#"
                class="px-8 py-4 border-2 border-slate-200 rounded-2xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 transition">
                Cara Pesan
            </a>
        </div>
    </div>
    <div class="flex-1 relative">
        <div
            class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
        </div>
        <div
            class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
        </div>
        <img src="assets/concert.png" alt="Concert"
            class="'rounded-[2rem]' shadow-2xl relative z-10 w-full object-cover 'aspect-[4/5]' object-center">

        <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                    <p class="font-bold">Pembayaran Aman via Midtrans</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Events Section (DINAMIS - PRAKTIKUM 6) -->
<section id="events" class="max-w-7xl mx-auto px-6 py-20">

    <!-- Header -->
    <div class="flex justify-between items-end mb-12">
        <div>
            <h2 class="text-3xl font-extrabold mb-2">Event Terdekat</h2>
            <p class="text-slate-500 font-medium">Jangan sampai ketinggalan acara seru minggu ini!</p>
        </div>
    </div>

    <!-- 🔽 FILTER TABS DINAMIS (BARU) 🔽 -->
    <div class="mb-8 flex flex-wrap gap-4 justify-center">
        <a href="/" class="px-5 py-2 bg-slate-200 hover:bg-slate-300 text-slate-800 rounded-xl font-bold transition">
            Semua Kategori
        </a>

        @foreach($categories as $cat)
        <a href="/?category={{ $cat->slug }}"
            class="px-5 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-xl font-bold transition">
            {{ $cat->name }}
        </a>
        @endforeach
    </div>

    <!-- 🔽 EVENT GRID DINAMIS (BARU) 🔽 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($events as $event)
        <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
            
            <!-- ✅ BAGIAN GAMBAR YANG DIPERBAIKI -->
            <div class="relative overflow-hidden 'aspect-[3/4]'">
                @if($event->poster_path)
                    <img src="{{ asset('storage/' . $event->poster_path) }}" 
                         alt="{{ $event->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                         onerror="this.onerror=null; this.src='https://placehold.co/400x600/6366f1/ffffff?text={{ urlencode($event->title) }}';">
                @else
                    <img src="https://placehold.co/400x600/6366f1/ffffff?text={{ urlencode($event->title) }}" 
                         alt="{{ $event->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @endif
                
                <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">
                    {{ $event->category->name ?? 'Umum' }}
                </div>
            </div>
            <!-- ✅ END BAGIAN GAMBAR -->

            <div class="p-6">
                <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition">{{ $event->title }}</h3>
                <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between items-center pt-4 border-t">
                    <span class="text-2xl font-black text-indigo-600">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                    <a href="{{ route('events.show', $event->id) }}"
                        class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 text-slate-500">
            <p class="text-lg font-bold">Tidak ada event yang tersedia untuk kategori ini.</p>
        </div>
        @endforelse
    </div>

</section>

<!-- ✅ Partner & Sponsor Section -->
@if(isset($partners) && $partners->count() > 0)
<section class="py-16 bg-slate-50 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-black text-slate-900 mb-2">Partner & Sponsor</h2>
            <p class="text-slate-500 font-medium">Didukung oleh perusahaan dan institusi terkemuka</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 items-center">
            @foreach($partners as $partner)
            <div class="flex items-center justify-center p-4 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition group">
                @if($partner->logo)
                <img src="{{ asset('storage/' . $partner->logo) }}"
                    alt="{{ $partner->name }}"
                    class="max-h-16 w-auto object-contain opacity-70 group-hover:opacity-100 transition grayscale group-hover:grayscale-0">
                @else
                <div class="w-16 h-16 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 font-bold text-xs text-center">
                    {{ strtoupper(substr($partner->name, 0, 2)) }}
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection