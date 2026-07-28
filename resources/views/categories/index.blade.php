@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">

    <!-- ============================================ -->
    <!-- 1. HEADER & SEARCH (Selalu Muncul) -->
    <!-- ============================================ -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-black text-slate-900 mb-3">Kategori Event</h1>
        <p class="text-lg text-slate-500">Temukan event sesuai minat Anda</p>
    </div>

    <!-- Search Bar -->
    <div class="max-w-2xl mx-auto mb-12">
        <form action="{{ route('categories.index') }}" method="GET" class="relative">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari kategori..."
                class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none shadow-sm">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </form>
    </div>

    <!-- ============================================ -->
    <!-- 2. KATEGORI GRID (Selalu Muncul) -->
    <!-- ============================================ -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($categories as $cat)
        <div class="bg-white rounded-2xl border border-slate-100 p-6 hover:shadow-xl hover:border-indigo-200 transition-all duration-300 group">
            <div class="flex items-start justify-between mb-4">
                <!-- Icon Kategori (Huruf Pertama) -->
                <div class="w-14 h-14 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 font-black text-2xl group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    {{ strtoupper(substr($cat->name, 0, 1)) }}
                </div>

                <!-- Badge Jumlah Event -->
                <span class="px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-bold">
                    {{ $cat->events_count }} event
                </span>
            </div>

            <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $cat->name }}</h3>
            <p class="text-slate-500 text-sm mb-4">
                {{ $cat->events_count }} event tersedia
            </p>

            <a href="{{ route('categories.show', $cat->slug) }}"
                class="inline-flex items-center gap-2 text-indigo-600 font-bold hover:text-indigo-700 transition">
                Lihat Event
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-slate-500 text-lg">Belum ada kategori</p>
        </div>
        @endforelse
    </div>

    <!-- ============================================ -->
    <!-- 3. BAGIAN EVENT (Muncul HANYA jika kategori dipilih) -->
    <!-- ============================================ -->
    @if(isset($category) && isset($events))
    <section class="mt-20 pt-16 border-t border-slate-200">
        <!-- Header Event Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-black text-slate-900 mb-2">
                    Event Kategori: <span class="text-indigo-600">{{ $category->name }}</span>
                </h2>
                <p class="text-slate-500">
                    Menampilkan {{ $events->count() }} event yang tersedia
                </p>
            </div>
            <a href="{{ route('categories.index') }}"
                class="px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-bold hover:bg-slate-200 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Semua Kategori
            </a>
        </div>

        <!-- Event Grid -->
        @if($events->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
            <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                <!-- Poster Event -->
                <div class="relative aspect-[3/4] overflow-hidden bg-slate-100">
                    @if($event->poster_path)
                    <img src="{{ asset('storage/' . $event->poster_path) }}"
                        alt="{{ $event->title }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="text-6xl font-black text-slate-300">
                            {{ strtoupper(substr($event->title, 0, 1)) }}
                        </span>
                    </div>
                    @endif

                    <!-- Badge Kategori -->
                    <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600 shadow-sm">
                        {{ $event->category->name ?? 'Umum' }}
                    </div>
                </div>

                <!-- Event Info -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-slate-900 mb-2 line-clamp-2 group-hover:text-indigo-600 transition">
                        {{ $event->title }}
                    </h3>

                    <div class="flex items-center gap-2 text-slate-500 text-sm mb-3">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}</span>
                    </div>

                    <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        </svg>
                        <span class="truncate">{{ $event->location }}</span>
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                        <span class="text-xl font-black text-indigo-600">
                            Rp {{ number_format($event->price, 0, ',', '.') }}
                        </span>
                        <a href="{{ route('events.show', $event->id) }}"
                            class="px-5 py-2 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition text-sm">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-16 bg-slate-50 rounded-2xl border border-slate-100 border-dashed">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Belum Ada Event</h3>
            <p class="text-slate-500 mb-6">Kategori ini belum memiliki event yang tersedia saat ini.</p>
            <a href="{{ route('categories.index') }}"
                class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                Lihat Kategori Lain
            </a>
        </div>
        @endif
    </section>
    @endif

</div>
@endsection