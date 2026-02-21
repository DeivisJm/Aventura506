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

        {{-- CATEGORY BADGE --}}
        <div class="inline-flex items-center gap-3 px-5 py-2 bg-white/10 backdrop-blur-md rounded-full text-sm uppercase tracking-widest border border-white/20">
            <span class="text-green-400">
                {{ strtoupper(__('categories.' . $tour->category)) }}
            </span>
        </div>

        <h1 class="mt-6 text-4xl md:text-6xl font-extrabold leading-tight">
            {{ $tour->getTranslated('name') }}
        </h1>

        <p class="mt-6 text-xl text-gray-200 max-w-2xl mx-auto">
            {{ $tour->getTranslated('description') }}
        </p>

        {{-- QUICK META INFO --}}
        <div class="mt-10 flex flex-wrap justify-center gap-6 text-sm text-gray-200">

            @if($tour->detail?->duration)
            <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-full backdrop-blur-md">
                ⏱ {{ $tour->detail->getTranslated('duration') }}
            </div>
            @endif

            @if($tour->detail?->start_hours_text)
            <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-full backdrop-blur-md">
                🕒 {{ $tour->detail->getTranslated('start_hours_text') }}
            </div>
            @endif

            <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-full backdrop-blur-md">
                📍 {{ $tour->location_text }}
            </div>

        </div>

    </div>
</section>
@endif

{{-- ================= MAIN CONTENT ================= --}}
<section class="max-w-7xl mx-auto px-6 py-24">

    <div class="grid lg:grid-cols-3 gap-16">

        {{-- LEFT CONTENT --}}
        <div class="lg:col-span-2 space-y-12">

            <div>
                <h2 class="text-3xl font-bold mb-6 text-main">
                    {{ __('tour_detail.about_title') }}
                </h2>

                <p class="text-lg text-muted leading-relaxed">
                    {{ $tour->detail?->getTranslated('full_description') 
                        ?? $tour->getTranslated('description') }}
                </p>
            </div>

            {{-- INCLUDES --}}
            @if($tour->detail?->includes)
            <div class="bg-card p-8 rounded-2xl shadow-sm">
                <h3 class="text-xl font-semibold mb-6">
                    {{ __('tour_detail.includes_title') }}
                </h3>

                <div class="grid md:grid-cols-2 gap-4 text-muted">
                    @foreach($tour->detail->includes[app()->getLocale()]
                    ?? $tour->detail->includes['es']
                    ?? [] as $item)
                    <div class="flex items-start gap-3">
                        <span class="text-green-500 mt-1">✓</span>
                        <span>{{ $item }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- IDEAL FOR --}}
            @if($tour->detail?->ideal_for)
            <div class="bg-card p-8 rounded-2xl shadow-sm">
                <h3 class="text-xl font-semibold mb-6">
                    {{ __('tour_detail.ideal_for_title') }}
                </h3>

                <div class="flex flex-wrap gap-3">
                    @foreach($tour->detail->ideal_for[app()->getLocale()]
                    ?? $tour->detail->ideal_for['es']
                    ?? [] as $item)
                    <span class="px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                        {{ $item }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        {{-- RIGHT SIDEBAR --}}
        <div class="sticky top-32 h-fit bg-card p-10 rounded-3xl shadow-xl">

            {{-- Section title --}}
            <h3 class="text-2xl font-bold mb-6 text-green-600">
                {{ __('tour_detail.quick_info') }}
            </h3>

            {{-- Compact highlight block --}}
            <div class="bg-white/40 dark:bg-white/5 rounded-2xl p-5 mb-8 border border-gray-200 dark:border-gray-700">

                {{-- Main price emphasis --}}
                <div class="text-sm uppercase tracking-widest text-muted mb-2">
                    {{ __('tour_detail.starting_from') ?? 'Starting from' }}
                </div>

                <div class="text-3xl font-extrabold text-green-600">
                    ${{ number_format($tour->price, 2) }}
                </div>

                <div class="text-xs uppercase tracking-widest text-muted mt-1">
                    {{ __('tour_detail.per_person') }}
                </div>

            </div>

            {{-- Price breakdown --}}
            @if($tour->prices->count())
            <div class="mt-4 space-y-4 border-t border-gray-200 dark:border-gray-700 pt-6">

                @foreach($tour->prices as $price)
                <div class="flex justify-between items-center py-2 hover:bg-black/5 dark:hover:bg-white/5 px-2 rounded-lg transition">

                    <div>
                        <div class="font-medium">
                            {{ $price->getTranslatedType() }}
                        </div>

                        @if($price->age_range)
                        <div class="text-xs text-muted">
                            {{ $price->age_range }}
                        </div>
                        @endif
                    </div>

                    <div class="font-semibold text-green-600">
                        @if($price->is_free)
                        {{ __('tour_detail.free') }}
                        @else
                        ${{ number_format($price->price, 2) }}
                        @endif
                    </div>

                </div>
                @endforeach

            </div>
            @endif

            {{-- Reservation button --}}
            @if($tour->price > 0)
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
@if($tour->map_embed_url)
<section class="max-w-7xl mx-auto px-6 pb-32">

    <div class="mb-10 text-center">
        <h2 class="text-3xl font-bold mb-3">
            {{ __('tour_detail.how_to_get_title') }}
        </h2>

        @if($tour->location_text)
        <p class="text-muted">
            {{ $tour->location_text }}
        </p>
        @endif
    </div>

    <div class="rounded-3xl overflow-hidden shadow-2xl">
        <iframe
            src="{{ $tour->map_embed_url }}"
            class="w-full h-[500px] border-0"
            loading="lazy"
            allowfullscreen>
        </iframe>
    </div>

</section>
@endif

{{-- ================= DYNAMIC DATA FOR MODAL ================= --}}
@php
$pricesForJs = $tour->prices->map(function($price){
return [
"id" => $price->id,
"type" => $price->getTranslatedType(),
"price" => $price->price,
"age_range" => $price->age_range,
"is_free" => $price->is_free,
];
});

$schedulesForJs = $tour->schedules->map(function($schedule){
return [
"id" => $schedule->id,
"start_time" => $schedule->start_time->format('H:i'),
];
});
@endphp

<div id="tourDynamicData"
    data-prices='@json($pricesForJs)'
    data-schedules='@json($schedulesForJs)'
    class="hidden">
</div>

{{-- ================= TRANSLATIONS FOR JS ================= --}}
<script>
    window.translations = {
        viewMore: "{{ __('booking.view_more') }}",
        viewLess: "{{ __('booking.view_less') }}"
    };
</script>
{{-- ================= APP LOCALE FOR JS ================= --}}
<script>
    window.appLocale = "{{ app()->getLocale() }}";
</script>

{{-- ================= BOOKING MODAL ================= --}}
<x-booking-modal :tour="$tour" />

@endsection