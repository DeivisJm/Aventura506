<div id="bookingModal" class="booking-overlay">

    <div class="booking-container
                w-full max-w-7xl
                rounded-xl shadow-2xl
                max-h-[95vh]
                flex flex-col
                overflow-hidden">

        {{-- ================= HEADER ================= --}}
        <div class="booking-header
                    flex justify-between items-center
                    px-6 md:px-12
                    py-4 md:py-6
                    border-b">

            <div>
                <h2 class="text-xl md:text-2xl font-semibold">
                    {{ __('booking.title_tour') }}
                </h2>

                <div class="booking-prices mt-4 md:mt-6 space-y-2"></div>
            </div>

            <button type="button"
                id="closeBooking"
                class="booking-close text-2xl md:text-3xl">
                ✕
            </button>
        </div>

        {{-- ================= CONTENT ================= --}}
        <div class="booking-content
                    flex-1
                    overflow-y-auto
                    flex flex-col
                    md:grid md:grid-cols-2">

            {{-- ================= LEFT: CALENDAR ================= --}}
            <div class="calendar-side
                        p-6 md:p-12
                        border-b md:border-b-0
                        md:border-r
                        border-gray-200 dark:border-gray-800
                        min-h-[420px]">

                {{-- MONTH HEADER --}}
                <div class="flex justify-between items-center mb-6 px-2">

                    <button type="button"
                        id="prevMonth"
                        class="month-btn px-3 py-1">
                        ‹
                    </button>

                    <h3 id="currentMonth"
                        class="text-lg md:text-xl font-semibold text-center flex-1">
                    </h3>

                    <button type="button"
                        id="nextMonth"
                        class="month-btn px-3 py-1">
                        ›
                    </button>
                </div>

                {{-- DAYS HEADER --}}
                <div id="daysHeader"
                    class="grid grid-cols-7 text-center text-xs md:text-sm font-medium mb-3">
                </div>

                {{-- CALENDAR GRID --}}
                <div id="calendarGrid"
                    class="grid grid-cols-7 gap-2 md:gap-4 text-center">
                </div>

            </div>

            {{-- ================= RIGHT: FORM ================= --}}
            <div class="form-side p-6 md:p-12">

                <div id="selectedDateDisplay"
                    class="text-base md:text-lg font-semibold mb-2">
                </div>

                <div id="dateError"
                    class="error-message hidden mb-4"></div>

                {{-- TIME SECTION --}}
                <div id="timeSection" class="hidden mb-8">

                    <h4 class="font-semibold mb-4">
                        {{ __('booking.select_time') }}
                    </h4>

                    <div id="dynamicSchedules"
                        class="grid grid-cols-2 gap-3 md:gap-4">
                    </div>

                    <button type="button"
                        id="toggleSchedules"
                        class="text-sm text-green-600 mt-3 hidden">
                        {{ __('booking.view_more') }}
                    </button>

                    <div id="timeError"
                        class="error-message hidden mt-3"></div>
                </div>

                {{-- ================= FORM ================= --}}
                <form method="POST"
                    action="{{ route('booking.store') }}"
                    class="space-y-6"
                    id="bookingForm"
                    novalidate>

                    @csrf

                    <input type="hidden"
                        name="tour_id"
                        value="{{ $tour->id }}">

                    {{-- NAME --}}
                    <div class="form-group">
                        <label class="booking-label">
                            {{ __('booking.name') }}
                        </label>
                        <input type="text"
                            name="name"
                            class="booking-input w-full"
                            data-required="true">
                        <div class="error-message hidden"></div>
                    </div>

                    {{-- EMAIL --}}
                    <div class="form-group">
                        <label class="booking-label">
                            {{ __('booking.email') }}
                        </label>
                        <input type="email"
                            name="email"
                            class="booking-input w-full"
                            data-required="true">
                        <div class="error-message hidden"></div>
                    </div>

                    {{-- PHONE --}}
                    <div class="form-group">
                        <label class="booking-label">
                            {{ __('booking.phone') }}
                        </label>
                        <input type="tel"
                            name="phone"
                            id="phoneInput"
                            class="booking-input w-full"
                            data-required="true">
                        <div class="error-message hidden"></div>
                    </div>

                    {{-- PERSONS (DYNAMIC) --}}
                    <input type="hidden" name="currency" id="bookingCurrency" value="USD">
                    <div id="dynamicPriceOptions"
                        class="space-y-4"></div>

                    <div id="personsError"
                        class="error-message hidden mt-2"></div>

                    {{-- NATIONALITY --}}
                    <div class="form-group">
                        <label class="booking-label">
                            {{ __('booking.nationality') }}
                        </label>
                        <input type="text"
                            name="nationality"
                            id="nationalityInput"
                            class="booking-input w-full"
                            data-required="true">
                        <div class="error-message hidden"></div>
                    </div>

                    {{-- NOTES --}}
                    <div class="form-group">
                        <label class="booking-label">
                            {{ __('booking.additional_notes') }}
                        </label>
                        <textarea name="notes"
                            rows="3"
                            class="booking-input w-full"></textarea>
                    </div>

                    {{-- TOTAL --}}
                    <div class="booking-total flex justify-between text-lg font-semibold">
                        <span>{{ __('booking.total') ?? 'Total' }}:</span>
                        <span id="totalPrice">$0.00</span>
                    </div>

                    {{-- HIDDEN FIELDS --}}
                    <input type="hidden" name="date" id="hiddenDate">
                    <input type="hidden" name="time" id="hiddenTime">
                    <input type="hidden" name="total" id="hiddenTotal">

                    {{-- SUBMIT --}}
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