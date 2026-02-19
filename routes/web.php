<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\TourController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| PÁGINAS PRINCIPALES
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

// Listado con filtro
Route::get('/tours', [TourController::class, 'index'])
    ->name('tours.index');

// Detalle por slug
Route::get('/tours/{slug}', [TourController::class, 'show'])
    ->name('tours.show');

/*
|--------------------------------------------------------------------------
| BOOKING
|--------------------------------------------------------------------------
*/

Route::post('/booking', [BookingController::class, 'store'])
    ->name('booking.store');

/*
|--------------------------------------------------------------------------
| CAMBIO DE IDIOMA
|--------------------------------------------------------------------------
*/

Route::get('/lang/{locale}', function ($locale) {
    if (! in_array($locale, ['es', 'en'])) {
        abort(400);
    }

    App::setLocale($locale);
    Session::put('locale', $locale);

    return redirect()->back();
})->name('lang.switch');
