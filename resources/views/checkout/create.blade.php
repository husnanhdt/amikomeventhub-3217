@extends('layouts.app')
@section('title', 'Checkout - ' . $event->title)
@section('content')
<main class="max-w-3xl mx-auto px-6 py-20">
    <div class="mb-12">
        <a href="{{ route('events.show', $event->id) }}" class="text-indigo-600 font-bold flex items-center gap-2 mb-6 hover:text-indigo-800 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Event
        </a>
        <h1 class="text-4xl font-extrabold">Checkout</h1>
        <p class="text-slate-500 mt-2">Lengkapi data Anda untuk mendapatkan tiket.</p>
    </div>

    @if(session('error'))
    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-xl font-bold border border-red-200">
        {{ session('error') }}
    </div>
    @endif

    <div class="grid grid-cols-1 gap-8">
        <!-- Summary Card -->
        <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
            <h3 class="text-xl font-bold mb-6 border-b pb-4">Pesanan Anda</h3>
            <div class="flex gap-6 items-start">
                <img src="{{ $event->poster_url ?? asset('images/default-poster.jpg') }}" alt="Event" class="w-24 h-24 rounded-2xl object-cover shadow-sm">
                <div>
                    <h4 class="font-extrabold text-lg">{{ $event->title }}</h4>
                    <p class="text-slate-500">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} • {{ $event->location }}</p>
                    <p class="text-indigo-600 font-bold mt-2">1 x Rp {{ number_format($event->price, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="mt-8 pt-6 border-t space-y-3">
                <div class="flex justify-between text-slate-500">
                    <span>Harga Tiket</span>
                    <span>Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-slate-500">
                    <span>Biaya Layanan</span>
                    <span>Rp 5.000</span>
                </div>
                <div class="flex justify-between text-2xl font-black mt-4 pt-4 border-t">
                    <span>Total Bayar</span>
                    <span class="text-indigo-600">Rp {{ number_format($event->price + 5000, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
            
            @auth
                <!-- ========================================== -->
                <!-- DATA PEMESAN: SUDAH LOGIN (AUTO-FILL) -->
                <!-- ========================================== -->
                <h3 class="text-xl font-bold mb-6 italic text-indigo-600 underline underline-offset-8">Data Pemesan</h3>
                <form action="{{ route('checkout.process', $event->id) }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Nama Lengkap (Read Only) -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Nama Lengkap</label>
                        <input type="text" value="{{ auth()->user()->name }}" readonly 
                               class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-slate-500 cursor-not-allowed font-medium">
                        <!-- Hidden input agar backend tetap menerima data dengan nama field yang sama -->
                        <input type="hidden" name="customer_name" value="{{ auth()->user()->name }}">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Email (Read Only) -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Email Aktif</label>
                            <input type="email" value="{{ auth()->user()->email }}" readonly 
                                   class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-slate-500 cursor-not-allowed font-medium">
                            <input type="hidden" name="customer_email" value="{{ auth()->user()->email }}">
                            <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-tighter">*E-Ticket akan dikirim ke email ini</p>
                        </div>

                        <!-- No. WhatsApp (Editable) -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">No. WhatsApp <span class="text-red-500">*</span></label>
                            <!-- PENTING: name tetap "customer_phone" agar tidak merusak logika backend kamu -->
                            <input type="tel" name="customer_phone" placeholder="08xxxxxxxxxx" 
                                   class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                                   required value="{{ old('customer_phone', auth()->user()->phone ?? '') }}">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 active:scale-95 transition-all">
                        Lanjut Pembayaran
                    </button>
                    <p class="text-center text-xs text-slate-400">Dengan menekan tombol di atas, Anda menyetujui Syarat & Ketentuan kami.</p>
                </form>

            @else
                <!-- ========================================== -->
                <!-- DATA PEMESAN: BELUM LOGIN (GUEST / MANUAL) -->
                <!-- ========================================== -->
                <div class="text-center mb-8">
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Checkout Lebih Cepat dengan Login</h3>
                    <p class="text-slate-500 text-sm mb-4">Data Anda akan otomatis terisi dan tiket tersimpan di riwayat.</p>
                    <a href="{{ route('login') }}?redirect={{ urlencode(url()->current()) }}" class="inline-block px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition mb-2">
                        Login Sekarang
                    </a>
                    
                    <div class="relative flex py-4 items-center">
                        <div class="flex-grow border-t border-slate-200"></div>
                        <span class="flex-shrink-0 mx-4 text-slate-400 text-xs font-bold uppercase">Atau isi manual di bawah</span>
                        <div class="flex-grow border-t border-slate-200"></div>
                    </div>
                </div>

                <h3 class="text-xl font-bold mb-6 italic text-slate-600 underline underline-offset-8">Data Pemesan (Manual)</h3>
                <form action="{{ route('checkout.process', $event->id) }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Nama Lengkap</label>
                        <input type="text" name="customer_name" placeholder="Masukkan nama sesuai identitas"
                            class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                            required value="{{ old('customer_name') }}">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">Email Aktif</label>
                            <input type="email" name="customer_email" placeholder="contoh@gmail.com"
                                class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                                required value="{{ old('customer_email') }}">
                            <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-tighter">*E-Ticket akan dikirim ke email ini</p>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">No. WhatsApp</label>
                            <input type="tel" name="customer_phone" placeholder="08xxxxxxx"
                                class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                                required value="{{ old('customer_phone') }}">
                        </div>
                    </div>
                    <button type="submit" class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 active:scale-95 transition-all">
                        Lanjut Pembayaran
                    </button>
                    <p class="text-center text-xs text-slate-400">Dengan menekan tombol di atas, Anda menyetujui Syarat & Ketentuan kami.</p>
                </form>
            @endauth

        </div>
    </div>
</main>
@endsection