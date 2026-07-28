@extends('layouts.organizer')

@section('page_title', 'Profil Penyelenggara')
@section('page_subtitle', 'Kelola informasi akun dan organisasi Anda.')

@section('content')
<div class="max-w-4xl">
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('organizer.profile.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Card 1: Informasi Akun Login -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 01-7 7h14a7 7 0 01-7-7z"></path>
                </svg>
                Informasi Akun Login
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>
            </div>
        </div>

        <!-- Card 2: Informasi Organisasi -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Informasi Organisasi / HIMA
            </h3>
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Organisasi</label>
                    <input type="text" name="partner_name" value="{{ old('partner_name', $partner->name ?? '') }}" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi Organisasi</label>
                    <textarea name="partner_description" rows="4" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">{{ old('partner_description', $partner->description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Tombol Simpan -->
        <div class="flex justify-end">
            <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection