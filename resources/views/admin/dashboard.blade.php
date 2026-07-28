@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard Ringkasan')

@section('content')
<!-- ============================================ -->
<!-- 1. STATS GRID (LOGIKA ASLI ANDA - DIPERTAHANKAN) -->
<!-- ============================================ -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
            </svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Total Pendapatan</p>
        <h3 class="text-2xl font-black">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                </path>
            </svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Tiket Terjual</p>
        <h3 class="text-2xl font-black">{{ number_format($ticketsSold, 0, ',', '.') }}</h3>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Event Aktif</p>
        <h3 class="text-2xl font-black">{{ $activeEvents }} Event</h3>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <p class="text-slate-400 text-sm font-bold uppercase mb-1">Pesanan Pending</p>
        <h3 class="text-2xl font-black">{{ $pendingOrders }} Pesanan</h3>
    </div>
</div>

<!-- ============================================ -->
<!-- 2. BAGIAN GRAFIK (TAMBAHAN BARU) -->
<!-- ============================================ -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
    <!-- Grafik 1: Pertumbuhan User -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <h3 class="text-lg font-black text-slate-900 mb-4">Pertumbuhan Pengguna (6 Bulan Terakhir)</h3>
        <canvas id="userGrowthChart"></canvas>
    </div>

    <!-- Grafik 2: Pendapatan per Event -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <h3 class="text-lg font-black text-slate-900 mb-4">Top 5 Event Berdasarkan Pendapatan</h3>
        <canvas id="revenueByEventChart"></canvas>
    </div>
</div>

<!-- Grafik 3: Status Transaksi (Pie Chart) -->
<div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm mb-10">
    <h3 class="text-lg font-black text-slate-900 mb-4 text-center">Distribusi Status Transaksi</h3>
    <div class="max-w-md mx-auto">
        <canvas id="transactionStatusChart"></canvas>
    </div>
</div>

<!-- ============================================ -->
<!-- 3. LATEST SALES TABLE (LOGIKA ASLI ANDA - DIPERTAHANKAN) -->
<!-- ============================================ -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-8 border-b flex justify-between items-center">
        <h3 class="font-black text-xl">Transaksi Terakhir</h3>
        <a href="{{ route('admin.transactions.index') }}" class="text-indigo-600 font-bold hover:underline">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-1/4">Tgl Transaksi</th>
                    <th class="px-8 py-4 w-1/4">Pembeli</th>
                    <th class="px-8 py-4 w-1/4">Event</th>
                    <th class="px-8 py-4 w-[10%]">Status</th>
                    <th class="px-8 py-4 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($recentTransactions as $trx)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-8 py-6 text-sm text-slate-600 max-w-xs break-all">{{ $trx->created_at->format('d M y - H:i') }}<br><span class="text-xs text-slate-400">{{ $trx->order_id }}</span></td>
                    <td class="px-8 py-6">
                        <p class="font-bold uppercase tracking-wide text-sm truncate max-w-[150px]">{{ $trx->customer_name }}</p>
                        <p class="text-xs text-slate-400 truncate max-w-[150px]">{{ $trx->customer_email }}</p>
                    </td>
                    <td class="px-8 py-6 font-medium text-slate-600 max-w-xs truncate">{{ $trx->event->title ?? '-' }}</td>
                    <td class="px-8 py-6 whitespace-nowrap">
                        @php
                            $status = strtolower($trx->status);
                        @endphp
                        @if($status === 'settlement' || $status === 'success')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase">Success</span>
                        @elseif($status === 'pending')
                            <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-bold uppercase">Pending</span>
                        @elseif($status === 'expire' || $status === 'failed' || $status === 'cancel' || $status === 'deny')
                            <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-xs font-bold uppercase">Failed</span>
                        @else
                            <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-bold uppercase">{{ $trx->status }}</span>
                        @endif
                    </td>
                    <td class="px-8 py-6 font-black text-indigo-600 whitespace-nowrap text-right">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-10 text-center text-slate-500">Belum ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ============================================ -->
<!-- 4. SCRIPT CHART.JS (TAMBAHAN BARU) -->
<!-- ============================================ -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik 1: Pertumbuhan User (Line Chart)
    const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
    new Chart(userGrowthCtx, {
        type: 'line',
        data: {
            labels: @json($userGrowthLabels),
            datasets: [{
                label: 'Jumlah User Baru',
                data: @json($userGrowthData),
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

    // Grafik 3: Status Transaksi (Pie Chart)
    const statusCtx = document.getElementById('transactionStatusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: @json($statusLabels),
            datasets: [{
                data: @json($statusData),
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)',  // Success - Hijau
                    'rgba(245, 158, 11, 0.8)',  // Pending - Kuning
                    'rgba(239, 68, 68, 0.8)',   // Expired/Failed - Merah
                    'rgba(107, 114, 128, 0.8)'  // Lainnya - Abu-abu
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endsection