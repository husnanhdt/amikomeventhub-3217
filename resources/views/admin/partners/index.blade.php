@extends('layouts.admin')

@section('title', 'Kelola Partner - Admin')
@section('page_title', 'Kelola Partner')
@section('page_subtitle', 'Atur logo partner untuk ditampilkan di homepage.')

@section('content')
<!-- Header dengan Tombol Tambah di Kanan -->
<header class="flex justify-end items-center mb-10">
    <a href="{{ route('admin.partners.create') }}"
        class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg hover:bg-indigo-700 transition">
        + Tambah Partner
    </a>
</header>

<!-- Card Tabel -->
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">

    <!-- Search -->
    <div class="px-8 py-6 bg-slate-50/50 border-b flex flex-wrap gap-4 items-center">
        <div class="flex-1 min-w-[300px] flex gap-2">
            <form method="GET" action="{{ route('admin.partners.index') }}" class="flex-1 flex gap-2">
                <input type="text" name="search" placeholder="Cari nama partner..."
                    value="{{ request('search') }}"
                    class="flex-1 px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition uppercase text-sm font-medium tracking-wide">
                <button type="submit" class="px-4 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">Cari</button>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4 w-16">NO</th>
                    <th class="px-8 py-4 w-32">LOGO</th>
                    <th class="px-8 py-4">NAMA PARTNER</th>
                    <th class="px-8 py-4 text-right">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($partners as $index => $partner)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6 font-bold text-slate-400">
                        {{ $partners->firstItem() + $index }}
                    </td>
                    <td class="px-8 py-6">
                        @if($partner->logo)
                        <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}"
                            class="w-16 h-16 rounded-xl object-cover border-2 border-slate-100">
                        @else
                        <div class="w-16 h-16 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-xs">
                            NO IMG
                        </div>
                        @endif
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold text-slate-800">{{ $partner->name }}</p>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end gap-2">
                            <!-- Edit -->
                            <a href="{{ route('admin.partners.edit', $partner->id) }}"
                                class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <!-- Delete -->
                            <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" onsubmit="return confirm('Hapus partner {{ $partner->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-10 text-center text-slate-500">
                        Belum ada partner. Klik "Tambah Partner" untuk mulai.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-8 py-6 bg-slate-50/50 border-t flex justify-between items-center">
        <p class="text-sm text-slate-500 font-medium">
            Menampilkan {{ $partners->firstItem() ?? 0 }} - {{ $partners->lastItem() ?? 0 }} dari {{ $partners->total() }} partner
        </p>
        <div class="flex gap-2">
            {{ $partners->links() }}
        </div>
    </div>
</div>
@endsection