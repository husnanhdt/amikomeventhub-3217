@extends('layouts.app')

@section('content')
<style>
    /* Overlay dengan blur - TIDAK memblock scroll */
    .register-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
    } 
    
    /* Hide navbar saat di halaman register */
    nav {
        display: none !important;
    }
    
    /* KUNCI UTAMA: Pastikan body dan html tetap bisa scroll seperti Yesplis */
    html, body {
        overflow: auto !important;
        height: auto !important;
    }
</style>

<!-- Overlay dengan Blur -->
<div class="register-overlay flex items-start justify-center pt-20 pb-20 px-4">
    
    <!-- Modal Content -->
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md relative z-10 my-auto">
        
        <!-- Header dengan 2 Tombol (Sticky agar tetap terlihat saat scroll) -->
        <div class="sticky top-0 bg-white z-20 px-8 pt-6 pb-4 border-b border-slate-100 rounded-t-3xl">
            <div class="flex justify-between items-center">
                <!-- Panah Kiri - Kembali ke Login -->
                <button onclick="window.location.href='{{ route('user.login') }}'" 
                        class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-100 transition">
                    <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                
                <!-- Close Button - Ke Home -->
                <a href="/" 
                   class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-slate-100 transition">
                    <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- Modal Body - Scrollable Content jika form terlalu panjang -->
        <div class="p-8 max-h-[75vh] overflow-y-auto custom-scrollbar">
            
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-black text-2xl mx-auto mb-3">
                    AH
                </div>
                <h2 class="text-2xl font-bold text-slate-900 mb-2">Lengkapi Profil Anda</h2>
                <p class="text-slate-500 text-sm">Masukkan detail Anda di bawah ini untuk melanjutkan</p>
            </div>

            <!-- Google Register Button -->
            <a href="{{ route('auth.google.redirect') }}" 
               class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-slate-100 rounded-2xl font-semibold hover:bg-slate-200 transition mb-5">
                <img src="https://www.google.com/favicon.ico" class="w-5 h-5">
                <span class="text-slate-700">Lanjutkan dengan Google</span>
            </a>

            <div class="relative mb-5">
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

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center justify-center gap-2 px-4 py-3 border-2 {{ old('gender') == 'male' ? 'border-indigo-600 bg-indigo-50' : 'border-slate-200' }} rounded-xl cursor-pointer hover:border-indigo-300 transition">
                            <input type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} required class="text-indigo-600 w-5 h-5">
                            <span class="text-sm font-medium">Laki - Laki</span> ♂
                        </label>
                        <label class="flex items-center justify-center gap-2 px-4 py-3 border-2 {{ old('gender') == 'female' ? 'border-pink-600 bg-pink-50' : 'border-slate-200' }} rounded-xl cursor-pointer hover:border-pink-300 transition">
                            <input type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} required class="text-pink-600 w-5 h-5">
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
                        <input type="password" name="password" id="password" required minlength="8"
                               class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
                        <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <button onclick="window.location.href='{{ route('user.login') }}'" class="text-indigo-600 font-bold hover:underline">
                    Masuk
                </button>
            </p>

            <!-- Terms -->
            <p class="text-xs text-slate-400 text-center mt-6 leading-relaxed">
                Dengan menggunakan website ini, membeli tiket, atau membuat akun, Anda setuju dengan 
                <a href="#" class="text-indigo-600 hover:underline">Syarat Layanan & Kebijakan Privasi</a>
            </p>
        </div>
    </div>
</div>

<script>
// Toggle Password Visibility
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
    } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
    }
}

// Gabungkan tanggal lahir sebelum submit (Format: YYYY-MM-DD)
document.querySelector('form').addEventListener('submit', function(e) {
    const day = document.querySelector('select[name="day"]').value;
    const month = document.querySelector('select[name="month"]').value;
    const year = document.querySelector('select[name="year"]').value;
    
    if (day && month && year) {
        const birthDate = `${year}-${month}-${day.padStart(2, '0')}`;
        document.getElementById('birth_date').value = birthDate;
    }
});
</script>
@endsection