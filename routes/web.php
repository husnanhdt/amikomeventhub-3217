<?php

use Illuminate\Support\Facades\Route;

// Route Home
Route::get('/', function () {
    return view('welcome');
});

// Route Profil
Route::get('/profil', function () {
    return view('profil');
});

// Route Katalog
Route::get('/katalog', function () {
    return view('katalog');
});

// Route Bantuan
Route::get('/bantuan', function () {
    return view('bantuan');
});

Route::get('/tentang', function () {
    return '<h1>Ini adalah Halaman Tentang Aplikasi Event Hub</h1>';
});

// Route Kontak
Route::get('/contact', function () {
    return view('contact');
});
