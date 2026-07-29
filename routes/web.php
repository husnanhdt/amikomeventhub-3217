<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
use App\Http\Controllers\Admin\OrganizerController as AdminOrganizerController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;

// Organizer Controllers
use App\Http\Controllers\Organizer\DashboardController as OrganizerDashboardController;
use App\Http\Controllers\Organizer\EventController as OrganizerEventController;
use App\Http\Controllers\Organizer\TransactionController as OrganizerTransactionController;

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
// Halaman Tentang Kami
Route::get('/tentang-kami', function () {
    $stats = [
        'events' => \App\Models\Event::where('date', '>=', now())->count(),
        'tickets' => \App\Models\Transaction::whereIn('status', ['success', 'paid', 'settlement'])->count(),
        'categories' => \App\Models\Category::count(),
        // ✅ UBAH INI: Hitung semua partner (tanpa filter status)
        'partners' => \App\Models\Partner::count(),
        // Atau jika mau yang approved saja:
        // 'partners' => \App\Models\Partner::where('status', 'approved')->count(),
    ];

    return view('tentang-kami', compact('stats'));
})->name('tentang-kami');
Route::get('/contact', fn() => view('contact'))->name('contact');

// Detail Event & Profil Penyelenggara
Route::get('/event-detail/{id}', [EventController::class, 'show'])->name('events.show');


// Tampilan Form Login & Register User
Route::get('/user/login', function () {
    return view('auth.login');
})->name('user.login');

Route::get('/user/register', function () {
    return view('auth.register');
})->name('user.register');

// ✅ PROSES REGISTRASI (HANYA ADA 1 KALI, DI LUAR AUTH MIDDLEWARE)
Route::post('/user/register', [RegisterController::class, 'register'])->name('register.post');

// Fallback: Jika user mengetik /login
Route::get('/login', function () {
    return redirect()->route('user.login');
})->name('login');

// ✅ PROSES LOGIN
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        $user = Auth::user();

        // Hapus intended URL agar tidak bentrok dengan role redirect
        session()->forget('url.intended');

        // Redirect berdasarkan role (PAKSA, tidak pakai intended)
        if ($user->role === 'superadmin') {
            return redirect()->route('superadmin.dashboard');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'organizer') {
            return redirect()->route('organizer.dashboard');
        }

        return redirect()->route('home');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
})->name('login');

// Google SSO
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])->name('auth.google.callback');

