@extends('layouts.app')

@section('content')

{{-- ================= HERO SECTION ================= --}}
<section class="relative bg-white overflow-hidden">

    <div class="max-w-7xl mx-auto px-6 py-20 grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">

        {{-- TEXTO --}}
        <div class="opacity-0 animate-hero hero-delay-1">

            <span class="text-green-600 font-semibold tracking-wide uppercase text-sm">
                Turismo & Aventura
            </span>

            <h1 class="mt-4 text-4xl md:text-5xl xl:text-6xl font-extrabold text-gray-900 leading-tight
                       opacity-0 animate-hero hero-delay-2">
                Viví lo mejor de
                <span class="text-green-600">La Fortuna</span>
                en un solo lugar
            </h1>

            <p class="mt-6 text-lg text-gray-600 max-w-xl
                      opacity-0 animate-hero hero-delay-3">
                Descubrí tours, experiencias naturales y hospedaje cuidadosamente
                seleccionados para que aproveches La Fortuna al máximo,
                sin perder tiempo ni dinero.
            </p>

            {{-- BOTONES --}}
            <div class="mt-8 flex flex-col sm:flex-row gap-4 hero-buttons">

                {{-- BOTÓN PRINCIPAL --}}
                <a href="#tours"
                    class="btn-primary">
                    Explorar Tours
                </a>

                {{-- BOTÓN SECUNDARIO --}}
                <a href="#hospedaje"
                    class="btn-secondary">
                    Ver Hospedaje
                </a>

            </div>

        </div>

        {{-- IMÁGENES --}}
        <div class="relative grid grid-cols-2 gap-6">

            {{-- Volcán Arenal --}}
            <img
                src="https://image-tc.galaxy.tf/wijpeg-27ubwpu4ecat1y90z03clnvcx/la-fortuna-san-carlos_standard.jpg?crop=316%2C0%2C1067%2C800"
                alt="Volcán Arenal - La Fortuna"
                class="rounded-2xl shadow-xl object-cover h-56 w-full
                       transition-all duration-500 ease-out
                       hover:scale-110 hover:-translate-y-1 cursor-pointer">

            {{-- Catarata La Fortuna --}}
            <img
                src="https://www.civitatis.com/f/costa-rica/arenal/galeria/fortuna-catarata-costa-rica.jpg"
                alt="Catarata La Fortuna"
                class="rounded-2xl shadow-xl object-cover h-72 w-full row-span-2
                       transition-all duration-500 ease-out
                       hover:scale-110 hover:-translate-y-1 cursor-pointer">

            {{-- Aventura / Naturaleza --}}
            <img
                src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/16/0a/f5/08/lovely-warm-water.jpg?w=1200&h=-1&s=1"
                alt="Aventura en La Fortuna"
                class="rounded-2xl shadow-xl object-cover h-48 w-full
                       transition-all duration-500 ease-out
                       hover:scale-110 hover:-translate-y-1 cursor-pointer">

            {{-- Overlay decorativo --}}
            <div class="absolute -z-10 -top-10 -right-10 w-72 h-72 bg-green-100 rounded-full blur-3xl"></div>
        </div>

    </div>
</section>
{{-- ================= END HERO ================= --}}

{{-- ================= INFO CARDS ================= --}}
<section class="max-w-7xl mx-auto px-4 py-16 grid gap-8 md:grid-cols-3">

    <div class="bg-white p-6 rounded-xl shadow text-center hover:shadow-lg transition">
        🌋
        <h3 class="font-semibold text-xl mt-4">Volcán Arenal</h3>
        <p class="text-sm text-gray-600 mt-2">
            Naturaleza, caminatas y vistas únicas.
        </p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow text-center hover:shadow-lg transition">
        🌿
        <h3 class="font-semibold text-xl mt-4">Aventura</h3>
        <p class="text-sm text-gray-600 mt-2">
            Canopy, rafting y adrenalina.
        </p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow text-center hover:shadow-lg transition">
        🏨
        <h3 class="font-semibold text-xl mt-4">Hospedaje</h3>
        <p class="text-sm text-gray-600 mt-2">
            Hoteles, lodges y cabañas.
        </p>
    </div>

</section>

@endsection