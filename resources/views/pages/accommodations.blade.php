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
        <section class="mb-14 scroll-hero">

            <form method="GET" action="{{ route('accommodations.index') }}" class="accommodation-filter-shell">

                <div class="accommodation-filter-header">
                    <div>
                        <p class="accommodation-filter-kicker">
                            {{ __('accommodations.filter_kicker') }}
                        </p>

                        <h2 class="accommodation-filter-title">
                            {{ __('accommodations.filter_title') }}
                        </h2>
                    </div>

                    <div class="accommodation-filter-actions accommodation-filter-actions-desktop">
                        <a href="{{ route('accommodations.index') }}" class="accommodation-filter-clear">
                            {{ __('accommodations.filter_clear') }}
                        </a>

                        <button type="submit" class="accommodation-filter-submit">
                            {{ __('accommodations.filter_button') }}
                        </button>
                    </div>
                </div>

                <div class="accommodation-filter-grid">

                    {{-- Search --}}
                    <div class="accommodation-filter-field accommodation-filter-field-search">
                        <label for="search" class="accommodation-filter-label">
                            {{ __('accommodations.filter_search') }}
                        </label>

                        <div class="accommodation-filter-input-wrap">
                            <svg class="accommodation-filter-input-icon" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" />
                            </svg>

                            <input
                                type="text"
                                id="search"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="{{ __('accommodations.filter_search_placeholder') }}"
                                class="accommodation-filter-input">
                        </div>
                    </div>

                    {{-- Guests --}}
                    <div class="accommodation-filter-field">
                        <label for="guests" class="accommodation-filter-label">
                            {{ __('accommodations.guests') }}
                        </label>

                        <input
                            type="number"
                            id="guests"
                            name="guests"
                            min="1"
                            value="{{ request('guests') }}"
                            placeholder="0"
                            class="accommodation-filter-input">
                    </div>

                    {{-- Bedrooms --}}
                    <div class="accommodation-filter-field">
                        <label for="bedrooms" class="accommodation-filter-label">
                            {{ __('accommodations.bedrooms') }}
                        </label>

                        <input
                            type="number"
                            id="bedrooms"
                            name="bedrooms"
                            min="1"
                            value="{{ request('bedrooms') }}"
                            placeholder="0"
                            class="accommodation-filter-input">
                    </div>

                    {{-- Beds --}}
                    <div class="accommodation-filter-field">
                        <label for="beds" class="accommodation-filter-label">
                            {{ __('accommodations.beds') }}
                        </label>

                        <input
                            type="number"
                            id="beds"
                            name="beds"
                            min="1"
                            value="{{ request('beds') }}"
                            placeholder="0"
                            class="accommodation-filter-input">
                    </div>

                    {{-- Bathrooms --}}
                    <div class="accommodation-filter-field">
                        <label for="bathrooms" class="accommodation-filter-label">
                            {{ __('accommodations.bathrooms') }}
                        </label>

                        <input
                            type="number"
                            id="bathrooms"
                            name="bathrooms"
                            min="1"
                            value="{{ request('bathrooms') }}"
                            placeholder="0"
                            class="accommodation-filter-input">
                    </div>
                </div>

                <div class="accommodation-filter-actions accommodation-filter-actions-mobile">
                    <a href="{{ route('accommodations.index') }}" class="accommodation-filter-clear">
                        {{ __('accommodations.filter_clear') }}
                    </a>

                    <button type="submit" class="accommodation-filter-submit">
                        {{ __('accommodations.filter_button') }}
                    </button>
                </div>

            </form>
        </section>

        {{-- ================= RESULTS GRID ================= --}}
        <section class="scroll-hero">
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
                                        {{ __('accommodations.book_now') }}
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

    </div>
</section>
@endsection