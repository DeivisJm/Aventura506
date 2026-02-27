@extends('layouts.app')

@section('title', __('contact.title'))

@section('content')

{{-- =====================================================
   CONTACT HERO
===================================================== --}}
<section class="bg-white dark:bg-gray-950 pt-32 pb-24 transition-colors duration-500">
    <div class="max-w-6xl mx-auto px-6 text-center scroll-hero">

        <span class="text-green-600 text-sm font-semibold tracking-wider uppercase">
            {{ __('contact.small_title') }}
        </span>

        <h1 class="mt-6 text-4xl md:text-5xl font-extrabold 
            text-gray-900 dark:text-white leading-tight">

            {{ __('contact.hero_title_part_1') }}

            <span class="text-green-600">
                {{ __('contact.hero_highlight') }}
            </span>

        </h1>

        <p class="mt-6 text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
            {{ __('contact.hero_description') }}
        </p>

    </div>
</section>


{{-- =====================================================
   CONTACT MAIN SECTION
===================================================== --}}
<section class="bg-transparent py-24 transition-colors duration-500">
    <div class="max-w-6xl mx-auto px-6 grid lg:grid-cols-2 gap-20 items-start">

        {{-- ================= LEFT INFO BLOCK ================= --}}
        <div class="scroll-hero">

            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
                {{ __('contact.why_title') }}
            </h2>

            <p class="text-gray-900 dark:text-gray-300  mb-10 leading-relaxed text-lg">
                {{ __('contact.why_description') }}
            </p>

            <ul class="space-y-8 text-gray-900 dark:text-gray-100">

                @for($i = 1; $i <= 5; $i++)

                    <li class="flex items-start gap-5 group">

                    <!-- Icon Circle -->
                    <div class="flex items-center justify-center 
                        w-10 h-10 rounded-full 
                        bg-white
                        border-2 border-green-600
                        shadow-md
                        dark:bg-green-900/40
                        dark:border-green-500
                        flex-shrink-0
                        transition-all duration-300 group-hover:scale-110">

                        <svg class="w-5 h-5 
                            text-green-700 
                            dark:text-green-400"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="3"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5 13l4 4L19 7" />
                        </svg>

                    </div>

                    <!-- Text -->
                    <span class="leading-relaxed font-medium">
                        {{ __('contact.benefit_'.$i) }}
                    </span>

                    </li>

                    @endfor

            </ul>

        </div>


        {{-- ================= FORM CARD ================= --}}
        <div class="scroll-hero">

            <div class="bg-white dark:bg-white/5 backdrop-blur-md
        rounded-3xl p-12
        border border-gray-200 dark:border-white/10
        shadow-xl transition-all duration-500">

                <form class="space-y-7">

                    {{-- NAME --}}
                    <div>
                        <label class="block text-sm font-medium mb-2
                    text-gray-900 dark:text-white">
                            {{ __('contact.form_name_label') }}
                        </label>

                        <input type="text"
                            class="w-full px-4 py-3 rounded-xl
                            bg-white dark:bg-transparent
                            border border-gray-300 dark:border-gray-700
                            text-black dark:text-white
                            placeholder-gray-400 dark:placeholder-gray-500
                            focus:text-black dark:focus:text-white
                            focus:outline-none
                            focus:border-green-600 dark:focus:border-green-400
                            transition-colors duration-300"
                            placeholder="{{ __('contact.form_name_placeholder') }}">
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label class="block text-sm font-medium mb-2
                    text-gray-900 dark:text-white">
                            {{ __('contact.form_email_label') }}
                        </label>

                        <input type="email"
                            class="w-full px-4 py-3 rounded-xl
                            bg-white dark:bg-transparent
                            border border-gray-300 dark:border-gray-700
                            text-black dark:text-white
                            placeholder-gray-400 dark:placeholder-gray-500
                            focus:text-black dark:focus:text-white
                            focus:outline-none
                            focus:border-green-600 dark:focus:border-green-400
                            transition-colors duration-300"
                            placeholder="{{ __('contact.form_email_placeholder') }}">
                    </div>

                    {{-- MESSAGE --}}
                    <div>
                        <label class="block text-sm font-medium mb-2
                    text-gray-900 dark:text-white">
                            {{ __('contact.form_message_label') }}
                        </label>

                        <textarea rows="4"
                            class="w-full px-4 py-3 rounded-xl
                        bg-white dark:bg-transparent
                        border border-gray-300 dark:border-gray-700
                        text-black dark:text-white
                        placeholder-gray-400 dark:placeholder-gray-500
                        focus:text-black dark:focus:text-white
                        focus:outline-none
                        focus:border-green-600 dark:focus:border-green-400
                        transition-colors duration-300"
                            placeholder="{{ __('contact.form_message_placeholder') }}"></textarea>
                    </div>

                    {{-- BUTTON --}}
                    <button type="submit"
                        class="w-full py-3 rounded-full
                        bg-green-600 dark:bg-green-500
                        text-white text-sm uppercase tracking-widest
                        transition-all duration-300
                        hover:bg-green-700 dark:hover:bg-green-400
                        hover:shadow-lg">
                        {{ __('contact.form_submit') }}
                    </button>

                    <p class="text-xs text-center mt-4
                text-gray-600 dark:text-gray-400">
                        {{ __('contact.whatsapp_note') }}
                    </p>

                </form>

            </div>

        </div>

    </div>
</section>

{{-- SUBSCRIPTION SECTION --}}
<section class="py-20 bg-white dark:bg-gray-950 transition-colors duration-500">
    <div class="max-w-4xl mx-auto px-6 text-center scroll-hero">

        <h3 class="text-2xl md:text-3xl font-semibold text-gray-900 dark:text-white mb-4">
            {{ __('footer.newsletter_title') }}
        </h3>

        <p class="text-base md:text-lg text-gray-600 dark:text-gray-400 mb-10 max-w-2xl mx-auto">
            {{ __('footer.newsletter_subtitle') }}
        </p>

        <form method="POST" action="{{ route('subscribe.store') }}"
            class="relative max-w-xl mx-auto">

            @csrf

            <div class="rounded-full flex items-center
                    bg-white
                    dark:bg-white/5
                    border-2 border-green-600
                    shadow-[0_0_0_3px_rgba(34,197,94,0.15)]
                    transition-all duration-300">

                <input type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="{{ __('footer.email_placeholder') }}"
                    class="flex-1 px-6 py-4 bg-transparent text-sm md:text-base
                    text-gray-900 dark:text-gray-200
                    placeholder-gray-500 dark:placeholder-gray-500
                    focus:outline-none rounded-full">

                <button type="submit"
                    class="luxury-btn relative px-8 py-4 rounded-full
                    bg-gradient-to-r from-green-600 to-green-700
                    text-white text-xs md:text-sm uppercase tracking-widest
                    overflow-hidden">
                    {{ __('footer.subscribe') }}
                </button>

            </div>

        </form>

    </div>
</section>

@endsection