@extends('layouts.organizer')

@section('page_title', 'Statistik Event')
@section('page_subtitle', 'Analitik dan performa event Anda')

@section('content')
<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <p class="text-sm font-semibold text-slate-500 mb-2">Total Event</p>
        <h3 class="text-4xl font-black text-indigo-600">{{ $totalEvents }}</h3>
    </div>
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <p class="text-sm font-semibold text-slate-500 mb-2">Total Tiket Terjual</p>
        <h3 class="text-4xl font-black text-green-600">{{ $totalTickets }}</h3>
    </div>
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <p class="text-sm font-semibold text-slate-500 mb-2">Total Pendapatan</p>
        <h3 class="text-4xl font-black text-purple-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
    </div>
</div>

<!-- Daftar Event dengan Statistik -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100">
        <h3 class="text-lg font-bold text-slate-900">Performa per Event</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold">
                <tr>
                    <th class="px-6 py-4">Event</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Tiket Terjual</th>
                    <th class="px-6 py-4">Pendapatan</th>
                    <th class="px-6 py-4">Progress</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($events as $event)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg overflow-hidden bg-slate-200 flex-shrink-0">
                                @if($event->poster_path)
                                <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                                    <span class="text-white font-bold text-xs">{{ strtoupper(substr($event->title, 0, 2)) }}</span>
                                </div>
                                @endif
                            </div>
                            <p class="font-bold text-slate-900 max-w-xs truncate">{{ $event->title }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 whitespace-nowrap">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</td>
                    <td class="px-6 py-4 font-bold text-green-600">{{ $event->ticket_sold }} tiket</td>
                    <td class="px-6 py-4 font-bold text-indigo-600">Rp {{ number_format($event->revenue ?? 0, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @php
                        $soldPct = min(($event->ticket_sold / max($event->stock, 1)) * 100, 100);
                        @endphp
                        <div class="w-32 bg-slate-200 rounded-full h-2">
                            {{-- pakai data-width, BUKAN style --}}
                            <div class="bg-indigo-600 h-2 rounded-full progress-bar" data-width="{{ $soldPct }}"></div>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">{{ number_format($soldPct, 0) }}% terjual</p>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                        Belum ada data event.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    document.querySelectorAll('.progress-bar').forEach(function (el) {
        el.style.width = (el.dataset.width || 0) + '%';
    });
</script>
@endsection
@endsection