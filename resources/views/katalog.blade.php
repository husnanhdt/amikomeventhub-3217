<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Event - AmikomEventHub</title>

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
                        primary: '#4F46E5',
                        secondary: '#7C3AED',
                        accent: '#06B6D4',
                        light: '#F8FAFC',
                        dark: '#1E293B',
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-slow': 'float 10s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0px)'
                            },
                            '50%': {
                                transform: 'translateY(-10px)'
                            },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        html {
            scroll-behavior: smooth;
        }

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

        .glass {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 8px 32px rgba(31, 41, 55, 0.08);
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        .floating-delay {
            animation: float 6s ease-in-out 3s infinite;
        }

        .text-gradient {
            background: linear-gradient(135deg, #4F46E5, #7C3AED, #06B6D4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .dots-pattern {
            background-image: radial-gradient(rgba(79, 70, 229, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        .card-hover {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(79, 70, 229, 0.15);
        }
    </style>
</head>

<body class="font-sans antialiased text-dark">

    <!-- Background -->
    <div class="fixed inset-0 gradient-bg -z-10"></div>

    <!-- Decorative Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute top-32 left-8 w-64 h-64 bg-gradient-to-br from-primary/5 to-secondary/5 rounded-full blur-3xl floating"></div>
        <div class="absolute bottom-32 right-8 w-80 h-80 bg-gradient-to-br from-accent/5 to-primary/5 rounded-full blur-3xl floating-delay"></div>
        <div class="absolute inset-0 dots-pattern opacity-50"></div>
    </div>

    <!-- Navigation -->
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
                    <a href="/" class="px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg font-medium transition">Home</a>
                    <a href="/profil" class="px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg font-medium transition">Profil</a>
                    <a href="/katalog" class="px-4 py-2 text-primary bg-primary/10 rounded-lg font-medium transition">Katalog</a>
                    <a href="/bantuan" class="px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg font-medium transition">Bantuan</a>
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
                <a href="/" class="block px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg font-medium transition">🏠 Home</a>
                <a href="/profil" class="block px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg font-medium transition">👤 Profil</a>
                <a href="/katalog" class="block px-4 py-2 text-primary bg-primary/10 rounded-lg font-medium">📋 Katalog</a>
                <a href="/bantuan" class="block px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg font-medium transition">❓ Bantuan</a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="min-h-screen px-4 pt-24 pb-12">
        <div class="max-w-6xl mx-auto">

            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center px-5 py-2.5 bg-white rounded-full text-gray-700 text-sm mb-6 shadow-sm border border-gray-200/60">
                    Event Terbaru & Terpopuler
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-dark mb-4">
                    Katalog <span class="text-gradient">AmikomEventHub</span>
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Temukan berbagai event menarik dan tingkatkan skill kamu bersama komunitas Amikom
                </p>
            </div>

            <!-- Event Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Event Card 1 -->
                <div class="card-hover glass rounded-2xl overflow-hidden border border-gray-200/60 flex flex-col h-full">
                    <!-- Image Section -->
                    <div class="bg-gradient-to-br from-purple-500 to-pink-500 h-48 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-white/10"></div>
                        <span class="text-white text-6xl relative z-10">🎤</span>
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-purple-600">
                            Seminar
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-dark mb-2">Seminar Teknologi 2025</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed flex-grow">
                            Seminar tentang perkembangan teknologi terbaru di industri digital bersama para expert.
                        </p>

                        <!-- Date -->
                        <div class="flex items-center text-gray-500 text-sm mb-3">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>15 Oktober 2025</span>
                        </div>

                        <!-- Bottom Section (Location + Button) - mt-auto untuk push ke bawah -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200/60 mt-auto">
                            <div class="flex items-center text-gray-500 text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Ruang Cinema Amikom</span>
                            </div>
                            <button class="px-5 py-2 bg-gradient-to-r from-primary to-secondary text-white rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300 font-medium text-sm">
                                Detail
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Event Card 2 -->
                <div class="card-hover glass rounded-2xl overflow-hidden border border-gray-200/60 flex flex-col h-full">
                    <div class="bg-gradient-to-br from-blue-500 to-cyan-500 h-48 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-white/10"></div>
                        <span class="text-white text-6xl relative z-10">🎨</span>
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-blue-600">
                            Workshop
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-dark mb-2">Workshop Desain UI/UX</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed flex-grow">Pelajari cara membuat desain antarmuka yang menarik dan user-friendly dari dasar.</p>

                        <div class="flex items-center text-gray-500 text-sm mb-3">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>20 Desember 2025</span>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-200/60 mt-auto">
                            <div class="flex items-center text-gray-500 text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Citra 2</span>
                            </div>
                            <button class="px-5 py-2 bg-gradient-to-r from-primary to-secondary text-white rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300 font-medium text-sm">
                                Detail
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Event Card 3 -->
                <div class="card-hover glass rounded-2xl overflow-hidden border border-gray-200/60 flex flex-col h-full">
                    <div class="bg-gradient-to-br from-green-500 to-emerald-500 h-48 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-white/10"></div>
                        <span class="text-white text-6xl relative z-10">💻</span>
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-green-600">
                            Kompetisi
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-dark mb-2">Hackathon 2026</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed flex-grow">Kompetisi programming 24 jam untuk menciptakan aplikasi inovatif dan solutif.</p>

                        <div class="flex items-center text-gray-500 text-sm mb-3">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>25 Januari 2026</span>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-200/60 mt-auto">
                            <div class="flex items-center text-gray-500 text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Citra 1</span>
                            </div>
                            <button class="px-5 py-2 bg-gradient-to-r from-primary to-secondary text-white rounded-lg hover:shadow-lg hover:scale-105 transition-all duration-300 font-medium text-sm">
                                Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer - Minimal White -->
    <footer class="glass border-t border-gray-200/60 py-7">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-500 text-sm">
                © 2026 <span class="text-dark font-semibold">AmikomEventHub</span> • Universitas Amikom Yogyakarta
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