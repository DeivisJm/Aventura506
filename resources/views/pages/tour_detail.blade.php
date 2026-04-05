@extends('layouts.app')

@section('title', $tour->getTranslated('name') ?? 'Tour')

@section('content')

{{-- ================= HERO PRO ================= --}}
<section class="tour-detail-hero">

    <div class="tour-detail-hero-media">
        <img
            src="{{ $tour->image_url }}"
            alt="{{ $tour->getTranslated('name') }}"
            class="tour-detail-hero-image">

        <div class="tour-detail-hero-overlay"></div>
    </div>

    <div class="tour-detail-hero-content">

        <div class="tour-detail-hero-badge">
            <span class="tour-detail-hero-badge-text">
                @if($tour->category)
                {{ strtoupper(__('categories.' . strtolower($tour->category->slug))) }}
                @endif
            </span>
        </div>

        <h1 class="tour-detail-hero-title">
            {{ $tour->getTranslated('name') }}
        </h1>

        <p class="tour-detail-hero-description">
            {{ $tour->getTranslated('description') }}
        </p>

        <div class="tour-detail-hero-meta">

            {{-- Duration --}}
            @if($tour->detail?->duration)
            <div class="tour-detail-hero-pill">

                <div class="tour-detail-hero-pill-icon">
                    <svg class="w-4 h-4 text-white"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                    </svg>
                </div>

                <span class="tour-detail-hero-pill-text">
                    {{ $tour->detail->getTranslated('duration') }}
                </span>

            </div>
            @endif

            {{-- Start Hours --}}
            @if($tour->detail?->start_hours_text)
            <div class="tour-detail-hero-pill">

                <div class="tour-detail-hero-pill-icon">
                    <svg class="w-4 h-4 text-white"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3m-9 8h10m-11 8h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>

                <span class="tour-detail-hero-pill-text">
                    {{ $tour->detail->getTranslated('start_hours_text') }}
                </span>

            </div>
            @endif

            {{-- Company --}}
            @if($tour->company?->name)
            <div class="tour-detail-hero-pill">

                <div class="tour-detail-hero-pill-icon">
                    <svg class="w-4 h-4 text-white"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 21h18M4 21V7a1 1 0 011-1h3V4a1 1 0 011-1h6a1 1 0 011 1v2h3a1 1 0 011 1v14M9 21V9h6v12" />
                    </svg>
                </div>

                <span class="tour-detail-hero-pill-text">
                    {{ $tour->company->name }}
                </span>

            </div>
            @endif

        </div>

    </div>
</section>


