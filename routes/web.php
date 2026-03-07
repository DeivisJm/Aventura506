<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

/*CONTROLLERS*/
use App\Http\Controllers\TourController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminAuthController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminTourController;
use App\Http\Controllers\Admin\AdminExchangeRateController;

/*PUBLIC WEBSITE ROUTES*/

Route::get('/', fn() => view('pages.home'))->name('home');
Route::get('/accommodations', fn() => view('pages.accommodations'))->name('accommodations');
Route::get('/about_us', fn() => view('pages.about_us'))->name('about');
Route::get('/contact', fn() => view('pages.contact'))->name('contact');

/*TOURS (Public)*/
Route::get('/tours', [TourController::class, 'index'])
    ->name('tours.index');

Route::get('/tours/{slug}', [TourController::class, 'show'])
    ->name('tours.show');


/*BOOKINGS*/
Route::post('/booking', [BookingController::class, 'store'])
    ->name('booking.store');

/*SUBSCRIBE*/
Route::post('/subscribe', [SubscriberController::class, 'store'])
    ->name('subscribe.store');

/*CONTACT FORM*/
Route::post('/contact/send', [ContactController::class, 'send'])
    ->name('contact.send');


/*LANGUAGE SWITCH*/
Route::get('/lang/{locale}', function ($locale) {

    if (!in_array($locale, ['es', 'en'])) {
        abort(400);
    }

    App::setLocale($locale);
    Session::put('locale', $locale);

    return redirect()->back();
})->name('lang.switch');


/*ADMIN AUTH ROUTES*/
Route::prefix('admin')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'showLogin'])
        ->name('admin.login');

    Route::post('/login', [AdminAuthController::class, 'login'])
        ->name('admin.login.post');
});


/*ADMIN PROTECTED ROUTES*/
Route::prefix('admin')
    ->middleware(['auth', 'role:superadmin'])
    ->group(function () {

        /*Dashboard*/
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        /*Exchange Rates*/
        Route::resource('exchange-rates', AdminExchangeRateController::class)
            ->names('admin.exchange_rates');

        /* Change schedule status */
        Route::post('/schedules/{schedule}/toggle', [AdminTourController::class, 'toggleSchedule'])
            ->name('admin.schedules.toggle');

        /*Tour Management Full CRUD for tours*/
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


        /*Logout*/
        Route::post('/logout', [AdminAuthController::class, 'logout'])
            ->name('admin.logout');
    });
