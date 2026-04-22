@php use Illuminate\Support\Str; @endphp

@extends('layouts.app')

@section('title', __('accommodations.title'))

@section('content')
<section class="accommodations-page">

    <div class="max-w-7xl mx-auto px-6 py-20">

        {{-- ================= PAGE HEADER ================= --}}
        <header class="mb-16 text-center scroll-hero accommodations-hero">

            <span class="inline-block text-green-600 font-semibold tracking-wide uppercase text-sm opacity-0 animate-hero hero-delay-1">
                {{ __('accommodations.hero_tag') }}
            </span>

            <h1 class="mt-4 text-4xl md:text-5xl xl:text-6xl font-extrabold text-gray-900 dark:text-white leading-tight opacity-0 animate-hero hero-delay-2">
                {{ __('accommodations.hero_title_line_1') }}
                <span class="text-green-600">
                    {{ __('accommodations.hero_title_highlight') }}
                </span>
            </h1>

            <p class="mt-6 text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto leading-relaxed opacity-0 animate-hero hero-delay-3">
                {{ __('accommodations.hero_description') }}
            </p>

        </header>

        {{-- ================= FILTER PANEL ================= --}}
        <section class="mb-14 scroll-hero accommodations-filter-section">

            <form method="GET" action="{{ route('accommodations.index') }}" class="accommodation-filter-shell accommodation-filter-shell-airbnb">

                <div class="accommodation-filter-header">
                    <div>
                        <p class="accommodation-filter-kicker">
                            {{ __('accommodations.filter_kicker') }}
                        </p>

                        <h2 class="accommodation-filter-title">
                            {{ __('accommodations.filter_title') }}
                        </h2>
                    </div>
                </div>
                <div class="accommodation-airbnb-bar">

                    {{-- Buscar --}}
                    <div class="accommodation-airbnb-col accommodation-airbnb-col-search">
                        <label for="search" class="accommodation-airbnb-label">
                            {{ __('accommodations.filter_search') }}
                        </label>

                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="{{ __('accommodations.filter_search_placeholder') }}"
                            class="accommodation-airbnb-input">
                    </div>

                    {{-- Huéspedes y más --}}
                    <div class="accommodation-airbnb-col accommodation-airbnb-col-more">
                        <label class="accommodation-airbnb-label">
                            {{ __('accommodations.filter_more') }}
                        </label>

                        <button
                            type="button"
                            class="accommodation-airbnb-trigger"
                            data-filter-toggle
                            aria-expanded="false">
                            <span
                                data-filter-summary
                                data-placeholder="{{ __('accommodations.filter_more_placeholder') }}"
                                data-label-guests="{{ __('accommodations.filter_summary_guests') }}"
                                data-label-bedrooms="{{ __('accommodations.filter_summary_bedrooms') }}"
                                data-label-beds="{{ __('accommodations.filter_summary_beds') }}"
                                data-label-bathrooms="{{ __('accommodations.filter_summary_bathrooms') }}">
                                {{ __('accommodations.filter_more_placeholder') }}
                            </span>
                        </button>
                    </div>

                    {{-- Botón buscar --}}
                    <button type="submit" class="accommodation-airbnb-submit">
                        {{ __('accommodations.filter_button') }}
                    </button>

                    {{-- Panel --}}
                    <div class="accommodation-airbnb-panel" data-filter-panel hidden>
                        <div class="accommodation-airbnb-panel-inner">

                            <div class="accommodation-airbnb-row">
                                <div>
                                    <strong>{{ __('accommodations.filter_guests_title') }}</strong>
                                    <p>{{ __('accommodations.filter_guests_description') }}</p>
                                </div>

                                <div class="accommodation-airbnb-stepper">
                                    <button type="button" data-action="minus" data-target="guests">−</button>
                                    <input type="hidden" name="guests" value="{{ request('guests', 0) }}" data-input="guests">
                                    <span data-value="guests">{{ request('guests', 0) }}</span>
                                    <button type="button" data-action="plus" data-target="guests">+</button>
                                </div>
                            </div>

                            <div class="accommodation-airbnb-row">
                                <div>
                                    <strong>{{ __('accommodations.filter_bedrooms_title') }}</strong>
                                    <p>{{ __('accommodations.filter_bedrooms_description') }}</p>
                                </div>

                                <div class="accommodation-airbnb-stepper">
                                    <button type="button" data-action="minus" data-target="bedrooms">−</button>
                                    <input type="hidden" name="bedrooms" value="{{ request('bedrooms', 0) }}" data-input="bedrooms">
                                    <span data-value="bedrooms">{{ request('bedrooms', 0) }}</span>
                                    <button type="button" data-action="plus" data-target="bedrooms">+</button>
                                </div>
                            </div>

                            <div class="accommodation-airbnb-row">
                                <div>
                                    <strong>{{ __('accommodations.filter_beds_title') }}</strong>
                                    <p>{{ __('accommodations.filter_beds_description') }}</p>
                                </div>

                                <div class="accommodation-airbnb-stepper">
                                    <button type="button" data-action="minus" data-target="beds">−</button>
                                    <input type="hidden" name="beds" value="{{ request('beds', 0) }}" data-input="beds">
                                    <span data-value="beds">{{ request('beds', 0) }}</span>
                                    <button type="button" data-action="plus" data-target="beds">+</button>
                                </div>
                            </div>

                            <div class="accommodation-airbnb-row accommodation-airbnb-row-last">
                                <div>
                                    <strong>{{ __('accommodations.filter_bathrooms_title') }}</strong>
                                    <p>{{ __('accommodations.filter_bathrooms_description') }}</p>
                                </div>

                                <div class="accommodation-airbnb-stepper">
                                    <button type="button" data-action="minus" data-target="bathrooms">−</button>
                                    <input type="hidden" name="bathrooms" value="{{ request('bathrooms', 0) }}" data-input="bathrooms">
                                    <span data-value="bathrooms">{{ request('bathrooms', 0) }}</span>
                                    <button type="button" data-action="plus" data-target="bathrooms">+</button>
                                </div>
                            </div>

                            <div class="accommodation-airbnb-panel-actions">
                                <a href="{{ route('accommodations.index') }}" class="accommodation-filter-clear">
                                    {{ __('accommodations.filter_clear') }}
                                </a>

                                <button type="submit" class="accommodation-filter-submit">
                                    {{ __('accommodations.filter_button') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>

        {{-- ================= RESULTS GRID ================= --}}
        <section class="scroll-hero accommodations-results-section">
            @if($accommodations->isEmpty())
            <div class="text-center py-16">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('accommodations.empty_title') }}
                </h2>

                <p class="mt-4 text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    {{ __('accommodations.empty_description') }}
                </p>
            </div>
            @else
            <div class="accommodations-grid">
                @foreach($accommodations as $index => $accommodation)
                @php
                $name = $accommodation->getTranslated('name');
                $description = $accommodation->getTranslated('short_description');
                $location = $accommodation->getTranslated('location');
                $gallery = $accommodation->getAllImages();

                $amenities = $accommodation->getAmenityItems();
                $visibleAmenities = array_slice($amenities, 0, 5);

                $cardId = 'accommodation-slider-' . $accommodation->id . '-' . $index;
                @endphp

                <article class="accommodation-card">
                    {{-- ================= IMAGE / SLIDER ================= --}}
                    <div class="accommodation-media" data-slider="{{ $cardId }}">
                        <div class="accommodation-slider-track">
                            @foreach($gallery as $image)
                            <div class="accommodation-slide">
                                <div
                                    class="accommodation-slide-bg"
                                    style="background-image: url('{{ asset($image) }}');">
                                </div>

                                <img
                                    src="{{ asset($image) }}"
                                    alt="{{ $name }} - image {{ $loop->iteration }}"
                                    class="accommodation-slide-image">
                            </div>
                            @endforeach
                        </div>

                        <div class="accommodation-media-overlay"></div>

                        @if(count($gallery) > 1)
                        <button type="button" class="accommodation-arrow accommodation-arrow-prev" data-slider-prev aria-label="Previous image">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6" />
                            </svg>
                        </button>

                        <button type="button" class="accommodation-arrow accommodation-arrow-next" data-slider-next aria-label="Next image">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6" />
                            </svg>
                        </button>
                        @endif

                        @if($location)
                        <div class="accommodation-location-badge">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-6-5.686-6-11a6 6 0 1112 0c0 5.314-6 11-6 11z" />
                                <circle cx="12" cy="10" r="2.5" />
                            </svg>
                            <span>{{ $location }}</span>
                        </div>
                        @endif

                        @if(count($gallery) > 1)
                        <div class="accommodation-slider-indicators-wrap">
                            <div class="accommodation-slider-indicators">
                                @foreach($gallery as $image)
                                <button
                                    type="button"
                                    class="accommodation-indicator {{ $loop->first ? 'is-active' : '' }}"
                                    data-slide-to="{{ $loop->index }}"
                                    aria-label="Go to image {{ $loop->iteration }}">
                                </button>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- ================= CARD CONTENT ================= --}}
                    <div class="accommodation-card-body">
                        <div class="accommodation-card-top">
                            <h3 class="accommodation-card-title">
                                {{ $name }}
                            </h3>

                            <p class="accommodation-card-description">
                                {{ Str::limit($description, 145) }}
                            </p>
                        </div>

                        {{-- ================= PROPERTY META ================= --}}
                        <div class="accommodation-meta-grid">
                            <div class="accommodation-meta-item">
                                <span class="accommodation-meta-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20a4 4 0 00-8 0M12 12a4 4 0 100-8 4 4 0 000 8M21 20a4 4 0 00-3-3.87M16 4.13a4 4 0 010 7.75" />
                                    </svg>
                                </span>
                                <div class="accommodation-meta-text">
                                    <strong>{{ $accommodation->guests ?? 0 }}</strong>
                                    <span>{{ __('accommodations.guests') }}</span>
                                </div>
                            </div>

                            <div class="accommodation-meta-item">
                                <span class="accommodation-meta-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M5 10V7a2 2 0 012-2h10a2 2 0 012 2v3M4 10v7M20 10v7M4 17h16" />
                                    </svg>
                                </span>
                                <div class="accommodation-meta-text">
                                    <strong>{{ $accommodation->bedrooms ?? 0 }}</strong>
                                    <span>{{ __('accommodations.bedrooms') }}</span>
                                </div>
                            </div>

                            <div class="accommodation-meta-item">
                                <span class="accommodation-meta-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 11h16M6 11V8a2 2 0 012-2h8a2 2 0 012 2v3M5 11v6M19 11v6M9 14h6" />
                                    </svg>
                                </span>
                                <div class="accommodation-meta-text">
                                    <strong>{{ $accommodation->beds ?? 0 }}</strong>
                                    <span>{{ __('accommodations.beds') }}</span>
                                </div>
                            </div>

                            <div class="accommodation-meta-item">
                                <span class="accommodation-meta-icon">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.9" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10M9 17V9a3 3 0 116 0v8M5 17h14" />
                                    </svg>
                                </span>
                                <div class="accommodation-meta-text">
                                    <strong>{{ $accommodation->bathrooms ?? 0 }}</strong>
                                    <span>{{ __('accommodations.bathrooms') }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- ================= AMENITIES ================= --}}
                        @if(!empty($visibleAmenities))
                        <div class="accommodation-amenities">
                            @foreach($visibleAmenities as $amenity)
                            <span class="accommodation-amenity-chip">
                                <span class="accommodation-amenity-icon">{!! $amenity['icon'] !!}</span>
                                <span>{{ $amenity['label'] }}</span>
                            </span>
                            @endforeach
                        </div>
                        @endif

                        {{-- ================= CALL TO ACTION ================= --}}
                        <div class="accommodation-card-footer">
                            <a
                                href="{{ $accommodation->external_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="accommodation-cta">

                                <span class="accommodation-cta-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                                        <path
                                            d="M12 3.8c-1.15 0-2.03.7-2.63 2.02l-4.94 10.87c-.22.48-.33.94-.33 1.36 0 1.32 1 2.25 2.34 2.25 1 0 1.88-.52 2.6-1.54L12 14.7l3.96 4.06c.72 1.02 1.6 1.54 2.6 1.54 1.34 0 2.34-.93 2.34-2.25 0-.42-.11-.88-.33-1.36L15.63 5.82C15.03 4.5 14.15 3.8 13 3.8h-1Z"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M9.55 10.55c0-1.38 1.05-2.45 2.45-2.45s2.45 1.07 2.45 2.45S13.4 13 12 13s-2.45-1.07-2.45-2.45Z"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>

                                <span class="accommodation-cta-text">
                                    {{ __('accommodations.book_now') }}
                                </span>
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
            @endif
        </section>

        @if ($accommodations->hasPages())

        <div class="mt-16 border-t pt-8">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                {{-- LEFT COUNTER --}}
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('accommodations.showing') }}
                    <span class="font-semibold text-green-600">
                        {{ $accommodations->firstItem() }} - {{ $accommodations->lastItem() }}
                    </span>
                    {{ __('accommodations.of') }}
                    <span class="font-semibold text-gray-900 dark:text-white">
                        {{ $accommodations->total() }}
                    </span>
                    {{ __('accommodations.results') }}
                </p>

                {{-- PAGINATION --}}
                <div class="custom-pagination">
                    {{ $accommodations->appends(request()->query())->onEachSide(1)->links('vendor.pagination.custom-green') }}
                </div>

            </div>

        </div>

        @endif

    </div>
</section>
@endsection