<section class="max-w-7xl mx-auto px-6 py-24">

    <div class="grid lg:grid-cols-3 gap-16">

        <div class="lg:col-span-2 space-y-20">

            {{-- ================= ABOUT ================= --}}
            <section>

                <div class="mb-12">
                    <div class="tour-detail-section-heading">
                        <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-main">
                            {{ __('tour_detail.about_title') }}
                        </h2>
                    </div>
                </div>

                <div class="max-w-3xl text-lg text-muted leading-relaxed space-y-6">
                    {{ $tour->detail?->getTranslated('full_description') 
                ?? $tour->getTranslated('description') }}
                </div>

            </section>

            {{-- ================= INCLUDES ================= --}}
            @if($tour->detail?->includes)
            <section class="tour-detail-section-block">

                <div class="mb-12">
                    <div class="tour-detail-section-heading">
                        <h3 class="text-2xl font-semibold tracking-tight text-main">
                            {{ __('tour_detail.includes_title') }}
                        </h3>
                    </div>
                </div>

                @php
                $includeItems = $tour->detail?->getIncludeItems() ?? [];
                @endphp

                <div class="tour-detail-feature-list">
                    @foreach($includeItems as $item)
                    <div class="tour-detail-feature-row">
                        <span class="tour-detail-feature-icon">
                            {!! $item['icon'] !!}
                        </span>

                        <p class="tour-detail-feature-text">
                            {{ $item['label'] }}
                        </p>
                    </div>
                    @endforeach
                </div>

            </section>
            @endif


            {{-- ================= IDEAL FOR ================= --}}
            @if($tour->detail?->ideal_for)
            <section class="tour-detail-section-block">

                <div class="mb-12">
                    <div class="tour-detail-section-heading">
                        <h3 class="text-2xl font-semibold tracking-tight text-main">
                            {{ __('tour_detail.ideal_for_title') }}
                        </h3>
                    </div>
                </div>

                @php
                $idealForItems = $tour->detail?->getIdealForItems() ?? [];
                @endphp

                <div class="tour-detail-ideal-list-premium">
                    @foreach($idealForItems as $item)
                    <div class="tour-detail-ideal-row">
                        <span class="tour-detail-ideal-row-icon">
                            {!! $item['icon'] !!}
                        </span>

                        <p class="tour-detail-ideal-row-text">
                            {{ $item['label'] }}
                        </p>
                    </div>
                    @endforeach
                </div>

            </section>
            @endif


            {{-- ================= RECOMMENDATIONS ================= --}}
            @if($tour->detail?->recommendations)
            <section class="tour-detail-section-block">

                <div class="mb-12">
                    <div class="tour-detail-section-heading">
                        <h3 class="text-2xl font-semibold tracking-tight text-main">
                            {{ __('tour_detail.recommendations_title') ?? 'Recomendaciones para su visita' }}
                        </h3>
                    </div>
                </div>

                @php
                $recommendationItems = $tour->detail?->getRecommendationItems() ?? [];
                @endphp

                <div class="tour-detail-feature-list">
                    @foreach($recommendationItems as $item)
                    <div class="tour-detail-feature-row is-recommendation">
                        <span class="tour-detail-feature-icon is-recommendation">
                            {!! $item['icon'] !!}
                        </span>

                        <p class="tour-detail-feature-text">
                            {{ $item['label'] }}
                        </p>
                    </div>
                    @endforeach
                </div>

            </section>
            @endif

        </div>

        <div class="sticky top-32 h-fit bg-card p-10 rounded-3xl shadow-xl">

            {{-- ================= TITLE ================= --}}
            <h3 class="text-2xl font-bold mb-8 text-green-600">
                {{ __('tour_detail.quick_info') }}
            </h3>

            {{-- ================= STARTING FROM CARD ================= --}}
            <div class="bg-white/40 dark:bg-white/5 rounded-2xl p-6 border border-gray-200 dark:border-gray-700">

                {{-- Starting From --}}
                <div class="text-sm uppercase tracking-widest text-muted mb-3">
                    {{ __('tour_detail.starting_from') }}
                </div>

                {{-- Price --}}
                <div id="startingFromPrice"
                    class="text-4xl font-extrabold text-green-600 leading-tight">
                </div>

                <div class="text-xs uppercase tracking-widest text-muted mt-2">
                    {{ __('tour_detail.per_person') }}
                </div>

                {{-- Currency Selector --}}
                <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">

                    <span class="text-sm font-medium text-muted">
                        {{ __('tour_detail.currency') }}
                    </span>

                    <div class="flex gap-2">
                        <button type="button"
                            data-currency="USD"
                            class="currency-btn px-3 py-1 rounded-md text-xs border transition">
                            USD $
                        </button>

                        <button type="button"
                            data-currency="CRC"
                            class="currency-btn px-3 py-1 rounded-md text-xs border transition">
                            CRC ₡
                        </button>
                    </div>

                </div>

            </div>

            {{-- ================= PRICE LIST ================= --}}
            @if($tour->prices->count())

            @php
            $groupedPrices = $tour->prices->groupBy('category_type');

            $hasNational = $tour->prices->where('category_type', 'national')->count() > 0;
            $hasInternational = $tour->prices->where('category_type', 'international')->count() > 0;
            $showMarketTitles = $hasNational && $hasInternational;
            @endphp

            <div class="mt-10 space-y-8">

                @foreach($groupedPrices as $market => $marketPrices)

                <div>

                    @if($showMarketTitles)
                    <h4 class="text-base font-semibold mb-4">
                        {{ $market === 'national'
                            ? __('tour_detail.national_prices')
                            : __('tour_detail.international_prices') }}
                    </h4>
                    @endif

                    <div class="space-y-4">

                        @foreach($marketPrices as $price)

                        <div class="flex justify-between items-center">

                            <div>
                                <div class="font-medium">
                                    {{ $price->getTranslatedType() }}
                                </div>

                                @if($price->min_age !== null || $price->max_age !== null)
                                <div class="text-xs text-muted">
                                    @if($price->min_age !== null && $price->max_age !== null)
                                    {{ $price->min_age }} - {{ $price->max_age }}
                                    @elseif($price->min_age !== null)
                                    {{ $price->min_age }}+
                                    @endif
                                </div>
                                @endif
                            </div>

                            <div class="font-semibold text-green-600"
                                data-price-id="{{ $price->id }}">
                            </div>

                        </div>

                        @endforeach

                    </div>

                </div>

                @endforeach

            </div>

            @endif

            {{-- ================= RESERVE BUTTON ================= --}}
            @if($tour->prices->where('is_free', false)->count())

            <button type="button"
                id="openBooking"
                class="btn-primary w-full mt-10 text-lg py-4 shadow-lg">
                {{ __('tour_detail.reserve') }}
            </button>

            @else

            <div class="mt-10 text-center text-green-600 font-semibold text-lg">
                {{ __('tour_detail.free') }}
            </div>

            @endif

        </div>

