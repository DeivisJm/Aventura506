document.addEventListener('DOMContentLoaded', () => {

    /* LOCALE*/
    const locale = window.appLocale === 'es'
        ? 'es-CR'
        : (window.appLocale === 'en' ? 'en-US' : 'en-US');

    /*ELEMENTS*/
    const modal = document.getElementById('bookingModal');
    const openBtn = document.getElementById('openBooking');
    const closeBtn = document.getElementById('closeBooking');

    const calendarGrid = document.getElementById('calendarGrid');
    const currentMonthEl = document.getElementById('currentMonth');
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');
    const daysHeader = document.getElementById('daysHeader');

    const personsInput = document.getElementById('personsInput');
    const totalPrice = document.getElementById('totalPrice');
    const basePrice = parseFloat(
        document.getElementById('basePrice')?.textContent.replace('$', '')
    ) || 30;
    // --------------------------------------------------
    // Initialize total on page load (IMPORTANT FIX)
    // --------------------------------------------------
    if (personsInput) {

        const initialPersons = parseInt(personsInput.value) || 1;
        const initialTotal = initialPersons * basePrice;

        totalPrice.textContent = "$" + initialTotal;

        const hiddenTotal = document.getElementById('hiddenTotal');
        if (hiddenTotal) {
            hiddenTotal.value = initialTotal;
        }
    }

    const timeSection = document.getElementById('timeSection');
    const selectedDateDisplay = document.getElementById('selectedDateDisplay');

    /* =====================================================
       DATE SETUP
    ===================================================== */

    const now = new Date();
    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());

    let currentMonth = new Date(now.getFullYear(), now.getMonth(), 1);
    window.selectedDate = null;
    /* =====================================================
       MODAL OPEN / CLOSE
    ===================================================== */

    openBtn?.addEventListener('click', () => {
        modal.classList.add('active');
        document.body.classList.add('overflow-hidden');
    });

    function closeModal() {
        modal.classList.remove('active');
        document.body.classList.remove('overflow-hidden');
    }

    closeBtn?.addEventListener('click', closeModal);

    modal?.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    /*DAYS HEADER (Localized) */
    function renderDaysHeader() {

        daysHeader.innerHTML = "";

        const baseDate = new Date(2023, 0, 1);

        for (let i = 0; i < 7; i++) {

            const date = new Date(baseDate);
            date.setDate(baseDate.getDate() + i);

            const span = document.createElement('span');

            span.textContent =
                date.toLocaleDateString(locale, { weekday: 'short' });

            daysHeader.appendChild(span);
        }
    }


    /* CALENDAR*/
    function renderCalendar() {

        calendarGrid.innerHTML = "";

        /* ===== Month + Year (Localized & Capitalized) ===== */
        currentMonthEl.textContent =
            currentMonth
                .toLocaleString(locale, {
                    month: 'long',
                    year: 'numeric'
                })
                .replace(/^./, c => c.toUpperCase());

        const year = currentMonth.getFullYear();
        const month = currentMonth.getMonth();

        let firstDay = new Date(year, month, 1).getDay();
        if (firstDay < 0) firstDay = 0;

        const daysInMonth = new Date(year, month + 1, 0).getDate();

        for (let i = 0; i < firstDay; i++) {
            calendarGrid.appendChild(document.createElement('div'));
        }

        for (let day = 1; day <= daysInMonth; day++) {

            const date = new Date(year, month, day);
            const btn = document.createElement('button');
            btn.textContent = day;

            /* Disable past days */
            if (date < today) {
                btn.disabled = true;
                btn.style.opacity = 0.3;
                btn.style.pointerEvents = "none";
            }

            btn.addEventListener('click', () => {

                window.selectedDate = date; // ✅ CORRECTO

                document.querySelectorAll('#calendarGrid button')
                    .forEach(b => b.classList.remove('active'));

                btn.classList.add('active');

                selectedDateDisplay.textContent =
                    window.selectedDate
                        .toLocaleDateString(locale, {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        })
                        .replace(/^./, c => c.toUpperCase());

                timeSection.classList.remove('hidden');
                setTimeout(() => {
                    timeSection.style.opacity = 1;
                }, 50);

                window.validateTimes();
            });

            calendarGrid.appendChild(btn);
        }
    }

    /*BLOCK PREVIOUS MONTHS */
    prevMonthBtn?.addEventListener('click', () => {

        const previousMonth = new Date(currentMonth);
        previousMonth.setMonth(previousMonth.getMonth() - 1);

        if (
            previousMonth.getFullYear() < now.getFullYear() ||
            (
                previousMonth.getFullYear() === now.getFullYear() &&
                previousMonth.getMonth() < now.getMonth()
            )
        ) return;

        currentMonth = previousMonth;
        renderCalendar();
    });

    nextMonthBtn?.addEventListener('click', () => {
        currentMonth.setMonth(currentMonth.getMonth() + 1);
        renderCalendar();
    });

    renderDaysHeader();
    renderCalendar();

    /*TIME VALIDATION*/
    window.validateTimes = function () {

        if (!window.selectedDate) return;

        const now = new Date();
        const timeButtons = document.querySelectorAll('.booking-time');

        timeButtons.forEach(btn => {

            if (!btn.dataset.time) return;

            const [h, m] = btn.dataset.time.split(':').map(Number);

            const selectedDateTime = new Date(window.selectedDate);
            selectedDateTime.setHours(h, m, 0, 0);

            const isToday =
                window.selectedDate.getFullYear() === now.getFullYear() &&
                window.selectedDate.getMonth() === now.getMonth() &&
                window.selectedDate.getDate() === now.getDate();

            if (!isToday) {
                btn.disabled = false;
                btn.classList.remove('time-disabled');
                return;
            }

            if (selectedDateTime <= now) {
                btn.disabled = true;
                btn.classList.remove('active');
                btn.classList.add('time-disabled');
            } else {
                btn.disabled = false;
                btn.classList.remove('time-disabled');
            }
        });
    };

    document.addEventListener('click', function (e) {

        if (!e.target.classList.contains('booking-time')) return;

        const btn = e.target;

        if (!window.selectedDate) return;
        if (btn.disabled) return;

        document.querySelectorAll('.booking-time')
            .forEach(b => b.classList.remove('active'));

        btn.classList.add('active');

        document.getElementById('hiddenTime').value = btn.dataset.time;
        const year = window.selectedDate.getFullYear();
        const month = String(window.selectedDate.getMonth() + 1).padStart(2, '0');
        const day = String(window.selectedDate.getDate()).padStart(2, '0');

        document.getElementById('hiddenDate').value = `${year}-${month}-${day}`;
    });



    /* PRICE CALCULATION*/
    personsInput?.addEventListener('input', () => {

        let persons = Math.max(1, parseInt(personsInput.value) || 1);
        personsInput.value = persons;

        totalPrice.textContent =
            "$" + (persons * basePrice);

        document.getElementById('hiddenTotal').value =
            persons * basePrice;

    });

    /* PHONE INPUT (intl-tel-input) */
    const phoneInput = document.querySelector("#phoneInput");

    if (phoneInput) {

        window.intlTelInput(phoneInput, {
            initialCountry: window.appLocale === 'es' ? "cr" : "us",
            preferredCountries: ["cr", "us", "ca"],
            separateDialCode: true,
            utilsScript:
                "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.12/build/js/utils.js"
        });
    }

    /* ================= NATIONALITY ================= */
    const nationalityInput = document.querySelector("#nationalityInput");

    if (nationalityInput && typeof $.fn.countrySelect !== "undefined") {

        $(nationalityInput).countrySelect({
            defaultCountry: window.appLocale === 'es' ? "cr" : "us",
            preferredCountries: ["cr", "us", "ca"],
            responsiveDropdown: true
        });

    }
});

document.addEventListener('DOMContentLoaded', function () {

    const form = document.querySelector('#bookingModal form');

    if (!form) return;

    form.addEventListener('submit', function (e) {

        const hiddenDate = document.getElementById('hiddenDate');
        const hiddenTime = document.getElementById('hiddenTime');

        if (!hiddenDate.value || !hiddenTime.value) {

            e.preventDefault();
            alert("Please select date and time.");
            return;
        }

    });

});

