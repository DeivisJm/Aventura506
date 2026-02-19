{{-- =========================================================
   RECTANGULAR BOOKING MODAL – FINAL PRO VERSION
========================================================= --}}

<div id="bookingModal" class="booking-overlay">

    <div class="booking-container w-full max-w-7xl rounded-xl shadow-2xl">

        {{-- HEADER --}}
        <div class="booking-header flex justify-between items-center px-12 py-6">

            <div>
                <h2 class="text-2xl font-semibold">
                    {{ __('booking.title_tour') }}
                </h2>

                <div class="booking-prices mt-6 space-y-3"></div>
            </div>

            <button type="button" id="closeBooking" class="booking-close text-3xl">
                ✕
            </button>
        </div>

        <div class="booking-content flex flex-col md:grid md:grid-cols-2">

            {{-- LEFT SIDE CALENDAR --}}
            <div class="calendar-side p-12 border-r border-gray-200 dark:border-gray-800 transition-all duration-500 md:block">

                <div class="flex justify-between items-center mb-8">
                    <button type="button" id="prevMonth" class="month-btn">‹</button>
                    <h3 id="currentMonth" class="text-xl font-semibold"></h3>
                    <button type="button" id="nextMonth" class="month-btn">›</button>
                </div>

                <div id="daysHeader"
                    class="grid grid-cols-7 text-center text-sm font-medium mb-4">
                </div>

                <div id="calendarGrid"
                    class="grid grid-cols-7 gap-4 text-center">
                </div>

            </div>

            {{-- RIGHT SIDE FORM --}}
            <div class="form-side p-12">

                <div id="selectedDateDisplay"
                    class="text-lg font-semibold mb-6">
                </div>

                <div id="timeSection" class="hidden mb-8">

                    <h4 class="font-semibold mb-4">
                        {{ __('booking.select_time') }}
                    </h4>

                    <div id="dynamicSchedules"
                        class="grid grid-cols-2 gap-4 transition-all duration-500 ease-in-out">
                    </div>

                    <button type="button"
                        id="toggleSchedules"
                        class="text-sm text-green-600 mt-3 hidden">
                        {{ __('booking.view_more') }}
                    </button>

                </div>

                {{-- ================= FORM ================= --}}
                <form method="POST"
                    action="{{ route('booking.store') }}"
                    class="space-y-6">

                    @csrf

                    <input type="hidden" name="tour_id" value="{{ $tour->id }}">

                    <div>
                        <label class="booking-label">
                            {{ __('booking.name') }}
                        </label>
                        <input type="text"
                            name="name"
                            required
                            class="booking-input w-full">
                    </div>

                    <div>
                        <label class="booking-label">
                            {{ __('booking.email') }}
                        </label>
                        <input type="email"
                            name="email"
                            required
                            class="booking-input w-full">
                    </div>

                    <div>
                        <label class="booking-label">
                            {{ __('booking.phone') }}
                        </label>
                        <input type="tel"
                            name="phone"
                            id="phoneInput"
                            required
                            class="booking-input w-full">
                    </div>

                    <div id="dynamicPriceOptions" class="space-y-4"></div>

                    <div>
                        <label class="booking-label">
                            {{ __('booking.nationality') }}
                        </label>
                        <input type="text"
                            name="nationality"
                            id="nationalityInput"
                            required
                            class="booking-input w-full">
                    </div>

                    <div class="booking-total">
                        <span>Total:</span>
                        <span id="totalPrice">
                            ${{ number_format($tour->prices->first()->price ?? 0, 2) }}
                        </span>
                    </div>

                    <input type="hidden" name="date" id="hiddenDate">
                    <input type="hidden" name="time" id="hiddenTime">
                    <input type="hidden" name="total" id="hiddenTotal">

                    <button type="submit"
                        class="booking-confirm w-full">
                        {{ __('booking.confirm') }}
                    </button>

                </form>
                {{-- ================= END FORM ================= --}}

            </div>
        </div>
    </div>
</div>