</section>
{{-- ================= MAP ================= --}}
@if($tour->company?->map_embed_url)
<section class="max-w-7xl mx-auto px-6 pb-32">

    <div class="mb-10 text-center">
        <h2 class="text-3xl font-bold mb-3">
            {{ __('tour_detail.how_to_get_title') }}
        </h2>

        @if($tour->company?->name)
        <p class="text-lg font-semibold text-gray-900 dark:text-white">
            {{ $tour->company->name }}
        </p>
        @endif

        @if($tour->detail?->location_name)
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
            📍 {{ $tour->detail->location_name }}
        </p>
        @endif
    </div>

    <div class="rounded-3xl overflow-hidden shadow-2xl">
        <iframe
            src="{{ $tour->company->map_embed_url }}"
            class="w-full h-[500px] border-0"
            loading="lazy"
            allowfullscreen>
        </iframe>
    </div>

</section>
@endif
{{-- ================= BOTTOM RESERVE CTA ================= --}}
@if($tour->prices->where('is_free', false)->count())

<section class="max-w-7xl mx-auto px-6 pb-24">
    <div class="flex justify-center">
        <div class="w-full max-w-3xl text-center">

            <div class="mb-6">
                <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                    {{ __('tour_detail.reserve') }}
                </h3>

                <p class="mt-2 text-sm md:text-base text-gray-600 dark:text-gray-400">
                    {{ __('tour_detail.reserve_cta_text') }}
                </p>
            </div>

            <button
                type="button"
                class="open-booking-trigger btn-primary
                       w-full sm:w-auto
                       min-w-[260px]
                       justify-center
                       text-lg py-4 px-10 shadow-lg">
                {{ __('tour_detail.reserve') }}
            </button>

        </div>
    </div>
</section>

@else

<section class="max-w-7xl mx-auto px-6 pb-24">
    <div class="flex justify-center">
        <div class="w-full max-w-3xl text-center rounded-3xl border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 px-8 py-8 shadow-lg">
            <div class="text-green-600 dark:text-green-400 font-semibold text-lg">
                {{ __('tour_detail.free') }}
            </div>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ __('tour_detail.free_booking_text') }}
            </p>
        </div>
    </div>
</section>

@endif

