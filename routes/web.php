<?php

use Illuminate\Support\Facades\Route;

// routes to navigate between pages
Route::get('/', fn() => view('pages.home'));
Route::get('/tours', fn() => view('pages.tours'));
Route::get('/accommodations', fn() => view('pages.accommodations'));
Route::get('/about_us', fn() => view('pages.about_us'));
Route::get('/contact', fn() => view('pages.contact'));


Route::get('/tours/{slug}', function ($slug) {

    /*
     * 🔴 TEMPORAL (mock)
     * Luego esto vendrá de la base de datos:
     * Tour::where('slug', $slug)->firstOrFail();
     */

    $tour = [
        'title' => 'Nature Tours La Fortuna',
        'category' => 'Naturaleza',
        'short_description' => 'Experiencias guiadas de naturaleza en La Fortuna.',
        'long_description' => 'Descubrí la biodiversidad de La Fortuna a través de caminatas guiadas, senderos ecológicos y observación de flora y fauna con guías certificados.',
        'image' => 'https://source.unsplash.com/1200x600/?rainforest,waterfall,costa-rica',
        'includes' => [
            'Caminatas guiadas',
            'Observación de flora y fauna',
            'Guías certificados',
            'Experiencia educativa'
        ],
        'ideal_for' => [
            'Amantes de la naturaleza',
            'Familias',
            'Parejas',
            'Turismo responsable'
        ],
    ];

    return view('pages.tour_detail', compact('tour'));
});
