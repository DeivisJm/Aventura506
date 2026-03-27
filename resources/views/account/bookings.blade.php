@extends('layouts.app')

@section('title', __('bookings.title'))

@section('content')

{{-- =====================================================
   BOOKINGS PAGE – HERO
===================================================== --}}
<section class="bookings-hero bg-white dark:bg-gray-950 pt-32 pb-20 overflow-hidden transition-colors duration-500">
    <div class="max-w-6xl mx-auto px-6 text-center">

        <span class="inline-block text-green-600 font-semibold tracking-wide uppercase text-sm
                     opacity-0 animate-hero hero-delay-1">
            {{ __('bookings.hero_tag') }}
        </span>

        <h1 class="mt-4 text-4xl md:text-5xl xl:text-6xl font-extrabold text-gray-900 dark:text-white leading-tight
                   opacity-0 animate-hero hero-delay-2">
            {{ __('bookings.hero_title_line_1') }}
            <span class="text-green-600">
                {{ __('bookings.hero_title_highlight') }}
            </span>
        </h1>

        <p class="mt-6 text-lg text-gray-600 dark:text-gray-400 max-w-3xl mx-auto leading-relaxed
                  opacity-0 animate-hero hero-delay-3">
            {{ __('bookings.hero_description') }}
        </p>

    </div>
</section>

