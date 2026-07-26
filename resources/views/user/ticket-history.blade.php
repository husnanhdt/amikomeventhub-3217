@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <h1 class="text-2xl font-bold mb-6">Riwayat Tiket</h1>
    
    @if($tickets->isEmpty())
        <div class="text-center py-12 bg-slate-50 rounded-2xl">
            <p class="text-lg text-slate-500">Belum ada tiket.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($tickets as $ticket)
            <div class="bg-white p-6 rounded-xl shadow-md border border-slate-100">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-xl font-bold">{{ $ticket->event->title }}</h2>
                        <p class="text-slate-500 mt-1">{{ $ticket->event->date->format('d M Y') }}</p>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                        {{ $ticket->status }}
                    </span>
                </div>
                
                <div class="mt-4">
                    <p class="text-slate-500">Lokasi: <span class="font-bold">{{ $ticket->event->location }}</span></p>
                    <p class="text-slate-500">Jumlah Tiket: <span class="font-bold">{{ $ticket->quantity }}</span></p>
                </div>
                
                <!-- Tombol Ulasan -->
                @if($ticket->event->canBeReviewed() && !$ticket->user->hasReviewedEvent($ticket->event->id))
                    <a href="{{ route('reviews.create', $ticket->event) }}" 
                       class="mt-4 inline-block w-full bg-indigo-600 text-white text-center px-4 py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition">
                        ★ Beri Ulasan
                    </a>
                @elseif($ticket->user->hasReviewedEvent($ticket->event->id))
                    <span class="mt-4 inline-block w-full bg-green-100 text-green-700 text-center px-4 py-2.5 rounded-lg font-bold">
                        ✓ Sudah Diulas
                    </span>
                @else
                    <span class="mt-4 inline-block w-full bg-slate-100 text-slate-500 text-center px-4 py-2.5 rounded-lg font-medium">
                        Tersedia 1 hari lagi
                    </span>
                @endif
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection