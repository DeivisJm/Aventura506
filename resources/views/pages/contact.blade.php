@extends('layouts.app')

@section('title', 'Contacto')

@section('content')

{{-- =====================================================
   CONTACT HERO
   Encabezado claro, directo y humano
===================================================== --}}
<section class="bg-white pt-32 pb-20">
    <div class="max-w-5xl mx-auto px-6 text-center">
        <h1 class="mt-4 text-4xl md:text-5xl font-extrabold text-gray-900">
            Hablemos de tu próxima aventura
        </h1>

        <p class="mt-6 text-gray-600 max-w-2xl mx-auto">
            ¿Tenés preguntas sobre tours, hospedaje o paquetes?
            Escribinos y con gusto te ayudamos a planear tu experiencia en La Fortuna.
        </p>

    </div>
</section>

{{-- =====================================================
   CONTACT CONTENT
   Información + Formulario
===================================================== --}}
<section class="py-20">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

        {{-- ================= LEFT: INFO ================= --}}
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">
                ¿Por qué contactarnos?
            </h2>

            <p class="text-gray-600 mb-6">
                Somos expertos locales en La Fortuna. Ya sea que planeés
                una visita corta o una aventura completa, te guiamos con
                recomendaciones honestas y personalizadas.
            </p>

            <ul class="space-y-4 text-gray-700">
                <li class="flex items-start gap-3">
                    <span class="text-green-600 font-bold">✔</span>
                    Recomendaciones de tours según tu estilo de viaje
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-green-600 font-bold">✔</span>
                    Hospedajes confiables y bien ubicados
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-green-600 font-bold">✔</span>
                    Respuesta rápida por WhatsApp
                </li>
            </ul>
        </div>

        {{-- ================= RIGHT: FORM ================= --}}
        <div class="bg-white p-8 rounded-2xl shadow-lg">

            <form class="space-y-6">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nombre completo
                    </label>
                    <input type="text"
                        class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        placeholder="Tu nombre">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Correo electrónico
                    </label>
                    <input type="email"
                        class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        placeholder="tu@email.com">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Mensaje
                    </label>
                    <textarea rows="4"
                        class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        placeholder="Contanos qué estás buscando..."></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-green-600 text-white py-3 rounded-full font-semibold
                               hover:bg-green-700 transition">
                    Enviar mensaje
                </button>

                <p class="text-xs text-gray-500 text-center mt-4">
                    O escribinos directamente por WhatsApp usando el botón flotante.
                </p>

            </form>

        </div>

    </div>
</section>

@endsection