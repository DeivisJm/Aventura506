<?php

use Illuminate\Support\Facades\Route;

// routes to navigate between pages
Route::get('/', fn() => view('pages.home'));
Route::get('/contact', fn() => view('pages.contact'));
Route::get('/destinations', fn() => view('pages.destinations'));
Route::get('/packages', fn() => view('pages.packages'));

use App\Http\Controllers\ContactController;

Route::post('/contact/send', [ContactController::class, 'send'])
    ->name('contact.send');

