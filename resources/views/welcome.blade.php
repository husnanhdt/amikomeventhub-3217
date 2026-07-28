@extends('layouts.app')

@section('content')
<!-- ============================================ -->
<!-- 1. HERO SECTION (DIPERBARUI: Desain Modern + Routing Dinamis) -->
<!-- ============================================ -->
<section class="relative min-h-[90vh] flex items-center overflow-hidden bg-gradient-to-br from-indigo-50 via-white to-purple-50">
    <!-- Background Blobs Animation -->
    <div class="absolute inset-0 opacity-30 pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-1/2 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12 w-full">
        <!-- Left Content -->
        <div class="flex-1 space-y-8 text-center md:text-left">
            <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider shadow-sm">#1 Event Platform</span>

            <h1 class="text-5xl md:text-7xl font-black leading-tight text-slate-900">
                Temukan & Pesan <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">
                    Tiket Event Impianmu.
                </span>
            </h1>

            <p class="text-lg text-slate-600 max-w-lg mx-auto md:mx-0 leading-relaxed">
                Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman, cepat, dan terpercaya dengan integrasi Midtrans.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                <!-- ✅ ROUTING DINAMIS: Smooth scroll ke bagian #events di bawah -->
                <a href="#events" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                    Mulai Jelajah
                </a>
                <!-- ✅ ROUTING DINAMIS: Arahkan ke halaman Cara Pesan -->
                <a href="{{ route('how-to-order') }}" class="px-8 py-4 bg-white text-slate-700 border-2 border-slate-200 rounded-2xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-300">
                    Cara Pesan
                </a>
            </div>

            <!-- Trust Badge -->
            <div class="flex items-center gap-4 pt-4 justify-center md:justify-start glass p-4 rounded-2xl border border-white/50 w-fit mx-auto md:mx-0">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                    <p class="font-bold text-slate-900">Pembayaran Aman via Midtrans</p>
                </div>
            </div>
        </div>

        <!-- Right Content - Event Poster -->
        <div class="flex-1 relative w-full max-w-md mx-auto md:max-w-none">
            <div class="relative rounded-[2rem] overflow-hidden shadow-2xl border-4 border-white/50">
                <img src="{{ asset('assets/concert.png') }}"
                    alt="Concert Event"
                    class="w-full h-auto object-cover aspect-[4/5] object-center relative z-10"
                    onerror="this.src='https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=800&auto=format&fit=crop'">

                <!-- Overlay Info -->
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-6 z-20">
                    <p class="text-white font-bold text-xl">Jazz Night 2026</p>
                    <p class="text-slate-200 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        21 Sep 2026 • Amikom Baru
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- 2. EVENTS SECTION (LOGIKA ASLI ANDA - DIPERTAHANKAN 100%) -->
<!-- ============================================ -->
<section id="events" class="max-w-7xl mx-auto px-6 py-20 scroll-mt-24">
    <!-- Header -->
    <div class="flex justify-between items-end mb-12">
        <div>
            <h2 class="text-3xl font-extrabold mb-2">Event Terdekat</h2>
            <p class="text-slate-500 font-medium">Jangan sampai ketinggalan acara seru minggu ini!</p>
        </div>
    </div>

    <!-- FILTER TABS DINAMIS -->
    <div class="mb-8 flex flex-wrap gap-4 justify-center">
        <!-- Semua Kategori -->
        <a href="{{ route('home') }}"
            class="px-6 py-2.5 rounded-xl font-bold transition-all duration-300 transform hover:scale-105 {{ !request('category') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-slate-200 text-slate-800 hover:bg-slate-300' }}">
            Semua Kategori
        </a>

        <!-- Dynamic Categories -->
        @foreach($categories as $cat)
        <a href="{{ route('home', ['category' => $cat->slug]) }}"
            class="px-6 py-2.5 rounded-xl font-bold transition-all duration-300 transform hover:scale-105 {{ request('category') == $cat->slug ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-indigo-100 text-indigo-700 hover:bg-indigo-200' }}">
            {{ $cat->name }}
        </a>
        @endforeach
    </div>

    <!-- EVENT GRID DINAMIS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($events as $event)
        <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden">
            <div class="relative overflow-hidden aspect-[3/4]">
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
                    <a href="{{ route('events.show', $event->id) }}" class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition">
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

<!-- ============================================ -->
<!-- 3. PARTNER & SPONSOR SECTION (LOGIKA ASLI ANDA - DIPERTAHANKAN 100%) -->
<!-- ============================================ -->
@if(isset($partners) && $partners->count() > 0)
@php
$originalPartners = $partners->values();
$repeatedPartners = collect();

while ($repeatedPartners->count() < 8) {
    $repeatedPartners=$repeatedPartners->concat($originalPartners);
    }

    $originalCount = $repeatedPartners->count();
    $marqueePartners = $repeatedPartners->concat($repeatedPartners);
    $totalCount = $marqueePartners->count();
    @endphp

    <section class="py-16 bg-gradient-to-b from-slate-50 to-white relative overflow-hidden border-t border-slate-100">
        <!-- Dekorasi Pola Dots -->
        <div class="absolute inset-0 opacity-[0.4]" style="background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 24px 24px;"></div>

        <div class="max-w-7xl mx-auto px-6 mb-12 text-center relative z-10">
            <h2 class="text-3xl font-black text-slate-900 mb-2">Partner & Sponsor</h2>
            <p class="text-slate-500 font-medium">Didukung oleh perusahaan dan institusi terkemuka</p>
        </div>

        <div class="slider relative z-10" style="--original-slides-count: {{ $originalCount }}; --total-slides: {{ $totalCount }};">
            <div class="slide-track">
                @foreach($marqueePartners as $partner)
                <div class="slide-item">
                    @if($partner->logo)
                    <div class="flex items-center justify-center p-4 bg-white/80 backdrop-blur-sm rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all duration-300 group w-[240px] h-[100px]">
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}"
                            class="max-h-12 w-auto object-contain opacity-70 group-hover:opacity-100 transition-all duration-300 grayscale group-hover:grayscale-0">
                    </div>
                    @else
                    <div class="flex items-center justify-center p-4 bg-white/80 backdrop-blur-sm rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all duration-300 group w-[240px] h-[100px]">
                        <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 font-bold text-sm group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-all duration-300">
                            {{ strtoupper(substr($partner->name, 0, 2)) }}
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        /* Animasi Blob untuk Hero Section */
        @keyframes blob {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        /* Animasi Slider Partner (Logika Asli Anda) */
        .slider {
            background: transparent;
            height: 140px;
            margin: auto;
            overflow: hidden;
            position: relative;
            width: 100%;
            --slide-width: 260px;
        }

        .slider::before,
        .slider::after {
            background: linear-gradient(to right, rgba(248, 250, 252, 1) 0%, rgba(248, 250, 252, 0) 100%);
            content: "";
            height: 140px;
            position: absolute;
            width: 150px;
            z-index: 2;
            pointer-events: none;
        }

        .slider::after {
            right: 0;
            top: 0;
            transform: rotateZ(180deg);
        }

        .slider::before {
            left: 0;
            top: 0;
        }

        .slide-track {
            animation: scroll 30s linear infinite;
            display: flex;
            width: calc(var(--slide-width) * var(--total-slides));
        }

        .slide-track:hover {
            animation-play-state: paused;
        }

        .slide-item {
            height: 140px;
            width: var(--slide-width);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            padding: 0 10px;
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(calc(-1 * var(--slide-width) * var(--original-slides-count)));
            }
        }
    </style>
    @endif
    @endsection