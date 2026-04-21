<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Services\SubscriberNotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminAccommodationController extends Controller
{
    /**
     * Display the accommodations list in the admin panel.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->get('search', ''));

        $query = Accommodation::query();

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where('name->es', 'like', "%{$search}%")
                    ->orWhere('name->en', 'like', "%{$search}%")
                    ->orWhere('short_description->es', 'like', "%{$search}%")
                    ->orWhere('short_description->en', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('host_name', 'like', "%{$search}%");
            });
        }

        $accommodations = $query
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(9)
            ->appends($request->query());

        $totalAccommodations = Accommodation::count();

        return view('admin.accommodations.index', compact(
            'accommodations',
            'totalAccommodations'
        ));
    }

    /**
     * Show the create accommodation form.
     */
    public function create(): View
    {
        $accommodation = new Accommodation([
            'is_active' => true,
        ]);

        return view('admin.accommodations.create', compact('accommodation'));
    }

    /**
     * Store a newly created accommodation.
     */
    public function store(Request $request, SubscriberNotificationService $subscriberNotificationService): RedirectResponse
    {
        $validated = $this->validateAccommodationRequest($request);

        $createdAccommodation = null;

        DB::transaction(function () use ($request, $validated, &$createdAccommodation) {
            $mainImagePath = null;

            if ($request->hasFile('main_image') && $request->file('main_image')->isValid()) {
                $path = $request->file('main_image')->store('accommodations', 'public');
                $mainImagePath = 'storage/' . $path;
            }

            $galleryImages = $this->storeGalleryImages($request);

            $createdAccommodation = Accommodation::create([
                'name' => [
                    'es' => $validated['name']['es'],
                    'en' => $validated['name']['en'],
                ],
                'slug' => Str::slug($validated['slug']),
                'short_description' => [
                    'es' => $validated['short_description']['es'],
                    'en' => $validated['short_description']['en'],
                ],
                'location' => $validated['location'],
                'host_name' => $validated['host_name'],
                'phone' => $validated['phone'],
                'external_url' => $validated['external_url'],
                'main_image' => $mainImagePath,
                'gallery_images' => $galleryImages,
                'guests' => (int) $validated['guests'],
                'bedrooms' => (int) $validated['bedrooms'],
                'beds' => (int) $validated['beds'],
                'bathrooms' => (int) $validated['bathrooms'],
                'amenities' => $this->normalizeAmenities($validated['amenities']),
                'is_active' => true,
                'sort_order' => ((int) Accommodation::max('sort_order')) + 1,
            ]);
        });

        if ($createdAccommodation) {
            $subscriberNotificationService->sendNewAccommodationNotification($createdAccommodation->fresh());
        }

        return redirect()
            ->route('admin.accommodations.index')
            ->with('success', 'El hospedaje fue creado correctamente.');
    }

    /**
     * Show the edit accommodation form.
     */
    public function edit(Accommodation $accommodation): View
    {
        return view('admin.accommodations.edit', compact('accommodation'));
    }

    /**
     * Update the specified accommodation.
     */
    public function update(Request $request, Accommodation $accommodation): RedirectResponse
    {
        $validated = $this->validateAccommodationRequest($request, $accommodation->id);

        DB::transaction(function () use ($request, $validated, $accommodation) {
            $mainImagePath = $accommodation->main_image;

            if ($request->hasFile('main_image') && $request->file('main_image')->isValid()) {
                $this->deletePublicFileIfExists($accommodation->main_image);

                $path = $request->file('main_image')->store('accommodations', 'public');
                $mainImagePath = 'storage/' . $path;
            }

            $existingGallery = is_array($accommodation->gallery_images)
                ? $accommodation->gallery_images
                : [];

            $newGalleryImages = $this->storeGalleryImages($request);

            $galleryImages = array_values(array_filter(array_merge(
                $existingGallery,
                $newGalleryImages
            )));

            if ($request->filled('gallery_remove') && is_array($request->gallery_remove)) {
                $removeIndexes = collect($request->gallery_remove)
                    ->filter(fn($value) => is_numeric($value))
                    ->map(fn($value) => (int) $value)
                    ->unique()
                    ->sortDesc()
                    ->values();

                foreach ($removeIndexes as $index) {
                    if (isset($galleryImages[$index])) {
                        $this->deletePublicFileIfExists($galleryImages[$index]);
                        unset($galleryImages[$index]);
                    }
                }

                $galleryImages = array_values($galleryImages);
            }

            $accommodation->update([
                'name' => [
                    'es' => $validated['name']['es'],
                    'en' => $validated['name']['en'],
                ],
                'slug' => Str::slug($validated['slug']),
                'short_description' => [
                    'es' => $validated['short_description']['es'],
                    'en' => $validated['short_description']['en'],
                ],
                'location' => $validated['location'],
                'host_name' => $validated['host_name'],
                'phone' => $validated['phone'],
                'external_url' => $validated['external_url'],
                'main_image' => $mainImagePath,
                'gallery_images' => $galleryImages,
                'guests' => (int) $validated['guests'],
                'bedrooms' => (int) $validated['bedrooms'],
                'beds' => (int) $validated['beds'],
                'bathrooms' => (int) $validated['bathrooms'],
                'amenities' => $this->normalizeAmenities($validated['amenities']),
            ]);
        });

        return redirect()
            ->route('admin.accommodations.index')
            ->with('success', 'El hospedaje se actualizó correctamente.');
    }

    /**
     * Toggle accommodation active state.
     */
    public function toggle(Accommodation $accommodation): RedirectResponse
    {
        $accommodation->update([
            'is_active' => !$accommodation->is_active,
        ]);

        return redirect()
            ->route('admin.accommodations.index')
            ->with('success', 'El estado del hospedaje fue actualizado.');
    }

    /**
     * Update accommodation position in the admin list.
     */
    public function updatePosition(Request $request, Accommodation $accommodation): JsonResponse
    {
        $validated = $request->validate([
            'sort_order' => ['required', 'integer', 'min:1'],
        ]);

        $newPosition = (int) $validated['sort_order'];
        $currentPosition = (int) $accommodation->sort_order;
        $maxPosition = (int) Accommodation::count();

        if ($newPosition > $maxPosition) {
            $newPosition = $maxPosition;
        }

        if ($newPosition === $currentPosition) {
            return response()->json([
                'success' => true,
                'message' => 'The position is already up to date.',
            ]);
        }

        DB::transaction(function () use ($accommodation, $currentPosition, $newPosition) {
            if ($newPosition < $currentPosition) {
                Accommodation::where('id', '!=', $accommodation->id)
                    ->whereBetween('sort_order', [$newPosition, $currentPosition - 1])
                    ->increment('sort_order');
            }

            if ($newPosition > $currentPosition) {
                Accommodation::where('id', '!=', $accommodation->id)
                    ->whereBetween('sort_order', [$currentPosition + 1, $newPosition])
                    ->decrement('sort_order');
            }

            $accommodation->update([
                'sort_order' => $newPosition,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'The accommodation order was updated successfully.',
            'sort_order' => $newPosition,
        ]);
    }

    /**
     * Validate the accommodation form request.
     */
    protected function validateAccommodationRequest(Request $request, ?int $accommodationId = null): array
    {
        $mainImageRules = $accommodationId
            ? ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,avif', 'max:4096']
            : ['required', 'file', 'mimes:jpg,jpeg,png,webp,avif', 'max:4096'];

        $validator = Validator::make(
            $request->all(),
            [
                'name.es' => ['required', 'string', 'max:255', 'regex:/^[\pL\pN\s\-\&\.\'\(\)]+$/u'],
                'name.en' => ['required', 'string', 'max:255', 'regex:/^[\pL\pN\s\-\&\.\'\(\)]+$/u'],

                'slug' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                    Rule::unique('accommodations', 'slug')->ignore($accommodationId),
                ],

                'short_description.es' => ['required', 'string', 'max:1000'],
                'short_description.en' => ['required', 'string', 'max:1000'],

                'location' => ['required', 'string', 'max:255', 'regex:/^[\pL\pN\s,\.\-#]+$/u'],
                'host_name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
                'phone' => ['required', 'string', 'max:15', 'regex:/^\d{8,15}$/'],
                'external_url' => ['required', 'url', 'max:2048'],

                'guests' => ['required', 'integer', 'min:1'],
                'bedrooms' => ['required', 'integer', 'min:0'],
                'beds' => ['required', 'integer', 'min:0'],
                'bathrooms' => ['required', 'integer', 'min:0'],

                'amenities.es' => ['required', 'string', 'max:1000', 'regex:/^[\pL\pN\s,\-\/&\.\+]+$/u'],
                'amenities.en' => ['required', 'string', 'max:1000', 'regex:/^[\pL\pN\s,\-\/&\.\+]+$/u'],

                'main_image' => $mainImageRules,

                'gallery_images' => ['nullable', 'array', 'max:7'],
                'gallery_images.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,avif', 'max:4096'],

                'gallery_remove' => ['nullable', 'array'],
                'gallery_remove.*' => ['integer'],
                'active_tab' => ['nullable', 'string'],
            ],
            $this->validationMessages(),
            $this->validationAttributes()
        );

        $validator->after(function ($validator) use ($request) {
            $amenitiesEs = $this->splitAmenitiesString(data_get($request->all(), 'amenities.es'));
            $amenitiesEn = $this->splitAmenitiesString(data_get($request->all(), 'amenities.en'));

            if (count($amenitiesEs) !== count($amenitiesEn)) {
                $validator->errors()->add(
                    'amenities.en',
                    'La cantidad de amenidades en inglés debe coincidir con la cantidad de amenidades en español.'
                );
            }
        });

        return $validator->validate();
    }

    /**
     * Custom validation messages in Spanish.
     */
    protected function validationMessages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'url' => 'El campo :attribute debe contener una URL válida.',
            'integer' => 'El campo :attribute debe ser numérico.',
            'min' => 'El campo :attribute debe ser al menos :min.',
            'max' => 'El campo :attribute no puede superar :max caracteres.',
            'regex' => 'El formato del campo :attribute no es válido.',
            'mimes' => 'El archivo de :attribute debe ser JPG, JPEG, PNG, WEBP o AVIF.',
            'file' => 'El campo :attribute debe ser un archivo válido.',
            'unique' => 'Ya existe un hospedaje con ese slug.',
        ];
    }

    /**
     * Custom validation attribute names.
     */
    protected function validationAttributes(): array
    {
        return [
            'name.es' => 'nombre del hospedaje en español',
            'name.en' => 'nombre del hospedaje en inglés',
            'slug' => 'slug del hospedaje',
            'short_description.es' => 'descripción corta en español',
            'short_description.en' => 'descripción corta en inglés',
            'location' => 'ubicación',
            'host_name' => 'nombre del anfitrión',
            'phone' => 'teléfono',
            'external_url' => 'enlace externo',
            'guests' => 'huéspedes',
            'bedrooms' => 'habitaciones',
            'beds' => 'camas',
            'bathrooms' => 'baños',
            'amenities.es' => 'amenidades en español',
            'amenities.en' => 'amenidades en inglés',
            'main_image' => 'imagen principal',
            'gallery_images' => 'galería de imágenes',
        ];
    }

    /**
     * Store gallery images in the public disk.
     * Returns database-ready paths like: storage/accommodations/file.jpg
     */
    protected function storeGalleryImages(Request $request): array
    {
        $galleryPaths = [];

        if (!$request->hasFile('gallery_images')) {
            return $galleryPaths;
        }

        $files = $request->file('gallery_images');

        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $image) {
            if (!$image instanceof \Illuminate\Http\UploadedFile) {
                continue;
            }

            if (!$image->isValid()) {
                continue;
            }

            $path = $image->store('accommodations', 'public');
            $galleryPaths[] = 'storage/' . $path;
        }

        return $galleryPaths;
    }

    /**
     * Normalize bilingual amenities into JSON objects for storage.
     */
    protected function normalizeAmenities(array $amenities): array
    {
        $itemsEs = $this->splitAmenitiesString($amenities['es'] ?? '');
        $itemsEn = $this->splitAmenitiesString($amenities['en'] ?? '');

        $total = max(count($itemsEs), count($itemsEn));
        $normalized = [];

        for ($index = 0; $index < $total; $index++) {
            $labelEs = $itemsEs[$index] ?? null;
            $labelEn = $itemsEn[$index] ?? null;

            if (!$labelEs && !$labelEn) {
                continue;
            }

            $keyBase = $labelEn ?: $labelEs;
            $key = Str::slug((string) $keyBase, '_');

            $normalized[] = [
                'key' => $key,
                'label' => [
                    'es' => $labelEs ?? $labelEn,
                    'en' => $labelEn ?? $labelEs,
                ],
            ];
        }

        return $normalized;
    }

    /**
     * Split a comma-separated amenity string.
     */
    protected function splitAmenitiesString(?string $value): array
    {
        if (!$value) {
            return [];
        }

        return collect(explode(',', $value))
            ->map(fn($item) => trim((string) $item))
            ->filter(fn($item) => $item !== '')
            ->values()
            ->all();
    }

    /**
     * Delete a file stored on the public disk when the database path
     * starts with "storage/" just like the tours module does.
     */
    protected function deletePublicFileIfExists(?string $publicPath): void
    {
        if (!$publicPath) {
            return;
        }

        if (!str_starts_with($publicPath, 'storage/')) {
            return;
        }

        $storagePath = str_replace('storage/', '', $publicPath);

        if (Storage::disk('public')->exists($storagePath)) {
            Storage::disk('public')->delete($storagePath);
        }
    }

    /**
     * Remove the specified accommodation.
     */
    public function destroy(Accommodation $accommodation): RedirectResponse
    {
        $this->deletePublicFileIfExists($accommodation->main_image);

        $galleryImages = is_array($accommodation->gallery_images)
            ? $accommodation->gallery_images
            : [];

        foreach ($galleryImages as $image) {
            $this->deletePublicFileIfExists($image);
        }

        $accommodation->delete();

        return redirect()
            ->route('admin.accommodations.index')
            ->with('success', 'El hospedaje fue eliminado correctamente.');
    }
}