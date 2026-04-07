<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Data mahasiswa (nanti bisa diganti dari database)
    $mahasiswa = [
        'nama' => 'Husnan Hidayat',
        'nim' => '24.12.3217',
        'kelas' => 'Digital Business 04',
    ];

    // Kirim data ke view 'welcome'
    return view('welcome', compact('mahasiswa'));
});
