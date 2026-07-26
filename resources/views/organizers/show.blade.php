@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">

    <!-- Header Profil Penyelenggara -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-3xl p-8 md:p-12 text-white shadow-xl mb-8 relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
            <!-- Logo / Avatar -->
            <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center text-indigo-700 font-black text-4xl shadow-lg border-4 border-indigo-200">
                {{ substr($partner->name, 0, 2) }}
            </div>

            <!-- Info -->
            <div class="text-center md:text-left flex-1">
                <h1 class="text-3xl md:text-4xl font-black mb-2">{{ $partner->name }}</h1>
                <p class="text-indigo-100 mb-4">Penyelenggara Event Terverifikasi</p>

                <!-- Rating Summary -->
                <div class="flex items-center justify-center md:justify-start gap-4 bg-white/10 backdrop-blur-sm rounded-2xl p-4 inline-flex">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-300">{{ number_format($averageRating, 1) }}</div>
                        <div class="text-yellow-300 text-sm">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <=round($averageRating))★@else☆@endif
                                @endfor
                                </div>
                        </div>
                        <div class="w-px h-10 bg-white/20"></div>
                        <div class="text-left">
                            <div class="font-bold text-lg">{{ $totalReviews }}</div>
                            <div class="text-indigo-100 text-sm">Total Ulasan</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Decoration -->
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-white opacity-5 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Kolom Kiri: Daftar Event Penyelenggara -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-lg p-6 border border-slate-100 sticky top-32">
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Event Lainnya</h3>
                    <div class="space-y-4">
                        @forelse($events->take(5) as $event)
                        <a href="{{ route('events.show', $event) }}" class="flex gap-3 group hover:bg-slate-50 p-2 rounded-xl transition">
                            <div class="w-16 h-16 bg-indigo-100 rounded-lg flex-shrink-0 flex items-center justify-center text-indigo-600 font-bold text-xs">
                                EVENT
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800 group-hover:text-indigo-600 transition line-clamp-2">{{ $event->title }}</p>
                                <p class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
                            </div>
                        </a>
                        @empty
                        <p class="text-sm text-slate-500">Belum ada event yang diselenggarakan.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Daftar Ulasan & Review -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-lg p-8 border border-slate-100">
                    <h3 class="text-2xl font-bold text-slate-900 mb-6">Rekam Jejak Ulasan</h3>

                    <div class="space-y-6">
                        @forelse($allReviews as $review)
                        <div class="border-b border-slate-100 pb-6 last:border-0 last:pb-0">
                            <div class="flex items-start gap-4">
                                @php
                                $userAvatar = $review->user->avatar ?? null;
                                $avatarUrl = $userAvatar ? (str_starts_with($userAvatar, 'http') ? $userAvatar : asset('storage/' . $userAvatar)) : 'https://ui-avatars.com/api/?name='.urlencode($review->user->name).'&background=6366f1&color=fff';
                                @endphp

                                <img src="{{ $avatarUrl }}" alt="{{ $review->user->name }}" class="w-12 h-12 rounded-full object-cover border-2 border-indigo-100">

                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h4 class="font-bold text-slate-900">{{ $review->user->name }}</h4>
                                            <p class="text-xs text-indigo-600 font-medium mb-1">Menghadiri: {{ $review->event->title }}</p>
                                            <div class="text-yellow-400 text-sm">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <=$review->rating)★@else☆@endif
                                                    @endfor
                                            </div>
                                        </div>
                                        <span class="text-xs text-slate-400">
                                            {{ \Carbon\Carbon::parse($review->review_date)->format('d M Y') }}
                                        </span>
                                    </div>

                                    @if($review->review)
                                    <p class="text-slate-600 mt-2 leading-relaxed bg-slate-50 p-4 rounded-xl">
                                        "{{ $review->review }}"
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12 text-slate-500 bg-slate-50 rounded-2xl">
                            <p class="text-lg font-semibold mb-2">Belum ada ulasan</p>
                            <p class="text-sm">Penyelenggara ini belum memiliki rekam jejak ulasan.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection