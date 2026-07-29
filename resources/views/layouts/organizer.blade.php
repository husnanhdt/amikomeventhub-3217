<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Dashboard - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-indigo-900 text-white flex flex-col fixed h-full">
            <!-- Logo -->
            <div class="p-6 border-b border-indigo-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-900 font-bold text-xl">
                        AH
                    </div>
                    <div>
                        <h1 class="font-bold text-lg">AmikomEventHub</h1>
                        <p class="text-xs text-indigo-300">Organizer Panel</p>
                    </div>
                </div>
            </div>

            <!-- Menu -->
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto sidebar-scroll">
                <p class="text-[10px] font-bold uppercase tracking-widest text-indigo-400 mb-4 px-2">Main Menu</p>

                <!-- Dashboard -->
                <a href="{{ route('organizer.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('organizer.dashboard') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    Dashboard
                </a>

                <!-- Kelola Event -->
                <a href="{{ route('organizer.events.index') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-lg transition {{ request()->routeIs('organizer.events.*') ? 'bg-white/10' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Kelola Event</span>
                </a>

                <!-- Laporan Transaksi -->
                <a href="{{ route('organizer.transactions.index') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('organizer.transactions.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Laporan Transaksi
                </a>

                <!-- ✅ BARU: Kelola Tiket -->
                <a href="{{ route('organizer.tickets.index') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('organizer.tickets.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                    Kelola Tiket
                </a>

                <!-- ✅ BARU: Ulasan Saya -->
                <a href="{{ route('organizer.reviews.index') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('organizer.reviews.*') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    Ulasan Saya
                </a>

                <!-- ✅ BARU: Statistik Event -->
                <a href="{{ route('organizer.statistics.index') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('organizer.statistics') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Statistik Event
                </a>

                <!-- Profil Organizer -->
                <a href="{{ route('organizer.profile') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('organizer.profile') ? 'bg-indigo-800 text-white' : 'hover:bg-indigo-800' }} rounded-xl font-bold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 01-7 7h14a7 7 0 01-7-7z"></path>
                    </svg>
                    Profil Organizer
                </a>
            </nav>

            <!-- User Info & Logout -->
            <!-- Lihat Website -->
            <a href="{{ route('home') }}"
                class="flex items-center gap-3 px-4 py-3 text-indigo-200 hover:text-white hover:bg-indigo-800 rounded-xl transition font-medium mx-2 mb-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                Lihat Website
            </a>

            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST" class="mx-2 mb-4">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-300 hover:text-white hover:bg-red-900/30 rounded-xl transition font-medium text-left">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Keluar
                </button>
            </form>
            </nav>
        </aside>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64">
            <!-- ✅ HEADER DENGAN PROFIL USER -->
            <header class="flex justify-between items-center mb-10 w-full px-8 pt-8">
                <div>
                    <h1 class="text-3xl font-black">@yield('page_title', 'Dashboard Organizer')</h1>
                    <p class="text-slate-500 font-medium mt-1">@yield('page_subtitle', 'Kelola event dan pantau pendapatan organisasi Anda.')</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right hidden md:block">
                        <p class="font-bold">{{ auth()->user()->partner->name ?? auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400">Penyelenggara</p>
                    </div>
                    <div class="w-12 h-12 bg-white rounded-2xl shadow-sm border flex items-center justify-center p-1">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->partner->name ?? auth()->user()->name) }}&background=6366f1&color=fff" class="rounded-xl" alt="Avatar">
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="px-8 pb-8">
                @yield('content')
            </div>
        </main>
    </div>

</body>

</html>