{{-- =====================================================
   BOOKINGS PAGE – CONTENT
===================================================== --}}
<section class="py-20 bg-transparent">
    <div class="max-w-6xl mx-auto px-6">

        @if($bookings->isEmpty())

        {{-- =====================================================
               EMPTY STATE
            ===================================================== --}}
        <div class="scroll-hero">
            <div class="bookings-empty-card p-8 md:p-12 text-center">

                <div class="bookings-empty-icon">
                    <svg class="w-10 h-10 text-green-600 dark:text-green-400"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 7V3m8 4V3m-9 8h10m-11 8h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>

                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white">
                    {{ __('bookings.empty_title') }}
                </h2>

                <p class="mt-4 text-gray-600 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed">
                    {{ __('bookings.empty_description') }}
                </p>

                <div class="mt-8 flex justify-center">
                    <a href="{{ route('tours.index') }}" class="btn-primary">
                        {{ __('bookings.explore_tours') }}
                    </a>
                </div>

            </div>
        </div>

        @else

        {{-- =====================================================
               BOOKING LIST
            ===================================================== --}}
        <div class="space-y-8">
            @foreach($bookings as $booking)

            @php
            /*
            |--------------------------------------------------------------------------
            | Booking classification
            |--------------------------------------------------------------------------
            | Prepared for both tours and accommodations.
            */
            $bookingStatus = strtolower($booking->status ?? 'pending');

            $relatedTour = $booking->tour ?? null;
            $relatedAccommodation = $booking->accommodation ?? null;

            $bookingType = 'tour';

            if (!is_null($relatedAccommodation)) {
            $bookingType = 'accommodation';
            } elseif (
            isset($booking->booking_type) &&
            in_array($booking->booking_type, ['tour', 'accommodation'])
            ) {
            $bookingType = $booking->booking_type;
            } elseif (
            isset($booking->type) &&
            in_array($booking->type, ['tour', 'accommodation'])
            ) {
            $bookingType = $booking->type;
            }

            /*
            |--------------------------------------------------------------------------
            | Experience name
            |--------------------------------------------------------------------------
            */
            $experienceName = __('bookings.reservation_fallback');

            if ($bookingType === 'accommodation') {
            $experienceName =
            $relatedAccommodation?->getTranslated('name')
            ?? $relatedAccommodation?->name
            ?? __('bookings.accommodation_fallback');
            } else {
            $experienceName =
            $relatedTour?->getTranslated('name')
            ?? $relatedTour?->name
            ?? __('bookings.tour_fallback');
            }

            /*
            |--------------------------------------------------------------------------
            | Labels
            |--------------------------------------------------------------------------
            */
            $bookingTypeLabel = $bookingType === 'accommodation'
            ? __('bookings.type_accommodation')
            : __('bookings.type_tour');

            $bookingTypeDescription = $bookingType === 'accommodation'
            ? __('bookings.type_accommodation_description')
            : __('bookings.type_tour_description');

            $editorialBadge = $bookingType === 'accommodation'
            ? __('bookings.editorial_badge_accommodation')
            : __('bookings.editorial_badge_tour');

            $bookingTypeIcon = $bookingType === 'accommodation' ? 'hotel' : 'map';

            /*
            |--------------------------------------------------------------------------
            | Thumbnail image
            |--------------------------------------------------------------------------
            */
            $thumbnail = null;

            if ($bookingType === 'accommodation') {
            $thumbnail = !empty($relatedAccommodation?->image)
            ? asset($relatedAccommodation->image)
            : asset('images/default-tour.jpg');
            } else {
            $thumbnail = !empty($relatedTour?->image)
            ? asset($relatedTour->image)
            : asset('images/default-tour.jpg');
            }
            @endphp

            <article class="scroll-hero booking-card booking-card--{{ $bookingType }}">

                {{-- =====================================================
                           LUMINOUS SIDE BAR
                        ===================================================== --}}
                <div class="booking-card-accent" aria-hidden="true"></div>

                {{-- =====================================================
                           CARD HEADER
                        ===================================================== --}}
                <div class="booking-card-header">
                    <div class="grid grid-cols-1 xl:grid-cols-[1fr_280px] gap-8 items-start">

                        {{-- =====================================================
                                   LEFT CONTENT
                                ===================================================== --}}
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="booking-card-badge">
                                    {{ __('bookings.card_badge') }}
                                </span>

                                <span class="booking-type-pill booking-type-pill--{{ $bookingType }}">
                                    <span class="booking-type-pill-icon">
                                        @if($bookingTypeIcon === 'hotel')
                                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7a2 2 0 012-2h10a2 2 0 012 2v14M9 9h.01M9 12h.01M9 15h.01M15 9h.01M15 12h.01M15 15h.01M8 21v-3a1 1 0 011-1h6a1 1 0 011 1v3" />
                                        </svg>
                                        @else
                                        <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2m0 18l6-2m-6 2V2m6 16l5.447 2.724A1 1 0 0021 17.382V6.618a1 1 0 00-.553-.894L15 3m0 15V3m0 0L9 2" />
                                        </svg>
                                        @endif
                                    </span>

                                    <span>{{ $bookingTypeLabel }}</span>
                                </span>
                            </div>

                            <h2 class="booking-card-title">
                                {{ $experienceName }}
                            </h2>

                            <p class="booking-card-subtext">
                                {{ $bookingTypeDescription }}
                            </p>

                            <div class="booking-card-detail-row break-all">
                                <span class="booking-card-detail-label">{{ __('bookings.email') }}</span>
                                <span class="booking-card-detail-value">{{ $booking->guest_email }}</span>
                            </div>

                            <div class="mt-4 flex flex-wrap items-center gap-3">
                                <span class="booking-status
                                            @if($bookingStatus === 'confirmed')
                                                booking-status--confirmed
                                            @elseif($bookingStatus === 'cancelled')
                                                booking-status--cancelled
                                            @else
                                                booking-status--pending
                                            @endif">
                                    {{ __('bookings.status_' . $bookingStatus) }}
                                </span>

                                @if(!empty($booking->created_at))
                                <p class="booking-created-at">
                                    {{ __('bookings.created_at') }}:
                                    {{ $booking->created_at->format('d/m/Y H:i') }}
                                </p>
                                @endif
                            </div>
                        </div>

                        {{-- =====================================================
                                   RIGHT COVER MEDIA
                                ===================================================== --}}
                        <div class="booking-card-media">
                            <div class="booking-card-cover">
                                <img
                                    src="{{ $thumbnail }}"
                                    alt="{{ $experienceName }}"
                                    class="booking-card-cover-image">

                                <div class="booking-card-cover-overlay"></div>

                                <span class="booking-card-cover-badge booking-card-cover-badge--{{ $bookingType }}">
                                    {{ $editorialBadge }}
                                </span>

                                <div class="booking-card-cover-content">
                                    <p class="booking-card-cover-type">
                                        {{ $bookingTypeLabel }}
                                    </p>
                                    <h3 class="booking-card-cover-title">
                                        {{ $experienceName }}
                                    </h3>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- =====================================================
                           CARD BODY
                        ===================================================== --}}
                <div class="booking-card-body">

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

                        <div class="booking-info-box">
                            <p class="booking-info-label">
                                {{ __('bookings.date') }}
                            </p>
                            <p class="booking-info-value">
                                {{ $booking->date ? \Carbon\Carbon::parse($booking->date)->format('d/m/Y') : __('bookings.not_available') }}
                            </p>
                        </div>

                        <div class="booking-info-box">
                            <p class="booking-info-label">
                                {{ __('bookings.time') }}
                            </p>
                            <p class="booking-info-value">
                                {{ $booking->time ? \Carbon\Carbon::parse($booking->time)->format('H:i') : __('bookings.not_available') }}
                            </p>
                        </div>

                        <div class="booking-info-box">
                            <p class="booking-info-label">
                                {{ $bookingType === 'accommodation' ? __('bookings.guests') : __('bookings.persons') }}
                            </p>
                            <p class="booking-info-value">
                                {{ $booking->persons ?? __('bookings.not_available') }}
                            </p>
                        </div>

                        <div class="booking-info-box booking-info-box--price">
                            <p class="booking-info-label">
                                {{ __('bookings.total') }}
                            </p>
                            <p class="booking-info-value booking-info-value--price">
                                @if(!is_null($booking->total_display))
                                {{ $booking->currency === 'CRC' ? '₡' : '$' }}{{ number_format($booking->total_display, 2) }}
                                @elseif(!is_null($booking->total))
                                {{ $booking->currency === 'CRC' ? '₡' : '$' }}{{ number_format($booking->total, 2) }}
                                @else
                                {{ __('bookings.not_available') }}
                                @endif
                            </p>
                        </div>

                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div class="booking-info-box booking-info-box--secondary">
                            <p class="booking-info-label">
                                {{ __('bookings.phone') }}
                            </p>
                            <p class="booking-info-value booking-info-value--soft break-all">
                                {{ $booking->guest_phone ?? __('bookings.not_available') }}
                            </p>
                        </div>

                        <div class="booking-info-box booking-info-box--secondary">
                            <p class="booking-info-label">
                                {{ __('bookings.nationality') }}
                            </p>
                            <p class="booking-info-value booking-info-value--soft">
                                {{ $booking->guest_nationality ?? __('bookings.not_available') }}
                            </p>
                        </div>

                    </div>

                    @if($bookingType === 'accommodation')
                    <div class="mt-6 booking-notes-box booking-context-box">
                        <p class="booking-info-label">
                            {{ __('bookings.accommodation_context_title') }}
                        </p>
                        <p class="booking-notes-text">
                            {{ __('bookings.accommodation_context_description') }}
                        </p>
                    </div>
                    @endif

                    @if(!empty($booking->notes))
                    <div class="mt-6 booking-notes-box">
                        <p class="booking-info-label">
                            {{ __('bookings.notes') }}
                        </p>
                        <p class="booking-notes-text">
                            {{ $booking->notes }}
                        </p>
                    </div>
                    @endif

                </div>
            </article>

            @endforeach
        </div>

        @endif

    </div>
</section>

@endsection