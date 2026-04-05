@extends('admin.layouts.admin')

@section('admin-content')

<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-6 mb-10">

    <div>
        <h1 class="admin-page-title">Gestión de Tours</h1>
        <p class="admin-page-subtitle">
            Administra, crea y edita los tours disponibles
        </p>
    </div>

    <a href="{{ route('admin.tours.create') }}"
        class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 
               text-white px-6 py-3 rounded-xl shadow-lg transition font-medium">
        Nuevo Tour
    </a>

</div>

{{-- ================= BUSCADOR ================= --}}
<form method="GET" id="search-form" class="relative mb-12 max-w-md">

    <input type="text"
        name="search"
        id="search-input"
        value="{{ request('search') }}"
        placeholder="Buscar tour por nombre..."
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

    <div id="autocomplete-results"
        class="absolute w-full mt-2 bg-white dark:bg-gray-800
               border border-gray-200 dark:border-gray-700
               rounded-xl shadow-lg hidden z-50">
    </div>

</form>

{{-- ================= GRID ================= --}}
<div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">

    @forelse ($tours as $tour)

    @php
    $tourName = is_array($tour->name) ? ($tour->name['es'] ?? '') : $tour->name;
    @endphp

    <div class="tour-card tour-admin-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg transition duration-300 overflow-hidden
    {{ !$tour->active ? 'tour-admin-card--inactive' : '' }}"
        data-name="{{ $tourName }}">

        <img src="{{ $tour->image ? asset($tour->image) : asset('images/default-tour.jpg') }}"
            class="h-48 w-full object-cover">

        <div class="p-6 tour-admin-card-body">

            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 tour-admin-card-title">
                {{ $tourName }}
            </h3>

            <div class="tour-admin-card-topbar">

                <span class="tour-admin-status-badge {{ $tour->active ? 'is-active' : 'is-inactive' }}">
                    @if($tour->active)
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    @else
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    @endif

                    <span>{{ $tour->active ? 'Activo' : 'Desactivado' }}</span>
                </span>

                <form method="POST"
                    action="{{ route('admin.tours.toggle', $tour) }}"
                    class="m-0">
                    @csrf
                    @method('PATCH')

                    <button type="submit"
                        class="tour-admin-toggle-link {{ $tour->active ? 'tour-admin-toggle-link--warning' : 'tour-admin-toggle-link--success' }}">
                        {{ $tour->active ? 'Desactivar' : 'Activar' }}
                    </button>
                </form>

            </div>

            <div class="tour-admin-card-bottom">

                <div class="tour-admin-card-actions-row">

                    <a href="{{ route('admin.tours.edit', $tour) }}"
                        class="tour-admin-action-link tour-admin-action-link-edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.65-1.65a2.121 2.121 0 113 3L7.5 21H3v-4.5L16.862 4.487z" />
                        </svg>
                        <span>Editar</span>
                    </a>

                    <form method="POST"
                        action="{{ route('admin.tours.destroy', $tour) }}"
                        class="m-0 tour-admin-delete-form js-delete-tour-form"
                        data-tour-name="{{ $tourName }}">
                        @csrf
                        @method('DELETE')

                        <button type="button"
                            class="tour-admin-action-link tour-admin-action-link-delete js-open-tour-delete-modal">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V5a1 1 0 011-1h4a1 1 0 011 1v2m-7 0v11m4-11v11m4-11v11M5 7l1 13a1 1 0 001 1h10a1 1 0 001-1l1-13" />
                            </svg>
                            <span>Eliminar</span>
                        </button>
                    </form>

                </div>

                <div class="tour-admin-order-section">
                    <span class="tour-admin-order-label">Orden</span>

                    <div class="tour-position-box"
                        data-tour-id="{{ $tour->id }}"
                        data-update-url="{{ route('admin.tours.update-position', $tour) }}">

                        <select class="tour-position-select"
                            aria-label="Seleccionar posición del tour">
                            @for($position = 1; $position <= $totalTours; $position++)
                                <option value="{{ $position }}"
                                {{ (int) $tour->sort_order === $position ? 'selected' : '' }}>
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
        No hay tours registrados.
    </p>

    @endforelse

</div>

{{-- Paginas contador --}}

@if($tours->hasPages())

<div class="mt-16 border-t pt-8">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

        {{-- CONTADOR IZQUIERDA --}}
        <p class="text-sm text-gray-600">
            Mostrando
            <span class="font-semibold text-green-600">
                {{ $tours->firstItem() }} - {{ $tours->lastItem() }}
            </span>
            de
            <span class="font-semibold">
                {{ $tours->total() }}
            </span>
            tours
        </p>

        {{-- PAGINACIÓN DERECHA --}}
        <div class="custom-pagination">
            {{ $tours->appends(request()->query())->onEachSide(1)->links('vendor.pagination.custom-green') }}
        </div>

    </div>

</div>

@endif

<div class="tour-delete-modal" id="tour-delete-modal" aria-hidden="true">
    <div class="tour-delete-modal-backdrop" data-tour-delete-modal-close></div>

    <div class="tour-delete-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="tour-delete-modal-title">
        <div class="tour-delete-modal-header">
            <div class="tour-delete-modal-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86l-7.5 13A1 1 0 003.66 18h16.68a1 1 0 00.87-1.5l-7.5-13a1 1 0 00-1.74 0z" />
                </svg>
            </div>

            <div>
                <h3 class="tour-delete-modal-title" id="tour-delete-modal-title">
                    Eliminar tour
                </h3>
                <p class="tour-delete-modal-subtitle" id="tour-delete-modal-description">
                    Esta acción eliminará el tour seleccionado de forma permanente.
                </p>
            </div>
        </div>

        <div class="tour-delete-modal-body">
            <p class="tour-delete-modal-note">
                Esta acción no se puede deshacer. Si el tour tiene reservas asociadas, el sistema impedirá su eliminación.
            </p>
        </div>

        <div class="tour-delete-modal-actions">
            <button type="button" class="tour-delete-modal-cancel" data-tour-delete-modal-close>
                Cancelar
            </button>

            <button type="button" class="tour-delete-modal-confirm" id="tour-delete-modal-confirm">
                Sí, eliminar
            </button>
        </div>
    </div>
</div>

@endsection