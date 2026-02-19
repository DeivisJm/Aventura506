@extends('layouts.app')

@section('title', ($tour->name ?? 'Tour') . ' | Aventura506')

@section('content')

{{-- ================= HERO PREMIUM ================= --}}
@if($tour->image)
<section class="relative h-[75vh] flex items-center justify-center scroll-hero">

    <div class="absolute inset-0">
        <img src="{{ asset($tour->image) }}"
            alt="{{ $tour->name }}"
            class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <div class="relative z-10 text-center px-6 text-white max-w-3xl">

        <span class="uppercase tracking-widest text-green-400 text-sm font-semibold">
            {{ strtoupper($tour->category) }}
        </span>

        <h1 class="mt-4 text-4xl md:text-6xl font-extrabold">
            {{ $tour->name }}
        </h1>

        <p class="mt-6 text-lg text-gray-200">
            {{ $tour->short_description }}
        </p>

        <div class="mt-6 flex flex-col items-center gap-2 text-sm text-gray-200">

            @if($tour->detail?->duration)
            <span>
                <strong>{{ __('tour_detail.duration') }}:</strong>
                {{ $tour->detail->duration }}
            </span>
            @endif

            @if($tour->detail?->start_hours_text)
            <span>
                <strong>{{ __('tour_detail.available_hours') }}:</strong>
                {{ $tour->detail->start_hours_text }}
            </span>
            @endif

        </div>

    </div>

</section>
@endif


{{-- ================= MAIN INFO ================= --}}
<section class="max-w-6xl mx-auto px-6 py-24 grid md:grid-cols-2 gap-16 scroll-hero">

    <div>
        <h2 class="text-2xl font-bold mb-6 text-main">
            {{ __('tour_detail.about_title') }}
        </h2>

        <p class="text-muted leading-relaxed">
            {{ $tour->detail?->full_description ?? $tour->short_description }}
        </p>

        {{-- INCLUDES --}}
        @if($tour->detail?->includes)
        <div class="mt-10">
            <h3 class="font-bold mb-4">
                {{ __('tour_detail.includes_title') }}
            </h3>

            <ul class="list-disc list-inside space-y-2 text-muted">
                @foreach($tour->detail->includes as $item)
                <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- IDEAL FOR --}}
        @if($tour->detail?->ideal_for)
        <div class="mt-10">
            <h3 class="font-bold mb-4">
                {{ __('tour_detail.ideal_for_title') }}
            </h3>

            <ul class="list-disc list-inside space-y-2 text-muted">
                @foreach($tour->detail->ideal_for as $item)
                <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
        @endif

    </div>


    {{-- QUICK INFO CARD --}}
    <div class="bg-card rounded-3xl p-10 shadow-lg">

        <h3 class="text-lg font-bold mb-6 text-green-600">
            {{ __('tour_detail.quick_info') }}
        </h3>

        <div class="space-y-4 text-muted">

            @if($tour->detail?->duration)
            <div>
                <strong>{{ __('tour_detail.duration') }}:</strong>
                {{ $tour->detail->duration }}
            </div>
            @endif

            @if($tour->detail?->start_hours_text)
            <div>
                <strong>{{ __('tour_detail.available_hours') }}:</strong>
                {{ $tour->detail->start_hours_text }}
            </div>
            @endif

        </div>

        {{-- PRICE TYPES (ADAPTADO A TU BD) --}}
        @if($tour->prices->count())
        <div class="mt-8 space-y-3">
            @foreach($tour->prices as $price)
            <div class="flex justify-between border-b pb-2">
                <span>
                    {{ $price->type }}
                    @if($price->age_range)
                    ({{ $price->age_range }})
                    @endif
                </span>

                <span class="font-semibold">
                    @if($price->is_free)
                    {{ __('Gratis') }}
                    @else
                    ${{ number_format($price->price, 2) }}
                    @endif
                </span>
            </div>
            @endforeach
        </div>
        @endif

        <button id="openBooking"
            class="btn-primary w-full mt-10 text-lg py-4 shadow-lg">
            {{ __('tour_detail.reserve') }}
        </button>

    </div>

</section>


{{-- ================= LOCATION ================= --}}
@if($tour->detail?->map_embed_url)
<section class="max-w-7xl mx-auto px-6 pb-28 scroll-hero">

    <header class="text-center mb-16">
        <h2 class="text-3xl md:text-4xl font-extrabold mb-4">
            {{ __('tour_detail.how_to_get_title') }}
        </h2>

        @if($tour->detail?->location_text)
        <p class="max-w-3xl mx-auto text-gray-600 dark:text-gray-300">
            {{ $tour->detail->location_text }}
        </p>
        @endif
    </header>

    <div class="rounded-3xl overflow-hidden shadow-xl">
        <iframe
            src="{{ $tour->detail->map_embed_url }}"
            class="w-full h-[500px] border-0"
            loading="lazy"
            allowfullscreen>
        </iframe>
    </div>

</section>
@endif


{{-- ================= DYNAMIC DATA FOR MODAL ================= --}}
<div id="tourDynamicData"
    data-prices='@json($tour->prices)'
    data-schedules='@json($tour->schedules)'
    class="hidden">
</div>

@endsection