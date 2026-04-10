{{-- Tampilkan data mahasiswa --}}
<div class="mb-4 p-4 bg-[#fff2f2] dark:bg-[#1D0002] rounded-sm border border-[#e3e3e0] dark:border-[#3E3E3A]">
    <p class="text-sm"><strong>Nama     :</strong> {{ $mahasiswa['nama'] }}</p>
    <p class="text-sm"><strong>NIM      :</strong> {{ $mahasiswa['nim'] }}</p>
    <p class="text-sm"><strong>Kelas    :</strong> {{ $mahasiswa['kelas'] }}</p>
</div><!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'AmikomEventHub') }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: '#7C3AED',
                        secondary: '#EC4899',
                        accent: '#06B6D4',
                    },
                    animation: {
                        'float': 'float 3s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Smooth Scroll */
        html { scroll-behavior: smooth; }
        
        /* Gradient Background Animation */
        .gradient-bg {
            background: linear-gradient(-45deg, #7C3AED, #EC4899, #06B6D4, #3B82F6);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Card Hover Effect */
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        /* Floating Elements */
        .floating {
            animation: float 3s ease-in-out infinite;
        }
        .floating-delay {
            animation: float 3s ease-in-out 1.5s infinite;
        }
    </style>
</head>
<body class="font-sans antialiased">
    
    <!-- Animated Background -->
    <div class="fixed inset-0 gradient-bg -z-10"></div>
    
    <!-- Floating Shapes -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute top-20 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl floating"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-white/10 rounded-full blur-3xl floating-delay"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-white/5 rounded-full blur-3xl"></div>
    </div>

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary to-secondary rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-lg">🎪</span>
                    </div>
                    <span class="text-white font-bold text-xl tracking-tight">AmikomEventHub</span>
                </div>
                
                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-2">
                    <a href="/" class="px-4 py-2 text-white bg-white/20 rounded-lg font-medium hover:bg-white/30 transition">🏠 Home</a>
                    <a href="/profil" class="px-4 py-2 text-white/90 hover:text-white hover:bg-white/10 rounded-lg font-medium transition">👤 Profil</a>
                    <a href="/katalog" class="px-4 py-2 text-white/90 hover:text-white hover:bg-white/10 rounded-lg font-medium transition">📋 Katalog</a>
                    <a href="/bantuan" class="px-4 py-2 text-white/90 hover:text-white hover:bg-white/10 rounded-lg font-medium transition">❓ Bantuan</a>
                </div>
                
                <!-- Mobile Menu Button -->
                <button class="md:hidden text-white p-2" onclick="toggleMenu()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden glass border-t border-white/10">
            <div class="px-4 py-3 space-y-2">
                <a href="/" class="block px-4 py-2 text-white bg-white/20 rounded-lg font-medium">🏠 Home</a>
                <a href="/profil" class="block px-4 py-2 text-white/90 hover:text-white hover:bg-white/10 rounded-lg font-medium transition">👤 Profil</a>
                <a href="/katalog" class="block px-4 py-2 text-white/90 hover:text-white hover:bg-white/10 rounded-lg font-medium transition">📋 Katalog</a>
                <a href="/bantuan" class="block px-4 py-2 text-white/90 hover:text-white hover:bg-white/10 rounded-lg font-medium transition">❓ Bantuan</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen flex items-center justify-center px-4 pt-20 pb-10">
        <div class="max-w-5xl w-full">
            
            <!-- Hero Section -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center px-4 py-2 bg-white/20 rounded-full text-white/90 text-sm mb-6 backdrop-blur-sm border border-white/20">
                    ✨ Selamat Datang di Platform Event Amikom
                </div>
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 leading-tight">
                    Temukan Event <br>
                    <span class="bg-gradient-to-r from-yellow-300 to-orange-400 bg-clip-text text-transparent">Terbaik Untukmu</span>
                </h1>
                <p class="text-lg text-white/80 max-w-2xl mx-auto">
                    Platform terpusat untuk menemukan, mengikuti, dan mengelola event-event menarik di lingkungan Universitas Amikom Yogyakarta.
                </p>
            </div>

            <!-- Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-12">
                <!-- Card 1: Profil -->
                <a href="/profil" class="card-hover glass rounded-2xl p-6 text-white no-underline block">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-cyan-400 rounded-xl flex items-center justify-center mb-4 text-2xl">👤</div>
                    <h3 class="font-semibold text-lg mb-2">Profil Praktikan</h3>
                    <p class="text-white/70 text-sm">Lihat informasi nama, NIM, dan kelas kamu</p>
                </a>
                
                <!-- Card 2: Katalog -->
                <a href="/katalog" class="card-hover glass rounded-2xl p-6 text-white no-underline block">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-400 rounded-xl flex items-center justify-center mb-4 text-2xl">📋</div>
                    <h3 class="font-semibold text-lg mb-2">Katalog Event</h3>
                    <p class="text-white/70 text-sm">Jelajahi berbagai event menarik yang tersedia</p>
                </a>
                
                <!-- Card 3: Bantuan -->
                <a href="/bantuan" class="card-hover glass rounded-2xl p-6 text-white no-underline block">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-red-400 rounded-xl flex items-center justify-center mb-4 text-2xl">❓</div>
                    <h3 class="font-semibold text-lg mb-2">Pusat Bantuan</h3>
                    <p class="text-white/70 text-sm">Temukan jawaban untuk pertanyaanmu</p>
                </a>
            </div>

            <!-- Student Info Card -->
            <div class="glass rounded-2xl p-6 md:p-8 max-w-2xl mx-auto border border-white/20">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-2xl flex items-center justify-center text-3xl shadow-lg">
                        🎓
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Data Praktikan</h2>
                        <p class="text-white/70 text-sm">Informasi identitas mahasiswa</p>
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-3 px-4 bg-white/10 rounded-xl">
                        <span class="text-white/70">Nama Lengkap</span>
                        <span class="text-white font-medium">Husnan Hidayat</span>
                    </div>
                    <div class="flex items-center justify-between py-3 px-4 bg-white/10 rounded-xl">
                        <span class="text-white/70">NIM</span>
                        <span class="text-white font-medium">24.12.3217</span>
                    </div>
                    <div class="flex items-center justify-between py-3 px-4 bg-white/10 rounded-xl">
                        <span class="text-white/70">Kelas</span>
                        <span class="text-white font-medium">Digital Business 04</span>
                    </div>
                    <div class="flex items-center justify-between py-3 px-4 bg-white/10 rounded-xl">
                        <span class="text-white/70">Program Studi</span>
                        <span class="text-white font-medium">Sistem Informasi</span>
                    </div>
                </div>
            </div>

            <!-- CTA Button -->
            <div class="text-center mt-10">
                <a href="/katalog" class="inline-flex items-center px-8 py-4 bg-white text-primary font-semibold rounded-2xl shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-300 no-underline">
                    <span class="mr-2">🚀</span>
                    Jelajahi Event Sekarang
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="glass border-t border-white/10 py-6">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-white/60 text-sm">
                © 2024 <span class="text-white font-medium">AmikomEventHub</span> • Tugas Praktikum Laravel • Universitas Amikom Yogyakarta
            </p>
        </div>
    </footer>

    <!-- Mobile Menu Toggle Script -->
    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('mobileMenu');
            const btn = e.target.closest('button');
            if (!menu.contains(e.target) && !btn && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });
    </script>
    
</body>
</html>