{{-- ================= Prices ================= --}}
@php
use App\Models\ExchangeRate;
$exchangeRate = (float) ExchangeRate::where('key', 'usd_to_crc')->value('value');
$pricesForJs = $tour->prices->map(function($price) use ($exchangeRate){

$priceInUsd = round($price->price, 2);
$priceInCrc = round($price->price * $exchangeRate, 2);

return [
"id" => $price->id,
"type" => $price->getTranslatedType(),
"price_usd" => $priceInUsd,
"price_crc" => $priceInCrc,
"min_age" => $price->min_age,
"max_age" => $price->max_age,
"is_free" => $price->is_free,
"category_type" => $price->category_type ?? 'international',
];
});

$schedulesForJs = $tour->schedules->map(function($schedule){
return [
"id" => $schedule->id,
"start_time" => \Carbon\Carbon::parse($schedule->start_time)->format('H:i'),
];
});

@endphp

<div id="tourDynamicData"
    data-prices='@json($pricesForJs)'
    data-schedules='@json($schedulesForJs)'
    class="hidden">
</div>

<script>
    window.translations = {
        viewMore: "{{ __('booking.view_more') }}",
        viewLess: "{{ __('booking.view_less') }}"
    };
</script>

<script>
    window.freeText = "{{ __('tour_detail.free') }}";
</script>

<script>
    window.marketTranslations = {
        national: "{{ __('booking.national_option') }}",
        international: "{{ __('booking.international_option') }}"
    };
</script>

<script>
    window.appLocale = "{{ app()->getLocale() }}";
</script>

<x-booking-modal :tour="$tour" />

<script>
    /**
     * Currency Engine
     * Handles UI updates, persistence, and price recalculation
     */

    document.addEventListener('DOMContentLoaded', function() {

        const currencyButtons = document.querySelectorAll('.currency-btn');
        const pricesData = JSON.parse(
            document.getElementById('tourDynamicData').dataset.prices
        );

        let activeCurrency = localStorage.getItem('selectedCurrency') || 'USD';

        /**
         * Formats price according to selected currency
         */
        function formatPrice(value) {
            if (activeCurrency === 'CRC') {
                return '₡' + Number(value).toLocaleString();
            }
            return '$' + Number(value).toFixed(2);
        }

        /**
         * Updates all visible prices in sidebar
         */
        function updateSidebarPrices() {

            document.querySelectorAll('[data-price-id]').forEach(el => {
                const id = el.dataset.priceId;
                const priceObj = pricesData.find(p => p.id == id);

                if (!priceObj || priceObj.is_free) {
                    el.textContent = window.freeText;
                    return;
                }

                const value = activeCurrency === 'CRC' ?
                    priceObj.price_crc :
                    priceObj.price_usd;

                el.textContent = formatPrice(value);
            });

            updateStartingFrom();
        }

        /**
         * Updates "Starting from" block
         */
        function updateStartingFrom() {
            const startEl = document.getElementById('startingFromPrice');
            if (!startEl) return;

            const firstPaid = pricesData.find(p => !p.is_free);

            if (!firstPaid) {
                startEl.textContent = window.freeText;
                return;
            }

            const value = activeCurrency === 'CRC' ?
                firstPaid.price_crc :
                firstPaid.price_usd;

            startEl.textContent = formatPrice(value);
        }

        /**
         * Updates active button style
         */
        function updateActiveButton() {
            currencyButtons.forEach(btn => {
                btn.classList.remove('bg-green-600', 'text-white');
                if (btn.dataset.currency === activeCurrency) {
                    btn.classList.add('bg-green-600', 'text-white');
                }
            });
        }

        /**
         * Change currency
         */
        function setCurrency(currency) {

            activeCurrency = currency;
            localStorage.setItem('selectedCurrency', currency);

            updateSidebarPrices();
            updateActiveButton();

            // Make currency globally accessible
            window.currentCurrency = currency;

            // Dispatch global event so booking modal updates automatically
            document.dispatchEvent(new Event('currencyChanged'));
        }

        currencyButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                setCurrency(btn.dataset.currency);
            });
        });

        setCurrency(activeCurrency);

    });
</script>

@endsection