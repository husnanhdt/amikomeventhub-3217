@extends('layouts.superadmin')

@section('title', 'Dashboard Superadmin')
@section('page_title', 'Dashboard Superadmin')
@section('page_subtitle', 'Pantau seluruh aktivitas platform AmikomEventHub.')

@section('content')

<!-- 1. STATS GRID - 6 Cards dengan Trend Indicators -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-10">
    <!-- Total Users -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 rounded-3xl text-white shadow-lg shadow-blue-200 hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <span class="text-xs font-bold bg-white/20 px-2 py-1 rounded-full">+12%</span>
        </div>
        <p class="text-blue-100 text-sm font-medium mb-1">Total Pengguna</p>
        <h3 class="text-3xl font-black">{{ number_format($stats['total_users']) }}</h3>
    </div>

    <!-- Total Organizers -->
    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 p-6 rounded-3xl text-white shadow-lg shadow-indigo-200 hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <span class="text-xs font-bold bg-white/20 px-2 py-1 rounded-full">+5%</span>
        </div>
        <p class="text-indigo-100 text-sm font-medium mb-1">Total Organizer</p>
        <h3 class="text-3xl font-black">{{ number_format($stats['total_organizers']) }}</h3>
    </div>

    <!-- Pending Organizations -->
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-6 rounded-3xl text-white shadow-lg shadow-orange-200 hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            @if($stats['pending_organizers'] > 0)
            <span class="text-xs font-bold bg-white/20 px-2 py-1 rounded-full animate-pulse">Perlu Aksi</span>
            @endif
        </div>
        <p class="text-orange-100 text-sm font-medium mb-1">Menunggu Persetujuan</p>
        <h3 class="text-3xl font-black">{{ number_format($stats['pending_organizers']) }}</h3>
    </div>

    <!-- Total Events -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-6 rounded-3xl text-white shadow-lg shadow-purple-200 hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <span class="text-xs font-bold bg-white/20 px-2 py-1 rounded-full">+8%</span>
        </div>
        <p class="text-purple-100 text-sm font-medium mb-1">Total Event</p>
        <h3 class="text-3xl font-black">{{ number_format($stats['total_events']) }}</h3>
    </div>

    <!-- Total Transactions -->
    <div class="bg-gradient-to-br from-pink-500 to-pink-600 p-6 rounded-3xl text-white shadow-lg shadow-pink-200 hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <span class="text-xs font-bold bg-white/20 px-2 py-1 rounded-full">+15%</span>
        </div>
        <p class="text-pink-100 text-sm font-medium mb-1">Total Transaksi</p>
        <h3 class="text-3xl font-black">{{ number_format($stats['total_transactions'] ?? 0) }}</h3>
    </div>

    <!-- Total Revenue -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 p-6 rounded-3xl text-white shadow-lg shadow-green-200 hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-xs font-bold bg-white/20 px-2 py-1 rounded-full">+23%</span>
        </div>
        <p class="text-green-100 text-sm font-medium mb-1">Total Pendapatan</p>
        <h3 class="text-2xl font-black">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
    </div>
</div>

<!-- 2. QUICK ACTIONS PANEL -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 mb-10">
    <h3 class="font-black text-lg text-slate-900 mb-4">⚡ Aksi Cepat</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('superadmin.organizations.index') }}" class="flex items-center gap-3 p-4 bg-gradient-to-r from-orange-50 to-orange-100 rounded-2xl hover:shadow-md transition">
            <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="font-bold text-slate-800 text-sm">Setujui Organisasi</p>
                <p class="text-xs text-slate-500">{{ $stats['pending_organizers'] }} menunggu</p>
            </div>
        </a>

        <a href="{{ route('superadmin.categories.create') }}" class="flex items-center gap-3 p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl hover:shadow-md transition">
            <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </div>
            <div>
                <p class="font-bold text-slate-800 text-sm">Tambah Kategori</p>
                <p class="text-xs text-slate-500">Buat kategori baru</p>
            </div>
        </a>

        <a href="{{ route('superadmin.reviews.index') }}" class="flex items-center gap-3 p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-2xl hover:shadow-md transition">
            <div class="w-10 h-10 bg-purple-500 rounded-xl flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
            </div>
            <div>
                <p class="font-bold text-slate-800 text-sm">Moderasi Review</p>
                <p class="text-xs text-slate-500">Kelola ulasan</p>
            </div>
        </a>

        <a href="{{ route('superadmin.admins.create') }}" class="flex items-center gap-3 p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-2xl hover:shadow-md transition">
            <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            </div>
            <div>
                <p class="font-bold text-slate-800 text-sm">Tambah Admin</p>
                <p class="text-xs text-slate-500">Buat pengurus baru</p>
            </div>
        </a>
    </div>
</div>

