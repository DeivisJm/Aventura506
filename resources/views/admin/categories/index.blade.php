@extends('admin.layouts.admin')

@section('admin-content')

<div class="flex justify-between items-start mb-10">

    <div>
        <h1 class="admin-page-title">Categorías</h1>
        <p class="admin-page-subtitle">
            Administra las categorías utilizadas por los tours del sistema.
        </p>
    </div>

    <a href="{{ route('admin.categories.create') }}" class="admin-btn-primary">
        Nueva categoría
    </a>

</div>

{{-- ================= BUSCADOR ================= --}}
<form method="GET" id="category-search-form" class="relative mb-12 max-w-md">

    <input type="text"
        name="search"
        id="category-search-input"
        value="{{ request('search') }}"
        placeholder="Buscar categoría por nombre..."
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

<div class="admin-card entity-table-card category-admin-card">

    <div class="mb-2">
        <h2 class="admin-section-title">Listado de categorías</h2>
        <p class="admin-section-description mt-2">
            Edita, activa o desactiva aquí las categorías vinculadas a los tours.
        </p>
    </div>

    <table class="admin-table entity-table entity-table-4-cols">

        <thead>
            <tr>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Tours</th>
                <th class="entity-actions-header">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($categories as $category)
            <tr class="{{ !$category->is_active ? 'category-row-inactive' : '' }}">
                <td>
                    <div class="entity-name-cell">
                        <span class="entity-name">
                            {{ $category->name['es'] ?? '' }}
                        </span>

                        @if(!empty($category->name['en']))
                        <span class="entity-subtext">
                            {{ $category->name['en'] }}
                        </span>
                        @endif

                        <span class="category-slug-text">
                            {{ $category->slug }}
                        </span>
                    </div>
                </td>

                <td>
                    <span class="category-status-badge {{ $category->is_active ? 'is-active' : 'is-inactive' }}">
                        {{ $category->is_active ? 'Activa' : 'Inactiva' }}
                    </span>
                </td>

                <td>
                    <span class="entity-count-badge">
                        {{ $category->tours_count }}
                    </span>
                </td>

                <td class="entity-actions-cell">
                    <div class="entity-actions-wrap">
                        <div class="users-actions entity-actions category-actions-premium">

                            <a href="{{ route('admin.categories.edit', $category) }}"
                                class="users-btn users-btn-edit">
                                Editar
                            </a>

                            @if($category->is_active)
                                @if($category->tours_count > 0)
                                    {{-- Only this button opens the confirmation modal --}}
                                    <button
                                        type="button"
                                        class="category-toggle-btn category-toggle-btn--warning js-category-disable-modal-trigger"
                                        data-category-name="{{ $category->name['es'] ?? '' }}"
                                        data-category-tours="{{ $category->tours_count }}"
                                        data-category-action="{{ route('admin.categories.toggle', $category) }}">
                                        Desactivar
                                    </button>
                                @else
                                    {{-- Direct disable when there are no associated tours --}}
                                    <form method="POST" action="{{ route('admin.categories.toggle', $category) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit" class="category-toggle-btn category-toggle-btn--warning">
                                            Desactivar
                                        </button>
                                    </form>
                                @endif
                            @else
                                {{-- Activate directly without any modal --}}
                                <form method="POST" action="{{ route('admin.categories.toggle', $category) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="category-toggle-btn category-toggle-btn--success">
                                        Activar
                                    </button>
                                </form>
                            @endif

                            <form method="POST"
                                action="{{ route('admin.categories.destroy', $category) }}"
                                class="delete-confirm-form"
                                data-delete-title="Eliminar categoría"
                                data-delete-message="Esta acción eliminará la categoría seleccionada si no tiene tours asociados.">
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
                    No hay categorías registradas.
                </td>
            </tr>
            @endforelse
        </tbody>

    </table>

    @if($categories->hasPages())
    <div class="mt-8">
        {{ $categories->links('vendor.pagination.custom-green') }}
    </div>
    @endif

</div>

{{-- ================= CONFIRMATION MODAL ================= --}}
<div class="category-disable-modal" id="category-disable-modal" aria-hidden="true">
    <div class="category-disable-modal-backdrop" data-category-modal-close></div>

    <div class="category-disable-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="category-disable-modal-title">
        <div class="category-disable-modal-header">
            <div class="category-disable-modal-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86l-7.4 12.82A2 2 0 004.63 20h14.74a2 2 0 001.74-3.32l-7.4-12.82a2 2 0 00-3.48 0z" />
                </svg>
            </div>

            <div class="category-disable-modal-copy">
                <h3 class="category-disable-modal-title" id="category-disable-modal-title">
                    Desactivar categoría con tours asociados
                </h3>

                <p class="category-disable-modal-subtitle">
                    Esta categoría tiene tours vinculados y también serán desactivados.
                </p>
            </div>

            <button type="button" class="category-disable-modal-close-icon" data-category-modal-close aria-label="Cerrar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18" />
                </svg>
            </button>
        </div>

        <div class="category-disable-modal-body">
            <p class="category-disable-modal-note">
                La categoría <strong id="category-disable-modal-name">—</strong> tiene
                <strong id="category-disable-modal-count">0</strong> tour(es) asociado(s).
                Si continúas, la categoría dejará de mostrarse al usuario y sus tours relacionados
                también quedarán inactivos.
            </p>
        </div>

        <div class="category-disable-modal-actions">
            <button type="button" class="category-disable-modal-cancel" data-category-modal-close>
                Cancelar
            </button>

            <form method="POST" id="category-disable-modal-form">
                @csrf
                @method('PATCH')
                <input type="hidden" name="confirm_disable_with_tours" value="1">

                <button type="submit" class="category-disable-modal-confirm">
                    Desactivar categoría y tours
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
