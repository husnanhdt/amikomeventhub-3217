<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $mahasiswa = [
        'nama' => 'Husnan Hidayat',
        'nim' => '24.12.3217',
        'kelas' => 'Digital Business 04',
    ];

    return view('welcome', compact('mahasiswa'));
});

Route::get('/tentang', function () {
    return '<h1>Ini adalah halaman Tentang Aplikasi Event Hub</h1>';
});

Route::get('/kontak', function () {
    return view('contact');
});