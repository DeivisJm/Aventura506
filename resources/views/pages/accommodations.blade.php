@php use Illuminate\Support\Str; @endphp

@extends('layouts.app')

@section('title', __('accommodations.page_title'))

@section('content')

<section class="accommodations-page">
    <div class="max-w-7xl mx-auto px-6 py-20">

        <header class="mb-20 text-center scroll-hero accommodations-hero">
            <span class="inline-block text-green-600 font-semibold tracking-wide uppercase text-sm opacity-0 animate-hero hero-delay-1">
                {{ __('accommodations.hero_badge') }}
            </span>

            <h1 class="mt-4 text-4xl md:text-5xl xl:text-6xl font-extrabold text-gray-900 dark:text-white leading-tight opacity-0 animate-hero hero-delay-2">
                {{ __('accommodations.hero_title_prefix') }}
                <span class="text-green-600">
                    {{ __('accommodations.hero_title_highlight') }}
                </span>
            </h1>

            <p class="mt-6 text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto opacity-0 animate-hero hero-delay-3">
                {{ __('accommodations.hero_description') }}
            </p>
        </header>

        <section class="mb-16">
            <h2 class="text-xl font-semibold mb-6 accommodations-filter-title text-gray-900 dark:text-white">
                {{ __('accommodations.filter_title') }}
            </h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                <a href="{{ route('accommodations.index', ['category' => 'all']) }}"
                   class="filter-card {{ $currentCategory === 'all' ? 'active' : '' }}">
                    {{ __('accommodations.filters.all') }}
                </a>

                @foreach($categories as $category)
                    @php
                        $categoryName = $category->translated_name ?? (
                            is_array($category->name ?? null)
                                ? ($category->name[app()->getLocale()] ?? $category->name['es'] ?? '')
                                : ($category->name ?? '')
                        );
                    @endphp

                    <a href="{{ route('accommodations.index', ['category' => $category->slug]) }}"
                       class="filter-card {{ $currentCategory === $category->slug ? 'active' : '' }}">
                        {{ $categoryName }}
                    </a>
                @endforeach
            </div>
        </section>

        <section class="scroll-hero">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">

                @forelse ($accommodations as $accommodation)
                    @php
                        $name = $accommodation->getTranslated('name');
                        $description = $accommodation->getTranslated('short_description');
                        $location = $accommodation->getTranslated('location_text');
                        $propertyType = $accommodation->getTranslated('property_type');
                        $imagePath = $accommodation->image_url;
                    @endphp

                    <article class="accommodation-card scroll-hero bg-white dark:bg-gray-900 rounded-3xl shadow hover:shadow-xl transition overflow-hidden border border-gray-100 dark:border-gray-800">
                        <div class="relative">
                            <img src="{{ $imagePath }}"
                                 alt="{{ $name }}"
                                 class="h-64 w-full object-cover">

                            @if($accommodation->is_featured)
                                <span class="absolute top-4 left-4 bg-white/90 text-green-700 text-xs font-semibold px-3 py-1 rounded-full shadow">
                                    {{ __('accommodations.featured') }}
                                </span>
                            @endif
                        </div>

                        <div class="p-6">
                            <div class="flex items-start justify-between gap-3 mb-3">
                                <div>
                                    <p class="text-sm text-green-600 font-medium">
                                        {{ $propertyType }}
                                    </p>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                        {{ $name }}
                                    </h3>
                                </div>

                                @if($accommodation->rating)
                                    <div class="text-sm font-semibold text-gray-700 dark:text-gray-200 whitespace-nowrap">
                                        ⭐ {{ number_format((float)$accommodation->rating, 1) }}
                                    </div>
                                @endif
                            </div>

                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                                {{ $location }}
                            </p>

                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">
                                {{ Str::limit($description, 120) }}
                            </p>

                            <div class="grid grid-cols-2 gap-3 text-sm text-gray-600 dark:text-gray-300 mb-5">
                                <div>👥 {{ $accommodation->max_guests }} {{ __('accommodations.guests') }}</div>
                                <div>🛏 {{ $accommodation->bedrooms }} {{ __('accommodations.bedrooms') }}</div>
                                <div>🛌 {{ $accommodation->beds }} {{ __('accommodations.beds') }}</div>
                                <div>🛁 {{ $accommodation->bathrooms }} {{ __('accommodations.bathrooms') }}</div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ __('accommodations.from_per_night') }}
                                    </p>
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">
                                        {{ $accommodation->currency }} {{ number_format((float)$accommodation->price_per_night, 2) }}
                                    </p>
                                </div>

                                <a href="{{ route('accommodations.show', $accommodation->slug) }}"
                                   class="btn-primary inline-block text-sm">
                                    {{ __('accommodations.view_more') }}
                                </a>
                            </div>
                        </div>
                    </article>

                @empty
                    <p class="col-span-3 text-center text-gray-500 dark:text-gray-400">
                        {{ __('accommodations.no_results') }}
                    </p>
                @endforelse

            </div>
        </section>

        @if ($accommodations->hasPages())
            <div class="mt-16 border-t border-gray-200 dark:border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('accommodations.showing') }}
                        <span class="font-semibold text-green-600">
                            {{ $accommodations->firstItem() }} - {{ $accommodations->lastItem() }}
                        </span>
                        {{ __('accommodations.of') }}
                        <span class="font-semibold">
                            {{ $accommodations->total() }}
                        </span>
                        {{ __('accommodations.results') }}
                    </p>

                    <div class="custom-pagination">
                        {{ $accommodations->onEachSide(1)->links('vendor.pagination.custom-green') }}
                    </div>
                </div>
            </div>
        @endif

    </div>
</section>

@endsection