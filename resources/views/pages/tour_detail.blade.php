@extends('layouts.app')

@section('title', ($tour['name'] ?? 'Tour') . ' | Aventura506')

@section('content')

<section class="max-w-7xl mx-auto px-6 py-28">

    {{-- HERO --}}
    <div class="tour-hero py-20 px-6 text-center scroll-hero">

        <span class="uppercase tracking-widest text-green-500 text-sm font-semibold">
            {{ $tour['category'] }}
        </span>

        <h1 class="mt-4 text-4xl md:text-5xl font-extrabold">
            {{ $tour['name'] }}
        </h1>

        <p class="mt-6 max-w-3xl mx-auto text-gray-600 dark:text-gray-300">
            {{ $tour['description'] }}
        </p>

    </div>

    {{-- IMAGE --}}
    <div class="mt-16 scroll-hero">
        <img src="{{ $tour['image'] }}"
            alt="{{ $tour['name'] }}"
            class="rounded-3xl shadow-lg w-full object-cover">
    </div>

    {{-- DETAILS --}}
    <section class="grid md:grid-cols-2 gap-14 mt-20 bg-card p-10 rounded-3xl scroll-hero">

        <div>
            <h2 class="text-2xl font-bold mb-6 text-main">
                ¿Qué incluye este tour?
            </h2>

            <ul class="space-y-3 text-muted list-disc list-inside">
                @foreach ($tour['includes'] as $item)
                <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>

        <div>
            <h2 class="text-2xl font-bold mb-6 text-main">
                Ideal para
            </h2>

            <ul class="space-y-3 text-muted list-disc list-inside">
                @foreach ($tour['ideal_for'] as $item)
                <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>

    </section>

    {{-- LOCATION --}}
    <section class="mt-28 scroll-hero">

        <header class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4">
                ¿Cómo llegar?
            </h2>

            <p class="max-w-3xl mx-auto text-gray-600 dark:text-gray-300">
                {{ $tour['location_text'] }}
            </p>
        </header>

        <div class="grid lg:grid-cols-3 gap-12 items-stretch">

            {{-- MAPA CON RUTA --}}
            <div class="lg:col-span-2 rounded-3xl overflow-hidden shadow-xl">
                <iframe
                    src="{{ $tour['map_embed_url'] }}"
                    class="w-full h-[460px] border-0"
                    loading="lazy"
                    allowfullscreen>
                </iframe>
            </div>

            {{-- INFO --}}
            <div class="bg-card rounded-3xl p-10 flex flex-col justify-between shadow-lg">

                <div>
                    <h3 class="text-sm uppercase tracking-widest text-green-500 font-semibold mb-6">
                        Distancia aproximada
                    </h3>

                    <div class="flex items-end gap-10 mb-12">
                        <div>
                            <span class="text-4xl font-extrabold">
                                {{ $tour['distance_km'] }}
                            </span>
                            <span class="text-sm text-muted ml-1">km</span>
                        </div>

                        <div>
                            <span class="text-4xl font-extrabold">
                                {{ $tour['distance_miles'] }}
                            </span>
                            <span class="text-sm text-muted ml-1">millas</span>
                        </div>
                    </div>
                </div>

                <a href="{{ $tour['map_directions_url'] }}"
                    target="_blank"
                    class="btn-primary w-full text-center text-lg py-4">
                    Obtener direcciones
                </a>

            </div>

        </div>

    </section>

    {{-- CTA --}}
    <div class="mt-20 text-center scroll-hero">
        <a href="https://wa.me/50683217459?text=Hola,%20me%20interesa%20el%20tour:%20{{ urlencode($tour['name']) }}"
            target="_blank"
            class="btn-primary text-lg px-10 py-4">
            Reservar este tour
        </a>
    </div>

</section>

@endsection