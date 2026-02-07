@extends('layouts.app')

@section('title', __('contact.title'))

@section('content')

{{-- =====================================================
   CONTACT HERO
===================================================== --}}
<section class="bg-white pt-32 pb-20">
    <div class="max-w-5xl mx-auto px-6 text-center">

        <h1 class="mt-4 text-4xl md:text-5xl font-extrabold text-gray-900">
            {{ __('contact.hero_title') }}
        </h1>

        <p class="mt-6 text-gray-600 max-w-2xl mx-auto">
            {{ __('contact.hero_description') }}
        </p>

    </div>
</section>

{{-- =====================================================
   CONTACT CONTENT
===================================================== --}}
<section class="py-20">
    <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

        {{-- ================= LEFT: INFO ================= --}}
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-4">
                {{ __('contact.why_title') }}
            </h2>

            <p class="text-gray-600 mb-6">
                {{ __('contact.why_description') }}
            </p>

            <ul class="space-y-4 text-gray-700">
                <li class="flex items-start gap-3">
                    <span class="text-green-600 font-bold">✔</span>
                    {{ __('contact.benefit_1') }}
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-green-600 font-bold">✔</span>
                    {{ __('contact.benefit_2') }}
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-green-600 font-bold">✔</span>
                    {{ __('contact.benefit_3') }}
                </li>
            </ul>
        </div>

        {{-- ================= RIGHT: FORM ================= --}}
        <div class="bg-white p-8 rounded-2xl shadow-lg">

            <form class="space-y-6">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('contact.form_name_label') }}
                    </label>
                    <input type="text"
                        class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        placeholder="{{ __('contact.form_name_placeholder') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('contact.form_email_label') }}
                    </label>
                    <input type="email"
                        class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        placeholder="{{ __('contact.form_email_placeholder') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('contact.form_message_label') }}
                    </label>
                    <textarea rows="4"
                        class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500"
                        placeholder="{{ __('contact.form_message_placeholder') }}"></textarea>
                </div>

                <button type="submit"
                    class="w-full bg-green-600 text-white py-3 rounded-full font-semibold hover:bg-green-700 transition">
                    {{ __('contact.form_submit') }}
                </button>

                <p class="text-xs text-gray-500 text-center mt-4">
                    {{ __('contact.whatsapp_note') }}
                </p>

            </form>

        </div>

    </div>
</section>

@endsection
