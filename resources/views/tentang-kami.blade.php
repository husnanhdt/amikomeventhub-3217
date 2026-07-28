@extends('layouts.app')

@section('content')

<!-- ============================================ -->
<!-- 1. HERO SECTION (Gaya Premium Dark) -->
<!-- ============================================ -->
<section class="relative min-h-[60vh] flex items-center justify-center overflow-hidden bg-slate-900">
    <!-- Abstract Background Shapes -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-600 rounded-full mix-blend-screen filter blur-[100px] opacity-40 animate-pulse"></div>
        <div class="absolute top-40 -left-20 w-72 h-72 bg-purple-600 rounded-full mix-blend-screen filter blur-[100px] opacity-40 animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%234f46e5\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
    </div>

    <div class="relative z-10 max-w-5xl mx-auto px-6 py-20 text-center">
        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-300 text-sm font-semibold mb-6 backdrop-blur-sm">
            <span class="w-2 h-2 rounded-full bg-indigo-400 animate-ping"></span>
            Tentang AmikomEventHub
        </span>
        <h1 class="text-4xl md:text-6xl font-black text-white mb-6 leading-tight">
            Revolusi Cara Anda <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400">
                Menikmati Event
            </span>
        </h1>
        <p class="text-lg text-slate-400 max-w-3xl mx-auto leading-relaxed">
            Bukan sekadar platform tiket. Kami adalah ekosistem digital yang memberdayakan mahasiswa, organisasi, dan penyelenggara profesional.
        </p>
    </div>
</section>

<!-- ============================================ -->
<!-- 2. STATISTIK (Overlapping Glassmorphism) -->
<!-- ============================================ -->
<section class="relative z-20 -mt-12 px-6">
    <div class="max-w-6xl mx-auto bg-white/80 backdrop-blur-xl border border-white/50 rounded-3xl shadow-2xl p-6 md:p-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center divide-x divide-slate-200/50">
            <div class="p-3">
                <div class="text-3xl md:text-4xl font-black text-indigo-600 mb-1">{{ $stats['events'] }}+</div>
                <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Event Aktif</div>
            </div>
            <div class="p-3">
                <div class="text-3xl md:text-4xl font-black text-purple-600 mb-1">{{ $stats['tickets'] }}+</div>
                <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tiket Terjual</div>
            </div>
            <div class="p-3">
                <div class="text-3xl md:text-4xl font-black text-pink-600 mb-1">{{ $stats['categories'] }}</div>
                <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kategori</div>
            </div>
            <div class="p-3">
                <div class="text-3xl md:text-4xl font-black text-orange-600 mb-1">{{ $stats['partners'] }}+</div>
                <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Mitra Resmi</div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- 3. VISI & MISI (Alternating Layout) -->
<!-- ============================================ -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-black text-slate-900 mb-4">Arah & Komitmen Kami</h2>
            <div class="w-20 h-1 bg-indigo-600 mx-auto rounded-full"></div>
        </div>

        <!-- Visi (Kiri Teks, Kanan Visual) -->
        <div class="flex flex-col md:flex-row items-center gap-10 mb-20">
            <div class="flex-1 space-y-4">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-900">Visi Kami</h3>
                <p class="text-slate-600 leading-relaxed">
                    Menjadi <strong class="text-indigo-600">jembatan digital utama</strong> di Indonesia yang menghubungkan penyelenggara event berkualitas dengan peserta yang antusias.
                </p>
            </div>
            <div class="flex-1 w-full">
                <div class="relative rounded-2xl overflow-hidden bg-gradient-to-br from-indigo-500 to-purple-600 p-6 text-white shadow-lg">
                    <p class="text-lg font-bold italic">"Setiap event adalah cerita, dan kami memastikan ceritanya dimulai dengan sempurna."</p>
                </div>
            </div>
        </div>

        <!-- Misi (Kiri Visual, Kanan Teks) -->
        <div class="flex flex-col md:flex-row-reverse items-center gap-10">
            <div class="flex-1 space-y-4">
                <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-purple-100 text-purple-600 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <h3 class="text-2xl font-bold text-slate-900">Misi Kami</h3>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3">
                        <span class="flex-shrink-0 w-5 h-5 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xs font-bold mt-0.5">✓</span>
                        <span class="text-slate-600 text-sm">Menyederhanakan proses manajemen event dengan teknologi yang <strong>intuitif</strong>.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="flex-shrink-0 w-5 h-5 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xs font-bold mt-0.5">✓</span>
                        <span class="text-slate-600 text-sm">Memberdayakan organisasi melalui dashboard analitik yang <strong>transparan</strong>.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="flex-shrink-0 w-5 h-5 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xs font-bold mt-0.5">✓</span>
                        <span class="text-slate-600 text-sm">Menjamin keamanan transaksi dengan standar <strong>enkripsi terbaik</strong>.</span>
                    </li>
                </ul>
            </div>
            <div class="flex-1 w-full">
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-100 text-center">
                        <div class="text-2xl mb-1">🚀</div>
                        <div class="font-bold text-slate-800 text-sm">Cepat</div>
                    </div>
                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-100 text-center">
                        <div class="text-2xl mb-1">🛡️</div>
                        <div class="font-bold text-slate-800 text-sm">Aman</div>
                    </div>
                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-100 text-center">
                        <div class="text-2xl mb-1">📱</div>
                        <div class="font-bold text-slate-800 text-sm">Responsif</div>
                    </div>
                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-100 text-center">
                        <div class="text-2xl mb-1">🤝</div>
                        <div class="font-bold text-slate-800 text-sm">Kolaboratif</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- 4. KEUNGGULAN (Bento Grid Style - COMPACT) -->
