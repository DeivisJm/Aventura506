<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Category;
use Illuminate\Http\Request;

class AccommodationController extends Controller
{
    public function index(Request $request)
    {
        $currentCategory = $request->get('category', 'all');

        $categories = Category::all();

        $query = Accommodation::query()
            ->where('is_active', true)
            ->with(['category', 'company'])
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('id');

        if ($currentCategory !== 'all') {
            $query->whereHas('category', function ($q) use ($currentCategory) {
                $q->where('slug', $currentCategory);
            });
        }

        $accommodations = $query->paginate(9)->withQueryString();

        return view('pages.accommodations', compact(
            'accommodations',
            'categories',
            'currentCategory'
        ));
    }

    public function show(string $slug)
    {
        $accommodation = Accommodation::with(['category', 'company'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('pages.accommodations_detail', compact('accommodation'));
    }
}