@extends('layouts.admin')

@section('title', 'Kelola Ulasan - Admin Dashboard')
@section('page_title', 'Kelola Ulasan')
@section('page_subtitle', 'Pantau dan moderasi semua ulasan dari pengguna')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
        <h3 class="font-black text-xl text-slate-900">Daftar Ulasan</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-6 py-4">Pengguna</th>
                    <th class="px-6 py-4">Event</th>
                    <th class="px-6 py-4">Rating</th>
                    <th class="px-6 py-4">Ulasan</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t border-slate-100">
                @forelse($reviews as $review)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <p class="font-bold text-slate-900">{{ $review->user->name ?? 'Unknown' }}</p>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 max-w-xs truncate">
                        {{ $review->event->title ?? 'Event Dihapus' }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex text-yellow-400 text-sm">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)★@else☆@endif
                            @endfor
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 max-w-xs">
                        {{ Str::limit($review->review, 60) }}
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-500 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-bold hover:bg-red-100 transition" onclick="return confirm('Yakin ingin menghapus ulasan ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                        <p class="font-semibold mb-1">Belum ada ulasan.</p>
                        <p class="text-xs">Ulasan akan muncul di sini setelah pengguna memberikan rating.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reviews->hasPages())
    <div class="p-6 border-t border-slate-100">
        {{ $reviews->links() }}
    </div>
    @endif
</div>
@endsection