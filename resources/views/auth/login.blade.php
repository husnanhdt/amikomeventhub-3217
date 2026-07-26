@extends('layouts.app')

@section('content')
<style>
    /* Blur effect untuk background */
    .login-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
    }
    
    /* Hide navbar saat di halaman login */
    nav {
        display: none !important;
    }
</style>

<!-- Overlay dengan Blur -->
<div class="login-overlay flex items-center justify-center p-4">
    
    <!-- Modal Content -->
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md relative z-10">
        
        <!-- Close Button -->
        <a href="/" 
           class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 transition">
            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </a>
        
        <!-- Modal Body -->
        <div class="p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-black text-2xl mx-auto mb-4">
                    AH
                </div>
                <h2 class="text-2xl font-bold text-slate-900 mb-2">{{ __('messages.welcome') }}</h2>
                <p class="text-slate-500 text-sm">{{ __('messages.subtitle') }}</p>
            </div>

            @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6 text-sm font-bold">
                {{ session('error') }}
            </div>
            @endif

            <!-- Login Options -->
            <div class="space-y-3">
                <a href="{{ route('auth.google.redirect') }}" 
                   class="w-full flex items-center justify-center gap-3 px-6 py-4 border-2 border-slate-200 rounded-2xl font-semibold hover:bg-slate-50 transition group">
                    <img src="https://www.google.com/favicon.ico" class="w-5 h-5">
                    <span class="text-slate-700 group-hover:text-slate-900">{{ __('messages.continue_google') }}</span>
                </a>

                <button onclick="showEmailLogin()" 
                        class="w-full flex items-center justify-center gap-3 px-6 py-4 border-2 border-slate-200 rounded-2xl font-semibold hover:bg-slate-50 transition group">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-slate-700 group-hover:text-slate-900">{{ __('messages.continue_email') }}</span>
                </button>

                <button class="w-full flex items-center justify-center gap-3 px-6 py-4 border-2 border-slate-200 rounded-2xl font-semibold hover:bg-slate-50 transition group">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="text-slate-700 group-hover:text-slate-900">{{ __('messages.continue_guest') }}</span>
                </button>
            </div>

            <p class="text-center mt-6 text-sm text-slate-600">
                {{ __('messages.no_account') }} 
                <a href="{{ route('user.register') }}" class="text-indigo-600 font-bold hover:underline">
                    {{ __('messages.register') }}
                </a>
            </p>

            <p class="text-xs text-slate-400 text-center mt-6">
                Dengan menggunakan website ini, membeli tiket, atau membuat akun, Anda setuju dengan 
                <a href="#" class="text-indigo-600 hover:underline">{{ __('messages.terms') }}</a>
            </p>
        </div>
    </div>
</div>

<!-- Email Login Form Modal -->
<div id="emailLoginForm" class="fixed inset-0 z-[10000] hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeEmailLogin()"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md relative z-10 p-8">
            <button onclick="closeEmailLogin()" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 transition">
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            <h3 class="text-xl font-bold text-center mb-6">Login dengan Email</h3>
            <form action="#" method="POST" class="space-y-4">
                @csrf
                <input type="email" name="email" placeholder="Email" 
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
                <input type="password" name="password" placeholder="Password" 
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
                <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function showEmailLogin() {
    document.getElementById('emailLoginForm').classList.remove('hidden');
}

function closeEmailLogin() {
    document.getElementById('emailLoginForm').classList.add('hidden');
}
</script>
@endsection