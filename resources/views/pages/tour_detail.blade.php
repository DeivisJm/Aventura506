@extends('layouts.app')

@section('title', $tour['title'] . ' | Aventura506')

@section('content')
<section class="max-w-6xl mx-auto px-6 py-24">

    {{-- ================= HEADER ================= --}}
    <header class="mb-16 text-center scroll-hero">

        <span class="text-green-600 font-semibold uppercase tracking-wide text-sm">
            {{ $tour['category'] }}
        </span>

        <h1 class="mt-4 text-4xl md:text-5xl font-extrabold">
            {{ $tour['title'] }}
        </h1>

        <p class="mt-6 text-gray-600 max-w-2xl mx-auto">
            {{ $tour['short_description'] }}
        </p>

    </header>

    {{-- ================= HERO IMAGE ================= --}}
    <img
        src="{{ $tour['image'] }}"
        alt="{{ $tour['title'] }}"
        class="rounded-3xl shadow-lg mb-20 w-full object-cover scroll-hero">

    {{-- ================= CONTENT ================= --}}
    <section class="grid md:grid-cols-2 gap-14 scroll-hero">

        {{-- INCLUDES --}}
        <div>
            <h2 class="text-2xl font-bold mb-4">¿Qué incluye este tour?</h2>
            <ul class="space-y-3 text-gray-600 list-disc list-inside">
                @foreach ($tour['includes'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>

        {{-- IDEAL FOR --}}
        <div>
            <h2 class="text-2xl font-bold mb-4">Ideal para</h2>
            <ul class="space-y-3 text-gray-600 list-disc list-inside">
                @foreach ($tour['ideal_for'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>

    </section>

    {{-- ================= CTA ================= --}}
    <div class="mt-20 text-center scroll-hero">
        <a
            href="https://wa.me/50683217459?text=Hola,%20me%20interesa%20el%20tour:%20{{ urlencode($tour['title']) }}"
            target="_blank"
            class="btn-primary px-8 py-4 text-lg">
            Reservar por WhatsApp
        </a>
    </div>

</section>
@endsection
