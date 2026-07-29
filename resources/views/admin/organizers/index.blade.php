@extends('layouts.admin')

@section('title', 'Kelola Organizer')
@section('page_title', 'Kelola Organizer')
@section('page_subtitle', 'Daftar semua pengguna dengan peran Organizer')

@section('content')

@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-xl mb-6">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
        <h3 class="font-bold text-slate-800 text-lg">Daftar Organizer</h3>
        <a href="{{ route('admin.organizers.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Organizer
        </a>
    </div>

    <!-- Search -->
    <div class="px-6 py-4 border-b border-slate-100">
        <form method="GET" action="{{ route('admin.organizers.index') }}" class="flex gap-3 max-w-2xl">
            <div class="flex-1">
                <input type="text" name="search" placeholder="Cari nama atau email..."
                    value="{{ request('search') }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Cari
            </button>

            @if(request('search'))
            <a href="{{ route('admin.organizers.index') }}" class="px-4 py-2.5 bg-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-300 transition">
                Reset
            </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-bold">
                <tr>
                    <th class="px-6 py-3">Nama Organizer</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Organisasi / Partner</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($organizers as $organizer)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                <span class="text-indigo-600 font-bold">{{ strtoupper(substr($organizer->name, 0, 1)) }}</span>
                            </div>
                            <span class="font-semibold text-slate-800">{{ $organizer->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $organizer->email }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        {{ $organizer->partner->name ?? '-' }}
                    </td>
                    <td class="px-6 py-4">
                        @if($organizer->partner && $organizer->partner->status === 'approved')
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">AKTIF</span>
                        @else
                        <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold">PENDING</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.organizers.edit', $organizer->id) }}"
                                class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold hover:bg-blue-200">
                                Edit
                            </a>
                            <form action="{{ route('admin.organizers.destroy', $organizer->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus organizer ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-semibold hover:bg-red-200">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                        Belum ada organizer
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
        {{ $organizers->links() }}
    </div>
</div>

@endsection