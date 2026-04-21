<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->filled('search')) {
            $search = strtolower(trim((string) $request->search));

            $query->where(function ($q) use ($search) {
                $q->whereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.es'))) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(JSON_UNQUOTE(JSON_EXTRACT(name, '$.en'))) LIKE ?", ["%{$search}%"])
                    ->orWhereRaw("LOWER(slug) LIKE ?", ["%{$search}%"]);
            });
        }

        $categories = $query
            ->withCount('tours')
            ->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.es')) ASC")
            ->paginate(10)
            ->appends($request->query());

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $category = new Category([
            'is_active' => true,
        ]);

        return view('admin.categories.create', compact('category'));
    }

    public function store(Request $request)
    {
        $data = $this->validateCategory($request);

        Category::create([
            'name' => [
                'es' => trim($data['name']['es']),
                'en' => trim($data['name']['en']),
            ],
            'slug' => Str::slug($data['slug']),
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'La categoría fue creada correctamente.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validateCategory($request, $category->id);

        $category->update([
            'name' => [
                'es' => trim($data['name']['es']),
                'en' => trim($data['name']['en']),
            ],
            'slug' => Str::slug($data['slug']),
        ]);

        return redirect()
            ->route('admin.categories.edit', $category)
            ->with('success', 'La categoría fue actualizada correctamente.');
    }

    public function toggle(Request $request, Category $category)
    {
        $isCurrentlyActive = (bool) $category->is_active;
        $hasAssociatedTours = $category->tours()->exists();

        if ($isCurrentlyActive) {
        if ($hasAssociatedTours && !$request->boolean('confirm_disable_with_tours')) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Esta categoría tiene tours asociados. Debes confirmar la desactivación conjunta.');
        }

        DB::transaction(function () use ($category, $hasAssociatedTours) {
            $category->update([
                'is_active' => false,
            ]);

            if ($hasAssociatedTours) {
                $category->tours()
                    ->where('active', true)
                    ->update([
                        'active' => false,
                        'deactivated_by_category' => true,
                    ]);
            }
        });

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                $hasAssociatedTours
                    ? 'La categoría y sus tours activos asociados fueron desactivados correctamente.'
                    : 'La categoría fue desactivada correctamente.'
            );
    }

    DB::transaction(function () use ($category) {
        $category->update([
            'is_active' => true,
        ]);

        $category->tours()
            ->where('deactivated_by_category', true)
            ->update([
                'active' => true,
                'deactivated_by_category' => false,
            ]);
    });

    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'La categoría fue activada y los tours afectados por la categoría fueron restaurados correctamente.');
    }

    public function destroy(Category $category)
    {
        if ($category->tours()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'No puedes eliminar esta categoría porque tiene tours asociados.');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'La categoría fue eliminada correctamente.');
    }

    private function validateCategory(Request $request, ?int $categoryId = null): array
    {
        return $request->validate([
            'name.es' => ['required', 'string', 'max:255'],
            'name.en' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug,' . $categoryId],
        ]);
    }
}