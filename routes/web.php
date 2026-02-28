<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\TourController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminAuthController;

/*
|--------------------------------------------------------------------------
| PUBLIC PAGE ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('pages.home'))->name('home');
Route::get('/accommodations', fn() => view('pages.accommodations'))->name('accommodations');
Route::get('/about_us', fn() => view('pages.about_us'))->name('about');
Route::get('/contact', fn() => view('pages.contact'))->name('contact');

/*
|--------------------------------------------------------------------------
| TOURS
|--------------------------------------------------------------------------
*/

Route::get('/tours', [TourController::class, 'index'])
    ->name('tours.index');

Route::get('/tours/{slug}', [TourController::class, 'show'])
    ->name('tours.show');

/*
|--------------------------------------------------------------------------
| BOOKINGS
|--------------------------------------------------------------------------
*/

Route::post('/booking', [BookingController::class, 'store'])
    ->name('booking.store');

/*
|--------------------------------------------------------------------------
| SUBSCRIBE
|--------------------------------------------------------------------------
*/

Route::post('/subscribe', [SubscriberController::class, 'store'])
    ->name('subscribe.store');

/*
|--------------------------------------------------------------------------
| CONTACT
|--------------------------------------------------------------------------
*/

Route::post('/contact/send', [ContactController::class, 'send'])
    ->name('contact.send');

/*
|--------------------------------------------------------------------------
| LANGUAGE SWITCH
|--------------------------------------------------------------------------
*/

Route::get('/lang/{locale}', function ($locale) {

    if (!in_array($locale, ['es', 'en'])) {
        abort(400);
    }

    App::setLocale($locale);
    Session::put('locale', $locale);

    return redirect()->back();
})->name('lang.switch');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'showLogin'])
        ->name('admin.login');

    Route::post('/login', [AdminAuthController::class, 'login'])
        ->name('admin.login.post');

    Route::middleware(['auth', 'role:superadmin'])->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::post('/logout', [AdminAuthController::class, 'logout'])
            ->name('admin.logout');
    });
});
