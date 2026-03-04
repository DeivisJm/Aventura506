<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tour;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Company;
use App\Models\TourDetail;
use App\Models\TourPrice;
use App\Models\TourSchedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminTourController extends Controller
{
    public function index(Request $request)
    {
        $query = Tour::query();

        // Search by name
        if ($request->filled('search')) {

            $search = strtolower($request->search);

            $query->where(function ($q) use ($search) {
                $q->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.es'))) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.en'))) LIKE ?", ["%{$search}%"]);
            });
        }

        $tours = $query->latest()->paginate(9);

        return view('admin.tours.index', compact('tours'));
    }

    public function create()
    {
        return view('admin.tours.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|unique:tours,slug',
        ]);

        Tour::create([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'active' => true,
        ]);

        return redirect()->route('admin.tours.index');
    }

    public function edit(Tour $tour)
    {
        $categories = Category::all();
        $companies = Company::all();

        $tour->load(['detail', 'prices', 'schedules']);

        return view('admin.tours.edit', compact(
            'tour',
            'categories',
            'companies'
        ));
    }

    public function update(Request $request, Tour $tour)
    {
        $validated = $request->validate([

            // Tour
            'name.es' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
            'slug' => 'required|string|unique:tours,slug,' . $tour->id,
            'category_id' => 'required|exists:categories,id',
            'company_id' => 'required|exists:companies,id',

            // Detail
            'detail.duration.es' => 'required|string',
            'detail.duration.en' => 'required|string',
            'detail.full_description.es' => 'required|string',
            'detail.full_description.en' => 'required|string',
            'detail.location_name' => 'required|string',

            // Prices
            'prices.*.type.es' => 'required|string',
            'prices.*.type.en' => 'required|string',
            'prices.*.price' => 'required|numeric|min:0',

            // Schedules
            'schedules.*.start_time' => 'required',
        ]);

        DB::transaction(function () use ($request, $tour) {

            /* ===================================================== */
            /* UPDATE MAIN TOUR                                      */
            /* ===================================================== */

            $tour->update([
                'name' => $request->name,
                'slug' => Str::slug($request->slug),
                'category_id' => $request->category_id,
                'company_id' => $request->company_id,
            ]);

            /* ===================================================== */
            /* HANDLE IMAGE UPLOAD                                   */
            /* ===================================================== */

            if ($request->hasFile('image')) {

                if ($tour->image && Storage::disk('public')->exists($tour->image)) {
                    Storage::disk('public')->delete($tour->image);
                }

                $path = $request->file('image')->store('tours', 'public');

                $tour->update([
                    'image' => 'storage/' . $path
                ]);
            }

            /* ===================================================== */
            /* UPDATE OR CREATE DETAIL                               */
            /* ===================================================== */

            $tour->detail()->updateOrCreate(
                ['tour_id' => $tour->id],
                [
                    'duration' => $request->detail['duration'],
                    'full_description' => $request->detail['full_description'],
                    'location_name' => $request->detail['location_name'],
                ]
            );

            /* ===================================================== */
            /* SYNC PRICES                                           */
            /* ===================================================== */

            $existingPriceIds = $tour->prices()->pluck('id')->toArray();
            $incomingPriceIds = collect($request->prices)
                ->pluck('id')
                ->filter()
                ->toArray();

            // Delete removed prices
            $pricesToDelete = array_diff($existingPriceIds, $incomingPriceIds);
            TourPrice::whereIn('id', $pricesToDelete)->delete();

            // Update or create prices
            foreach ($request->prices as $priceData) {

                $tour->prices()->updateOrCreate(
                    ['id' => $priceData['id'] ?? null],
                    [
                        'type' => $priceData['type'],
                        'price' => $priceData['price'],
                    ]
                );
            }

            /* ===================================================== */
            /* SYNC SCHEDULES                                        */
            /* ===================================================== */

            $existingScheduleIds = $tour->schedules()->pluck('id')->toArray();
            $incomingScheduleIds = collect($request->schedules)
                ->pluck('id')
                ->filter()
                ->toArray();

            $schedulesToDelete = array_diff($existingScheduleIds, $incomingScheduleIds);
            TourSchedule::whereIn('id', $schedulesToDelete)->delete();

            foreach ($request->schedules as $scheduleData) {

                $tour->schedules()->updateOrCreate(
                    ['id' => $scheduleData['id'] ?? null],
                    [
                        'start_time' => $scheduleData['start_time'],
                    ]
                );
            }
        });

        return redirect()
            ->route('admin.tours.edit', $tour)
            ->with('success', 'El tour se actualizó correctamente.');
    }

    public function toggle(Tour $tour)
    {
        $tour->update([
            'active' => !$tour->active
        ]);

        return back();
    }
}
