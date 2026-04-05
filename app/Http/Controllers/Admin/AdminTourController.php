<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tour;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Company;
use App\Models\TourPrice;
use App\Models\TourSchedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminTourController extends Controller
{
    public function index(Request $request)
    {
        $query = Tour::query();

        // Search by localized tour name
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

        $totalTours = Tour::count();

        return view('admin.tours.index', compact('tours', 'totalTours'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $companies = Company::orderBy('name')->get();
        $tour = new Tour();

        return view('admin.tours.create', compact(
            'tour',
            'categories',
            'companies'
        ));
    }

    public function store(Request $request)
    {
        $this->validateTourRequest($request);

        DB::transaction(function () use ($request) {
            $categoryId = $this->resolveCategoryId($request);
            $companyId = $this->resolveCompanyId($request);

            $tour = Tour::create([
                'name' => $request->name,
                'slug' => Str::slug($request->slug),
                'description' => $request->description,
                'category_id' => $categoryId,
                'company_id' => $companyId,
                'active' => true,
                'sort_order' => (Tour::max('sort_order') ?? 0) + 1,
            ]);

            $this->handleTourImage($request, $tour);
            $this->saveTourDetail($request, $tour);
            $this->updateCompanyInfo($request, $companyId);
            $this->syncTourPrices($request, $tour, false);
            $this->syncTourSchedules($request, $tour, false);
        });

        return redirect()
            ->route('admin.tours.index')
            ->with('success', 'El tour fue creado correctamente.');
    }

    public function edit(Tour $tour)
    {
        $categories = Category::orderBy('name')->get();
        $companies = Company::orderBy('name')->get();

        $tour->load(['detail', 'prices', 'schedulesAdmin']);

        return view('admin.tours.edit', compact(
            'tour',
            'categories',
            'companies'
        ));
    }

    public function update(Request $request, Tour $tour)
    {
        $this->validateTourRequest($request, $tour->id);

        DB::transaction(function () use ($request, $tour) {
            $categoryId = $this->resolveCategoryId($request);
            $companyId = $this->resolveCompanyId($request);

            $tour->update([
                'name' => $request->name,
                'slug' => Str::slug($request->slug),
                'description' => $request->description,
                'category_id' => $categoryId,
                'company_id' => $companyId,
            ]);

            $this->handleTourImage($request, $tour);
            $this->saveTourDetail($request, $tour);
            $this->updateCompanyInfo($request, $companyId);
            $this->syncTourPrices($request, $tour, true);
            $this->syncTourSchedules($request, $tour, true);
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

        if ($newPosition > $maxPosition) {
            $newPosition = $maxPosition;
        }

        if ($newPosition === $currentPosition) {
            return response()->json([
                'success' => true,
                'message' => 'The position is already up to date.',
            ]);
        }

        DB::transaction(function () use ($tour, $currentPosition, $newPosition) {
            if ($newPosition < $currentPosition) {
                Tour::where('id', '!=', $tour->id)
                    ->whereBetween('sort_order', [$newPosition, $currentPosition - 1])
                    ->increment('sort_order');
            }

            if ($newPosition > $currentPosition) {
                Tour::where('id', '!=', $tour->id)
                    ->whereBetween('sort_order', [$currentPosition + 1, $newPosition])
                    ->decrement('sort_order');
            }

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

    public function toggleSchedule(TourSchedule $schedule)
    {
        $schedule->update([
            'active' => !$schedule->active
        ]);

        return response()->json([
            'success' => true,
            'active' => $schedule->active
        ]);
    }

    /**
     * Validate the tour form request.
     */
    private function validateTourRequest(Request $request, ?int $tourId = null): void
    {
        $request->validate([
            // Tour
            'name.es' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
            'slug' => 'required|string|unique:tours,slug,' . $tourId,
            'description.es' => 'required|string',
            'description.en' => 'required|string',
            'category_id' => 'required',
            'new_category.es' => 'nullable|string|max:255',
            'new_category.en' => 'nullable|string|max:255',

            'company_id' => 'required',
            'new_company' => 'nullable|string|max:255',

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
            'image' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:10240',
            'cropped_image' => 'nullable|string',
        ], [
            'image.mimes' => 'La imagen debe ser un archivo JPG, JPEG, PNG o WEBP.',
            'image.max' => 'La imagen no debe superar los 10 MB.',
        ]);


        // Validate category
        if ($request->category_id === 'new') {
            $request->validate([
                'new_category.es' => ['required', 'string', 'max:255'],
                'new_category.en' => ['required', 'string', 'max:255'],
            ]);
        } else {
            $request->validate([
                'category_id' => ['exists:categories,id'],
            ]);
        }

        // Validate company
        if ($request->company_id === 'new') {
            $request->validate([
                'new_company' => ['required', 'string', 'max:255'],
            ]);
        } else {
            $request->validate([
                'company_id' => ['exists:companies,id'],
            ]);
        }
    }

    /**
     * Resolve the selected category id or create a new category.
     */
    /**
     * Resolve the selected category id or create a new multilingual category.
     */
    private function resolveCategoryId(Request $request): int
    {
        if ($request->category_id !== 'new') {
            return (int) $request->category_id;
        }

        $nameEs = trim($request->input('new_category.es'));
        $nameEn = trim($request->input('new_category.en'));

        $slug = \Illuminate\Support\Str::slug($nameEn ?: $nameEs);

        $category = \App\Models\Category::firstOrCreate(
            ['slug' => $slug],
            [
                'name' => [
                    'es' => $nameEs,
                    'en' => $nameEn,
                ],
            ]
        );

        return (int) $category->id;
    }
    private function resolveCompanyId(Request $request): int
    {
        if ($request->company_id !== 'new') {
            return (int) $request->company_id;
        }

        $name = trim($request->input('new_company'));

        $company = Company::firstOrCreate(
            ['name' => $name],
            [
                'email' => $request->input('company.email'),
                'phone' => $request->input('company.phone'),
                'location_name' => $request->input('detail.location_name'),
                'map_embed_url' => $request->input('company.map_embed_url'),
            ]
        );

        return (int) $company->id;
    }

    /**
     * Save or replace the tour image.
     * Priority:
     * 1. Cropped base64 image from the crop editor
     * 2. Raw uploaded file fallback
     */
    private function handleTourImage(Request $request, Tour $tour): void
    {
        if (!$request->filled('cropped_image') && !$request->hasFile('image')) {
            return;
        }

        if (!empty($tour->image) && str_starts_with($tour->image, 'storage/')) {
            $oldPath = str_replace('storage/', '', $tour->image);

            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        if ($request->filled('cropped_image')) {
            $base64Image = $request->input('cropped_image');

            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $matches)) {
                $extension = strtolower($matches[1]);
                $extension = $extension === 'jpeg' ? 'jpg' : $extension;

                $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
                $decodedImage = base64_decode($base64Image);

                $fileName = 'tours/' . Str::random(40) . '.' . $extension;

                Storage::disk('public')->put($fileName, $decodedImage);

                $tour->update([
                    'image' => 'storage/' . $fileName,
                ]);
            }

            return;
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('tours', 'public');

            $tour->update([
                'image' => 'storage/' . $path,
            ]);
        }
    }

    /**
     * Save or update the tour detail record.
     */
    private function saveTourDetail(Request $request, Tour $tour): void
    {
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
    }

    /**
     * Update the selected company extra information.
     */
    private function updateCompanyInfo(Request $request, int $companyId): void
    {
        Company::where('id', $companyId)->update([
            'email' => $request->input('company.email'),
            'phone' => $request->input('company.phone'),
            'location_name' => $request->input('detail.location_name'),
            'map_embed_url' => $request->input('company.map_embed_url'),
        ]);
    }

    /**
     * Create or sync tour prices.
     */
    private function syncTourPrices(Request $request, Tour $tour, bool $isUpdate): void
    {
        if ($isUpdate) {
            $existingPriceIds = $tour->prices()->pluck('id')->toArray();

            $incomingPriceIds = collect($request->prices ?? [])
                ->pluck('id')
                ->filter()
                ->toArray();

            $pricesToDelete = array_diff($existingPriceIds, $incomingPriceIds);

            if (!empty($pricesToDelete)) {
                TourPrice::whereIn('id', $pricesToDelete)->delete();
            }
        }

        foreach ($request->prices ?? [] as $priceData) {
            $typeEs = $priceData['type']['es'] ?? 'tipo';

            if ($isUpdate) {
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
            } else {
                $tour->prices()->create([
                    'type_key' => Str::slug($typeEs, '_'),
                    'type' => $priceData['type'],
                    'category_type' => $priceData['category_type'] ?? 'international',
                    'price' => $priceData['price'],
                    'min_age' => $priceData['min_age'] ?? null,
                    'max_age' => $priceData['max_age'] ?? null,
                    'currency' => 'USD',
                    'is_free' => (float) $priceData['price'] <= 0,
                ]);
            }
        }
    }

    /**
     * Create or sync tour schedules.
     */
    private function syncTourSchedules(Request $request, Tour $tour, bool $isUpdate): void
    {
        if ($isUpdate) {
            $existingScheduleIds = $tour->schedulesAdmin()->pluck('id')->toArray();

            $incomingScheduleIds = collect($request->schedules ?? [])
                ->pluck('id')
                ->filter()
                ->toArray();

            $schedulesToDelete = array_diff($existingScheduleIds, $incomingScheduleIds);

            if (!empty($schedulesToDelete)) {
                TourSchedule::whereIn('id', $schedulesToDelete)->delete();
            }
        }

        foreach ($request->schedules ?? [] as $scheduleData) {
            if ($isUpdate) {
                $tour->schedulesAdmin()->updateOrCreate(
                    ['id' => $scheduleData['id'] ?? null],
                    [
                        'start_time' => $scheduleData['start_time'],
                        'active' => isset($scheduleData['active']) ? 1 : 0,
                    ]
                );
            } else {
                $tour->schedulesAdmin()->create([
                    'start_time' => $scheduleData['start_time'],
                    'active' => isset($scheduleData['active']) ? 1 : 0,
                ]);
            }
        }
    }
}
