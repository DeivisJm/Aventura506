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

        $tours = $query
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(9)
            ->appends($request->query());

        /* Total number of tours used to build the position selector */
        $totalTours = Tour::count();

        return view('admin.tours.index', compact('tours', 'totalTours'));
    }

    public function create()
    {
        $categories = Category::all();
        $companies = Company::all();

        $tour = new Tour();

        return view('admin.tours.create', compact(
            'tour',
            'categories',
            'companies'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([

            // Tour
            'name.es' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
            'slug' => 'required|string|unique:tours,slug',
            'description.es' => 'required|string',
            'description.en' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'company_id' => 'required|exists:companies,id',

            // Detail
            'detail.duration.es' => 'required|string',
            'detail.duration.en' => 'required|string',
            'detail.full_description.es' => 'required|string',
            'detail.full_description.en' => 'required|string',
            'detail.includes.es' => 'required|string',
            'detail.includes.en' => 'required|string',
            'detail.ideal_for.es' => 'required|string',
            'detail.ideal_for.en' => 'required|string',
            'detail.recommendations.es' => 'required|string',
            'detail.recommendations.en' => 'required|string',
            'detail.location_name' => 'required|string',
            'detail.start_hours_text.es' => 'required|string',
            'detail.start_hours_text.en' => 'required|string',

            // Company extra
            'company.email' => 'nullable|string|max:255',
            'company.phone' => 'nullable|string|max:255',
            'company.map_embed_url' => 'required|string',

            // Prices
            'prices.*.type.es' => 'required|string',
            'prices.*.type.en' => 'required|string',
            'prices.*.category_type' => 'nullable|string',
            'prices.*.price' => 'required|numeric|min:0',
            'prices.*.min_age' => 'nullable|integer|min:0',
            'prices.*.max_age' => 'nullable|integer|min:0',

            // Schedules
            'schedules.*.start_time' => 'required',

            // Image
            'image' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($request) {

            $tour = Tour::create([
                'name' => $request->name,
                'slug' => Str::slug($request->slug),
                'description' => $request->description,
                'category_id' => $request->category_id,
                'company_id' => $request->company_id,
                'active' => true,
                'sort_order' => (Tour::max('sort_order') ?? 0) + 1,
            ]);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('tours', 'public');

                $tour->update([
                    'image' => 'storage/' . $path
                ]);
            }

            $tour->detail()->create([
                'duration' => $request->detail['duration'],
                'full_description' => $request->detail['full_description'],
                'includes' => [
                    'es' => array_map('trim', explode(',', $request->detail['includes']['es'])),
                    'en' => array_map('trim', explode(',', $request->detail['includes']['en'])),
                ],
                'ideal_for' => [
                    'es' => array_map('trim', explode(',', $request->detail['ideal_for']['es'])),
                    'en' => array_map('trim', explode(',', $request->detail['ideal_for']['en'])),
                ],
                'recommendations' => [
                    'es' => array_map('trim', explode(',', $request->detail['recommendations']['es'])),
                    'en' => array_map('trim', explode(',', $request->detail['recommendations']['en'])),
                ],
                'location_name' => $request->detail['location_name'],
                'start_hours_text' => $request->detail['start_hours_text'],
            ]);

            Company::where('id', $request->company_id)->update([
                'email' => $request->input('company.email'),
                'phone' => $request->input('company.phone'),
                'map_embed_url' => $request->input('company.map_embed_url'),
            ]);

            if ($request->prices) {
                foreach ($request->prices as $price) {
                    $typeEs = $price['type']['es'] ?? 'tipo';

                    $tour->prices()->create([
                        'type_key' => Str::slug($typeEs, '_'),
                        'type' => $price['type'],
                        'category_type' => $price['category_type'] ?? 'international',
                        'price' => $price['price'],
                        'min_age' => $price['min_age'] ?? null,
                        'max_age' => $price['max_age'] ?? null,
                        'currency' => 'USD',
                        'is_free' => (float) $price['price'] <= 0,
                    ]);
                }
            }

            if ($request->schedules) {
                foreach ($request->schedules as $schedule) {
                    $tour->schedulesAdmin()->create([
                        'start_time' => $schedule['start_time'],
                        'active' => isset($schedule['active']) ? 1 : 0,
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.tours.index')
            ->with('success', 'El tour fue creado correctamente.');
    }


    public function edit(Tour $tour)
    {
        $categories = Category::all();
        $companies = Company::all();

        $tour->load(['detail', 'prices', 'schedulesAdmin']);

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
            'description.es' => 'required|string',
            'description.en' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'company_id' => 'required|exists:companies,id',

            // Detail
            'detail.duration.es' => 'required|string',
            'detail.duration.en' => 'required|string',
            'detail.full_description.es' => 'required|string',
            'detail.full_description.en' => 'required|string',
            'detail.includes.es' => 'required|string',
            'detail.includes.en' => 'required|string',
            'detail.ideal_for.es' => 'required|string',
            'detail.ideal_for.en' => 'required|string',
            'detail.recommendations.es' => 'required|string',
            'detail.recommendations.en' => 'required|string',
            'detail.location_name' => 'required|string',
            'detail.start_hours_text.es' => 'required|string',
            'detail.start_hours_text.en' => 'required|string',

            // Company extra
            'company.email' => 'nullable|string|max:255',
            'company.phone' => 'nullable|string|max:255',
            'company.map_embed_url' => 'required|string',

            // Prices
            'prices.*.type.es' => 'required|string',
            'prices.*.type.en' => 'required|string',
            'prices.*.category_type' => 'nullable|string',
            'prices.*.price' => 'required|numeric|min:0',
            'prices.*.min_age' => 'nullable|integer|min:0',
            'prices.*.max_age' => 'nullable|integer|min:0',

            // Schedules
            'schedules.*.start_time' => 'required',

            // Image
            'image' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($request, $tour) {

            $tour->update([
                'name' => $request->name,
                'slug' => Str::slug($request->slug),
                'description' => $request->description,
                'category_id' => $request->category_id,
                'company_id' => $request->company_id,
            ]);

            if ($request->hasFile('image')) {
                if ($tour->image) {
                    $oldPath = str_replace('storage/', '', $tour->image);

                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }

                $path = $request->file('image')->store('tours', 'public');

                $tour->update([
                    'image' => 'storage/' . $path
                ]);
            }

            $tour->detail()->updateOrCreate(
                ['tour_id' => $tour->id],
                [
                    'duration' => $request->detail['duration'],
                    'full_description' => $request->detail['full_description'],
                    'includes' => [
                        'es' => array_map('trim', explode(',', $request->detail['includes']['es'])),
                        'en' => array_map('trim', explode(',', $request->detail['includes']['en'])),
                    ],
                    'ideal_for' => [
                        'es' => array_map('trim', explode(',', $request->detail['ideal_for']['es'])),
                        'en' => array_map('trim', explode(',', $request->detail['ideal_for']['en'])),
                    ],
                    'recommendations' => [
                        'es' => array_map('trim', explode(',', $request->detail['recommendations']['es'])),
                        'en' => array_map('trim', explode(',', $request->detail['recommendations']['en'])),
                    ],
                    'location_name' => $request->detail['location_name'],
                    'start_hours_text' => $request->detail['start_hours_text'],
                ]
            );

            Company::where('id', $request->company_id)->update([
                'email' => $request->input('company.email'),
                'phone' => $request->input('company.phone'),
                'map_embed_url' => $request->input('company.map_embed_url'),
            ]);

            $existingPriceIds = $tour->prices()->pluck('id')->toArray();

            $incomingPriceIds = collect($request->prices ?? [])
                ->pluck('id')
                ->filter()
                ->toArray();

            $pricesToDelete = array_diff($existingPriceIds, $incomingPriceIds);

            if (!empty($pricesToDelete)) {
                TourPrice::whereIn('id', $pricesToDelete)->delete();
            }

            if ($request->prices) {
                foreach ($request->prices as $priceData) {
                    $typeEs = $priceData['type']['es'] ?? 'tipo';

                    $tour->prices()->updateOrCreate(
                        ['id' => $priceData['id'] ?? null],
                        [
                            'type_key' => Str::slug($typeEs, '_'),
                            'type' => $priceData['type'],
                            'category_type' => $priceData['category_type'] ?? 'international',
                            'price' => $priceData['price'],
                            'min_age' => $priceData['min_age'] ?? null,
                            'max_age' => $priceData['max_age'] ?? null,
                            'currency' => 'USD',
                            'is_free' => (float) $priceData['price'] <= 0,
                        ]
                    );
                }
            }

            $existingScheduleIds = $tour->schedulesAdmin()->pluck('id')->toArray();

            $incomingScheduleIds = collect($request->schedules ?? [])
                ->pluck('id')
                ->filter()
                ->toArray();

            $schedulesToDelete = array_diff($existingScheduleIds, $incomingScheduleIds);

            if (!empty($schedulesToDelete)) {
                TourSchedule::whereIn('id', $schedulesToDelete)->delete();
            }

            foreach ($request->schedules ?? [] as $scheduleData) {
                $tour->schedulesAdmin()->updateOrCreate(
                    ['id' => $scheduleData['id'] ?? null],
                    [
                        'start_time' => $scheduleData['start_time'],
                        'active' => isset($scheduleData['active']) ? 1 : 0,
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
    public function updatePosition(Request $request, Tour $tour)
    {
        $validated = $request->validate([
            'sort_order' => ['required', 'integer', 'min:1'],
        ]);

        $newPosition = (int) $validated['sort_order'];
        $currentPosition = (int) $tour->sort_order;
        $maxPosition = (int) Tour::count();

        /* Prevent invalid positions outside the current range */
        if ($newPosition > $maxPosition) {
            $newPosition = $maxPosition;
        }

        /* If position did not change, there is nothing to reorder */
        if ($newPosition === $currentPosition) {
            return response()->json([
                'success' => true,
                'message' => 'The position is already up to date.',
            ]);
        }

        DB::transaction(function () use ($tour, $currentPosition, $newPosition) {

            /* Moving up:
           shift down the tours between target position and current position - 1 */
            if ($newPosition < $currentPosition) {
                Tour::where('id', '!=', $tour->id)
                    ->whereBetween('sort_order', [$newPosition, $currentPosition - 1])
                    ->increment('sort_order');
            }

            /* Moving down:
           shift up the tours between current position + 1 and target position */
            if ($newPosition > $currentPosition) {
                Tour::where('id', '!=', $tour->id)
                    ->whereBetween('sort_order', [$currentPosition + 1, $newPosition])
                    ->decrement('sort_order');
            }

            /* Save the selected position for the current tour */
            $tour->update([
                'sort_order' => $newPosition,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'The tour order was updated successfully.',
            'sort_order' => $newPosition,
        ]);
    }


    public function toggleSchedule(\App\Models\TourSchedule $schedule)
    {
        $schedule->update([
            'active' => !$schedule->active
        ]);

        return response()->json([
            'success' => true,
            'active' => $schedule->active
        ]);
    }
}
