@php use Illuminate\Support\Str; @endphp

@extends('layouts.app')

@section('title', __('tours.page_title'))

@section('content')

<section class="tours-page">

    <div class="max-w-7xl mx-auto px-6 py-20">

        {{-- ================= PAGE HEADER ================= --}}
        <header class="mb-20 text-center scroll-hero tours-hero">

            <span class="inline-block text-green-600 font-semibold tracking-wide uppercase text-sm
                         opacity-0 animate-hero hero-delay-1">
                {{ __('tours.hero_badge') }}
            </span>

            <h1 class="mt-4 text-4xl md:text-5xl xl:text-6xl font-extrabold
                       text-gray-900 leading-tight
                       opacity-0 animate-hero hero-delay-2">
                {{ __('tours.hero_title_prefix') }}
                <span class="text-green-600">
                    {{ __('tours.hero_title_highlight') }}
                </span>
            </h1>

            <p class="mt-6 text-lg text-gray-600 max-w-2xl mx-auto
                      opacity-0 animate-hero hero-delay-3">
                {{ __('tours.hero_description') }}
            </p>

        </header>

        {{-- ================= FILTER CARDS ================= --}}
        <section class="mb-16">

            <h2 class="text-xl font-semibold text-gray-800 mb-6">
                {{ __('tours.filter_title') }}
            </h2>

            @php
            $currentCategory = request('category', 'all');
            @endphp

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">

                @foreach([
                'all' => __('tours.filters.all'),
                'adventure' => __('tours.filters.adventure'),
                'extreme' => __('tours.filters.extreme'),
                'nature' => __('tours.filters.nature'),
                'water' => __('tours.filters.water'),
                'vehicle' => __('tours.filters.vehicle'),
                'horseback' => __('tours.filters.horseback'),
                ] as $value => $label)

                <a href="{{ route('tours.index', ['category' => $value]) }}"
                    class="filter-card {{ $currentCategory === $value ? 'active' : '' }}">
                    {{ $label }}
                </a>

                @endforeach

            </div>
        </section>

        {{-- ================= TOURS GRID ================= --}}
        <section class="scroll-hero">

            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">

                @forelse ($tours as $tour)

                @php
                // Descripción segura
                $description = '';

                if (is_array($tour->short_description ?? null)) {
                $description = $tour->short_description[app()->getLocale()]
                ?? $tour->short_description['es']
                ?? '';
                } elseif (!empty($tour->short_description)) {
                $description = $tour->short_description;
                } elseif (is_array($tour->description ?? null)) {
                $description = $tour->description[app()->getLocale()]
                ?? $tour->description['es']
                ?? '';
                } else {
                $description = $tour->description ?? '';
                }

                // 🔥 SOLUCIÓN ERROR NAME ARRAY
                $tourName = is_array($tour->name ?? null)
                ? ($tour->name[app()->getLocale()] ?? $tour->name['es'] ?? '')
                : $tour->name;

                // 🔥 Imagen segura
                $imagePath = !empty($tour->image)
                ? asset($tour->image)
                : asset('images/default-tour.jpg');
                @endphp

                <article class="scroll-hero bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">

                    <img src="{{ $imagePath }}"
                        alt="{{ $tourName }}"
                        class="h-48 w-full object-cover">

                    <div class="p-6">

                        <h3 class="text-xl font-semibold mb-2">
                            {{ $tourName }}
                        </h3>

                        <p class="text-gray-600 text-sm mb-4">
                            {{ Str::limit($description, 120) }}
                        </p>

                        <a href="{{ route('tours.show', $tour->slug) }}"
                            class="btn-primary inline-block text-sm">
                            {{ __('tours.view_more') }}
                        </a>

                    </div>

                </article>



                @empty

                <p class="col-span-3 text-center text-gray-500">
                    {{ __('tours.no_results') }}
                </p>

                @endforelse

            </div>


        </section>
        @if ($tours->hasPages())

        <div class="mt-16 border-t pt-8">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                {{-- LEFT COUNTER --}}
                <p class="text-sm text-gray-600">
                    {{ __('tours.showing') }}
                    <span class="font-semibold text-green-600">
                        {{ $tours->firstItem() }} - {{ $tours->lastItem() }}
                    </span>
                    {{ __('tours.of') }}
                    <span class="font-semibold">
                        {{ $tours->total() }}
                    </span>
                    {{ __('tours.results') }}
                </p>

                {{-- PAGINATION --}}
                <div class="custom-pagination">
                    {{ $tours->onEachSide(1)->links('vendor.pagination.custom-green') }}
                </div>

            </div>

        </div>

        @endif

    </div>

</section>

@endsection