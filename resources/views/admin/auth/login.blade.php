<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - AmikomEventHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen p-6">

    <!-- Login Card -->
    <div class="w-full max-w-md bg-white rounded-'[2rem]' shadow-xl border border-slate-100 p-10 text-center">
        
        <!-- Logo & Title -->
        <div class="mb-8">
            <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-black text-2xl mx-auto mb-4 shadow-lg shadow-indigo-200">
                AH
            </div>
            <h1 class="text-2xl font-black text-slate-900">Admin Login</h1>
            <p class="text-slate-500 text-sm mt-2">Masuk untuk mengelola event & tiket.</p>
        </div>

        <!-- Flash Message -->
        @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 text-sm font-bold">
            {{ session('success') }}
        </div>
        @endif

        <!-- Form Login -->
        <form action="{{ route('admin.login') }}" method="POST" class="space-y-5 text-left">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wide ml-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@amikom.ac.id"
                    class="w-full px-5 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/10 outline-none transition font-medium @error('email') 'border-red-500' @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1 ml-1 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wide ml-1">Password</label>
                <input type="password" name="password" placeholder="••••••••"
                    class="w-full px-5 py-3.5 bg-slate-50 border-2 'border-slate-100' rounded-xl focus:border-indigo-600 focus:ring-4 focus:ring-indigo-500/10 outline-none transition font-medium @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1 ml-1 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                <label for="remember" class="text-sm text-slate-600 font-medium">Ingat saya</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black text-lg shadow-lg shadow-indigo-200 hover:bg-indigo-700 active:scale-[0.98] transition-all mt-2">
                Masuk
            </button>
        </form>

        <!-- Back to Home -->
        <div class="mt-8 pt-6 border-t border-slate-100">
            <a href="{{ url('/') }}" class="text-slate-500 hover:text-indigo-600 text-sm font-bold transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>

</body>
</html>