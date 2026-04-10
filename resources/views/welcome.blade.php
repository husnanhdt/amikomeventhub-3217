<!DOCTYPE html>
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
                        primary: '#4F46E5', // Indigo elegant
                        secondary: '#7C3AED', // Purple soft
                        accent: '#06B6D4', // Cyan subtle
                        light: '#F8FAFC', // Light background
                        dark: '#1E293B', // Dark text
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-slow': 'float 8s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0px) rotate(0deg)'
                            },
                            '50%': {
                                transform: 'translateY(-20px) rotate(2deg)'
                            },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* White Gradient Background - Subtle & Elegant */
        .gradient-bg {
            background:
                radial-gradient(ellipse at top, #ffffff 0%, #f1f5f9 40%, #e2e8f0 100%),
                radial-gradient(ellipse at bottom right, rgba(79, 70, 229, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at top left, rgba(124, 58, 237, 0.06) 0%, transparent 50%);
            background-size: 100% 100%, 200% 200%, 200% 200%;
            animation: gradientShift 20s ease infinite;
        }

        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%, 0% 50%, 100% 50%;
            }

            50% {
                background-position: 0% 50%, 100% 50%, 0% 50%;
            }
        }

        /* Glassmorphism - White Version */
        .glass {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow:
                0 8px 32px rgba(31, 41, 55, 0.08),
                0 2px 8px rgba(31, 41, 55, 0.04);
        }

        /* Card Hover Effect */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow:
                0 25px 50px -12px rgba(79, 70, 229, 0.15),
                0 0 0 1px rgba(79, 70, 229, 0.1);
        }

        /* Floating Elements - Subtle */
        .floating {
            animation: float 6s ease-in-out infinite;
        }

        .floating-delay {
            animation: float 6s ease-in-out 3s infinite;
        }

        .floating-slow {
            animation: float 10s ease-in-out infinite;
        }

        /* Text Gradient */
        .text-gradient {
            background: linear-gradient(135deg, #4F46E5, #7C3AED, #06B6D4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Button Glow */
        .btn-glow {
            position: relative;
            overflow: hidden;
        }

        .btn-glow::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s ease;
        }

        .btn-glow:hover::before {
            left: 100%;
        }

        /* Decorative Dots Pattern */
        .dots-pattern {
            background-image: radial-gradient(rgba(79, 70, 229, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
        }
    </style>
</head>

<body class="font-sans antialiased text-dark">

    <!-- Elegant White Gradient Background -->
    <div class="fixed inset-0 gradient-bg -z-10"></div>

    <!-- Subtle Decorative Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute top-32 left-8 w-64 h-64 bg-gradient-to-br from-primary/5 to-secondary/5 rounded-full blur-3xl floating"></div>
        <div class="absolute bottom-32 right-8 w-80 h-80 bg-gradient-to-br from-accent/5 to-primary/5 rounded-full blur-3xl floating-delay"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-gradient-to-br from-white/40 to-transparent rounded-full blur-2xl"></div>
        <!-- Dots Pattern Overlay -->
        <div class="absolute inset-0 dots-pattern opacity-50"></div>
    </div>

    <!-- Navigation - Clean White -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass border-b border-gray-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 flex items-center justify-center">
                        <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="w-7 h-7 object-contain">
                    </div>
                    <span class="text-dark font-bold text-xl tracking-tight">AmikomEventHub</span>
                </div>

                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-1">
                    <a href="/" class="px-4 py-2 text-primary bg-primary/10 rounded-lg font-medium transition">Home</a>
                    <a href="/profil" class="px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg font-medium transition">Profil</a>
                    <a href="/katalog" class="px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg font-medium transition">Katalog</a>
                    <a href="/bantuan" class="px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg font-medium transition">Bantuan</a>
                    <a href="/contact" class="px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg font-medium transition">Kontak</a>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-700 p-2 hover:bg-gray-100 rounded-lg transition" onclick="toggleMenu()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden glass border-t border-gray-200/50">
            <div class="px-4 py-3 space-y-2">
                <a href="/" class="block px-4 py-2 text-primary bg-primary/10 rounded-lg font-medium">Home</a>
                <a href="/profil" class="block px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg font-medium transition">Profil</a>
                <a href="/katalog" class="block px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg font-medium transition">Katalog</a>
                <a href="/bantuan" class="block px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg font-medium transition">Bantuan</a>
                <a href="/contact" class="block px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg font-medium transition">Kontak</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen flex items-center justify-center px-4 pt-24 pb-12">
        <div class="max-w-5xl w-full">

            <!-- Hero Section - Clean & Minimal -->
            <div class="text-center mb-14">
                <div class="inline-flex items-center px-5 py-2.5 bg-white rounded-full text-gray-700 text-sm mb-7 shadow-sm border border-gray-200/60">
                    Selamat Datang di Platform Event Amikom
                </div>
                <h1 class="text-4xl md:text-6xl font-bold text-dark mb-5 leading-tight">
                    Temukan Event <br>
                    <span class="text-gradient">Terbaik Untukmu</span>
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Platform terpusat untuk menemukan, mengikuti, dan mengelola event - event menarik di lingkungan Universitas Amikom Yogyakarta.
                </p>
            </div>

            <!-- Info Cards - White Glass Style -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-14">
                <!-- Card 1: Profil -->
                <a href="/profil" class="card-hover glass rounded-2xl p-7 text-dark no-underline block group">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center mb-5 text-2xl shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform">👤</div>
                    <h3 class="font-semibold text-lg mb-2 text-dark">Profil Praktikan</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Lihat informasi Nama, NIM, dan Kelas</p>
                </a>

                <!-- Card 2: Katalog -->
                <a href="/katalog" class="card-hover glass rounded-2xl p-7 text-dark no-underline block group">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-400 rounded-2xl flex items-center justify-center mb-5 text-2xl shadow-lg shadow-purple-500/20 group-hover:scale-110 transition-transform">📋</div>
                    <h3 class="font-semibold text-lg mb-2 text-dark">Katalog Event</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Jelajahi berbagai event menarik yang tersedia untuk diikuti</p>
                </a>

                <!-- Card 3: Bantuan -->
                <a href="/bantuan" class="card-hover glass rounded-2xl p-7 text-dark no-underline block group">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-400 to-red-400 rounded-2xl flex items-center justify-center mb-5 text-2xl shadow-lg shadow-orange-500/20 group-hover:scale-110 transition-transform">❓</div>
                    <h3 class="font-semibold text-lg mb-2 text-dark">Pusat Bantuan</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Temukan jawaban untuk pertanyaanmu seputar platform ini</p>
                </a>
            </div>

            <!-- CTA Button - Clean & Modern -->
            <div class="text-center mt-12">
                <a href="/katalog" class="btn-glow inline-flex items-center px-9 py-4 bg-gradient-to-r from-primary to-secondary text-white font-semibold rounded-2xl shadow-xl shadow-primary/30 hover:shadow-2xl hover:shadow-primary/40 hover:scale-105 transition-all duration-300 no-underline">
                    Jelajahi Event Sekarang
                    <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
        </div>
    </main>

    <!-- Footer - Minimal White -->
    <footer class="glass border-t border-gray-200/60 py-7">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-500 text-sm">
                © 2026 <span class="text-dark font-semibold">AmikomEventHub</span> Universitas Amikom Yogyakarta
            </p>
        </div>
    </footer>

    <!-- Mobile Menu Toggle Script -->
    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

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