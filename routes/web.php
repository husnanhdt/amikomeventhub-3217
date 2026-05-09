<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\TransactionController;

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

// ✅ Checkout: BUTUH {id} ← FIX ERROR ArgumentCountError
Route::get('/checkout/{id}', [EventController::class, 'checkout'])->name('checkout');

// Tambahkan di bawah route checkout
Route::post('/checkout/{id}/process', [EventController::class, 'process'])->name('checkout.process');

// Ticket: tidak butuh ID (menampilkan hasil pembayaran)
Route::get('/ticket', [EventController::class, 'ticket'])->name('ticket');

/*
|--------------------------------------------------------------------------
| ADMIN AREA - Dashboard & Management
|--------------------------------------------------------------------------
*/

// Group route admin dengan prefix dan naming convention
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // ✅ Kelola Event (Admin) - CRUD Resource
    Route::resource('events', AdminEventController::class);

    // Laporan Transaksi (Admin)
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    
});

// Logout route
Route::post('/logout', function () {
    // Untuk sementara, redirect ke home saja
    // Nanti kalau sudah ada autentikasi, gunakan: Auth::logout();
    return redirect('/')->with('success', 'Anda telah logout');
})->name('logout');