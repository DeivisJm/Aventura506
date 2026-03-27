@extends('admin.layouts.admin')

@section('admin-content')

<div class="flex justify-between items-start mb-10">

    <div>
        <h1 class="admin-page-title">Compañías</h1>
        <p class="admin-page-subtitle">
            Administra las compañías operadoras utilizadas por los tours del sistema.
        </p>
    </div>

    <a href="{{ route('admin.companies.create') }}" class="admin-btn-primary">
        Nueva compañía
    </a>

</div>

{{-- ================= BUSCADOR ================= --}}
<form method="GET" id="company-search-form" class="relative mb-12 max-w-md">

    <input type="text"
        name="search"
        id="company-search-input"
        value="{{ request('search') }}"
        placeholder="Buscar compañía por nombre..."
        autocomplete="off"
        class="w-full pl-12 pr-4 py-3 rounded-xl border
               border-gray-300 dark:border-gray-700
               bg-white dark:bg-gray-800
               text-gray-900 dark:text-white
               focus:ring-2 focus:ring-green-500 outline-none transition">

    <button type="submit"
        class="absolute left-3 top-1/2 -translate-y-1/2
               text-gray-500 hover:text-green-600 transition">

        <svg class="w-5 h-5"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8" />
            <path stroke-linecap="round"
                stroke-linejoin="round"
                d="M21 21l-4.35-4.35" />
        </svg>

    </button>

</form>

<div class="admin-card entity-table-card">

    <div class="mb-2">
        <h2 class="admin-section-title">Listado de compañías</h2>
        <p class="admin-section-description mt-2">
            Edita aquí las compañías vinculadas a los tours.
        </p>
    </div>

    <table class="admin-table entity-table">

        <thead>
            <tr>
                <th class="text-left">Nombre</th>
                <th class="text-left">Teléfono</th>
                <th class="text-center">Tours</th>
                <th class="text-right">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($companies as $company)
            <tr>
                <td class="text-left">
                    <div class="entity-name-cell">
                        <span class="entity-name">
                            {{ $company->name }}
                        </span>
                    </div>
                </td>

                <td class="text-left">
                    <span class="entity-subtext">
                        {{ $company->phone ?: 'No registrado' }}
                    </span>
                </td>

                <td class="text-center">
                    <span class="entity-count-badge">
                        {{ $company->tours_count }}
                    </span>
                </td>

                <td class="text-right entity-actions-cell">
                    <div class="entity-actions-wrap">
                        <div class="users-actions entity-actions">
                            <a href="{{ route('admin.companies.edit', $company) }}"
                                class="users-btn users-btn-edit">
                                Editar
                            </a>

                            <form method="POST"
                                action="{{ route('admin.companies.destroy', $company) }}"
                                class="delete-confirm-form"
                                data-delete-title="Eliminar compañía"
                                data-delete-message="Esta acción eliminará la compañía seleccionada si no tiene tours asociados.">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="users-btn users-btn-delete">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-10 text-gray-500 dark:text-gray-400">
                    No hay compañías registradas.
                </td>
            </tr>
            @endforelse
        </tbody>

    </table>

    @if($companies->hasPages())
    <div class="mt-8">
        {{ $companies->links('vendor.pagination.custom-green') }}
    </div>
    @endif

</div>

@endsection