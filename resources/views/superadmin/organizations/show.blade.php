@extends('layouts.superadmin')

@section('title', 'Detail Organisasi')
@section('page_title', $partner->name)
@section('page_subtitle', 'Detail informasi dan statistik organisasi')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Info Organisasi -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-start justify-between mb-6">
            <div class="flex items-center gap-4">
                @if($partner->logo)
                <img src="{{ $partner->logo }}" alt="{{ $partner->name }}" class="w-20 h-20 rounded-xl object-cover">
                @else
                <div class="w-20 h-20 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <span class="text-indigo-600 font-bold text-3xl">{{ strtoupper(substr($partner->name, 0, 1)) }}</span>
                </div>
                @endif
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">{{ $partner->name }}</h2>
                    <div class="flex items-center gap-2 mt-1">
                        @if($partner->status === 'approved')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Aktif</span>
                        @elseif($partner->status === 'pending')
                            <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold">Menunggu Persetujuan</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">Ditolak</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                @if($partner->status === 'pending')
                    <form action="{{ route('superadmin.organizations.approve', $partner->id) }}" method="POST">
                        @csrf
                        <button class="px-4 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">
                            Setujui
                        </button>
                    </form>
                    <form action="{{ route('superadmin.organizations.reject', $partner->id) }}" method="POST">
                        @csrf
                        <button class="px-4 py-2 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700">
                            Tolak
                        </button>
                    </form>
                @endif
                <a href="{{ route('superadmin.organizations.edit', $partner->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700">
                    Edit
                </a>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <p class="text-sm text-slate-500 mb-1">Deskripsi</p>
                <p class="text-slate-800">{{ $partner->description ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-slate-500 mb-1">Tanggal Bergabung</p>
                <p class="text-slate-800">{{ $partner->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <div class="border-t pt-6">
            <h3 class="font-bold text-slate-800 mb-4">Informasi Pemilik</h3>
            @if($partner->user)
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-slate-500 mb-1">Nama Lengkap</p>
                    <p class="text-slate-800 font-medium">{{ $partner->user->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500 mb-1">Email</p>
                    <p class="text-slate-800 font-medium">{{ $partner->user->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500 mb-1">Jenis Kelamin</p>
                    <p class="text-slate-800">{{ $partner->user->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500 mb-1">Tanggal Lahir</p>
                    <p class="text-slate-800">{{ $partner->user->birth_date ? \Carbon\Carbon::parse($partner->user->birth_date)->format('d M Y') : '-' }}</p>
                </div>
            </div>
            @else
            <p class="text-slate-500">Tidak ada data pemilik</p>
            @endif
        </div>
    </div>

    <!-- Statistik -->
    <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="font-bold text-slate-800 mb-4">Statistik</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl">
                    <span class="text-sm text-slate-600">Total Event</span>
                    <span class="text-2xl font-bold text-blue-600">{{ $stats['total_events'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-xl">
                    <span class="text-sm text-slate-600">Tiket Terjual</span>
                    <span class="text-2xl font-bold text-green-600">{{ $stats['total_tickets_sold'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-indigo-50 rounded-xl">
                    <span class="text-sm text-slate-600">Total Pendapatan</span>
                    <span class="text-lg font-bold text-indigo-600">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Event -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100">
        <h3 class="font-bold text-slate-800">Daftar Event</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-bold">
                <tr>
                    <th class="px-6 py-3">Nama Event</th>
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Harga</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($partner->events as $event)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 font-medium text-slate-800">{{ $event->title }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-slate-100 rounded text-xs">{{ $event->category->name ?? '-' }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-500">{{ $event->date->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-{{ $event->status == 'active' ? 'green' : 'gray' }}-100 text-{{ $event->status == 'active' ? 'green' : 'gray' }}-700 rounded text-xs">
                            {{ ucfirst($event->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-semibold text-slate-800">Rp {{ number_format($event->price, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                        Belum ada event
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection