@extends('layouts.app')

@section('title', __('navigation.home'))

@section('content')

{{-- ================= HERO SECTION ================= --}}
<section class="relative bg-white overflow-hidden">

    <div class="max-w-7xl mx-auto px-6 py-20 grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">

        {{-- TEXTO --}}
        <div class="opacity-0 animate-hero hero-delay-1">

            <span class="text-green-600 font-semibold tracking-wide uppercase text-sm">
                {{ __('home.hero_tag') }}
            </span>

            <h1 class="mt-4 text-4xl md:text-5xl xl:text-6xl font-extrabold text-gray-900 leading-tight
                       opacity-0 animate-hero hero-delay-2">
                {{ __('home.hero_title_line_1') }}
                <span class="text-green-600">
                    {{ __('home.hero_title_highlight') }}
                </span>
                {{ __('home.hero_title_line_2') }}
            </h1>

            <p class="mt-6 text-lg text-gray-600 max-w-xl
                      opacity-0 animate-hero hero-delay-3">
                {{ __('home.hero_description') }}
            </p>

            {{-- BOTONES --}}
            <div class="mt-8 flex flex-col sm:flex-row gap-4 hero-buttons">

                <a href="/tours" class="btn-primary">
                    {{ __('home.btn_explore_tours') }}
                </a>

                <a href="/accommodations" class="btn-secondary">
                    {{ __('home.btn_view_accommodation') }}
                </a>

            </div>

        </div>

        {{-- IMAGES --}}
        <div class="relative grid grid-cols-2 gap-6 scroll-hero">

            {{-- Volcán Arenal --}}
            <img src="https://image-tc.galaxy.tf/wijpeg-27ubwpu4ecat1y90z03clnvcx/la-fortuna-san-carlos_standard.jpg?crop=316%2C0%2C1067%2C800" alt="Volcán Arenal - La Fortuna" class="rounded-2xl shadow-xl object-cover h-56 w-full transition-all duration-500 ease-out hover:scale-110 hover:-translate-y-1 cursor-pointer">

            {{-- Catarata La Fortuna --}}
            <img src="https://www.civitatis.com/f/costa-rica/arenal/galeria/fortuna-catarata-costa-rica.jpg" alt="Catarata La Fortuna" class="rounded-2xl shadow-xl object-cover h-72 w-full row-span-2 transition-all duration-500 ease-out hover:scale-110 hover:-translate-y-1 cursor-pointer">

            {{-- Aventura / Naturaleza --}}
            <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/16/0a/f5/08/lovely-warm-water.jpg?w=1200&h=-1&s=1" alt="Aventura en La Fortuna" class="rounded-2xl shadow-xl object-cover h-48 w-full transition-all duration-500 ease-out hover:scale-110 hover:-translate-y-1 cursor-pointer">

        </div>
</section>

{{-- ================= YOUTUBE EXPERIENCE ================= --}}
<section class="bg-white py-28 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            {{-- LEFT / CONTENT --}}
            <div class="scroll-hero space-y-8">

                <h2 class="text-3xl md:text-4xl xl:text-5xl font-extrabold text-gray-900 leading-tight">
                    {{ __('home.video_title_line_1') }}
                    <span class="block text-green-600">
                        {{ __('home.video_title_line_2') }}
                    </span>
                </h2>

                <p class="text-lg text-gray-600 max-w-xl leading-relaxed">
                    {{ __('home.video_description') }}
                </p>

                {{-- AUTHOR --}}
                <div class="flex items-center gap-3 text-sm text-gray-500">

                    {{-- YOUTUBE ICON --}}
                    <svg class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M23.498 6.186a2.958 2.958 0 00-2.08-2.092C19.585 3.5 12 3.5 12 3.5s-7.585 0-9.418.594A2.958 2.958 0 00.502 6.186 30.07 30.07 0 000 12a30.07 30.07 0 00.502 5.814 2.958 2.958 0 002.08 2.092C4.415 20.5 12 20.5 12 20.5s7.585 0 9.418-.594a2.958 2.958 0 002.08-2.092A30.07 30.07 0 0024 12a30.07 30.07 0 00-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                    </svg>

                    <a
                        href="https://www.youtube.com/@SebasAventuracr"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="hover:text-red-600 transition-colors">

                        {{ __('home.video_by') }}
                        <strong class="text-gray-700 hover:text-green-600 transition-colors">
                            Sebas Aventura
                        </strong>
                    </a>

                </div>
            </div>

            {{-- RIGHT / VIDEO --}}
            <div class="scroll-hero">
                <div
                    class="relative rounded-3xl overflow-hidden shadow-2xl
                           ring-1 ring-black/5">

                    <iframe
                        class="w-full aspect-video"
                        src="https://www.youtube.com/embed/videoseries?list=PLzJaAzeEwGMPF1XbEBB2U-LY1xvzZPmzP"
                        title="Aventura506 Experiences"
                        frameborder="0"
                        loading="lazy"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>

                </div>
            </div>

        </div>
    </div>
