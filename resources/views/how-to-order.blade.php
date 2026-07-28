@extends('layouts.app')

@section('title', 'Cara Pesan & Bayar')
@section('content')

<div class="min-h-screen bg-gradient-to-b from-slate-50 to-indigo-50/30 py-16">
    <div class="max-w-6xl mx-auto px-6">
        
        <!-- Header dengan Badge -->
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider mb-4">
                Panduan Pengguna
            </span>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-4">
                Cara Pesan & <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Bayar</span>
            </h1>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Hanya 4 langkah mudah untuk mengamankan tiket event impianmu di AmikomEventHub.
            </p>
        </div>

        <!-- 4 Steps (Desain Premium dengan Dekorasi) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-24">
            <!-- Step 1 -->
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-indigo-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-indigo-100"></div>
                <div class="absolute -top-3 -left-3 w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center font-bold text-lg shadow-lg shadow-indigo-200 z-10">
                    1
                </div>
                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Jelajahi Event</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Temukan berbagai event menarik berdasarkan kategori, tanggal, atau lokasi favoritmu.</p>
            </div>

            <!-- Step 2 -->
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-purple-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-purple-100"></div>
                <div class="absolute -top-3 -left-3 w-10 h-10 bg-purple-600 text-white rounded-xl flex items-center justify-center font-bold text-lg shadow-lg shadow-purple-200 z-10">
                    2
                </div>
                <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Pilih & Checkout</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Klik "Lihat Detail", pilih jumlah tiket, dan lengkapi data diri di halaman checkout.</p>
            </div>

            <!-- Step 3 -->
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-pink-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-pink-100"></div>
                <div class="absolute -top-3 -left-3 w-10 h-10 bg-pink-600 text-white rounded-xl flex items-center justify-center font-bold text-lg shadow-lg shadow-pink-200 z-10">
                    3
                </div>
                <div class="w-14 h-14 bg-pink-50 text-pink-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Pembayaran Aman</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Selesaikan pembayaran dengan aman via GoPay, QRIS, Virtual Account, atau Kartu Kredit.</p>
            </div>

            <!-- Step 4 -->
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-24 h-24 bg-green-50 rounded-bl-full -mr-4 -mt-4 transition group-hover:bg-green-100"></div>
                <div class="absolute -top-3 -left-3 w-10 h-10 bg-green-600 text-white rounded-xl flex items-center justify-center font-bold text-lg shadow-lg shadow-green-200 z-10">
                    4
                </div>
                <div class="w-14 h-14 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-3">Terima E-Ticket</h3>
                <p class="text-slate-600 text-sm leading-relaxed">E-Ticket & QR Code akan dikirim ke emailmu. Tunjukkan saat check-in di lokasi event.</p>
            </div>
        </div>

        <!-- FAQ Section (Desain Lebih Clean & Modern) -->
        <div class="max-w-3xl mx-auto mb-20">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-black text-slate-900 mb-3">Pertanyaan Umum</h2>
                <p class="text-slate-500">Temukan jawaban atas pertanyaan yang sering ditanyakan.</p>
            </div>

            <div class="space-y-3">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:border-indigo-300 transition-colors duration-300">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center group" onclick="toggleFaq(this)">
                        <span class="font-bold text-slate-800 group-hover:text-indigo-700 transition">Metode pembayaran apa saja yang tersedia?</span>
                        <svg class="w-5 h-5 text-slate-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-5 text-slate-600 text-sm leading-relaxed border-t border-slate-100 pt-4">
                        Kami menerima pembayaran via GoPay, QRIS, Virtual Account (BCA, BNI, BRI, Mandiri), dan Kartu Kredit/Debit melalui gateway Midtrans yang terenkripsi.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:border-indigo-300 transition-colors duration-300">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center group" onclick="toggleFaq(this)">
                        <span class="font-bold text-slate-800 group-hover:text-indigo-700 transition">Apakah tiket bisa direfund?</span>
                        <svg class="w-5 h-5 text-slate-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-5 text-slate-600 text-sm leading-relaxed border-t border-slate-100 pt-4">
                        Tiket yang sudah dibeli tidak dapat direfund (dikembalikan). Namun, tiket dapat dipindahtangankan ke orang lain dengan menunjukkan E-Ticket/QR Code yang sama.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:border-indigo-300 transition-colors duration-300">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center group" onclick="toggleFaq(this)">
                        <span class="font-bold text-slate-800 group-hover:text-indigo-700 transition">Bagaimana jika saya tidak menerima E-Ticket?</span>
                        <svg class="w-5 h-5 text-slate-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-5 text-slate-600 text-sm leading-relaxed border-t border-slate-100 pt-4">
                        Silakan cek folder Spam atau Promotions di email Anda. Jika masih tidak ditemukan dalam 15 menit, segera hubungi kami di support@amikom.ac.id.
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:border-indigo-300 transition-colors duration-300">
                    <button class="w-full px-6 py-5 text-left flex justify-between items-center group" onclick="toggleFaq(this)">
                        <span class="font-bold text-slate-800 group-hover:text-indigo-700 transition">Apakah perlu akun untuk membeli tiket?</span>
                        <svg class="w-5 h-5 text-slate-400 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-5 text-slate-600 text-sm leading-relaxed border-t border-slate-100 pt-4">
                        Ya, Anda perlu login atau mendaftar akun terlebih dahulu untuk melakukan checkout. Proses registrasi gratis dan hanya membutuhkan waktu 1 menit.
                    </div>
                </div>
            </div>
        </div>

        <!-- ✅ CTA Section (DIPERBAIKI SPACING - Diberi mb-32 agar tidak terlalu dekat footer) -->
        <div class="max-w-4xl mx-auto mb-32">
            <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-3xl p-10 md:p-14 text-center text-white shadow-2xl shadow-indigo-200 relative overflow-hidden">
                <!-- Decorative Circles -->
                <div class="absolute top-0 left-0 w-32 h-32 bg-white/10 rounded-full -ml-10 -mt-10"></div>
                <div class="absolute bottom-0 right-0 w-40 h-40 bg-white/10 rounded-full -mr-10 -mb-10"></div>
                
                <div class="relative z-10">
                    <h2 class="text-3xl md:text-4xl font-black mb-4">Siap Menemukan Event Seru?</h2>
                    <p class="text-indigo-100 text-lg mb-8 max-w-xl mx-auto">
                        Jangan sampai kehabisan tiket. Jelajahi ratusan event menarik dan amankan tempatmu sekarang juga!
                    </p>
                    <a href="{{ route('home') }}#events"
                        class="inline-flex items-center gap-2 px-8 py-4 bg-white text-indigo-700 rounded-2xl font-bold text-lg shadow-lg hover:bg-indigo-50 hover:scale-105 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Mulai Jelajah Event
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleFaq(button) {
        const answer = button.nextElementSibling;
        const arrow = button.querySelector('svg');

        answer.classList.toggle('hidden');
        if (answer.classList.contains('hidden')) {
            arrow.classList.remove('rotate-180');
            button.classList.remove('bg-indigo-50');
        } else {
            arrow.classList.add('rotate-180');
            button.classList.add('bg-indigo-50');
        }
    }
</script>

@endsection