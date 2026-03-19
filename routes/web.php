<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

/* CONTROLLERS */
use App\Http\Controllers\TourController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminTourController;
use App\Http\Controllers\Admin\AdminExchangeRateController;
use App\Http\Controllers\Admin\AdminUserController;

/* =====================================================
| PUBLIC WEBSITE ROUTES
===================================================== */

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/accommodations', fn() => view('pages.accommodations'))->name('accommodations');
Route::get('/about_us', fn() => view('pages.about_us'))->name('about');
Route::get('/contact', fn() => view('pages.contact'))->name('contact');

/* Tours */
Route::get('/tours', [TourController::class, 'index'])
    ->name('tours.index');

Route::get('/tours/{slug}', [TourController::class, 'show'])
    ->name('tours.show');

/* Booking */
Route::post('/booking', [BookingController::class, 'store'])
    ->name('booking.store');

/* Subscribe */
Route::post('/subscribe', [SubscriberController::class, 'store'])
    ->name('subscribe.store');

/* Contact */
Route::post('/contact/send', [ContactController::class, 'send'])
    ->name('contact.send');

/* =====================================================
| LANGUAGE SWITCH
===================================================== */
Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, ['es', 'en'])) {
        abort(400);
    }

    App::setLocale($locale);
    Session::put('locale', $locale);

    return redirect()->back();
})->name('lang.switch');

/* =====================================================
| AUTH ROUTES
===================================================== */
Route::get('/login', [AdminAuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AdminAuthController::class, 'login'])
    ->name('login.post');

Route::get('/register', [AdminAuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AdminAuthController::class, 'register'])
    ->name('register.post');

/* Optional: keep old admin URLs working temporarily */
Route::redirect('/admin/login', '/login');
Route::redirect('/admin/register', '/register');

/* =====================================================
| ADMIN PROTECTED ROUTES
===================================================== */
Route::prefix('admin')
    ->middleware(['auth', 'role:superadmin', 'no.cache'])
    ->group(function () {

        /* Dashboard */
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        /* Exchange Rates */
        Route::resource('exchange-rates', AdminExchangeRateController::class)
            ->names('admin.exchange_rates');

        /* Users */
        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('admin.users.index');

        Route::get('/users/create', [AdminUserController::class, 'create'])
            ->name('admin.users.create');

        Route::post('/users', [AdminUserController::class, 'store'])
            ->name('admin.users.store');

        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])
            ->name('admin.users.edit');

        Route::put('/users/{user}', [AdminUserController::class, 'update'])
            ->name('admin.users.update');

        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])
            ->name('admin.users.destroy');

        /* Subscribers */
        Route::get('/subscribers/{subscriber}/edit', [AdminUserController::class, 'editSubscriber'])
            ->name('admin.subscribers.edit');

        Route::put('/subscribers/{subscriber}', [AdminUserController::class, 'updateSubscriber'])
            ->name('admin.subscribers.update');

        Route::delete('/subscribers/{subscriber}', [AdminUserController::class, 'destroySubscriber'])
            ->name('admin.subscribers.destroy');

        /* Schedules */
        Route::post('/schedules/{schedule}/toggle', [AdminTourController::class, 'toggleSchedule'])
            ->name('admin.schedules.toggle');

        /* Tours */
        Route::get('/tours', [AdminTourController::class, 'index'])
            ->name('admin.tours.index');

        Route::get('/tours/create', [AdminTourController::class, 'create'])
            ->name('admin.tours.create');

        Route::post('/tours', [AdminTourController::class, 'store'])
            ->name('admin.tours.store');

        Route::get('/tours/{tour}/edit', [AdminTourController::class, 'edit'])
            ->name('admin.tours.edit');

        Route::put('/tours/{tour}', [AdminTourController::class, 'update'])
            ->name('admin.tours.update');

        Route::patch('/tours/{tour}/toggle', [AdminTourController::class, 'toggle'])
            ->name('admin.tours.toggle');

        /* Update manual tour position */
        Route::patch('/tours/{tour}/position', [AdminTourController::class, 'updatePosition'])
            ->name('admin.tours.update-position');

        /* Logout */
        Route::post('/logout', [AdminAuthController::class, 'logout'])
            ->name('admin.logout');
    });
