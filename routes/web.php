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

        // Redirect berdasarkan role
        if ($user->role === 'superadmin') {
            return redirect()->intended(route('superadmin.dashboard'));
        } elseif ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->role === 'organizer') {
            return redirect()->intended(route('organizer.dashboard'));
        }

        return redirect()->intended(route('home'));
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
        Route::resource('categories', CategoryController::class);
        Route::resource('partners', PartnerController::class);
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    });

    Route::get('/organizers', [AdminOrganizerController::class, 'index'])->name('organizers.index');
    Route::get('/organizers/{id}/edit', [AdminOrganizerController::class, 'edit'])->name('organizers.edit');
    Route::delete('/organizers/{id}', [AdminOrganizerController::class, 'destroy'])->name('organizers.destroy');

        Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
Route::delete('/reviews/{id}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

        Route::get('/users', function () {
            return view('admin.users.index'); // Nanti diganti dengan controller
        })->name('users.index');

        Route::get('/settings', function () {
            return view('admin.settings'); // Nanti diganti dengan controller
        })->name('settings');
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
    Route::get('/dashboard', function () {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_organizers' => \App\Models\User::where('role', 'organizer')->count(),
            'total_admins' => \App\Models\User::where('role', 'admin')->count(),
            'total_events' => \App\Models\Event::count(),
            'total_revenue' => \App\Models\Transaction::whereIn('status', ['success', 'paid', 'settlement'])->sum('total_price'),
            'pending_partners' => \App\Models\Partner::where('status', 'pending')->count(),
        ];
        
        $recentActivities = \App\Models\Transaction::with(['user', 'event'])
            ->latest()
            ->take(10)
            ->get();
        
        return view('superadmin.dashboard', compact('stats', 'recentActivities'));
    })->name('dashboard');
    
    // Manage Users
    Route::get('/users', function () {
        $users = \App\Models\User::with('partner')->latest()->paginate(20);
        return view('superadmin.users.index', compact('users'));
    })->name('users.index');
    
    // Manage Organizers (Approve/Reject)
    Route::get('/organizers', function () {
        $organizers = \App\Models\User::where('role', 'organizer')
            ->with('partner')
            ->latest()
            ->paginate(20);
        return view('superadmin.organizers.index', compact('organizers'));
    })->name('organizers.index');
    
    Route::post('/organizers/{id}/approve', function ($id) {
        $user = \App\Models\User::findOrFail($id);
        if ($user->partner) {
            $user->partner->update(['status' => 'approved']);
        }
        return back()->with('success', 'Organizer disetujui');
    })->name('organizers.approve');
    
    // System Settings
    Route::get('/settings', function () {
        return view('superadmin.settings');
    })->name('settings');
});

// Checkout Routes - WAJIB LOGIN
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout/{id}', [EventController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/{id}/process', [EventController::class, 'process'])->name('checkout.process');
});