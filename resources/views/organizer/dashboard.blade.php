@extends('layouts.organizer')

@section('title', 'Dashboard Organizer - AmikomEventHub')
@section('page_title', 'Dashboard Organizer')
@section('page_subtitle', 'Kelola event dan pantau pendapatan organisasi Anda.')

@section('content')
<!-- ============================================ -->
<!-- 1. STATS GRID (Dengan Icon Berwarna) -->
<!-- ============================================ -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <!-- Total Event -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Total Event</p>
        <h3 class="text-2xl font-black">{{ $totalEvents ?? 0 }}</h3>
    </div>

    <!-- Tiket Terjual -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
            </svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Tiket Terjual</p>
        <h3 class="text-2xl font-black">{{ $totalTickets ?? 0 }}</h3>
    </div>

    <!-- Pendapatan -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Total Pendapatan</p>
        <h3 class="text-2xl font-black text-purple-600">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
    </div>

    <!-- Event Aktif -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Event Aktif</p>
        <h3 class="text-2xl font-black">{{ $activeEvents ?? 0 }} Event</h3>
    </div>
</div>

<!-- ============================================ -->
<!-- 2. BAGIAN GRAFIK -->
<!-- ============================================ -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
    <!-- Grafik 1: Penjualan Tiket (6 Bulan Terakhir) -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <h3 class="text-lg font-black text-slate-900 mb-4">Penjualan Tiket (6 Bulan Terakhir)</h3>
        <canvas id="ticketSalesChart"></canvas>
    </div>

    <!-- Grafik 2: Pendapatan per Event -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <h3 class="text-lg font-black text-slate-900 mb-4">Top 5 Event Berdasarkan Pendapatan</h3>
        <canvas id="revenueByEventChart"></canvas>
    </div>
</div>

<!-- ============================================ -->
<!-- 3. EVENT TERLARIS & TERBARU -->
<!-- ============================================ -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-8 border-b flex justify-between items-center">
        <h3 class="font-black text-xl">Event Terbaru & Performa</h3>
        <a href="{{ route('organizer.events.index') }}" class="text-indigo-600 font-bold hover:underline">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">Event</th>
                    <th class="px-8 py-4">Tanggal</th>
                    <th class="px-8 py-4">Tiket Terjual</th>
                    <th class="px-8 py-4">Pendapatan</th>
                    <th class="px-8 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($recentEvents ?? [] as $event)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-slate-200 flex-shrink-0">
                                @if($event->poster_path)
                                    <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                                        <span class="text-white font-bold text-xs">{{ strtoupper(substr($event->title, 0, 2)) }}</span>
                                    </div>
                                @endif
                            </div>
                            <p class="font-bold text-slate-900 truncate max-w-xs">{{ $event->title }}</p>
                        </div>
                    </td>
                    <td class="px-8 py-6 text-sm text-slate-600 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                    </td>
                    <td class="px-8 py-6 font-bold text-green-600">
                        {{ $event->sold_tickets ?? 0 }} Tiket
                    </td>
                    <td class="px-8 py-6 font-black text-indigo-600 whitespace-nowrap">
                        Rp {{ number_format($event->revenue ?? 0, 0, ',', '.') }}
                    </td>
                    <td class="px-8 py-6 whitespace-nowrap">
                        @if(\Carbon\Carbon::parse($event->date)->isFuture())
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase">Aktif</span>
                        @else
                            <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-bold uppercase">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-10 text-center text-slate-500">
                        Belum ada event. <a href="{{ route('organizer.events.create') }}" class="text-indigo-600 font-bold hover:underline">Buat event pertama Anda!</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ============================================ -->
<!-- 4. SCRIPT CHART.JS -->
<!-- ============================================ -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik 1: Penjualan Tiket (Line Chart)
    const ticketSalesCtx = document.getElementById('ticketSalesChart').getContext('2d');
    new Chart(ticketSalesCtx, {
        type: 'line',
        data: {
            labels: @json($ticketSalesLabels),
            datasets: [{
                label: 'Tiket Terjual',
                data: @json($ticketSalesData),
                borderColor: 'rgb(99, 102, 241)',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    // Grafik 2: Pendapatan per Event (Bar Chart)
    const revenueCtx = document.getElementById('revenueByEventChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: @json($revenueByEventLabels),
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: @json($revenueByEventData),
                backgroundColor: [
                    'rgba(99, 102, 241, 0.8)',
                    'rgba(16, 185, 129, 0.8)',
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(139, 92, 246, 0.8)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endsection