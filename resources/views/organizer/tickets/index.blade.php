@extends('layouts.organizer')

@section('page_title', 'Kelola Tiket')
@section('page_subtitle', 'Pantau stok dan daftar peserta untuk setiap event')

@section('content')
<div class="space-y-6">
    @foreach($events as $event)
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 hover:shadow-lg transition">
        <div class="flex items-start gap-6">
            <!-- Poster -->
            <div class="w-24 h-24 rounded-xl overflow-hidden flex-shrink-0 bg-slate-200">
                @if($event->poster_path)
                    <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                        <span class="text-white font-bold text-xs text-center px-1">{{ strtoupper(substr($event->title, 0, 2)) }}</span>
                    </div>
                @endif
            </div>

            <!-- Info Event -->
            <div class="flex-1">
                <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $event->title }}</h3>
                <p class="text-sm text-slate-500 mb-4">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} • {{ $event->location }}</p>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div class="bg-indigo-50 rounded-xl p-3 text-center">
                        <p class="text-xs text-indigo-600 font-bold uppercase mb-1">Stok Awal</p>
                        <p class="text-2xl font-black text-indigo-700">{{ $event->original_stock }}</p>
                    </div>
                    <div class="bg-green-50 rounded-xl p-3 text-center">
                        <p class="text-xs text-green-600 font-bold uppercase mb-1">Terjual</p>
                        <p class="text-2xl font-black text-green-700">{{ $event->sold_tickets }}</p>
                    </div>
                    <div class="bg-orange-50 rounded-xl p-3 text-center">
                        <p class="text-xs text-orange-600 font-bold uppercase mb-1">Sisa</p>
                        <p class="text-2xl font-black text-orange-700">{{ $event->remaining_stock }}</p>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="flex gap-3">
                    <a href="{{ route('organizer.tickets.show', $event->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition">
                        Lihat Peserta
                    </a>
                    <button class="px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-bold text-sm hover:bg-slate-200 transition">
                        Export Excel
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @if($events->hasPages())
    <div class="mt-6">
        {{ $events->links() }}
    </div>
    @endif
</div>
@endsection