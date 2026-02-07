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

                <a href="#hospedaje" class="btn-secondary">
                    {{ __('home.btn_view_accommodation') }}
                </a>

            </div>

        </div>

        {{-- IMÁGENES --}}
        <div class="relative grid grid-cols-2 gap-6">
            {{-- Volcán Arenal --}}
            <img src="https://image-tc.galaxy.tf/wijpeg-27ubwpu4ecat1y90z03clnvcx/la-fortuna-san-carlos_standard.jpg?crop=316%2C0%2C1067%2C800" alt="Volcán Arenal - La Fortuna" class="rounded-2xl shadow-xl object-cover h-56 w-full transition-all duration-500 ease-out hover:scale-110 hover:-translate-y-1 cursor-pointer">
            {{-- Catarata La Fortuna --}}
            <img src="https://www.civitatis.com/f/costa-rica/arenal/galeria/fortuna-catarata-costa-rica.jpg" alt="Catarata La Fortuna" class="rounded-2xl shadow-xl object-cover h-72 w-full row-span-2 transition-all duration-500 ease-out hover:scale-110 hover:-translate-y-1 cursor-pointer">
            {{-- Aventura / Naturaleza --}}
            <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/16/0a/f5/08/lovely-warm-water.jpg?w=1200&h=-1&s=1" alt="Aventura en La Fortuna" class="rounded-2xl shadow-xl object-cover h-48 w-full transition-all duration-500 ease-out hover:scale-110 hover:-translate-y-1 cursor-pointer">
            {{-- Overlay decorativo --}}
            <div class="absolute -z-10 -top-10 -right-10 w-72 h-72 bg-green-100 rounded-full blur-3xl"></div>
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


{{-- ================= INFO CARDS ================= --}}
<section class="max-w-7xl mx-auto px-4 py-16 grid gap-8 md:grid-cols-3">

    <div class="bg-white p-6 rounded-xl shadow text-center hover:shadow-lg transition">
        🌋
        <h3 class="font-semibold text-xl mt-4">
            {{ __('home.card_volcano_title') }}
        </h3>
        <p class="text-sm text-gray-600 mt-2">
            {{ __('home.card_volcano_desc') }}
        </p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow text-center hover:shadow-lg transition">
        🌿
        <h3 class="font-semibold text-xl mt-4">
            {{ __('home.card_adventure_title') }}
        </h3>
        <p class="text-sm text-gray-600 mt-2">
            {{ __('home.card_adventure_desc') }}
        </p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow text-center hover:shadow-lg transition">
        🏨
        <h3 class="font-semibold text-xl mt-4">
            {{ __('home.card_accommodation_title') }}
        </h3>
        <p class="text-sm text-gray-600 mt-2">
            {{ __('home.card_accommodation_desc') }}
        </p>
    </div>

</section>

@endsection