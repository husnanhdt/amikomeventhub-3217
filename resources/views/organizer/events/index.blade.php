@extends('layouts.organizer')

@section('page_title', 'Kelola Event')
@section('page_subtitle', 'Daftar semua event yang telah Anda buat.')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h3 class="text-lg font-bold text-slate-900">Daftar Event Saya</h3>
        <p class="text-sm text-slate-500">Total {{ $events->count() }} event terdaftar</p>
    </div>
    <a href="{{ route('organizer.events.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition flex items-center gap-2 shadow-lg shadow-indigo-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Buat Event Baru
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    @if($events->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold">
                <tr>
                    <th class="px-6 py-4">Poster</th>
                    <th class="px-6 py-4">Judul Event</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Lokasi</th>
                    <th class="px-6 py-4">Harga</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($events as $event)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        @if($event->poster_path)
                        <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}" class="w-12 h-12 rounded-lg object-cover shadow-sm">
                        @else
                        <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 font-bold text-xl">
                            {{ strtoupper(substr($event->title, 0, 1)) }}
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-semibold text-slate-900 max-w-xs truncate">{{ $event->title }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600 whitespace-nowrap">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600 max-w-xs truncate">{{ $event->location }}</td>
                    <td class="px-6 py-4 font-bold text-indigo-600 whitespace-nowrap">Rp {{ number_format($event->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('events.show', $event->id) }}" target="_blank" class="px-3 py-1.5 bg-slate-100 text-slate-700 rounded-lg text-xs font-bold hover:bg-slate-200 transition">Lihat</a>
                            {{-- Tombol Edit bisa ditambahkan nanti --}}
                            <a href="#" class="px-3 py-1.5 bg-yellow-50 text-yellow-700 rounded-lg text-xs font-bold hover:bg-yellow-100 transition">Edit</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <!-- Empty State -->
    <div class="text-center py-16 px-6">
        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </div>
        <h4 class="text-lg font-bold text-slate-900 mb-2">Belum Ada Event</h4>
        <p class="text-slate-500 mb-6 max-w-sm mx-auto">Anda belum membuat event apapun. Mulai buat event pertama Anda sekarang untuk menarik peserta!</p>
        <a href="{{ route('organizer.events.create') }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
            Buat Event Pertama
        </a>
    </div>
    @endif
</div>
@endsection