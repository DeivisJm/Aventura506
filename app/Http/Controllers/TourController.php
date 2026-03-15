<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;

class TourController extends Controller
{
    /**
     * ======================================================
     * LIST OF TOURS WITH FILTER
     * ======================================================
     */
    public function index(Request $request)
    {
        $category = $request->get('category');

        $query = Tour::with('category')
            ->where('active', true);

        // SOLO filtrar si la categoría existe y no es ALL
        if ($category && $category !== 'all') {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        $tours = $query
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('pages.tours', compact('tours'));
    }

    /**
     * ======================================================
     * TOUR DETAIL WITH RELATION
     * ======================================================
     */
    public function show($slug)
    {
        $tour = Tour::with(['detail', 'prices', 'schedules', 'company'])
            ->where('slug', $slug)
            ->firstOrFail();
        return view('pages.tour_detail', compact('tour'));
    }
}