/*
|--------------------------------------------------------------------------
| 4. USER AUTHENTICATION & DASHBOARD (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Update Profil User
    Route::put('/user/profile/update', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::put('/user/change-password', [ProfileController::class, 'changePassword'])->name('user.change-password');

    // Logout User
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/')->with('success', 'Anda telah logout');
    })->name('logout');

    // Review & Rating
    Route::get('/event/{event}/review', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/event/{event}/review', [ReviewController::class, 'store'])->name('reviews.store');

    // Riwayat Transaksi & Tiket
    Route::get('/transaction-history', [TransactionHistoryController::class, 'index'])->name('transaction.history');
    Route::get('/ticket-history', [TicketHistoryController::class, 'index'])->name('ticket.history');

    // Manajemen Tiket User
    Route::get('/my-tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/my-tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/my-tickets/{ticket}/checkin', [TicketController::class, 'checkIn'])->name('tickets.checkin');
});

/*
|--------------------------------------------------------------------------
| 5. CHECKOUT, PAYMENT & E-TICKET (User Side)
|--------------------------------------------------------------------------
*/
Route::get('/checkout/{id}', [EventController::class, 'checkout'])->name('checkout');
Route::post('/checkout/{id}/process', [EventController::class, 'process'])->name('checkout.process');
Route::get('/payment/{order_id}', [EventController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [EventController::class, 'success'])->name('checkout.success');
Route::get('/ticket/{id?}', [EventController::class, 'ticket'])->name('ticket');

// Midtrans Webhook
Route::post('/midtrans/callback', [MidtransWebhookController::class, 'handle'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

/*
|--------------------------------------------------------------------------
| 6. PUBLIC REVIEWS (Tanpa Auth)
|--------------------------------------------------------------------------
*/
Route::get('/event/{event}/reviews', [ReviewController::class, 'index'])->name('reviews.index');

/*
|--------------------------------------------------------------------------
| 7. ADMIN AREA (Protected)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminLoginController::class, 'login']);
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout');

    Route::post('partners/{id}/approve', [PartnerController::class, 'approve'])->name('partners.approve');
    Route::post('partners/{id}/reject', [PartnerController::class, 'reject'])->name('partners.reject');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('events', AdminEventController::class);
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::resource('categories', CategoryController::class);
        Route::resource('partners', PartnerController::class);
        Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('transactions/export-excel', [TransactionController::class, 'exportExcel'])->name('transactions.export.excel');
        Route::get('transactions/export-pdf', [TransactionController::class, 'exportPdf'])->name('transactions.export.pdf');
    });

    // Organizer Management
    Route::get('/organizers', [AdminOrganizerController::class, 'index'])->name('organizers.index');
    Route::get('/organizers/create', [AdminOrganizerController::class, 'create'])->name('organizers.create');
    Route::post('/organizers', [AdminOrganizerController::class, 'store'])->name('organizers.store');
    Route::get('/organizers/{id}/edit', [AdminOrganizerController::class, 'edit'])->name('organizers.edit');
    Route::put('/organizers/{id}', [AdminOrganizerController::class, 'update'])->name('organizers.update');
    Route::delete('/organizers/{id}', [AdminOrganizerController::class, 'destroy'])->name('organizers.destroy');

    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{id}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/users', function () {
        return view('admin.users.index'); // Nanti diganti dengan controller
    })->name('users.index');

    // Route untuk MENAMPILKAN halaman settings (GET)
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('settings');

    // ✅ BARU: Route untuk MENYIMPAN data settings (POST)
    Route::post('/settings', function (\Illuminate\Http\Request $request) {
        // Nanti di sini logika untuk save ke database atau config
        // Untuk sekarang, kita kembalikan ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Pengaturan sistem berhasil diperbarui!');
    })->name('settings.update');
});

/*
|--------------------------------------------------------------------------
| 8. ORGANIZER AREA (Multi-Tenant Dashboard)
|--------------------------------------------------------------------------
*/
Route::prefix('organizer')->name('organizer.')->middleware(['auth', 'organizer'])->group(function () {
    Route::get('/dashboard', [OrganizerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/events', [OrganizerEventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [OrganizerEventController::class, 'create'])->name('events.create');
    Route::post('/events', [OrganizerEventController::class, 'store'])->name('events.store');
    Route::get('/transactions', [OrganizerTransactionController::class, 'index'])->name('transactions.index');
    Route::get('/profile', [\App\Http\Controllers\Organizer\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\Organizer\ProfileController::class, 'update'])->name('profile.update');

    Route::get('/tickets', [\App\Http\Controllers\Organizer\TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{event}', [\App\Http\Controllers\Organizer\TicketController::class, 'show'])->name('tickets.show');

    Route::get('/reviews', [\App\Http\Controllers\Organizer\ReviewController::class, 'index'])->name('reviews.index');

    Route::get('/statistics', [\App\Http\Controllers\Organizer\StatisticsController::class, 'index'])->name('statistics.index');
    Route::get('/events', [OrganizerEventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [OrganizerEventController::class, 'create'])->name('events.create');
    Route::post('/events', [OrganizerEventController::class, 'store'])->name('events.store');
    Route::get('/events/{id}/edit', [OrganizerEventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{id}', [OrganizerEventController::class, 'update'])->name('events.update');
    Route::delete('/events/{id}', [OrganizerEventController::class, 'destroy'])->name('events.destroy');
    Route::get('/transactions/export-excel', [OrganizerTransactionController::class, 'exportExcel'])->name('transactions.export.excel');
    Route::get('/transactions/export-pdf', [OrganizerTransactionController::class, 'exportPdf'])->name('transactions.export.pdf');
});

Route::get('/organizer/{partner}', [OrganizerController::class, 'show'])->name('organizer.show');

// Halaman Cara Pesan
Route::get('/cara-pesan', function () {
    return view('how-to-order');
})->name('how-to-order');

// Halaman Kategori (Tampilin semua kategori)
Route::get('/kategori', function () {
    $categories = \App\Models\Category::withCount(['events' => function ($query) {
        $query->where('date', '>=', now());
    }])->get();

    return view('categories.index', compact('categories'));
})->name('categories.index');

// Halaman Kategori dengan Event
Route::get('/kategori/{slug}', function ($slug) {
    $category = \App\Models\Category::where('slug', $slug)->firstOrFail();

    // Ambil semua kategori untuk ditampilkan
    $categories = \App\Models\Category::withCount(['events' => function ($query) {
        $query->where('date', '>=', now());
    }])->get();

    // Ambil event dari kategori yang dipilih
    $events = $category->events()
        ->where('date', '>=', now())
        ->orderBy('date', 'asc')
        ->get();

    // Tampilkan view categories.index dengan data category dan events
    return view('categories.index', compact('categories', 'category', 'events'));
})->name('categories.show');

/*
|--------------------------------------------------------------------------
| 9. SUPERADMIN AREA (Full Access)
|--------------------------------------------------------------------------
*/
Route::prefix('superadmin')->name('superadmin.')->middleware(['auth', 'superadmin'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Superadmin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/transactions', [\App\Http\Controllers\Superadmin\TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/export-excel', [\App\Http\Controllers\Superadmin\TransactionController::class, 'exportExcel'])->name('transactions.export.excel');
    Route::get('/transactions/export-pdf', [\App\Http\Controllers\Superadmin\TransactionController::class, 'exportPdf'])->name('transactions.export.pdf');
    Route::get('/transactions/{id}', [\App\Http\Controllers\Superadmin\TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/transactions/{id}/print', [\App\Http\Controllers\Superadmin\TransactionController::class, 'printTicket'])->name('transactions.print');
    
    // ✅ KELOLA ORGANISASI
    Route::get('/organizations', [\App\Http\Controllers\Superadmin\OrganizationController::class, 'index'])->name('organizations.index');
    Route::get('/organizations/{id}', [\App\Http\Controllers\Superadmin\OrganizationController::class, 'show'])->name('organizations.show');
    Route::get('/organizations/{id}/edit', [\App\Http\Controllers\Superadmin\OrganizationController::class, 'edit'])->name('organizations.edit');
    Route::put('/organizations/{id}', [\App\Http\Controllers\Superadmin\OrganizationController::class, 'update'])->name('organizations.update');
    Route::post('/organizations/{id}/approve', [\App\Http\Controllers\Superadmin\OrganizationController::class, 'approve'])->name('organizations.approve');
    Route::post('/organizations/{id}/reject', [\App\Http\Controllers\Superadmin\OrganizationController::class, 'reject'])->name('organizations.reject');
    Route::delete('/organizations/{id}', [\App\Http\Controllers\Superadmin\OrganizationController::class, 'destroy'])->name('organizations.destroy');
    Route::get('/organizations/export', [\App\Http\Controllers\Superadmin\OrganizationController::class, 'export'])->name('organizations.export');

// Kategori (CRUD)
    Route::get('/categories', [\App\Http\Controllers\Superadmin\CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [\App\Http\Controllers\Superadmin\CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [\App\Http\Controllers\Superadmin\CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [\App\Http\Controllers\Superadmin\CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [\App\Http\Controllers\Superadmin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [\App\Http\Controllers\Superadmin\CategoryController::class, 'destroy'])->name('categories.destroy');

// ✅ KELOLA PARTNER
    Route::get('/partners', [\App\Http\Controllers\Superadmin\PartnerController::class, 'index'])->name('partners.index');
    Route::post('/partners/{id}/approve', [\App\Http\Controllers\Superadmin\PartnerController::class, 'approve'])->name('partners.approve');
    Route::post('/partners/{id}/reject', [\App\Http\Controllers\Superadmin\PartnerController::class, 'reject'])->name('partners.reject');
    Route::get('/partners/{id}', [\App\Http\Controllers\Superadmin\PartnerController::class, 'show'])->name('partners.show');
    Route::delete('/partners/{id}', [\App\Http\Controllers\Superadmin\PartnerController::class, 'destroy'])->name('partners.destroy');

     // ✅ REVIEW & MODERASI
    Route::get('/reviews', [\App\Http\Controllers\Superadmin\ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/{id}', [\App\Http\Controllers\Superadmin\ReviewController::class, 'show'])->name('reviews.show');
    Route::post('/reviews/{id}/approve', [\App\Http\Controllers\Superadmin\ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{id}/reject', [\App\Http\Controllers\Superadmin\ReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('/reviews/{id}', [\App\Http\Controllers\Superadmin\ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/reviews/bulk-action', [\App\Http\Controllers\Superadmin\ReviewController::class, 'bulkAction'])->name('reviews.bulk-action');
    Route::get('/reviews/export', [\App\Http\Controllers\Superadmin\ReviewController::class, 'export'])->name('reviews.export');

    // ✅ PENGELOLA PENGURUS/ADMIN
    Route::get('/admins', [\App\Http\Controllers\Superadmin\AdminController::class, 'index'])->name('admins.index');
    Route::get('/admins/create', [\App\Http\Controllers\Superadmin\AdminController::class, 'create'])->name('admins.create');
    Route::post('/admins', [\App\Http\Controllers\Superadmin\AdminController::class, 'store'])->name('admins.store');
    Route::get('/admins/{id}', [\App\Http\Controllers\Superadmin\AdminController::class, 'show'])->name('admins.show');
    Route::get('/admins/{id}/edit', [\App\Http\Controllers\Superadmin\AdminController::class, 'edit'])->name('admins.edit');
    Route::put('/admins/{id}', [\App\Http\Controllers\Superadmin\AdminController::class, 'update'])->name('admins.update');
    Route::delete('/admins/{id}', [\App\Http\Controllers\Superadmin\AdminController::class, 'destroy'])->name('admins.destroy');
    Route::post('/admins/{id}/reset-password', [\App\Http\Controllers\Superadmin\AdminController::class, 'resetPassword'])->name('admins.reset-password');

    // ✅ PASTIKAN ROUTE INI ADA:
    Route::get('/events', [OrganizerEventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [OrganizerEventController::class, 'create'])->name('events.create');
    Route::post('/events', [OrganizerEventController::class, 'store'])->name('events.store');
    Route::get('/events/{id}/edit', [OrganizerEventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{id}', [OrganizerEventController::class, 'update'])->name('events.update');
    Route::delete('/events/{id}', [OrganizerEventController::class, 'destroy'])->name('events.destroy');
    

    // Manage Users (Opsional, bisa dikembangkan nanti)
    Route::get('/users', function () {
        $users = \App\Models\User::with('partner')->latest()->paginate(20);
        return view('superadmin.users.index', compact('users'));
    })->name('users.index');
});

// Checkout Routes - WAJIB LOGIN
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout/{id}', [EventController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/{id}/process', [EventController::class, 'process'])->name('checkout.process');
});
