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

        {{-- ================= SMART FILTER ================= --}}
        @php
        $currentCategory = request('category', 'all');
        $currentSearch = request('search', '');

        $selectedCategory = $categories->firstWhere('slug', $currentCategory);
        $selectedCategoryName = $selectedCategory
        ? $selectedCategory->translated_name
        : __('tours.filter_all_categories');
        @endphp

        <section class="mb-16 scroll-hero tours-smart-filter-section">

            <form method="GET" action="{{ route('tours.index') }}" class="tours-smart-filter-shell">

                <div class="tours-smart-filter-header">
                    <div>
                        <p class="tours-smart-filter-kicker">
                            {{ __('tours.filter_kicker') }}
                        </p>

                        <h2 class="tours-smart-filter-title">
                            {{ __('tours.filter_title') }}
                        </h2>
                    </div>
                </div>

                <div class="tours-smart-filter-bar">

                    {{-- Buscar --}}
                    <div class="tours-smart-filter-field tours-smart-filter-field-search">
                        <label for="search" class="tours-smart-filter-label">
                            {{ __('tours.filter_search') }}
                        </label>

                        <div class="tours-smart-input-wrap">
                            <svg class="tours-smart-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="11" cy="11" r="7"></circle>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 20l-3.5-3.5"></path>
                            </svg>

                            <input
                                type="text"
                                id="search"
                                name="search"
                                value="{{ $currentSearch }}"
                                placeholder="{{ __('tours.filter_search_placeholder') }}"
                                class="tours-smart-input">
                        </div>
                    </div>

                    {{-- Categoría custom --}}
                    <div class="tours-smart-filter-field tours-smart-filter-field-category">
                        <label class="tours-smart-filter-label">
                            {{ __('tours.filter_category') }}
                        </label>

                        <div class="tours-smart-dropdown" data-category-dropdown>
                            <input
                                type="hidden"
                                name="category"
                                value="{{ $currentCategory }}"
                                data-category-input>

                            <button
                                type="button"
                                class="tours-smart-dropdown-trigger"
                                data-category-trigger
                                aria-expanded="false"
                                aria-haspopup="listbox">
                                <span class="tours-smart-dropdown-trigger-text" data-category-label>
                                    {{ $selectedCategoryName }}
                                </span>

                                <svg class="tours-smart-dropdown-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6" />
                                </svg>
                            </button>

                            <div class="tours-smart-dropdown-panel" data-category-panel hidden>
                                <div class="tours-smart-dropdown-options" role="listbox">

                                    <button
                                        type="button"
                                        class="tours-smart-dropdown-option {{ $currentCategory === 'all' ? 'is-active' : '' }}"
                                        data-category-option
                                        data-value="all"
                                        data-label="{{ __('tours.filter_all_categories') }}">
                                        {{ __('tours.filter_all_categories') }}
                                    </button>

                                    @foreach($categories as $category)
                                    <button
                                        type="button"
                                        class="tours-smart-dropdown-option {{ $currentCategory === $category->slug ? 'is-active' : '' }}"
                                        data-category-option
                                        data-value="{{ $category->slug }}"
                                        data-label="{{ $category->translated_name }}">
                                        {{ $category->translated_name }}
                                    </button>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Acciones --}}
                    <div class="tours-smart-filter-actions">
                        <button type="submit" class="tours-smart-submit">
                            {{ __('tours.filter_button') }}
                        </button>

                        <a href="{{ route('tours.index') }}" class="tours-smart-clear">
                            {{ __('tours.filter_clear') }}
                        </a>
                    </div>

                </div>

                @if($currentSearch || $currentCategory !== 'all')
                <div class="tours-smart-filter-summary">
                    <span class="tours-smart-filter-summary-label">
                        {{ __('tours.filter_active_label') }}
                    </span>

                    @if($currentSearch)
                    <span class="tours-smart-filter-chip">
                        {{ __('tours.filter_active_search') }}: {{ $currentSearch }}
                    </span>
                    @endif

                    @if($currentCategory !== 'all')
                    <span class="tours-smart-filter-chip">
                        {{ __('tours.filter_active_category') }}: {{ $selectedCategoryName }}
                    </span>
                    @endif
                </div>
                @endif

            </form>
        </section>

        {{-- ================= TOURS GRID ================= --}}
        <section class="scroll-hero">

            <div class="tours-premium-grid">
                @forelse ($tours as $tour)

                @php
                // secure description
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

                // Safe translated name
                $tourName = is_array($tour->name ?? null)
                ? ($tour->name[app()->getLocale()] ?? $tour->name['es'] ?? '')
                : $tour->name;

                // Safe image URL from model accessor
                $imagePath = $tour->image_url;
                @endphp

                <article class="tour-public-card scroll-hero">

                    <div class="tour-public-card-image-frame">
                        <img
                            src="{{ $imagePath }}"
                            alt="{{ $tourName }}"
                            class="tour-public-card-image">
                    </div>

                    <div class="tour-public-card-body">

                        <h3 class="tour-public-card-title">
                            {{ $tourName }}
                        </h3>

                        <p class="tour-public-card-text">
                            {{ Str::limit($description, 120) }}
                        </p>

                        <a href="{{ route('tours.show', $tour->slug) }}"
                            class="btn-primary inline-block text-sm">
                            {{ __('tours.view_more') }}
                        </a>

                    </div>

                </article>

                @empty

                <p class="tours-empty-state">
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
                    {{ $tours->appends(request()->query())->onEachSide(1)->links('vendor.pagination.custom-green') }}
                </div>

            </div>

        </div>

        @endif

    </div>

</section>

@endsection