<!-- ============================================ -->
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-black text-slate-900 mb-3">Mengapa Memilih Kami?</h2>
            <p class="text-slate-500 max-w-2xl mx-auto">Standar layanan yang kami jaga untuk setiap pengguna.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Card 1: Large -->
            <div class="md:col-span-2 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-start gap-5">
                    <div class="w-14 h-14 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Keamanan Transaksi Level Bank</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Bermitra resmi dengan <strong>Midtrans</strong> dengan enkripsi standar industri tertinggi.</p>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-gradient-to-br from-indigo-600 to-purple-700 p-6 rounded-2xl shadow-lg text-white hover:-translate-y-1 transition-transform duration-300">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mb-4 backdrop-blur-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="text-lg font-bold mb-2">E-Ticket Instan</h3>
                <p class="text-indigo-100 text-xs leading-relaxed">QR Code tiket langsung terkirim ke email setelah pembayaran.</p>
            </div>

            <!-- Card 3 -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 group">
                <div class="w-10 h-10 bg-pink-50 rounded-lg flex items-center justify-center text-pink-600 mb-4 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Kurasi Ketat</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Setiap penyelenggara diverifikasi untuk memastikan event berkualitas.</p>
            </div>

            <!-- Card 4: Large -->
            <div class="md:col-span-2 bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-start gap-5">
                    <div class="w-14 h-14 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600 group-hover:scale-110 transition-transform flex-shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Dashboard Multi-Tenant</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">Dashboard analitik real-time untuk memantau penjualan dan pendapatan secara mandiri.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================ -->
<!-- 5. CTA SECTION (COMPACT - Tidak Terlalu Tinggi) -->
<!-- ============================================ -->
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-6">
        <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-indigo-600 to-purple-700 p-10 md:p-14 text-center shadow-xl">
            <!-- Decorative circles (lebih kecil) -->
            <div class="absolute top-0 left-0 w-32 h-32 bg-white/10 rounded-full -ml-10 -mt-10"></div>
            <div class="absolute bottom-0 right-0 w-40 h-40 bg-white/10 rounded-full -mr-10 -mb-10"></div>
            
            <div class="relative z-10">
                <h2 class="text-2xl md:text-4xl font-black text-white mb-4">
                    Siap Mengelola Event Besar?
                </h2>
                <p class="text-indigo-100 mb-8 max-w-xl mx-auto">
                    Bergabunglah dengan ratusan organisasi yang telah mempercayakan manajemen tiket kepada kami.
                </p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('home') }}#events" class="px-6 py-3.5 bg-white text-indigo-700 rounded-xl font-bold hover:bg-indigo-50 transition shadow-lg flex items-center justify-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Jelajahi Event
                    </a>
                    <button onclick="openRegisterModal(); selectOrganizer()" class="px-6 py-3.5 bg-indigo-800 text-white border-2 border-indigo-500 rounded-xl font-bold hover:bg-indigo-900 transition shadow-lg flex items-center justify-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Daftarkan Organisasi
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    function selectOrganizer() {
        setTimeout(() => {
            const organizerRadio = document.querySelector('input[name="account_type"][value="organizer"]');
            if (organizerRadio) {
                organizerRadio.checked = true;
                organizerRadio.dispatchEvent(new Event('change'));
            }
        }, 100);
        if (typeof openRegisterModal === 'function') {
            openRegisterModal();
        }
    }
</script>
@endpush