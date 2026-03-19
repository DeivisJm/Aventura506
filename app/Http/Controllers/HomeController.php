<?php

namespace App\Http\Controllers;

use App\Models\Tour;

class HomeController extends Controller
{
    public function index()
    {
        /* Get the first active tour based on public display order */
        $featuredTour = Tour::with(['prices'])
            ->where('active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->first();

        return view('pages.home', compact('featuredTour'));
    }
}