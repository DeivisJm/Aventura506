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

            {{-- Filter cards container --}}
            <div id="tour-filters"
                class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">

                <button class="filter-card active" data-category="all">
                    {{ __('tours.filters.all') }}
                </button>

                <button class="filter-card" data-category="adventure">
                    {{ __('tours.filters.adventure') }}
                </button>

                <button class="filter-card" data-category="extreme">
                    {{ __('tours.filters.extreme') }}
                </button>

                <button class="filter-card" data-category="nature">
                    {{ __('tours.filters.nature') }}
                </button>

                <button class="filter-card" data-category="water">
                    {{ __('tours.filters.water') }}
                </button>

                <button class="filter-card" data-category="vehicle">
                    {{ __('tours.filters.vehicle') }}
                </button>

            </div>
        </section>

        {{-- ================= TOURS GRID ================= --}}
        <section class="scroll-hero">

            <div id="tours-grid"
                class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                {{-- Cards rendered by JS --}}
            </div>

            <p id="no-results"
                class="hidden mt-12 text-center text-gray-500">
                {{ __('tours.no_results') }}
            </p>

        </section>

    </div>
</section>

@endsection
