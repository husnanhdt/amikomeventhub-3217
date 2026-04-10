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