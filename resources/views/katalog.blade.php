<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Event - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="text-2xl font-bold text-purple-600">AmikomEventHub</div>
                <div class="flex space-x-4">
                    <a href="/" class="px-4 py-2 text-gray-700 hover:bg-purple-100 rounded-lg transition">Home</a>
                    <a href="/profil" class="px-4 py-2 text-gray-700 hover:bg-purple-100 rounded-lg transition">Profil</a>
                    <a href="/katalog" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">Katalog</a>
                    <a href="/bantuan" class="px-4 py-2 text-gray-700 hover:bg-purple-100 rounded-lg transition">Bantuan</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="max-w-6xl mx-auto px-4 py-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">Katalog Event AmikomEventHub</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Event Card 1 -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl hover:scale-105 transition transform">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-48 flex items-center justify-center">
                    <span class="text-white text-6xl">🎤</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Seminar Teknologi 2024</h3>
                    <p class="text-gray-600 mb-4">Seminar tentang perkembangan teknologi terbaru di industri digital.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">📅 15 Mei 2024</span>
                        <button class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">Detail</button>
                    </div>
                </div>
            </div>

            <!-- Event Card 2 -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl hover:scale-105 transition transform">
                <div class="bg-gradient-to-r from-blue-500 to-cyan-500 h-48 flex items-center justify-center">
                    <span class="text-white text-6xl">🎨</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Workshop Desain UI/UX</h3>
                    <p class="text-gray-600 mb-4">Pelajari cara membuat desain antarmuka yang menarik dan user-friendly.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">📅 20 Mei 2024</span>
                        <button class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">Detail</button>
                    </div>
                </div>
            </div>

            <!-- Event Card 3 -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl hover:scale-105 transition transform">
                <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-48 flex items-center justify-center">
                    <span class="text-white text-6xl">💻</span>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Hackathon 2024</h3>
                    <p class="text-gray-600 mb-4">Kompetisi programming 24 jam untuk menciptakan aplikasi inovatif.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">📅 25 Mei 2024</span>
                        <button class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">Detail</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>