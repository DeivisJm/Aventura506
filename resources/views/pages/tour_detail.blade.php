@extends('layouts.app')

@section('title', $tour->getTranslated('name') ?? 'Tour')

@section('content')

{{-- ================= HERO PRO ================= --}}
@if($tour->image)
<section class="relative min-h-[85vh] flex items-center justify-center overflow-hidden">

    <div class="absolute inset-0">
        <img src="{{ asset($tour->image) }}"
            alt="{{ $tour->getTranslated('name') }}"
            class="w-full h-full object-cover scale-105 transition-transform duration-[6000ms] ease-out hover:scale-110">

        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-black/30"></div>
    </div>

    <div class="relative z-10 text-center px-6 text-white max-w-4xl">

        <div class="inline-flex items-center gap-3 px-5 py-2 bg-white/10 backdrop-blur-md rounded-full text-sm uppercase tracking-widest border border-white/20">
            <span class="text-green-400">
                @if($tour->category)
                {{ strtoupper(__('categories.' . strtolower($tour->category->slug))) }}
                @endif
            </span>
        </div>

        <h1 class="mt-6 text-4xl md:text-6xl font-extrabold leading-tight">
            {{ $tour->getTranslated('name') }}
        </h1>

        <p class="mt-6 text-xl text-gray-200 max-w-2xl mx-auto">
            {{ $tour->getTranslated('description') }}
        </p>

        <div class="mt-10 flex flex-wrap justify-center gap-6 text-sm text-white">

            {{-- Duration --}}
            @if($tour->detail?->duration)
            <div class="flex items-center gap-3 
                bg-white/10 
                px-5 py-2.5 
                rounded-full 
                backdrop-blur-md 
                border border-white/20">

                <div class="flex items-center justify-center 
                    w-8 h-8 
                    rounded-full 
                    bg-white/20 
                    backdrop-blur-sm">

                    <svg class="w-4 h-4 text-white"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                    </svg>
                </div>

                <span class="font-medium tracking-wide">
                    {{ $tour->detail->getTranslated('duration') }}
                </span>

            </div>
            @endif


            {{-- Start Hours --}}
            @if($tour->detail?->start_hours_text)
            <div class="flex items-center gap-3 
                bg-white/10 
                px-5 py-2.5 
                rounded-full 
                backdrop-blur-md 
                border border-white/20">

                <div class="flex items-center justify-center 
                    w-8 h-8 
                    rounded-full 
                    bg-white/20 
                    backdrop-blur-sm">

                    <svg class="w-4 h-4 text-white"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3m-9 8h10m-11 8h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>

                <span class="font-medium tracking-wide">
                    {{ $tour->detail->getTranslated('start_hours_text') }}
                </span>

            </div>
            @endif


            {{-- Company --}}
            <div class="flex items-center gap-3 
                bg-white/10 
                px-5 py-2.5 
                rounded-full 
                backdrop-blur-md 
                border border-white/20">

                <div class="flex items-center justify-center 
                    w-8 h-8 
                    rounded-full 
                    bg-white/20 
                    backdrop-blur-sm">

                    <svg class="w-4 h-4 text-white"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 21h18M4 21V7a1 1 0 011-1h3V4a1 1 0 011-1h6a1 1 0 011 1v2h3a1 1 0 011 1v14M9 21V9h6v12" />
                    </svg>
                </div>

                @if($tour->company?->name)
                <span class="font-semibold tracking-wide">
                    {{ $tour->company->name }}
                </span>
                @endif

            </div>

        </div>

    </div>
</section>
@endif

