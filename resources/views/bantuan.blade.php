<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantuan - AmikomEventHub</title>

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

        .faq-item {
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            transform: translateX(4px);
            border-color: rgba(79, 70, 229, 0.3);
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
                    <a href="/katalog" class="px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg font-medium transition">Katalog</a>
                    <a href="/bantuan" class="px-4 py-2 text-primary bg-primary/10 rounded-lg font-medium transition">Bantuan</a>
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
                <a href="/" class="block px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg font-medium transition">Home</a>
                <a href="/profil" class="block px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg font-medium transition">Profil</a>
                <a href="/katalog" class="block px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg font-medium transition">Katalog</a>
                <a href="/bantuan" class="block px-4 py-2 text-primary bg-primary/10 rounded-lg font-medium">Bantuan</a>
                <a href="/contact" class="block px-4 py-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg font-medium transition">Kontak</a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="min-h-screen flex items-center justify-center px-4 pt-24 pb-12">
        <div class="max-w-3xl w-full">

            <!-- Header -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center px-5 py-2.5 bg-white rounded-full text-gray-700 text-sm mb-6 shadow-sm border border-gray-200/60">
                    Butuh Bantuan?
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-dark mb-4">
                    FAQ - <span class="text-gradient">Pertanyaan Umum</span>
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Temukan jawaban untuk pertanyaan seputar platform AmikomEventHub
                </p>
            </div>

            <!-- FAQ Cards -->
            <div class="space-y-4">

                <!-- FAQ Item 1 -->
                <div class="faq-item glass rounded-2xl p-6 border border-gray-200/60 hover:shadow-lg">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">🤔</div>
                        <div>
                            <h3 class="text-lg font-semibold text-dark mb-2">Apa itu AmikomEventHub?</h3>
                            <p class="text-gray-600 leading-relaxed">AmikomEventHub adalah platform informasi dan manajemen event terpusat untuk mahasiswa Universitas Amikom Yogyakarta. Di sini kamu bisa menemukan, mengikuti, dan mengelola berbagai event menarik.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="faq-item glass rounded-2xl p-6 border border-gray-200/60 hover:shadow-lg">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-400 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">📝</div>
                        <div>
                            <h3 class="text-lg font-semibold text-dark mb-2">Bagaimana cara mendaftar event?</h3>
                            <p class="text-gray-600 leading-relaxed">Klik tombol "Detail" pada katalog event yang kamu minati, lalu ikuti instruksi pendaftaran yang tersedia. Pastikan kamu sudah login untuk melakukan pendaftaran.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="faq-item glass rounded-2xl p-6 border border-gray-200/60 hover:shadow-lg">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-400 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">💰</div>
                        <div>
                            <h3 class="text-lg font-semibold text-dark mb-2">Apakah event-event ini berbayar?</h3>
                            <p class="text-gray-600 leading-relaxed">Sebagian besar event gratis untuk mahasiswa Amikom. Untuk event tertentu mungkin ada biaya pendaftaran yang akan dijelaskan secara transparan di halaman detail event.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="faq-item glass rounded-2xl p-6 border border-gray-200/60 hover:shadow-lg">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-red-400 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">📞</div>
                        <div>
                            <h3 class="text-lg font-semibold text-dark mb-2">Bagaimana cara menghubungi admin?</h3>
                            <p class="text-gray-600 leading-relaxed">Kamu dapat menghubungi tim admin melalui email <span class="text-primary font-medium">admin@amikomeventhub.ac.id</span> atau WhatsApp <span class="text-primary font-medium">0857-2424-3087</span>.</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="faq-item glass rounded-2xl p-6 border border-gray-200/60 hover:shadow-lg">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-violet-400 rounded-xl flex items-center justify-center text-2xl flex-shrink-0">🎓</div>
                        <div>
                            <h3 class="text-lg font-semibold text-dark mb-2">Siapa saja yang bisa mengikuti event?</h3>
                            <p class="text-gray-600 leading-relaxed">Event-event kami terbuka untuk seluruh mahasiswa Universitas Amikom Yogyakarta dari semua program studi dan angkatan. Beberapa event mungkin memiliki persyaratan khusus yang akan dijelaskan di detail event.</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Contact CTA -->
            <div class="mt-10 text-center">
                <div class="glass rounded-2xl p-6 border border-gray-200/60">
                    <p class="text-gray-600 mb-4">Masih ada pertanyaan lain?</p>
                    <a href="mailto:admin@amikomeventhub.ac.id" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-secondary text-white font-medium rounded-xl hover:shadow-lg hover:scale-105 transition-all duration-300 no-underline">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>

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