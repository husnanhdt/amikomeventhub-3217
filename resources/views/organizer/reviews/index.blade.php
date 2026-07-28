@extends('layouts.organizer')

@section('page_title', 'Ulasan Saya')
@section('page_subtitle', 'Pantau rating dan review dari peserta event Anda')

@section('content')
<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <p class="text-sm font-semibold text-slate-500 mb-2">Rating Rata-rata</p>
        <div class="flex items-baseline gap-2">
            <h3 class="text-4xl font-black text-yellow-500">{{ number_format($averageRating, 1) }}</h3>
            <span class="text-yellow-400 text-xl">★</span>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <p class="text-sm font-semibold text-slate-500 mb-2">Total Ulasan</p>
        <h3 class="text-4xl font-black text-indigo-600">{{ $totalReviews }}</h3>
    </div>
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <p class="text-sm font-semibold text-slate-500 mb-2">Distribusi Rating</p>
        <div class="space-y-1">
            @for($i = 5; $i >= 1; $i--)
            <div class="flex items-center gap-2 text-xs">
                <span class="w-3">{{ $i }}★</span>
                <div class="flex-1 bg-slate-200 rounded-full h-2">
                    <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $reviews->where('rating', $i)->count() / max($totalReviews, 1) * 100 }}%"></div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>

<!-- Daftar Ulasan -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100">
        <h3 class="text-lg font-bold text-slate-900">Semua Ulasan</h3>
    </div>

    <div class="divide-y divide-slate-100">
        @forelse($reviews as $review)
        <div class="p-6 hover:bg-slate-50 transition">
            <div class="flex items-start gap-4">
                <!-- Avatar User -->
                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold flex-shrink-0">
                    {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                </div>

                <div class="flex-1">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h4 class="font-bold text-slate-900">{{ $review->user->name }}</h4>
                            <p class="text-xs text-indigo-600 font-medium">Event: {{ $review->event->title }}</p>
                        </div>
                        <span class="text-xs text-slate-400">{{ $review->created_at->format('d M Y') }}</span>
                    </div>

                    <!-- Rating -->
                    <div class="flex items-center gap-1 mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endif
                        @endfor
                    </div>

                    <!-- Review Text -->
                    @if($review->review)
                    <p class="text-slate-600 bg-slate-50 p-4 rounded-xl">
                        "{{ $review->review }}"
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="p-12 text-center text-slate-500">
            <p class="font-semibold mb-1">Belum ada ulasan</p>
            <p class="text-sm">Ulasan akan muncul di sini setelah peserta memberikan rating.</p>
        </div>
        @endforelse
    </div>

    @if($reviews->hasPages())
    <div class="p-6 border-t border-slate-100">
        {{ $reviews->links() }}
    </div>
    @endif
</div>
@endsection