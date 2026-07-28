<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AmikomEventHub - Temukan Event Seru!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900">

    <!-- Navigation -->
    <nav class="glass sticky top-8 z-40 mx-4 mt-4 px-6 py-4 rounded-2xl border border-white/20 shadow-lg flex justify-between items-center">

        <!-- Logo - Klik untuk refresh home -->
        <a href="{{ route('home') }}" class="flex items-center gap-2 hover:opacity-80 transition">
            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                AH
            </div>
            <span class="text-xl font-bold tracking-tight hidden sm:block">AmikomEventHub</span>
        </a>


        <!-- 2. BAGIAN TENGAH: Link Navigasi -->
        <div class="hidden md:flex gap-8 font-medium">
            <a href="{{ route('home') }}"
                class="transition {{ request()->routeIs('home') ? 'text-indigo-600 font-semibold' : 'hover:text-indigo-600' }}">
                {{ __('messages.explore') }}
            </a>
            <a href="{{ route('categories.index') }}"
                class="transition {{ request()->routeIs('categories.*') ? 'text-indigo-600 font-semibold' : 'hover:text-indigo-600' }}">
                {{ __('messages.categories') }}
            </a>
            <a href="{{ route('tentang-kami') }}"
                class="transition {{ request()->routeIs('tentang-kami') ? 'text-indigo-600 font-semibold' : 'hover:text-indigo-600' }}">
                Tentang Kami
            </a>
        </div>

        <!-- 3. BAGIAN KANAN: Language Switcher + Auth Buttons -->
        <div class="flex items-center gap-4">

            <!-- Language Switcher (ID / EN) -->
            <div class="flex items-center gap-1 bg-slate-100 rounded-lg p-1">
                <a href="{{ route('lang.switch', 'id') }}" class="px-3 py-1.5 text-xs font-bold rounded-md transition {{ session('locale', 'id') == 'id' ? 'bg-white shadow text-indigo-600' : 'text-slate-500 hover:text-slate-700' }}">
                    ID
                </a>
                <a href="{{ route('lang.switch', 'en') }}" class="px-3 py-1.5 text-xs font-bold rounded-md transition {{ session('locale') == 'en' ? 'bg-white shadow text-indigo-600' : 'text-slate-500 hover:text-slate-700' }}">
                    EN
                </a>
            </div>

            <!-- Divider Vertikal -->
            <div class="h-8 w-px bg-slate-300 hidden sm:block"></div>

            @auth
            <!-- User Sudah Login -->
            <div class="flex items-center gap-4">

                <!-- Menu Khusus Organizer -->
                @if(auth()->user()->role === 'organizer' || auth()->user()->role === 'admin')
                <a href="{{ route('organizer.dashboard') }}"
                    class="flex items-center gap-2 text-sm font-medium text-slate-700 hover:text-indigo-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="hidden sm:block">Dashboard Organizer</span>
                </a>
                @endif

                <!-- Link Transaksi (untuk semua user) -->
                <a href="{{ route('transaction.history') }}" class="flex items-center gap-2 text-sm font-medium text-slate-700 hover:text-indigo-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span class="hidden sm:block">Transaksi</span>
                </a>

                <!-- Link Tiket (untuk semua user) -->
                <a href="{{ route('ticket.history') }}" class="flex items-center gap-2 text-sm font-medium text-slate-700 hover:text-indigo-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                    <span class="hidden sm:block">Tiket</span>
                </a>

                <!-- Divider -->
                <div class="h-8 w-px bg-slate-300 hidden sm:block"></div>

                <!-- Dropdown Profil -->
                <div class="relative">
                    <button id="profileMenuButton" class="flex items-center gap-2 hover:bg-slate-100 rounded-xl p-1 pr-3 transition group" onclick="toggleProfileMenu()">
                        @php
                        $avatarUrl = auth()->user()->avatar;
                        $displayAvatar = $avatarUrl ? (str_starts_with($avatarUrl, 'http') ? $avatarUrl : asset('storage/' . $avatarUrl)) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=6366f1&color=fff';
                        @endphp
                        <img src="{{ $displayAvatar }}" class="w-9 h-9 rounded-full border-2 border-indigo-100 object-cover group-hover:scale-105 transition">
                        <span class="font-semibold text-sm hidden lg:block text-slate-700">{{ auth()->user()->name }}</span>
                    </button>

                    <!-- Dropdown Menu Profil -->
                    <div id="profileMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 z-50 hidden border border-slate-100" role="menu">
                        <a href="javascript:void(0)" onclick="openProfileModal(); closeProfileMenu();" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100" role="menuitem">Ubah Profil</a>
                        <a href="javascript:void(0)" onclick="openPasswordModal(); closeProfileMenu();" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100" role="menuitem">Ubah Kata Sandi</a>
                        <form action="{{ route('logout') }}" method="POST" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50" role="menuitem">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
            @else
            <!-- User Belum Login -->
            <div class="flex items-center gap-3">
                <button onclick="openLoginModal()" class="px-5 py-2.5 rounded-xl font-semibold hover:bg-slate-200 transition cursor-pointer">
                    {{ __('messages.login') }}
                </button>
                <button onclick="openRegisterModal()" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition cursor-pointer">
                    {{ __('messages.register') }}
                </button>
            </div>
            @endauth

        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="bg-indigo-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">

                <!-- Brand Section -->
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">
                            AH
                        </div>
                        <h3 class="text-xl font-bold">AmikomEventHub</h3>
                    </div>
                    <p class="text-indigo-200 leading-relaxed">
                        Platform reservasi tiket event online terbaik untuk mahasiswa dan penyelenggara profesional.
                    </p>
                </div>

                <!-- Navigasi Section -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider mb-6 text-indigo-200">Navigasi</h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('home') }}" class="text-indigo-200 hover:text-white transition">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('categories.index') }}" class="text-indigo-200 hover:text-white transition">
                                Kategori
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tentang-kami') }}" class="text-indigo-200 hover:text-white transition">
                                Tentang Kami
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('how-to-order') }}" class="text-indigo-200 hover:text-white transition">
                                Cara Bayar
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Kontak Section -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider mb-6 text-indigo-200">Kontak</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <a href="mailto:support@amikom.ac.id" class="text-indigo-200 hover:text-white transition">
                                support@amikom.ac.id
                            </a>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <a href="tel:+6281234567890" class="text-indigo-200 hover:text-white transition">
                                +62 812 3456 7890
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 border-t border-indigo-800 text-center">
                <p class="text-indigo-300 text-sm">
                    &copy; 2026 AmikomEventHub. Built with Laravel & Tailwind CSS.
                </p>
            </div>
        </div>
    </footer>

    <!-- ========================================== -->
    <!-- MODAL LOGIN YESPLIS STYLE -->
    <!-- ========================================== -->
    <div id="loginModal" class="fixed inset-0 z-50 hidden">
        <!-- Backdrop Gelap & Blur -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeLoginModal()"></div>

        <!-- Modal Content -->
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md relative z-10 transform transition-all scale-100">

                <!-- Close Button -->
                <button onclick="closeLoginModal()" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 transition">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Modal Body -->
                <div class="p-8">
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-black text-2xl mx-auto mb-4">AH</div>
                        <h2 class="text-2xl font-bold text-slate-900 mb-2">{{ __('messages.welcome') }}</h2>
                        <p class="text-slate-500 text-sm">{{ __('messages.subtitle') }}</p>
                    </div>

                    @if(session('error'))
                    <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6 text-sm font-bold">{{ session('error') }}</div>
                    @endif

                    <!-- Login Options -->
                    <div class="space-y-3">
                        <!-- Google Login -->
                        <a href="{{ route('auth.google.redirect') }}" class="w-full flex items-center justify-center gap-3 px-6 py-4 border-2 border-slate-200 rounded-2xl font-semibold hover:bg-slate-50 transition group">
                            <img src="https://www.google.com/favicon.ico" class="w-5 h-5">
                            <span class="text-slate-700 group-hover:text-slate-900">{{ __('messages.continue_google') }}</span>
                        </a>

                        <!-- Email Login -->
                        <button onclick="showEmailLogin()" class="w-full flex items-center justify-center gap-3 px-6 py-4 border-2 border-slate-200 rounded-2xl font-semibold hover:bg-slate-50 transition group">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-slate-700 group-hover:text-slate-900">{{ __('messages.continue_email') }}</span>
                        </button>

                        <!-- Guest Login -->
                        <button class="w-full flex items-center justify-center gap-3 px-6 py-4 border-2 border-slate-200 rounded-2xl font-semibold hover:bg-slate-50 transition group">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 01-7 7h14a7 7 0 01-7-7z"></path>
                            </svg>
                            <span class="text-slate-700 group-hover:text-slate-900">{{ __('messages.continue_guest') }}</span>
                        </button>
                    </div>

                    <p class="text-center mt-6 text-sm text-slate-600">
                        {{ __('messages.no_account') }}
                        <button onclick="closeLoginModal(); openRegisterModal();" class="text-indigo-600 font-bold hover:underline">
                            {{ __('messages.register') }}
                        </button>
                    </p>

                    <p class="text-xs text-slate-400 text-center mt-6">
                        Dengan menggunakan website ini, Anda setuju dengan <a href="#" class="text-indigo-600 hover:underline">{{ __('messages.terms') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL REGISTER YESPLIS STYLE -->
    <!-- ========================================== -->
    <div id="registerModal" class="fixed inset-0 z-50 hidden">
        <!-- Backdrop Gelap & Blur -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeRegisterModal()"></div>

        <!-- Modal Content -->
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md relative z-10 transform transition-all scale-100 max-h-[90vh] overflow-y-auto">

                <!-- Header: Panah Kiri & X Close -->
                <div class="px-8 pt-6 pb-2 flex justify-between items-center">
                    <button onclick="closeRegisterModal(); openLoginModal();" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 transition">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <button onclick="closeRegisterModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 transition">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-8">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-black text-2xl mx-auto mb-3">AH</div>
                        <h2 class="text-2xl font-bold text-slate-900 mb-2">Lengkapi Profil Anda</h2>
                        <p class="text-slate-500 text-sm">Masukkan detail Anda di bawah ini untuk melanjutkan</p>
                    </div>

                    <!-- Google Register Button -->
                    <a href="{{ route('auth.google.redirect') }}"
                        class="w-full flex items-center justify-center gap-3 px-6 py-4 border-2 border-slate-200 rounded-2xl font-semibold hover:bg-slate-50 transition group mb-6">
                        <img src="https://www.google.com/favicon.ico" class="w-5 h-5">
                        <span class="text-slate-700 group-hover:text-slate-900">Lanjutkan dengan Google</span>
                    </a>

                    <div class="relative mb-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-slate-500">Atau daftar dengan email</span>
                        </div>
                    </div>

                    <!-- Register Form -->
                    <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
                        </div>

                        <!-- ✅ BARU: Tipe Akun -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tipe Akun</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center justify-center gap-2 px-4 py-3 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-indigo-300 transition">
                                    <input type="radio" name="account_type" value="user" checked class="text-indigo-600 w-5 h-5">
                                    <span class="text-sm font-medium">User Biasa</span>
                                </label>
                                <label class="flex items-center justify-center gap-2 px-4 py-3 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-indigo-300 transition">
                                    <input type="radio" name="account_type" value="organizer" class="text-indigo-600 w-5 h-5">
                                    <span class="text-sm font-medium">Organizer</span>
                                </label>
                            </div>
                            <p class="text-xs text-slate-400 mt-1">Pilih "Organizer" jika Anda mewakili HIMA/Kepanitiaan</p>
                        </div>

                        <!-- ✅ BARU: Jika pilih Organizer, tampilkan field tambahan -->
                        <div id="organizerFields" class="hidden space-y-4 mt-4 p-4 bg-indigo-50 rounded-xl">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Organisasi/HIMA</label>
                                <input type="text" name="organization_name" placeholder="Contoh: HIMA Sistem Informasi"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Organisasi</label>
                                <textarea name="organization_description" rows="3" placeholder="Ceritakan tentang organisasi Anda..."
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex items-center justify-center gap-2 px-4 py-3 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-indigo-300 transition">
                                    <input type="radio" name="gender" value="male" required class="text-indigo-600 w-5 h-5">
                                    <span class="text-sm font-medium">Laki - Laki</span> ♂
                                </label>
                                <label class="flex items-center justify-center gap-2 px-4 py-3 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-pink-300 transition">
                                    <input type="radio" name="gender" value="female" required class="text-pink-600 w-5 h-5">
                                    <span class="text-sm font-medium">Perempuan</span> ♀
                                </label>
                            </div>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir</label>
                            <div class="grid grid-cols-3 gap-3">
                                <select name="day" required class="px-3 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
                                    <option value="">Tanggal</option>
                                    @for($i=1; $i<=31; $i++)
                                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">{{ $i }}</option>
                                        @endfor
                                </select>
                                <select name="month" required class="px-3 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
                                    <option value="">Bulan</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                                <select name="year" required class="px-3 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
                                    <option value="">Tahun</option>
                                    @for($i=date('Y'); $i>=1950; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <input type="hidden" name="birth_date" id="birth_date">
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi</label>
                            <div class="relative">
                                <input type="password" name="password" id="reg_password" required minlength="8"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
                                <button type="button" onclick="toggleRegPassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                    <svg id="regEyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-slate-400 mt-1.5">Minimal 8 karakter</p>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" required minlength="8"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 mt-6">
                            Daftar
                        </button>
                    </form>

                    <!-- Login Link -->
                    <p class="text-center mt-6 text-sm text-slate-600">
                        Sudah punya akun?
                        <button onclick="closeRegisterModal(); openLoginModal();" class="text-indigo-600 font-bold hover:underline">
                            Masuk
                        </button>
                    </p>

                    <!-- Terms -->
                    <p class="text-xs text-slate-400 text-center mt-6 leading-relaxed">
                        Dengan membuat akun, Anda setuju dengan
                        <a href="#" class="text-indigo-600 hover:underline">Syarat Layanan & Kebijakan Privasi</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Login Form (Hidden by default) -->
    <div id="emailLoginForm" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeEmailLogin()"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md relative z-10 p-8">
                <button onclick="closeEmailLogin()" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 transition">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <h3 class="text-xl font-bold text-center mb-6">Login dengan Email</h3>

                <!-- ✅ SUDAH DIPERBAIKI -->
                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
                    <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
                    <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">Masuk</button>
                </form>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL EDIT PROFIL (UPLOAD FOTO) - HANYA UNTUK USER LOGIN -->
    <!-- ========================================== -->
    @auth
    <div id="profileModal" class="fixed inset-0 z-50 hidden">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeProfileModal()"></div>

        <!-- Modal Content -->
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md relative z-10 transform transition-all scale-100">

                <!-- Header -->
                <div class="px-8 pt-6 pb-4 flex justify-between items-center border-b border-slate-100">
                    <h3 class="text-xl font-bold text-slate-900">Edit Profil</h3>
                    <button onclick="closeProfileModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 transition">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-8">
                    @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 text-sm font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <!-- Avatar Preview & Upload Button -->
                        <div class="flex flex-col items-center mb-6">
                            <div class="relative group">
                                @php
                                $user = auth()->user();
                                $avatarUrl = $user ? $user->avatar : null;
                                $userName = $user ? $user->name : 'User';
                                $currentAvatar = $avatarUrl ? (str_starts_with($avatarUrl, 'http') ? $avatarUrl : asset('storage/' . $avatarUrl)) : 'https://ui-avatars.com/api/?name='.urlencode($userName).'&background=6366f1&color=fff';
                                @endphp

                                <img id="avatarPreview" src="{{ $currentAvatar }}" class="w-24 h-24 rounded-full border-4 border-indigo-100 object-cover mb-3">

                                <label for="avatarInput" class="absolute bottom-0 right-0 bg-indigo-600 text-white p-2.5 rounded-full cursor-pointer hover:bg-indigo-700 transition shadow-lg group-hover:scale-110 transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </label>
                                <input type="file" id="avatarInput" name="avatar" class="hidden" accept="image/*" onchange="previewAvatar(this)">
                            </div>
                            <p class="text-xs text-slate-500 font-medium">Klik ikon kamera untuk mengganti foto</p>
                        </div>

                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
                        </div>

                        <!-- Email (Read Only) -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                            <input type="email" value="{{ auth()->user()->email }}" disabled
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 cursor-not-allowed">
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 mt-6">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endauth

    <!-- ========================================== -->
    <!-- MODAL UBAH KATA SANDI - HANYA UNTUK USER LOGIN -->
    <!-- ========================================== -->
    @auth
    <div id="passwordModal" class="fixed inset-0 z-50 hidden">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closePasswordModal()"></div>

        <!-- Modal Content -->
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md relative z-10 p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold">Ubah Kata Sandi</h3>
                    <button onclick="closePasswordModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-4 text-sm font-bold">{{ session('success') }}</div>
                @endif

                <form action="{{ route('user.change-password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi Lama</label>
                        <input type="password" name="current_password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
                        @error('current_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi Baru</label>
                        <input type="password" name="password" required minlength="8" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" required minlength="8" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>

                    <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    @endauth

    <!-- ALL JAVASCRIPT IN ONE PLACE -->
    <script>
        // Login Modal Functions
        function openLoginModal() {
            document.getElementById('loginModal').classList.remove('hidden');
        }

        function closeLoginModal() {
            document.getElementById('loginModal').classList.add('hidden');
        }

        function showEmailLogin() {
            closeLoginModal();
            document.getElementById('emailLoginForm').classList.remove('hidden');
        }

        function closeEmailLogin() {
            document.getElementById('emailLoginForm').classList.add('hidden');
            openLoginModal();
        }

        // Register Modal Functions
        function openRegisterModal() {
            document.getElementById('registerModal').classList.remove('hidden');
        }

        function closeRegisterModal() {
            document.getElementById('registerModal').classList.add('hidden');
        }

        // Profile Modal Functions
        function openProfileModal() {
            document.getElementById('profileModal').classList.remove('hidden');
        }

        function closeProfileModal() {
            document.getElementById('profileModal').classList.add('hidden');
        }

        // Password Modal Functions
        function openPasswordModal() {
            document.getElementById('passwordModal').classList.remove('hidden');
        }

        function closePasswordModal() {
            document.getElementById('passwordModal').classList.add('hidden');
        }

        // Toggle Password Visibility for Register
        function toggleRegPassword() {
            const passwordInput = document.getElementById('reg_password');
            const eyeIcon = document.getElementById('regEyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }

        // Gabungkan tanggal lahir sebelum submit
        document.querySelector('form').addEventListener('submit', function(e) {
            const day = document.querySelector('select[name="day"]').value;
            const month = document.querySelector('select[name="month"]').value;
            const year = document.querySelector('select[name="year"]').value;

            if (day && month && year) {
                const birthDate = `${year}-${month}-${day.padStart(2, '0')}`;
                document.getElementById('birth_date').value = birthDate;
            }
        });

        // Preview Avatar Upload
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Toggle Profile Dropdown
        function toggleProfileMenu() {
            const menu = document.getElementById('profileMenu');
            menu.classList.toggle('hidden');
        }

        function closeProfileMenu() {
            const menu = document.getElementById('profileMenu');
            menu.classList.add('hidden');
        }

        // Tutup dropdown saat klik di luar
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('profileMenu');
            const button = document.getElementById('profileMenuButton');
            if (menu && button && !button.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });

        // ✅ BARU: Toggle Organizer Fields
        document.querySelectorAll('input[name="account_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const organizerFields = document.getElementById('organizerFields');
                if (this.value === 'organizer') {
                    organizerFields.classList.remove('hidden');
                } else {
                    organizerFields.classList.add('hidden');
                }
            });
        });
    </script>

</body>

</html>