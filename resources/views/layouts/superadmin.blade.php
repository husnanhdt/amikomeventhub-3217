<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Superadmin') - AmikomEventHub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <!-- Tailwind CSS CDN (Agar langsung jalan tanpa npm run dev) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8fafc;
        }

        .sidebar {
            background: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%);
        }

        .sidebar-menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu-item.active {
            background-color: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #818cf8;
        }
    </style>
</head>

<body class="antialiased">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="sidebar w-64 min-h-screen fixed left-0 top-0 text-white">
            <div class="p-6">
                <!-- Logo -->
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-indigo-500 rounded-xl flex items-center justify-center font-black text-xl">
                        AE
                    </div>
                    <div>
                        <h1 class="font-bold text-lg leading-tight">AmikomEventHub</h1>
                        <p class="text-xs text-indigo-300">SUPERADMIN PANEL</p>
                    </div>
                </div>

                <!-- Main Menu -->
                <div class="mb-6">
                    <p class="text-xs text-indigo-300 uppercase font-bold mb-3 px-3">MAIN MENU</p>
                    <nav class="space-y-1">
                        <a href="{{ route('superadmin.dashboard') }}"
                            class="sidebar-menu-item flex items-center gap-3 px-3 py-2.5 rounded-lg transition {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            <span>Dashboard Superadmin</span>
                        </a>
                    </nav>
                </div>

                <!-- Pengawasan & Master Data -->
                <div class="mb-6">
                    <p class="text-xs text-indigo-300 uppercase font-bold mb-3 px-3">PENGAWASAN & MASTER DATA</p>
                    <nav class="space-y-1">
                        <a href="{{ route('superadmin.transactions.index') }}"
                            class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all hover:bg-white/10 {{ request()->routeIs('superadmin.transactions.*') ? 'sidebar-active' : 'text-indigo-100' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span class="font-medium">Transaksi Global</span>
                        </a>

                        <a href="{{ route('superadmin.categories.index') }}"
                            class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all hover:bg-white/10 {{ request()->routeIs('superadmin.categories.*') ? 'sidebar-active' : 'text-indigo-100' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <span class="font-medium">Kelola Kategori</span>
                        </a>

                        <a href="{{ route('superadmin.partners.index') }}"
                            class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all hover:bg-white/10 {{ request()->routeIs('superadmin.partners.*') ? 'sidebar-active' : 'text-indigo-100' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span class="font-medium">Kelola Partner</span>
                        </a>

                        <a href="{{ route('superadmin.organizations.index') }}"
                            class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all hover:bg-white/10 {{ request()->routeIs('superadmin.organizations.*') ? 'sidebar-active' : 'text-indigo-100' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="font-medium">Kelola Organisasi</span>
                        </a>

                        <a href="{{ route('superadmin.reviews.index') }}"
                            class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all hover:bg-white/10 {{ request()->routeIs('superadmin.reviews.*') ? 'sidebar-active' : 'text-indigo-100' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                            <span class="font-medium">Review</span>
                            @if($stats['pending'] ?? 0 > 0)
                            <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $stats['pending'] }}</span>
                            @endif
                        </a>

                        <a href="{{ route('superadmin.admins.index') }}"
                            class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all hover:bg-white/10 {{ request()->routeIs('superadmin.admins.*') ? 'sidebar-active' : 'text-indigo-100' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span class="font-medium">Pengurus</span>
                        </a>
                    </nav>
                </div>

                <!-- Settings -->
                <div class="border-t border-indigo-700 pt-6 mt-6">
                    <a href="{{ route('home') }}"
                        class="flex items-center gap-3 px-4 py-3 text-indigo-200 hover:text-white hover:bg-indigo-800 rounded-xl transition font-medium mx-2 mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Lihat Website
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="mx-2 mb-4">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-300 hover:text-white hover:bg-red-900/30 rounded-xl transition font-medium text-left">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Top Header -->
            <header class="bg-white border-b border-slate-200 px-8 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">@yield('page_title', 'Dashboard')</h1>
                        <p class="text-sm text-slate-500">@yield('page_subtitle', 'Overview platform')</p>
                    </div>

                    <div class="flex items-center gap-4">
                        <!-- Notifications -->
                        <button class="w-10 h-10 rounded-full hover:bg-slate-100 flex items-center justify-center relative">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            @if($badgeCount ?? 0 > 0)
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            @endif
                        </button>

                        <!-- User Profile -->
                        <div class="flex items-center gap-3 pl-6 border-l border-slate-200">
                            <div class="text-right">
                                <p class="font-bold text-slate-900 text-sm">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500">Superadmin</p>
                            </div>
                            <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(auth()->user()->name, 1, 1)) }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>