<!-- 3. PENDING ORGANIZATIONS & RECENT EVENTS -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
    
    <!-- Pending Organizations -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-gradient-to-r from-orange-50 to-transparent">
            <div>
                <h3 class="font-black text-lg text-slate-900"> Organisasi Menunggu Persetujuan</h3>
                <p class="text-xs text-slate-500 mt-1">Tinjau dan setujui organisasi baru</p>
            </div>
            <a href="{{ route('superadmin.organizations.index') }}" class="text-indigo-600 text-sm font-bold hover:underline flex items-center gap-1">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
        <div class="p-0">
            @forelse($pendingOrganizations as $org)
            <div class="flex justify-between items-center p-4 border-b border-slate-100 last:border-0 hover:bg-slate-50 transition">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                        {{ strtoupper(substr($org->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800">{{ $org->name }}</h4>
                        <p class="text-xs text-slate-500">{{ $org->user?->name ?? 'Tanpa User' }} • {{ $org->user?->email ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <form action="{{ route('superadmin.organizations.approve', $org->id) }}" method="POST" onsubmit="return confirm('Setujui organisasi ini?')">
                        @csrf
                        <button class="px-3 py-1.5 bg-green-100 text-green-700 rounded-lg text-xs font-bold hover:bg-green-200 transition flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Setujui
                        </button>
                    </form>
                    <form action="{{ route('superadmin.organizations.reject', $org->id) }}" method="POST" onsubmit="return confirm('Tolak organisasi ini?')">
                        @csrf
                        <button class="px-3 py-1.5 bg-red-100 text-red-700 rounded-lg text-xs font-bold hover:bg-red-200 transition flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Tolak
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-slate-700 font-bold mb-1">🎉 Semua Organisasi Sudah Disetujui!</p>
                <p class="text-slate-500 text-sm">Tidak ada organisasi yang menunggu persetujuan.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Events -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-transparent">
            <h3 class="font-black text-lg text-slate-900">🎉 Event Terbaru di Platform</h3>
            <p class="text-xs text-slate-500 mt-1">Event yang baru saja dibuat</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                    <tr>
                        <th class="px-6 py-3">Event</th>
                        <th class="px-6 py-3">Organizer</th>
                        <th class="px-6 py-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentEvents as $event)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                                    {{ strtoupper(substr($event->title, 0, 1)) }}
                                </div>
                                <span class="font-medium text-slate-800 text-sm truncate max-w-[150px]">{{ $event->title }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 bg-slate-200 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-bold text-slate-600">{{ strtoupper(substr($event->partner?->user?->name ?? 'S', 0, 1)) }}</span>
                                </div>
                                <span class="text-xs text-slate-500">{{ $event->partner?->user?->name ?? 'Sistem' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap">
                            <div class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center">
                            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <p class="text-slate-700 font-bold mb-1">Belum Ada Event</p>
                            <p class="text-slate-500 text-sm">Event akan muncul di sini setelah dibuat.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 4. RECENT ACTIVITIES LOG -->
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h3 class="font-black text-lg text-slate-900">📋 Aktivitas Terbaru</h3>
            <p class="text-xs text-slate-500 mt-1">Log aktivitas sistem dalam 24 jam terakhir</p>
        </div>
        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">Live</span>
    </div>
    
    <div class="space-y-4">
        @if($stats['pending_organizers'] > 0)
        <div class="flex items-start gap-4 p-4 bg-orange-50 rounded-2xl border border-orange-100">
            <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center text-white flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="flex-1">
                <p class="font-bold text-slate-800 text-sm">Ada {{ $stats['pending_organizers'] }} organisasi menunggu persetujuan</p>
                <p class="text-xs text-slate-500 mt-1">Perlu ditinjau dan disetujui oleh superadmin</p>
                <a href="{{ route('superadmin.organizations.index') }}" class="text-orange-600 text-xs font-bold hover:underline mt-2 inline-block">Tinjau Sekarang →</a>
            </div>
        </div>
        @endif

        <div class="flex items-start gap-4 p-4 bg-blue-50 rounded-2xl border border-blue-100">
            <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center text-white flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <div class="flex-1">
                <p class="font-bold text-slate-800 text-sm">Total pendapatan platform: Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                <p class="text-xs text-slate-500 mt-1">Dari semua transaksi yang berhasil</p>
            </div>
        </div>

        <div class="flex items-start gap-4 p-4 bg-green-50 rounded-2xl border border-green-100">
            <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center text-white flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
            <div class="flex-1">
                <p class="font-bold text-slate-800 text-sm">Platform berkembang dengan baik!</p>
                <p class="text-xs text-slate-500 mt-1">{{ $stats['total_users'] }} pengguna, {{ $stats['total_organizers'] }} organizer, {{ $stats['total_events'] }} event</p>
            </div>
        </div>
    </div>
</div>

@endsection