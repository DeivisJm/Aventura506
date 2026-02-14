<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\BookingController;

/*PÁGINAS PRINCIPALES*/
Route::get('/', fn() => view('pages.home'))->name('home');

Route::get('/tours', fn() => view('pages.tours'))
    ->name('tours');

Route::get('/accommodations', fn() => view('pages.accommodations'))
    ->name('accommodations');

Route::get('/about_us', fn() => view('pages.about_us'))
    ->name('about');

Route::get('/contact', fn() => view('pages.contact'))
    ->name('contact');


/*
|--------------------------------------------------------------------------
| TOURS
|--------------------------------------------------------------------------
| Ya preparados para Base de Datos + Admin
*/

// Listado de tours
Route::get('/tours', [TourController::class, 'index'])
    ->name('tours.index');

// Detalle (una sola página para TODOS los tours)
Route::get('/tours/{slug}', [TourController::class, 'show'])
    ->name('tours.show');

//Change language
Route::get('/lang/{locale}', function ($locale) {
    if (! in_array($locale, ['es', 'en'])) {
        abort(400);
    }

    App::setLocale($locale);
    Session::put('locale', $locale);

    return redirect()->back();
})->name('lang.switch');

//route email booking
Route::post('/booking', [BookingController::class, 'store'])
    ->name('booking.store');
