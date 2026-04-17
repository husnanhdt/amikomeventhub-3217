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
    return view('tentang');
});

// Route Kontak
Route::get('/contact', function () {
    return view('contact');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/event-detail', function () {
    return view('layouts.event-detail');
});

Route::get('/checkout', function () {
    return view('layouts.checkout');
});

Route::get('/ticket', function () {
    return view('layouts.ticket');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

// Route Admin Event
Route::get('/admin/events', function () {
    return view('admin.events');
}); 

// Route Transaksi
Route::get('/admin/transactions', function () {
    return view('admin.transactions');
});