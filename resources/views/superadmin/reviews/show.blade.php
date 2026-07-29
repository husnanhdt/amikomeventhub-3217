@extends('layouts.superadmin')

@section('title', 'Detail Review')
@section('page_title', 'Detail Ulasan')
@section('page_subtitle', 'Informasi lengkap tentang review ini')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <a href="{{ route('superadmin.reviews.index') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-slate-800 mb-6">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        Kembali ke Daftar Review
    </a>

    <!-- Main Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        
        <!-- Header -->
        <div class="px-8 py-6 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-purple-50">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-2xl">{{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">{{ $review->user->name ?? 'Unknown' }}</h2>
                        <p class="text-slate-600">{{ $review->user->email ?? '-' }}</p>
                        <div class="flex items-center gap-1 mt-2">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-slate-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                </svg>
                            @endfor
                            <span class="ml-2 text-sm font-semibold text-slate-600">{{ $review->rating }} / 5</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-2">
                    @if(!$review->is_approved)
                        <form action="{{ route('superadmin.reviews.approve', $review->id) }}" method="POST">
                            @csrf
                            <button class="px-4 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">
                                Setujui
                            </button>
                        </form>
                    @else
                        <form action="{{ route('superadmin.reviews.reject', $review->id) }}" method="POST">
                            @csrf
                            <button class="px-4 py-2 bg-orange-600 text-white rounded-lg font-semibold hover:bg-orange-700">
                                Tolak
                            </button>
                        </form>
                    @endif
                    <form action="{{ route('superadmin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-4 py-2 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8">
            <!-- Review Content -->
            <div class="mb-8">
                <h3 class="font-bold text-slate-800 mb-3">Ulasan</h3>
                <div class="bg-slate-50 rounded-xl p-6">
                    <p class="text-slate-700 leading-relaxed">{{ $review->comment }}</p>
                </div>
            </div>

            <!-- Event Info -->
            <div class="mb-8">
                <h3 class="font-bold text-slate-800 mb-3">Event yang Direview</h3>
                <div class="bg-blue-50 rounded-xl p-6 flex items-center gap-4">
                    <div class="w-16 h-16 bg-blue-200 rounded-lg flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-slate-800 text-lg">{{ $review->event->title ?? '-' }}</h4>
                        <p class="text-slate-600">{{ $review->event->partner->name ?? '-' }}</p>
                        <p class="text-sm text-slate-500 mt-1">{{ $review->event->category->name ?? '-' }} • {{ $review->event->date->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Metadata -->
            <div class="grid grid-cols-2 gap-6 pt-6 border-t border-slate-200">
                <div>
                    <p class="text-sm text-slate-500 mb-1">Tanggal Review</p>
                    <p class="font-semibold text-slate-800">{{ $review->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500 mb-1">Status Moderasi</p>
                    @if($review->is_approved)
                        <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-bold">
                            ✓ Disetujui
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-bold">
                            ⏳ Menunggu Moderasi
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection