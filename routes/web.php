<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==========================================
// 1. IMPORT CONTROLLERS
// ==========================================
// User & Public Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\TransactionHistoryController;
use App\Http\Controllers\TicketHistoryController;
use App\Http\Controllers\TicketController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PartnerController;

/*
|--------------------------------------------------------------------------
| 2. GLOBAL & LANGUAGE ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');


/*
|--------------------------------------------------------------------------
| 3. PUBLIC & USER AREA (Tanpa Auth / Bisa Diakses Siapa Saja)
|--------------------------------------------------------------------------
*/
// Home & Halaman Statis
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', fn() => view('profil'))->name('profil');
Route::get('/katalog', fn() => view('katalog'))->name('katalog');
Route::get('/bantuan', fn() => view('bantuan'))->name('bantuan');
Route::get('/tentang', fn() => view('tentang'))->name('tentang');
Route::get('/contact', fn() => view('contact'))->name('contact');

// Detail Event & Profil Penyelenggara
Route::get('/event-detail/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/organizer/{partner}', [OrganizerController::class, 'show'])->name('organizers.show');

// Tampilan Form Login & Register User
Route::get('/user/login', function () {
    return view('auth.login');
})->name('user.login');

Route::get('/user/register', function () {
    return view('auth.register');
})->name('user.register');

// Fallback: Jika user mengetik /login, arahkan ke halaman login user
Route::get('/login', function () {
    return redirect()->route('user.login');
})->name('login');

// ✅ PERBAIKAN: Google SSO WAJIB DI LUAR middleware 'auth' agar user belum login bisa akses
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Halaman Profil User
Route::get('/user/profile', function () {
    return redirect('/')->with('openProfile', true);
})->name('user.profile');

/*
|--------------------------------------------------------------------------
| 4. USER AUTHENTICATION & PROFILE (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Aksi Register (POST)
    Route::post('/user/register', [RegisterController::class, 'register'])->name('register.post');

    // Update Profil User (Termasuk Upload Avatar)
    Route::put('/user/profile/update', [ProfileController::class, 'update'])->name('user.profile.update');

    // Logout User Biasa
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/')->with('success', 'Anda telah logout');
    })->name('logout');

    // Buat Review (Hanya user yang sudah login)
    Route::get('/event/{event}/review', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/event/{event}/review', [ReviewController::class, 'store'])->name('reviews.store');

    // Riwayat Transaksi & Tiket
    Route::get('/transaction-history', [TransactionHistoryController::class, 'index'])->name('transaction.history');
    Route::get('/ticket-history', [TicketHistoryController::class, 'index'])->name('ticket.history');

    // User Ticket Routes
    Route::get('/my-tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/ticket/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    
    // Check-in route (untuk panitia)
    Route::post('/ticket/{ticket}/checkin', [TicketController::class, 'checkIn'])->name('tickets.checkin');

    Route::put('/user/change-password', [ProfileController::class, 'changePassword'])->name('user.change-password');
});


/*
|--------------------------------------------------------------------------
| 5. CHECKOUT & TRANSACTIONS (User Side)
|--------------------------------------------------------------------------
*/
Route::get('/checkout/{id}', [EventController::class, 'checkout'])->name('checkout');
Route::post('/checkout/{id}/process', [EventController::class, 'process'])->name('checkout.process');
Route::get('/ticket/{id?}', [EventController::class, 'ticket'])->name('ticket');
Route::get('/payment/{order_id}', [EventController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [EventController::class, 'success'])->name('checkout.success');

// Midtrans Webhook (Tanpa CSRF Token agar bisa diterima dari server Midtrans)
Route::post('/midtrans/callback', [MidtransWebhookController::class, 'handle'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);


/*
|--------------------------------------------------------------------------
| 6. PUBLIC REVIEWS (Tanpa Auth / Bisa Diakses Siapa Saja)
|--------------------------------------------------------------------------
*/
Route::get('/event/{event}/reviews', [ReviewController::class, 'index'])->name('reviews.index');


/*
|--------------------------------------------------------------------------
| 7. ADMIN AREA (Protected)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // A. Admin Auth (Bebas akses, tidak butuh middleware auth)
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminLoginController::class, 'login']);
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');

    // B. Admin Dashboard & Management (WAJIB login DAN punya role admin)
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('events', AdminEventController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('partners', PartnerController::class);

        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    });
});
