@extends('admin.layouts.admin')

@section('admin-content')

<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-6 mb-10">

    <div>
        <h1 class="admin-page-title">Gestión de Hospedajes</h1>
        <p class="admin-page-subtitle">
            Administra, crea y edita los hospedajes disponibles
        </p>
    </div>

    <a href="{{ route('admin.accommodations.create') }}"
        class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 
               text-white px-6 py-3 rounded-xl shadow-lg transition font-medium">
        Nuevo Hospedaje
    </a>

</div>

{{-- ================= SEARCH ================= --}}
<form method="GET" id="search-form" class="relative mb-12 max-w-md">

    <input type="text"
        name="search"
        id="search-input"
        value="{{ request('search') }}"
        placeholder="Buscar hospedaje por nombre..."
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

{{-- ================= GRID ================= --}}
<div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">

    @forelse ($accommodations as $accommodation)

    @php
    $name = $accommodation->name['es'] ?? $accommodation->name['en'] ?? 'Hospedaje';
    $image = $accommodation->main_image
    ? asset($accommodation->main_image)
    : asset('images/default-accommodation.jpg');
    @endphp

    <div class="tour-card accommodation-admin-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg transition duration-300 overflow-hidden
    {{ !$accommodation->is_active ? 'accommodation-admin-card--inactive' : '' }}">

        <img src="{{ $image }}"
            alt="{{ $name }}"
            class="h-48 w-full object-cover transition duration-300">

        <div class="p-6 accommodation-admin-card-body">

            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 accommodation-admin-card-title">
                {{ $name }}
            </h3>

            {{-- TOP STATUS / TOGGLE --}}
            <div class="accommodation-admin-card-topbar">

                <span class="accommodation-admin-status-badge {{ $accommodation->is_active ? 'is-active' : 'is-inactive' }}">
                    @if($accommodation->is_active)
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    @else
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    @endif

                    <span>{{ $accommodation->is_active ? 'Activo' : 'Desactivado' }}</span>
                </span>

                <form method="POST"
                    action="{{ route('admin.accommodations.toggle', $accommodation) }}"
                    class="m-0">
                    @csrf
                    @method('PATCH')

                    <button type="submit"
                        class="accommodation-admin-toggle-link {{ $accommodation->is_active ? 'accommodation-admin-toggle-link--warning' : 'accommodation-admin-toggle-link--success' }}">
                        {{ $accommodation->is_active ? 'Desactivar' : 'Activar' }}
                    </button>
                </form>

            </div>

            <div class="accommodation-admin-card-bottom">

                <div class="accommodation-admin-card-actions-row">

                    <a href="{{ route('admin.accommodations.edit', $accommodation) }}"
                        class="accommodation-admin-action-link accommodation-admin-action-link-edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.65-1.65a2.121 2.121 0 113 3L7.5 21H3v-4.5L16.862 4.487z" />
                        </svg>
                        <span>Editar</span>
                    </a>

                    <form method="POST"
                        action="{{ route('admin.accommodations.destroy', $accommodation) }}"
                        class="m-0 accommodation-admin-delete-form js-delete-accommodation-form"
                        data-accommodation-name="{{ $name }}">
                        @csrf
                        @method('DELETE')

                        <button type="button"
                            class="accommodation-admin-action-link accommodation-admin-action-link-delete js-open-delete-modal">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V5a1 1 0 011-1h4a1 1 0 011 1v2m-7 0v11m4-11v11m4-11v11M5 7l1 13a1 1 0 001 1h10a1 1 0 001-1l1-13" />
                            </svg>
                            <span>Eliminar</span>
                        </button>
                    </form>

                </div>

                <div class="accommodation-admin-order-section accommodation-admin-order-section--separated">
                    <span class="accommodation-admin-order-label">Orden</span>

                    <div class="tour-position-box"
                        data-accommodation-id="{{ $accommodation->id }}"
                        data-update-url="{{ route('admin.accommodations.update-position', $accommodation) }}">

                        <select class="tour-position-select"
                            aria-label="Seleccionar posición del hospedaje">
                            @for($position = 1; $position <= $totalAccommodations; $position++)
                                <option value="{{ $position }}"
                                {{ (int) $accommodation->sort_order === $position ? 'selected' : '' }}>
                                {{ $position }}
                                </option>
                                @endfor
                        </select>
                    </div>
                </div>
            </div>

        </div>

    </div>

    @empty

    <p class="col-span-3 text-center text-gray-500">
        No hay hospedajes registrados.
    </p>

    @endforelse

</div>

@if($accommodations->hasPages())

<div class="mt-16 border-t pt-8">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

        <p class="text-sm text-gray-600">
            Mostrando
            <span class="font-semibold text-green-600">
                {{ $accommodations->firstItem() }} - {{ $accommodations->lastItem() }}
            </span>
            de
            <span class="font-semibold">
                {{ $accommodations->total() }}
            </span>
            hospedajes
        </p>

        <div class="custom-pagination">
            {{ $accommodations->appends(request()->query())->onEachSide(1)->links('vendor.pagination.custom-green') }}
        </div>

    </div>

</div>

@endif
<div class="accommodation-delete-modal" id="accommodation-delete-modal" aria-hidden="true">
    <div class="accommodation-delete-modal-backdrop" data-delete-modal-close></div>

    <div class="accommodation-delete-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="accommodation-delete-modal-title">
        <div class="accommodation-delete-modal-header">
            <div class="accommodation-delete-modal-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86l-7.5 13A1 1 0 003.66 18h16.68a1 1 0 00.87-1.5l-7.5-13a1 1 0 00-1.74 0z" />
                </svg>
            </div>

            <div>
                <h3 class="accommodation-delete-modal-title" id="accommodation-delete-modal-title">
                    Eliminar hospedaje
                </h3>
                <p class="accommodation-delete-modal-subtitle" id="accommodation-delete-modal-description">
                    Esta acción eliminará el hospedaje seleccionado de forma permanente.
                </p>
            </div>
        </div>

        <div class="accommodation-delete-modal-body">
            <p class="accommodation-delete-modal-note">
                Esta acción no se puede deshacer. Asegúrate de que realmente deseas eliminar este hospedaje del sistema.
            </p>
        </div>

        <div class="accommodation-delete-modal-actions">
            <button type="button" class="accommodation-delete-modal-cancel" data-delete-modal-close>
                Cancelar
            </button>

            <button type="button" class="accommodation-delete-modal-confirm" id="accommodation-delete-modal-confirm">
                Sí, eliminar
            </button>
        </div>
    </div>
</div>
@endsection