<section class="max-w-7xl mx-auto px-6 py-24">

    <div class="grid lg:grid-cols-3 gap-16">

        <div class="lg:col-span-2 space-y-20">

            {{-- ================= ABOUT ================= --}}
            <section>

                <div class="mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-main">
                        {{ __('tour_detail.about_title') }}
                    </h2>

                    <div class="mt-4 w-20 h-[3px] bg-gradient-to-r from-green-600 to-green-400 rounded-full"></div>
                </div>

                <div class="max-w-3xl text-lg text-muted leading-relaxed space-y-6">
                    {{ $tour->detail?->getTranslated('full_description') 
                ?? $tour->getTranslated('description') }}
                </div>

            </section>


            {{-- ================= INCLUDES ================= --}}
            @if($tour->detail?->includes)
            <section>

                <div class="mb-12">
                    <h3 class="text-2xl font-semibold tracking-tight text-main">
                        {{ __('tour_detail.includes_title') }}
                    </h3>
                    <div class="mt-4 w-16 h-[2px] bg-green-600/60 rounded-full"></div>
                </div>

                <div class="grid md:grid-cols-2 gap-x-16 gap-y-8">

                    @foreach($tour->detail->includes[app()->getLocale()]
                    ?? $tour->detail->includes['es']
                    ?? [] as $item)

                    <div class="flex items-start gap-4 group">

                        <div class="mt-1 w-2 h-2 rounded-full bg-green-600 group-hover:scale-125 transition-transform duration-300"></div>

                        <p class="text-muted leading-relaxed group-hover:text-main transition-colors duration-300">
                            {{ $item }}
                        </p>

                    </div>

                    @endforeach

                </div>

            </section>
            @endif


            {{-- ================= IDEAL FOR ================= --}}
            @if($tour->detail?->ideal_for)
            <section>

                <div class="mb-12">
                    <h3 class="text-2xl font-semibold tracking-tight text-main">
                        {{ __('tour_detail.ideal_for_title') }}
                    </h3>

                    <div class="mt-4 w-16 h-[2px] bg-green-600/60 rounded-full"></div>
                </div>

                <div class="flex flex-wrap gap-5">

                    @foreach($tour->detail->ideal_for[app()->getLocale()]
                    ?? $tour->detail->ideal_for['es']
                    ?? [] as $item)

                    <span class="px-6 py-3
                bg-green-50
                text-green-700
                rounded-full
                text-sm
                font-medium
                border border-green-200
                hover:bg-green-100
                transition-all duration-300
                whitespace-nowrap">

                        {{ $item }}

                    </span>

                    @endforeach

                </div>

            </section>
            @endif


            {{-- ================= RECOMMENDATIONS ================= --}}
            @if($tour->detail?->recommendations)
            <section>

                <div class="mb-12">
                    <h3 class="text-2xl font-semibold tracking-tight text-main">
                        {{ __('tour_detail.recommendations_title') ?? 'Recomendaciones para su visita' }}
                    </h3>
                    <div class="mt-4 w-16 h-[2px] bg-green-600/60 rounded-full"></div>
                </div>

                <div class="grid md:grid-cols-2 gap-x-16 gap-y-8">

                    @foreach($tour->detail->recommendations[app()->getLocale()]
                    ?? $tour->detail->recommendations['es']
                    ?? [] as $item)

                    <div class="flex items-start gap-4 group">

                        <div class="mt-1 w-2 h-2 rounded-full bg-green-600 group-hover:scale-125 transition-transform duration-300"></div>

                        <p class="text-muted leading-relaxed group-hover:text-main transition-colors duration-300">
                            {{ $item }}
                        </p>

                    </div>

                    @endforeach

                </div>

            </section>
            @endif

        </div>

        <div class="sticky top-32 h-fit bg-card p-10 rounded-3xl shadow-xl">

            <h3 class="text-2xl font-bold mb-6 text-green-600">
                {{ __('tour_detail.quick_info') }}
            </h3>

            <div class="bg-white/40 dark:bg-white/5 rounded-2xl p-5 mb-8 border border-gray-200 dark:border-gray-700">

                <div class="text-sm uppercase tracking-widest text-muted mb-2">
                    {{ __('tour_detail.starting_from') ?? 'Starting from' }}
                </div>

                <div class="text-3xl font-extrabold text-green-600">
                    @php
                    $exchangeRate = config('currency.crc_to_usd');

                    // Try to find an adult-type price
                    $priceModel = $tour->prices->where('type_key', 'adult')->first();

                    // Si no existe adult, buscar cualquier precio que no sea gratis
                    if (!$priceModel) {
                    $priceModel = $tour->prices->where('is_free', false)->first();
                    }

                    if ($priceModel && !$priceModel->is_free) {

                    $priceInUsd = $priceModel->price;

                    if ($priceModel->currency === 'CRC') {
                    $priceInUsd = $priceModel->price * $exchangeRate;
                    }

                    } else {
                    $priceInUsd = null;
                    }
                    @endphp

                    @if($priceInUsd)
                    ${{ number_format($priceInUsd, 2) }}
                    @else
                    {{ __('tour_detail.free') }}
                    @endif
                </div>

                <div class="text-xs uppercase tracking-widest text-muted mt-1">
                    {{ __('tour_detail.per_person') }}
                </div>

            </div>

            @if($tour->prices->count())

            @php
            $groupedPrices = $tour->prices->groupBy('category_type');
            @endphp

            <div class="mt-6 border-t pt-6 space-y-8">

                @php
                $hasNational = $tour->prices->where('category_type', 'national')->count() > 0;
                $hasInternational = $tour->prices->where('category_type', 'international')->count() > 0;
                $showMarketTitles = $hasNational && $hasInternational;
                @endphp

                @foreach($groupedPrices as $market => $marketPrices)

                <div>

                    @if($showMarketTitles)
                    <h4 class="text-lg font-semibold mb-4">
                        {{ $market === 'national' 
                    ? __('tour_detail.national_prices') 
                    : __('tour_detail.international_prices') }}
                    </h4>
                    @endif

                    <div class="space-y-3">

                        @foreach($marketPrices as $price)
                        <div class="flex justify-between items-center py-2 px-3 rounded-lg hover:bg-black/5">

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

                            <div class="font-semibold text-green-600">
                                @if($price->is_free)
                                {{ __('tour_detail.free') }}
                                @else
                                @php
                                $priceInUsd = $price->price;

                                $exchangeRate = config('currency.crc_to_usd');

                                if($price->currency === 'CRC') {
                                $priceInUsd = $price->price * $exchangeRate;
                                }
                                @endphp

                                ${{ number_format($priceInUsd, 2) }}
                                @endif
                            </div>

                        </div>
                        @endforeach

                    </div>

                </div>

                @endforeach

            </div>
            @endif

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

{{-- ================= Prices ================= --}}
@php

$exchangeRate = config('currency.crc_to_usd');

$pricesForJs = $tour->prices->map(function($price) use ($exchangeRate){

$priceInUsd = $price->price;

if($price->currency === 'CRC'){
    $priceInUsd = $price->price * $exchangeRate;
}

return [
"id" => $price->id,
"type" => $price->getTranslatedType(),
"price" => round($priceInUsd, 2),
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

@endsection