</section>

{{-- ================= FEATURED TOUR BANNER ================= --}}
@if($featuredTour)
@php
$locale = app()->getLocale();

$tourName = is_array($featuredTour->name)
? ($featuredTour->name[$locale] ?? reset($featuredTour->name))
: $featuredTour->name;

$tourDescription = is_array($featuredTour->description)
? ($featuredTour->description[$locale] ?? reset($featuredTour->description))
: $featuredTour->description;

$startingPrice = $featuredTour->prices
->where('is_free', false)
->max('price');

@endphp
<section class="bg-white py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
        <div class="scroll-hero home-featured-tour-banner">

            {{-- Background image --}}
            <div class="home-featured-tour-banner-media">
                <img
                    src="{{ $featuredTour->image ? asset($featuredTour->image) : asset('images/default-tour.jpg') }}"
                    alt="{{ $tourName }}"
                    class="home-featured-tour-banner-image">

                <div class="home-featured-tour-banner-overlay"></div>
            </div>

            {{-- Decorative glow --}}
            <div class="absolute -top-10 -right-10 w-72 h-72 bg-green-400/20 rounded-full blur-3xl"></div>

            {{-- Content --}}
            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-10 items-end px-8 py-12 md:px-12 md:py-16 min-h-[460px]">

                {{-- Left content --}}
                <div class="max-w-2xl">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full
                                 bg-white/10 backdrop-blur-md border border-white/20
                                 text-white text-xs md:text-sm font-semibold uppercase tracking-[0.18em]">
                        {{ __('home.featured_tour_badge') }}
                    </span>

                    <p class="mt-5 text-sm md:text-base font-semibold uppercase tracking-[0.18em] text-green-300">
                        {{ __('home.featured_tour_intro') }}
                    </p>

                    <h2 class="mt-4 text-3xl md:text-5xl font-extrabold text-white leading-tight">
                        {{ $tourName }}
                    </h2>

                    <p class="mt-5 text-base md:text-lg text-white/85 leading-relaxed max-w-xl">
                        {{ \Illuminate\Support\Str::limit(strip_tags($tourDescription), 180) }}
                    </p>

                    <p class="mt-4 text-sm md:text-base text-white/70 max-w-lg leading-relaxed">
                        {{ __('home.featured_tour_helper_text') }}
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <a href="{{ route('tours.show', $featuredTour->slug) }}"
                            class="inline-flex items-center justify-center
                                   bg-green-600 hover:bg-green-700
                                   text-white font-semibold
                                   px-7 py-3 rounded-full
                                   shadow-lg transition-all duration-300 hover:scale-[1.02]">
                            {{ __('home.featured_tour_reserve_button') }}
                        </a>

                        <a href="{{ route('tours.show', $featuredTour->slug) }}"
                            class="inline-flex items-center gap-2 text-sm md:text-base font-semibold text-white/90 hover:text-white transition-colors">
                            {{ __('home.featured_tour_view_details') }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Right price card --}}
                <div class="lg:justify-self-end">
                    <div class="w-full max-w-sm rounded-[1.75rem] bg-white/12 backdrop-blur-xl border border-white/20 p-6 md:p-7 shadow-2xl">

                        <p class="text-white/70 text-sm uppercase tracking-[0.18em] font-semibold">
                            {{ __('home.featured_tour_price_badge') }}
                        </p>

                        <div class="mt-3">
                            @if(!is_null($startingPrice))
                            <h3 class="text-4xl md:text-5xl font-extrabold text-white leading-none">
                                ${{ number_format($startingPrice, 2) }}
                            </h3>

                            <p class="mt-3 text-white/75 text-sm">
                                {{ __('home.featured_tour_base_price') }}
                            </p>
                            @else
                            <h3 class="text-3xl md:text-4xl font-extrabold text-white leading-none">
                                {{ __('home.featured_tour_check_price') }}
                            </h3>

                            <p class="mt-3 text-white/75 text-sm">
                                {{ __('home.featured_tour_price_detail') }}
                            </p>
                            @endif
                        </div>

                        <div class="mt-6 pt-5 border-t border-white/15">
                            <a href="{{ route('tours.show', $featuredTour->slug) }}"
                                class="inline-flex items-center gap-2 text-sm font-semibold text-green-300 hover:text-white transition-colors">
                                {{ __('home.featured_tour_view_details') }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endif

@endsection