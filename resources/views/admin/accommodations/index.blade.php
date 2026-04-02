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

        <div class="tour-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg 
            hover:shadow-2xl transition duration-300 overflow-hidden group
            {{ !$accommodation->is_active ? 'border-2 border-red-500' : '' }}">

            <img src="{{ $image }}"
                alt="{{ $name }}"
                class="h-48 w-full object-cover group-hover:scale-105 transition duration-300">

            <div class="p-6">

                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">
                    {{ $name }}
                </h3>

                <div class="flex justify-between items-center">

                    {{-- STATUS --}}
                    <span class="
                        inline-flex items-center gap-2
                        px-4 py-2
                        rounded-full
                        text-sm font-semibold
                        transition-all duration-300
                        shadow-sm
                        {{ $accommodation->is_active
                            ? 'bg-green-50 text-green-700 ring-1 ring-green-200 hover:bg-green-100'
                            : 'bg-red-50 text-red-700 ring-1 ring-red-200 hover:bg-red-100' }}
                    ">

                        @if($accommodation->is_active)
                            <svg class="w-4 h-4 text-green-600"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        @else
                            <svg class="w-4 h-4 text-red-600"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        @endif

                        {{ $accommodation->is_active ? 'Activo' : 'Desactivado' }}
                    </span>

                    {{-- TOGGLE --}}
                    <form method="POST"
                        action="{{ route('admin.accommodations.toggle', $accommodation) }}">
                        @csrf
                        @method('PATCH')

                        <button type="submit"
                            class="text-sm font-semibold transition-all duration-200
                            {{ $accommodation->is_active
                                ? 'text-red-600 hover:text-red-800'
                                : 'text-green-600 hover:text-green-800' }}">
                            {{ $accommodation->is_active ? 'Desactivar' : 'Activar' }}
                        </button>
                    </form>

                </div>

                {{-- EDIT / ORDER --}}
                <div class="mt-4 flex items-end justify-between gap-4 min-h-[64px]">

                    <a href="{{ route('admin.accommodations.edit', $accommodation) }}"
                        class="text-sm font-semibold text-cyan-500 hover:text-cyan-700 transition">
                        Editar
                    </a>

                    <div class="tour-position-box"
                        data-accommodation-id="{{ $accommodation->id }}"
                        data-update-url="{{ route('admin.accommodations.update-position', $accommodation) }}">

                        <span class="tour-position-label">
                            Orden
                        </span>

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

@endsection