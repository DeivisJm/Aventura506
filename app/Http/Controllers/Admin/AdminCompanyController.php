<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class AdminCompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::query();

        if ($request->filled('search')) {
            $search = strtolower($request->search);

            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(email) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(phone) LIKE ?', ["%{$search}%"])
                    ->orWhereRaw('LOWER(location_name) LIKE ?', ["%{$search}%"]);
            });
        }

        $companies = $query
            ->withCount('tours')
            ->orderBy('name')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        $company = new Company();

        return view('admin.companies.create', compact('company'));
    }

    public function store(Request $request)
    {
        $data = $this->validateCompany($request);

        Company::create($data);

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'La compañía fue creada correctamente.');
    }

    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $data = $this->validateCompany($request);

        $company->update($data);

        return redirect()
            ->route('admin.companies.edit', $company)
            ->with('success', 'La compañía fue actualizada correctamente.');
    }

    public function destroy(Company $company)
    {
        if ($company->tours()->exists()) {
            return redirect()
                ->route('admin.companies.index')
                ->with('error', 'No puedes eliminar esta compañía porque tiene tours asociados.');
        }

        $company->delete();

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'La compañía fue eliminada correctamente.');
    }

    private function validateCompany(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'location_name' => ['nullable', 'string', 'max:255'],
            'map_embed_url' => ['nullable', 'string'],
        ]);
    }
}
