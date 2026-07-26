@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-3 gap-12">
    <!-- Left: Poster -->
    <div class="lg:col-span-1">
        <div class="sticky top-32">
            <img src="{{ $event->poster_url ?? asset('images/default-poster.jpg') }}"
                alt="{{ $event->title }}"
                class="w-full rounded-[2.5rem] shadow-2xl border-8 border-white">

            <!-- Organizer Info (Clickable) -->
            <a href="{{ route('organizers.show', $event->partner_id ?? 1) }}" class="block mt-8 p-6 bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-md hover:border-indigo-200 transition group">
                <h4 class="font-bold mb-4 text-slate-900">Penyelenggara</h4>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold group-hover:bg-indigo-600 group-hover:text-white transition">
                        {{ substr($event->partner->name ?? 'EO', 0, 2) }}
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 group-hover:text-indigo-600 transition">{{ $event->partner->name ?? 'Event Organizer' }}</p>
                        <p class="text-xs text-slate-500 flex items-center gap-1">
                            <svg class="w-3 h-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Verified Organizer
                        </p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Right: Details -->
    <div class="lg:col-span-2 space-y-12">
        <div class="space-y-4">
            <span class="px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">
                {{ $event->category->name ?? 'General' }}
            </span>
            <h1 class="text-4xl md:text-5xl font-black leading-tight">{{ $event->title }}</h1>

            <div class="flex flex-wrap gap-6 text-slate-500 font-medium">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($event->date)->format('l, d M Y') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>{{ $event->location }}</span>
                </div>
            </div>
        </div>

        <div class="prose prose-slate max-w-none">
            <h3 class="text-2xl font-bold mb-4">Deskripsi Event</h3>
            <p class="text-lg text-slate-600 leading-relaxed">
                {{ $event->description }}
            </p>
        </div>

        <div class="bg-indigo-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-indigo-200 relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                <div>
                    <p class="text-indigo-200 font-bold uppercase tracking-widest text-sm mb-2">Harga Tiket</p>
                    <h2 class="text-5xl font-black">Rp {{ number_format($event->price, 0, ',', '.') }}
                        <span class="text-lg font-medium text-indigo-200">/ orang</span>
                    </h2>
                    <p class="mt-4 text-indigo-100 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Sisa stok: <span class="font-bold underline">{{ $event->stock }} Tiket lagi!</span>
                    </p>
                </div>
                <div>
                    <a href="{{ route('checkout', $event->id) }}"
                        class="inline-block px-10 py-5 bg-white text-indigo-600 rounded-2xl font-black text-xl hover:scale-105 transition-transform shadow-xl">
                        Pesan Sekarang
                    </a>
                </div>
            </div>
            <!-- Decoration -->
            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>
            <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-400 opacity-20 rounded-full"></div>
        </div>

        <div class="space-y-4">
            <h3 class="text-xl font-bold">Kebijakan Tiket</h3>
            <ul class="space-y-3 text-slate-500">
                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    E-Ticket akan dikirimkan otomatis setelah pembayaran berhasil.
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Tiket dapat discan di pintu masuk (Check-in).
                </li>
                <li class="flex items-start gap-2 text-rose-500">
                    <svg class="w-5 h-5 text-rose-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Tiket yang sudah dibeli tidak dapat direfund.
                </li>
            </ul>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- Section Review & Rating (FULL WIDTH) -->
    <!-- ========================================== -->
    <div class="lg:col-span-3 mt-12">
        <div class="bg-white rounded-3xl shadow-lg p-8 border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-slate-900">Ulasan & Penilaian</h2>

                @auth
                @if(method_exists($event, 'canBeReviewed') && $event->canBeReviewed() && !Auth::user()->hasReviewedEvent($event->id))
                <a href="{{ route('reviews.create', $event) }}"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                    Tulis Review
                </a>
                @elseif(method_exists(Auth::user(), 'hasReviewedEvent') && Auth::user()->hasReviewedEvent($event->id))
                <span class="px-6 py-3 bg-green-100 text-green-700 rounded-xl font-semibold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Sudah Mereview
                </span>
                @else
                <span class="px-6 py-3 bg-slate-100 text-slate-500 rounded-xl font-semibold text-sm">
                    Review tersedia 1 hari setelah acara
                </span>
                @endif
                @else
                <a href="{{ route('user.login') }}"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                    Login untuk Review
                </a>
                @endauth
            </div>

            <!-- Rating Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="text-center p-6 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl text-white">
                    <div class="text-5xl font-bold mb-2">
                        {{ number_format($event->average_rating ?? 0, 1) }}
                    </div>
                    <div class="text-yellow-300 text-2xl mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <=round($event->average_rating ?? 0))
                            ★
                            @else
                            ☆
                            @endif
                            @endfor
                    </div>
                    <div class="text-indigo-100">{{ $event->total_reviews ?? 0 }} Ulasan</div>
                </div>

                <div class="md:col-span-2 space-y-2">
                    @for($i = 5; $i >= 1; $i--)
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-semibold w-8">{{ $i }} ★</span>
                        <div class="flex-1 bg-slate-200 rounded-full h-3 overflow-hidden">
                            @php
                            $total = $event->total_reviews ?? 0;
                            $count = method_exists($event, 'reviews') ? $event->reviews()->where('rating', $i)->count() : 0;
                            $percentage = $total > 0 ? ($count / $total) * 100 : 0;
                            @endphp
                            <div class="bg-yellow-400 h-full rounded-full"
                                style="width: {{ $percentage }}%"></div>
                        </div>
                        <span class="text-sm text-slate-600 w-12">{{ $count }}</span>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Reviews List -->
            <div class="space-y-6">
                @if(method_exists($event, 'reviews'))
                @forelse($event->reviews()->with('user')->latest()->limit(5)->get() as $review)
                <div class="border-b border-slate-100 pb-6 last:border-0">
                    <div class="flex items-start gap-4">
                        @php
                        $userAvatar = $review->user->avatar ?? null;
                        $avatarUrl = $userAvatar ? (str_starts_with($userAvatar, 'http') ? $userAvatar : asset('storage/' . $userAvatar)) : 'https://ui-avatars.com/api/?name='.urlencode($review->user->name).'&background=6366f1&color=fff';
                        @endphp
                        <img src="{{ $avatarUrl }}"
                            alt="{{ $review->user->name }}"
                            class="w-12 h-12 rounded-full object-cover border-2 border-indigo-100">
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-bold text-slate-900">{{ $review->user->name }}</h4>
                                    <div class="text-yellow-400 text-sm">
                                        @for($j = 1; $j <= 5; $j++)
                                            @if($j <=$review->rating)★@else☆@endif
                                            @endfor
                                    </div>
                                </div>
                                <span class="text-sm text-slate-500">
                                    {{ $review->review_date ? \Carbon\Carbon::parse($review->review_date)->diffForHumans() : 'Baru saja' }}
                                </span>
                            </div>
                            @if($review->review)
                            <p class="text-slate-600 mt-2 leading-relaxed">{{ $review->review }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-12 text-slate-500 bg-slate-50 rounded-2xl">
                    <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <p class="text-lg font-semibold mb-2">Belum ada ulasan</p>
                    <p class="text-sm">Jadilah yang pertama memberikan ulasan untuk acara ini!</p>
                </div>
                @endforelse
                @else
                <div class="text-center py-12 text-slate-500">
                    <p class="text-sm">Fitur ulasan sedang dalam pengembangan.</p>
                </div>
                @endif
            </div>

            @if(method_exists($event, 'reviews') && ($event->total_reviews ?? 0) > 5)
            <div class="text-center mt-8">
                <a href="{{ route('reviews.index', $event) }}"
                    class="inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-indigo-800 transition">
                    Lihat Semua {{ $event->total_reviews }} Ulasan
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
            @endif
        </div>
    </div>
</main>
@endsection