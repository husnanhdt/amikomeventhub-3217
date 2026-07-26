@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-3xl shadow-lg p-8 mb-6">
            <h1 class="text-3xl font-bold text-slate-900 mb-2">Beri Penilaian & Review</h1>
            <p class="text-slate-600">Bagikan pengalaman Anda mengikuti acara ini</p>
        </div>

        <!-- Event Info (SANGAT PENTING untuk UX) -->
        <div class="bg-white rounded-3xl shadow-lg p-6 mb-6">
            <div class="flex gap-4">
                <!-- PERBAIKAN: Gunakan poster_url sesuai accessor di Model Event kamu -->
                <img src="{{ $event->poster_url }}" 
                     alt="{{ $event->title }}"
                     class="w-32 h-32 object-cover rounded-2xl border border-slate-100">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 mb-2">{{ $event->title }}</h2>
                    <p class="text-slate-600 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($event->date)->format('d F Y') }}
                    </p>
                    <p class="text-slate-600 text-sm flex items-center gap-2 mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $event->location }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Review -->
        <div class="bg-white rounded-3xl shadow-lg p-8">
            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('reviews.store', $event) }}" method="POST">
                @csrf

                <!-- Rating Stars -->
                <div class="mb-8">
                    <label class="block text-sm font-semibold text-slate-700 mb-4">
                        Bagaimana pengalaman Anda? *
                    </label>
                    <div class="flex gap-2" id="starRating">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" data-rating="{{ $i }}"
                                class="star-btn text-4xl text-slate-300 hover:text-yellow-400 transition focus:outline-none">
                                ★
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" required>
                    <p class="text-sm text-slate-500 mt-2" id="ratingText"></p>
                </div>

                <!-- Review Text -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Ulasan (Opsional)
                    </label>
                    <textarea name="review" rows="5"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none resize-none"
                        placeholder="Ceritakan pengalaman Anda mengikuti acara ini..."></textarea>
                    <p class="text-xs text-slate-500 mt-1">Maksimal 1000 karakter</p>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-4">
                    <a href="{{ route('events.show', $event) }}"
                        class="px-6 py-3 border-2 border-slate-200 rounded-xl font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                        Kirim Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Star Rating Interaction (Versi Premium dengan Hover Effect)
    const starBtns = document.querySelectorAll('.star-btn');
    const ratingInput = document.getElementById('ratingInput');
    const ratingText = document.getElementById('ratingText');

    const ratingLabels = [
        '',
        'Sangat Buruk',
        'Buruk',
        'Cukup',
        'Bagus',
        'Sangat Bagus'
    ];

    starBtns.forEach(btn => {
        // Saat diklik
        btn.addEventListener('click', function () {
            const rating = parseInt(this.dataset.rating);
            ratingInput.value = rating;

            starBtns.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-slate-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-slate-300');
                }
            });

            ratingText.textContent = ratingLabels[rating];
        });

        // Saat mouse diarahkan (Hover)
        btn.addEventListener('mouseenter', function () {
            const rating = parseInt(this.dataset.rating);
            starBtns.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                }
            });
        });

        // Saat mouse dijauhkan (Kembali ke nilai yang diklik)
        btn.addEventListener('mouseleave', function () {
            const currentRating = parseInt(ratingInput.value) || 0;
            starBtns.forEach((star, index) => {
                if (index < currentRating) {
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                }
            });
        });
    });
</script>
@endsection