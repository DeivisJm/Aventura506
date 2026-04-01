<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use Illuminate\Http\Request;

class AccommodationController extends Controller
{
    /**
     * Display the public accommodations page.
     */
    public function index(Request $request)
    {
        $query = Accommodation::query()
            ->where('is_active', true);

        /**
         * Apply text search across translated JSON fields.
         */
        if ($request->filled('search')) {
            $search = trim((string) $request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name->es', 'like', "%{$search}%")
                    ->orWhere('name->en', 'like', "%{$search}%")
                    ->orWhere('short_description->es', 'like', "%{$search}%")
                    ->orWhere('short_description->en', 'like', "%{$search}%")
                    ->orWhere('location->es', 'like', "%{$search}%")
                    ->orWhere('location->en', 'like', "%{$search}%");
            });
        }

        /**
         * Apply minimum numeric filters.
         */
        if ($request->filled('guests')) {
            $query->where('guests', '>=', (int) $request->guests);
        }

        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', (int) $request->bedrooms);
        }

        if ($request->filled('beds')) {
            $query->where('beds', '>=', (int) $request->beds);
        }

        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '>=', (int) $request->bathrooms);
        }

        /**
         * Keep a consistent ordering across the page.
         */
        $accommodations = $query
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('pages.accommodations', compact('accommodations'));
    }
}