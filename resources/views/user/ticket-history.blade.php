@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <h1 class="text-3xl font-bold mb-8">Riwayat Tiket</h1>

    @if($tickets->isEmpty())
    <div class="text-center py-12 bg-slate-50 rounded-2xl">
        <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
        </svg>
        <p class="text-lg text-slate-500">Belum ada tiket.</p>
        <a href="{{ route('home') }}" class="inline-block mt-4 px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
            Jelajahi Event
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($tickets as $ticket)
        @php
            $ticketStatus = strtolower($ticket->status ?? 'pending');
            $eventDate = \Carbon\Carbon::parse($ticket->event->date);
            
            // Jika end_date tidak ada, anggap berakhir 1 hari setelah tanggal event
            $eventEndDate = $ticket->event->end_date 
                ? \Carbon\Carbon::parse($ticket->event->end_date) 
                : $eventDate->copy()->addDay();
            
            $now = \Carbon\Carbon::now();

            // Review baru bisa dilakukan 1 hari SETELAH event berakhir
            $reviewAvailableDate = $eventEndDate->copy()->addDay();

            // Cek apakah waktu sekarang sudah melewati batas waktu review
            $canReview = $now->greaterThanOrEqualTo($reviewAvailableDate);
            $hasReviewed = $ticket->user->hasReviewedEvent($ticket->event->id);

            // Hitung sisa hari (selalu positif, dibulatkan ke atas)
            $daysUntilReview = $now->diffInDays($reviewAvailableDate);
        @endphp

        <div class="bg-white p-6 rounded-xl shadow-md border border-slate-100 hover:shadow-lg transition">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-slate-900">{{ $ticket->event->title }}</h2>
                    <p class="text-slate-500 text-sm mt-1">
                        {{ $eventDate->format('d M Y') }}
                    </p>
                </div>

                <!-- Status Badge yang Lebih Pintar -->
                @if($ticketStatus === 'used')
                    <span class="px-4 py-1.5 bg-slate-100 text-slate-700 rounded-full text-sm font-bold">
                        USED
                    </span>
                @elseif($ticketStatus === 'cancelled')
                    <span class="px-4 py-1.5 bg-red-100 text-red-700 rounded-full text-sm font-bold">
                        CANCELLED
                    </span>
                @elseif($canReview)
                    <span class="px-4 py-1.5 bg-blue-100 text-blue-700 rounded-full text-sm font-bold">
                        COMPLETED
                    </span>
                @else
                    <span class="px-4 py-1.5 bg-green-100 text-green-700 rounded-full text-sm font-bold">
                        ACTIVE
                    </span>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                <div>
                    <p class="text-sm text-slate-500 mb-1">Kode Tiket</p>
                    <p class="font-mono font-bold text-slate-900 text-sm">
                        {{ $ticket->ticket_code ?? 'N/A' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-slate-500 mb-1">Jumlah Tiket</p>
                    <p class="font-bold text-slate-900">
                        {{ $ticket->quantity ?? 1 }}
                    </p>
                </div>
            </div>

            <!-- Ticket Info -->
            <div class="mt-4 pt-4 border-t border-slate-100">
                <p class="text-xs text-slate-400">
                    Lokasi: {{ $ticket->event->location }}
                </p>
            </div>

            <!-- ========================================== -->
            <!-- TOMBOL AKSI (E-Ticket & Ulasan) -->
            <!-- ========================================== -->
            <div class="mt-6 space-y-3">

                <!-- 1. Tombol Lihat E-Ticket -->
                @if(in_array($ticketStatus, ['paid', 'success']))
                <a href="{{ route('ticket', $ticket->transaction_id) }}"
                    class="block w-full text-center px-4 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                    Lihat E-Ticket
                </a>
                @endif

                <!-- 2. Tombol Beri Ulasan -->
                @if(in_array($ticketStatus, ['paid', 'success']))
                    @if($canReview)
                        @if(!$hasReviewed)
                        <a href="{{ route('reviews.create', $ticket->event) }}"
                            class="block w-full text-center px-4 py-3 bg-yellow-500 text-white rounded-xl font-bold hover:bg-yellow-600 transition shadow-sm">
                            ★ Beri Ulasan Acara Ini
                        </a>
                        @else
                        <span class="block w-full text-center px-4 py-3 bg-green-100 text-green-700 rounded-xl font-bold">
                            ✓ Sudah Diulas
                        </span>
                        @endif
                    @else
                        <!-- Tampilan hitung mundur yang AMAN dan BULAT -->
                        <span class="block w-full text-center px-4 py-3 bg-slate-100 text-slate-500 rounded-xl text-sm font-medium">
                            @if(ceil($daysUntilReview) == 1)
                                Ulasan tersedia besok
                            @else
                                Ulasan tersedia dalam {{ ceil($daysUntilReview) }} hari
                            @endif
                        </span>
                    @endif
                @endif

            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection