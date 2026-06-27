<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController; // ← Import untuk Auth
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;


/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES (PUBLIC - Untuk Admin Login)
|--------------------------------------------------------------------------
*/
// ✅ Tambahkan route 'login' yang redirect ke admin login
Route::get('/login', function() {
    return redirect()->route('admin.login');
})->name('login');

// Route login admin yang sudah ada
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');


/*
|--------------------------------------------------------------------------
| USER AREA - Public Pages
|--------------------------------------------------------------------------
*/

// Halaman utama (pakai Controller)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman statis (boleh tetap closure - sesuai modul)
Route::get('/profil', fn() => view('profil'))->name('profil');
Route::get('/katalog', fn() => view('katalog'))->name('katalog');
Route::get('/bantuan', fn() => view('bantuan'))->name('bantuan');
Route::get('/tentang', fn() => view('tentang'))->name('tentang');
Route::get('/contact', fn() => view('contact'))->name('contact');

// ✅ Alur pemesanan event (pakai Controller) - USER SIDE
// Detail event: butuh {id}
Route::get('/event-detail/{id}', [EventController::class, 'show'])->name('events.show');

// ✅ USER AREA - Checkout Routes
Route::get('/checkout/{id}', [EventController::class, 'checkout'])->name('checkout');
Route::post('/checkout/{id}/process', [EventController::class, 'process'])->name('checkout.process');

// Ticket: tidak butuh ID (menampilkan hasil pembayaran)
Route::get('/ticket/{id?}', [EventController::class, 'ticket'])->name('ticket');

Route::get('/payment/{order_id}', [\App\Http\Controllers\EventController::class, 'payment'])->name('checkout.payment');

Route::get('/success/{order_id}', [\App\Http\Controllers\EventController::class, 'success'])->name('checkout.success');
/*
|--------------------------------------------------------------------------
| ADMIN AREA - Dashboard & Management (PROTECTED)
|--------------------------------------------------------------------------
*/

// Group route admin dengan prefix dan naming convention
// ✅ Tambahkan ->middleware('auth') agar semua route admin wajib login dulu
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kelola Event (Admin) - CRUD Resource
    Route::resource('events', AdminEventController::class);

    // Laporan Transaksi (Admin)
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

    // Category Routes
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);

    // Partner Routes
    Route::resource('partners', \App\Http\Controllers\Admin\PartnerController::class);

});

// Logout route (standalone - untuk user biasa jika ada)
Route::post('/logout', function () {
    // Untuk sementara, redirect ke home saja
    // Nanti kalau sudah ada autentikasi, gunakan: Auth::logout();
    return redirect('/')->with('success', 'Anda telah logout');
})->name('logout');