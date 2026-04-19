<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Category;

class TourController extends Controller
{
    /**
     * ======================================================
     * LIST OF TOURS WITH SMART FILTER
     * ======================================================
     */
    public function index(Request $request)
    {
        $category = $request->get('category', 'all');
        $search = trim((string) $request->get('search', ''));

        $categories = Category::orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.es')) ASC")->get();

        $query = Tour::with('category')
            ->where('active', true);

        // Filter by selected category slug
        if (!empty($category) && $category !== 'all') {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category);
            });
        }

        // Smart search by tour name, description, and category
        if ($search !== '') {
            $searchLike = '%' . $search . '%';

            $query->where(function ($q) use ($searchLike) {
                $q->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.es')) LIKE ?", [$searchLike])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.en')) LIKE ?", [$searchLike])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(description, '$.es')) LIKE ?", [$searchLike])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(description, '$.en')) LIKE ?", [$searchLike])
                    ->orWhereHas('category', function ($categoryQuery) use ($searchLike) {
                        $categoryQuery->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.es')) LIKE ?", [$searchLike])
                            ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.en')) LIKE ?", [$searchLike]);
                    });
            });
        }

        $tours = $query
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(9)
            ->appends($request->query());

        return view('pages.tours', compact('tours', 'categories'));
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