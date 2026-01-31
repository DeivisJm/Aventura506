@extends('layouts.app')

@section('content')

{{-- =====================================================
   ABOUT US – HERO
===================================================== --}}
<section class="bg-white pt-32 pb-20">
    <div class="max-w-5xl mx-auto px-6 text-center">

        <span class="inline-block text-green-600 font-semibold tracking-wide uppercase text-sm
                     opacity-0 animate-hero hero-delay-1">
            Sobre Aventura506
        </span>

        <h1 class="mt-4 text-4xl md:text-5xl xl:text-6xl font-extrabold text-gray-900 leading-tight
                   opacity-0 animate-hero hero-delay-2">
            Tu punto de partida para vivir
            <span class="text-green-600">La Fortuna</span>
        </h1>

        <p class="mt-6 text-lg text-gray-600 max-w-2xl mx-auto
                  opacity-0 animate-hero hero-delay-3">
            En Aventura506 te ayudamos a descubrir experiencias auténticas,
            tours y actividades cuidadosamente seleccionadas para que disfrutes
            La Fortuna sin complicaciones.
        </p>

    </div>
</section>

{{-- ABOUT US – CONTENT--}}
<section class="bg-gray-50 py-20">
    <div class="max-w-6xl mx-auto px-6">

        {{-- WRAPPER OBSERVADO --}}
        <div class="scroll-hero grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">

            {{-- LEFT --}}
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-gray-900">
                    ¿Quiénes somos?
                </h2>

                <p class="text-gray-600 leading-relaxed">
                    <strong>Aventura506</strong> es una plataforma digital creada para
                    facilitar la reserva de tours, experiencias y servicios turísticos
                    en la zona de La Fortuna, Costa Rica.
                </p>

                <p class="text-gray-600 leading-relaxed">
                    Nuestro objetivo es ayudarte a encontrar las mejores opciones
                    disponibles, comparar experiencias y conectar directamente con
                    proveedores confiables, todo desde un solo lugar.
                </p>
            </div>

            {{-- RIGHT --}}
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-gray-900">
                    Importante saber
                </h2>

                <p class="text-gray-600 leading-relaxed">
                    Aventura506 <strong>no es operador turístico</strong>.
                    No realizamos los tours directamente.
                </p>

                <p class="text-gray-600 leading-relaxed">
                    Actuamos como <strong>intermediarios</strong> entre los viajeros
                    y los operadores turísticos locales, facilitando el proceso
                    de información y contacto.
                </p>

                <ul class="space-y-4 mt-6">
                    <li class="flex items-start gap-3">
                        <span class="text-green-600 font-bold">✔</span>
                        Operadores locales verificados
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-600 font-bold">✔</span>
                        Información clara y transparente
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-600 font-bold">✔</span>
                        Atención rápida vía WhatsApp
                    </li>
                </ul>
            </div>

        </div>
    </div>
</section>


{{-- ABOUT US – CTA --}}
<section class="bg-white py-20">
    <div class="max-w-4xl mx-auto px-6 text-center scroll-hero">

        <h2 class="text-3xl font-bold text-gray-900">
            ¿Listo para planear tu aventura?
        </h2>

        <p class="mt-4 text-gray-600 max-w-xl mx-auto">
            Escríbenos y te ayudamos a encontrar la experiencia ideal
            según tu tiempo, presupuesto y estilo de viaje.
        </p>

        <div class="mt-8 flex justify-center gap-4 hero-buttons">
            <a href="/contact" class="btn-primary">
                Contáctanos
            </a>

            <a href="/" class="btn-secondary">
                Ver experiencias
            </a>
        </div>

    </div>
</section>
@endsection