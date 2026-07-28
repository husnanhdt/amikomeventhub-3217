@extends('layouts.admin')

@section('title', 'Kelola Organizer - Admin Dashboard')
@section('page_title', 'Kelola Organizer')
@section('page_subtitle', 'Daftar semua pengguna dengan peran Organizer')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <h3 class="font-black text-xl text-slate-900">Daftar Organizer</h3>
        <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition shadow-sm">
            + Tambah Organizer
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-6 py-4">Nama Organizer</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Organisasi / Partner</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t border-slate-100">
                @forelse($organizers as $org)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <p class="font-bold text-slate-900">{{ $org->name }}</p>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $org->email }}</td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        {{ $org->partner->name ?? '-' }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase">Aktif</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.organizers.edit', $org->id) }}" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold hover:bg-indigo-100 transition">Edit</a>
                            <form action="{{ route('admin.organizers.destroy', $org->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-bold hover:bg-red-100 transition" onclick="return confirm('Yakin ingin menghapus organizer ini?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                        <p class="font-semibold mb-1">Belum ada data organizer.</p>
                        <p class="text-xs">Silakan tambahkan organizer baru melalui tombol di atas.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($organizers->hasPages())
    <div class="p-6 border-t border-slate-100">
        {{ $organizers->links() }}
    </div>
    @endif
</div>
@endsection