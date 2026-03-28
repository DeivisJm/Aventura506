@extends('layouts.app')

@section('title', $accommodation->getTranslated('name'))

@section('content')

<section class="max-w-7xl mx-auto px-6 py-16">
    <div class="mb-8">
        <p class="text-green-600 font-semibold mb-2">
            {{ $accommodation->getTranslated('property_type') }}
        </p>

        <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-3">
            {{ $accommodation->getTranslated('name') }}
        </h1>

        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-300">
            @if($accommodation->rating)
                <span>⭐ {{ number_format((float)$accommodation->rating, 1) }}</span>
            @endif

            @if($accommodation->reviews_count)
                <span>{{ $accommodation->reviews_count }} reviews</span>
            @endif

            <span>{{ $accommodation->getTranslated('location_text') }}</span>
        </div>
    </div>

    <div class="mb-10">
        <img src="{{ $accommodation->image_url }}"
             alt="{{ $accommodation->getTranslated('name') }}"
             class="w-full h-[450px] object-cover rounded-3xl shadow">
    </div>

    <div class="grid lg:grid-cols-3 gap-10">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow border border-gray-100 dark:border-gray-800 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ $accommodation->getTranslated('name') }}
                </h2>

                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                    {{ $accommodation->getTranslated('description') }}
                </p>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow border border-gray-100 dark:border-gray-800 p-8 mb-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                    Details
                </h3>

                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                    <div class="rounded-2xl bg-gray-50 dark:bg-gray-800 p-4">
                        <p class="text-gray-500 dark:text-gray-400">Guests</p>
                        <p class="font-bold text-gray-900 dark:text-white">{{ $accommodation->max_guests }}</p>
                    </div>

                    <div class="rounded-2xl bg-gray-50 dark:bg-gray-800 p-4">
                        <p class="text-gray-500 dark:text-gray-400">Bedrooms</p>
                        <p class="font-bold text-gray-900 dark:text-white">{{ $accommodation->bedrooms }}</p>
                    </div>

                    <div class="rounded-2xl bg-gray-50 dark:bg-gray-800 p-4">
                        <p class="text-gray-500 dark:text-gray-400">Beds</p>
                        <p class="font-bold text-gray-900 dark:text-white">{{ $accommodation->beds }}</p>
                    </div>

                    <div class="rounded-2xl bg-gray-50 dark:bg-gray-800 p-4">
                        <p class="text-gray-500 dark:text-gray-400">Bathrooms</p>
                        <p class="font-bold text-gray-900 dark:text-white">{{ $accommodation->bathrooms }}</p>
                    </div>
                </div>
            </div>

            @php
                $amenities = $accommodation->amenities[app()->getLocale()] ?? $accommodation->amenities['es'] ?? [];
                $includes = $accommodation->includes[app()->getLocale()] ?? $accommodation->includes['es'] ?? [];
                $rules = $accommodation->house_rules[app()->getLocale()] ?? $accommodation->house_rules['es'] ?? [];
            @endphp

            @if(!empty($amenities))
                <div class="bg-white dark:bg-gray-900 rounded-3xl shadow border border-gray-100 dark:border-gray-800 p-8 mb-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                        Amenities
                    </h3>

                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach($amenities as $item)
                            <div class="rounded-2xl bg-gray-50 dark:bg-gray-800 px-4 py-3 text-gray-700 dark:text-gray-200">
                                ✓ {{ $item }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(!empty($includes))
                <div class="bg-white dark:bg-gray-900 rounded-3xl shadow border border-gray-100 dark:border-gray-800 p-8 mb-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                        Includes
                    </h3>

                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach($includes as $item)
                            <div class="rounded-2xl bg-gray-50 dark:bg-gray-800 px-4 py-3 text-gray-700 dark:text-gray-200">
                                ✓ {{ $item }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(!empty($rules))
                <div class="bg-white dark:bg-gray-900 rounded-3xl shadow border border-gray-100 dark:border-gray-800 p-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                        House rules
                    </h3>

                    <div class="grid sm:grid-cols-2 gap-3">
                        @foreach($rules as $item)
                            <div class="rounded-2xl bg-gray-50 dark:bg-gray-800 px-4 py-3 text-gray-700 dark:text-gray-200">
                                • {{ $item }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <aside>
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-800 p-8 sticky top-24">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                    Price per night
                </p>

                <p class="text-3xl font-extrabold text-gray-900 dark:text-white mb-6">
                    {{ $accommodation->currency }} {{ number_format((float)$accommodation->price_per_night, 2) }}
                </p>

                <div class="space-y-4 mb-6">
                    @if($accommodation->check_in_time)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Check-in</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $accommodation->check_in_time }}</span>
                        </div>
                    @endif

                    @if($accommodation->check_out_time)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Check-out</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $accommodation->check_out_time }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Guests</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $accommodation->max_guests }}</span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Location</span>
                        <span class="font-semibold text-gray-900 dark:text-white text-right">{{ $accommodation->getTranslated('location_text') }}</span>
                    </div>
                </div>

                <a href="{{ route('contact') }}"
                   class="btn-primary w-full text-center inline-block">
                    Contact / Book now
                </a>
            </div>
        </aside>
    </div>
</section>

@endsection