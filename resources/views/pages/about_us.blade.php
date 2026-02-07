@extends('layouts.app')

@section('title', __('about.title'))

@section('content')

{{-- =====================================================
   ABOUT US – HERO
===================================================== --}}
<section class="bg-white pt-32 pb-20">
    <div class="max-w-5xl mx-auto px-6 text-center">

        <span class="inline-block text-green-600 font-semibold tracking-wide uppercase text-sm
                     opacity-0 animate-hero hero-delay-1">
            {{ __('about.hero_tag') }}
        </span>

        <h1 class="mt-4 text-4xl md:text-5xl xl:text-6xl font-extrabold text-gray-900 leading-tight
                   opacity-0 animate-hero hero-delay-2">
            {{ __('about.hero_title_line_1') }}
            <span class="text-green-600">
                {{ __('about.hero_title_highlight') }}
            </span>
        </h1>

        <p class="mt-6 text-lg text-gray-600 max-w-2xl mx-auto
                  opacity-0 animate-hero hero-delay-3">
            {{ __('about.hero_description') }}
        </p>

    </div>
</section>

{{-- =====================================================
   ABOUT US – CONTENT
===================================================== --}}
<section class="py-20">
    <div class="max-w-6xl mx-auto px-6">

        <div class="scroll-hero grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">

            {{-- LEFT --}}
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ __('about.who_title') }}
                </h2>

                <p class="text-gray-600 leading-relaxed">
                    <strong>Aventura506</strong>
                    {{ __('about.who_paragraph_1') }}
                </p>

                <p class="text-gray-600 leading-relaxed">
                    {{ __('about.who_paragraph_2') }}
                </p>
            </div>

            {{-- RIGHT --}}
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ __('about.important_title') }}
                </h2>

                <p class="text-gray-600 leading-relaxed">
                    {{ __('about.important_paragraph_1') }}
                </p>

                <p class="text-gray-600 leading-relaxed">
                    {{ __('about.important_paragraph_2') }}
                </p>

                <ul class="space-y-4 mt-6">
                    <li class="flex items-start gap-3">
                        <span class="text-green-600 font-bold">✔</span>
                        {{ __('about.benefit_1') }}
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-600 font-bold">✔</span>
                        {{ __('about.benefit_2') }}
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-600 font-bold">✔</span>
                        {{ __('about.benefit_3') }}
                    </li>
                </ul>
            </div>

        </div>
    </div>
</section>

{{-- =====================================================
   ABOUT US – CTA
===================================================== --}}
<section class="bg-white py-20">
    <div class="max-w-4xl mx-auto px-6 text-center scroll-hero">

        <h2 class="text-3xl font-bold text-gray-900">
            {{ __('about.cta_title') }}
        </h2>

        <p class="mt-4 text-gray-600 max-w-xl mx-auto">
            {{ __('about.cta_description') }}
        </p>

        <div class="mt-8 flex justify-center gap-4 hero-buttons">
            <a href="/contact" class="btn-primary">
                {{ __('about.cta_contact') }}
            </a>

            <a href="/" class="btn-secondary">
                {{ __('about.cta_experiences') }}
            </a>
        </div>

    </div>
</section>

@endsection
