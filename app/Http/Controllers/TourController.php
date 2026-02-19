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
        $query = Tour::where('is_active', 1);

        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        $tours = $query->orderBy('created_at', 'desc')->get();

        return view('pages.tours', compact('tours'));
    }

    /**
     * ======================================================
     * TOUR DETAIL WITH RELATION
     * ======================================================
     */
    public function show($slug)
    {
        $tour = Tour::with(['detail', 'prices', 'schedules'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('pages.tour_detail', compact('tour'));
    }
}
