document.addEventListener('DOMContentLoaded', () => {

    /* ================= LOCALE ================= */
    const locale = window.appLocale === 'es' ? 'es-CR' : 'en-US';

    /* ================= ELEMENTS ================= */
    const modal = document.getElementById('bookingModal');
    const openBtn = document.getElementById('openBooking');
    const closeBtn = document.getElementById('closeBooking');

    const calendarGrid = document.getElementById('calendarGrid');
    const currentMonthEl = document.getElementById('currentMonth');
    const daysHeader = document.getElementById('daysHeader');

    const personsInput = document.getElementById('personsInput');
    const totalPrice = document.getElementById('totalPrice');
    const hiddenTotal = document.getElementById('hiddenTotal');

    const timeSection = document.getElementById('timeSection');
    const selectedDateDisplay = document.getElementById('selectedDateDisplay');
    const form = document.querySelector('#bookingModal form');

    const hiddenDate = document.getElementById('hiddenDate');
    const hiddenTime = document.getElementById('hiddenTime');

    const basePrice = parseFloat(
        document.getElementById('basePrice')?.textContent.replace('$', '')
    ) || 30;

    /* ================= INITIAL TOTAL ================= */
    if (personsInput && hiddenTotal) {
        const initialPersons = parseInt(personsInput.value) || 0;
        const initialTotal = initialPersons * basePrice;
        totalPrice.textContent = "$" + initialTotal;
        hiddenTotal.value = initialTotal;
    }

    /* ================= MODAL ================= */
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
        if (e.target.classList.contains('booking-overlay')) {
            closeModal();
        }
    });

    /* ================= NAME ONLY LETTERS ================= */
    const nameInput = document.querySelector('input[name="name"]');
    nameInput?.addEventListener('input', () => {
        nameInput.value = nameInput.value.replace(/[^a-zA-ZÀ-ÿ\s]/g, '');
    });

    /* ================= CALENDAR ================= */
    const now = new Date();
    const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    let currentMonth = new Date(now.getFullYear(), now.getMonth(), 1);
    window.selectedDate = null;

    function renderDaysHeader() {
        daysHeader.innerHTML = "";
        const baseDate = new Date(2023, 0, 1);

        for (let i = 0; i < 7; i++) {
            const date = new Date(baseDate);
            date.setDate(baseDate.getDate() + i);
            const span = document.createElement('span');
            span.textContent = date.toLocaleDateString(locale, { weekday: 'short' });
            daysHeader.appendChild(span);
        }
    }

    function renderCalendar() {

        calendarGrid.innerHTML = "";

        currentMonthEl.textContent =
            currentMonth.toLocaleString(locale, {
                month: 'long',
                year: 'numeric'
            }).replace(/^./, c => c.toUpperCase());

        const year = currentMonth.getFullYear();
        const month = currentMonth.getMonth();
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        for (let i = 0; i < firstDay; i++) {
            calendarGrid.appendChild(document.createElement('div'));
        }

        for (let day = 1; day <= daysInMonth; day++) {

            const date = new Date(year, month, day);
            const btn = document.createElement('button');
            btn.textContent = day;

            if (date < today) {
                btn.disabled = true;
                btn.style.opacity = 0.3;
            }

            btn.addEventListener('click', () => {

                window.selectedDate = date;

                hiddenDate.value =
                    `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;

                document.querySelectorAll('#calendarGrid button')
                    .forEach(b => b.classList.remove('active'));

                btn.classList.add('active');

                selectedDateDisplay.textContent =
                    date.toLocaleDateString(locale, {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    }).replace(/^./, c => c.toUpperCase());

                timeSection.classList.remove('hidden');

                validateTimes();
                clearError('dateError');
            });

            calendarGrid.appendChild(btn);
        }
    }

    renderDaysHeader();
    renderCalendar();

    /* ================= MONTH NAVIGATION ================= */
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');

    prevMonthBtn?.addEventListener('click', () => {
        currentMonth.setMonth(currentMonth.getMonth() - 1);
        renderCalendar();
    });

    nextMonthBtn?.addEventListener('click', () => {
        currentMonth.setMonth(currentMonth.getMonth() + 1);
        renderCalendar();
    });

    /* ================= TIME VALIDATION ================= */
    function validateTimes() {

        if (!window.selectedDate) return;

        const now = new Date();
        const timeButtons = document.querySelectorAll('.booking-time');

        timeButtons.forEach(btn => {

            const [h, m] = btn.dataset.time.split(':').map(Number);
            const selectedDateTime = new Date(window.selectedDate);
            selectedDateTime.setHours(h, m, 0, 0);

            const isToday =
                window.selectedDate.getFullYear() === now.getFullYear() &&
                window.selectedDate.getMonth() === now.getMonth() &&
                window.selectedDate.getDate() === now.getDate();

            if (isToday && selectedDateTime <= now) {
                btn.disabled = true;
                btn.classList.remove('active');
                btn.classList.add('time-disabled');
            } else {
                btn.disabled = false;
                btn.classList.remove('time-disabled');
            }
        });
    }

    /* ================= TIME SELECT ================= */
    document.addEventListener('click', function (e) {

        if (!e.target.classList.contains('booking-time')) return;

        const btn = e.target;
        if (!window.selectedDate || btn.disabled) return;

        document.querySelectorAll('.booking-time')
            .forEach(b => b.classList.remove('active'));

        btn.classList.add('active');

        hiddenTime.value = btn.dataset.time;
        clearError('timeError');
    });

    /* ================= PRICE ================= */
    personsInput?.addEventListener('input', () => {

        let persons = Math.max(0, parseInt(personsInput.value) || 0);
        personsInput.value = persons;

        const total = persons * basePrice;
        totalPrice.textContent = "$" + total;
        hiddenTotal.value = total;

        clearError('personsError');
    });

    /* ================= PHONE ================= */
    const phoneInput = document.querySelector("#phoneInput");
    let iti = null;

    if (phoneInput) {
        iti = window.intlTelInput(phoneInput, {
            initialCountry: window.appLocale === 'es' ? "cr" : "us",
            preferredCountries: ["cr", "us", "ca"],
            separateDialCode: true,
            nationalMode: false,
            autoPlaceholder: "aggressive",
            utilsScript:
                "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.12/build/js/utils.js"
        });

        phoneInput.addEventListener('input', () => {
            phoneInput.value = phoneInput.value.replace(/[^0-9]/g, '');
        });
    }

    /* ================= NATIONALITY WITH FLAG ================= */
    const nationalityInput = document.querySelector("#nationalityInput");

    if (nationalityInput && typeof $.fn.countrySelect !== "undefined") {
        $(nationalityInput).countrySelect({
            defaultCountry: window.appLocale === 'es' ? "cr" : "us",
            preferredCountries: ["cr", "us", "ca"],
            responsiveDropdown: true
        });
    }

    /* ================= AUTO CLEAR ================= */
    form?.querySelectorAll('.booking-input').forEach(input => {
        input.addEventListener('input', () => {
            input.classList.remove('error');
            const errorDiv = input.nextElementSibling;
            if (errorDiv) {
                errorDiv.textContent = "";
                errorDiv.classList.add('hidden');
            }
        });
    });

    function clearError(id) {
        const el = document.getElementById(id);
        if (el) {
            el.textContent = "";
            el.classList.add('hidden');
        }
    }

    form?.addEventListener('submit', function (e) {

        e.preventDefault(); // 🔥 SIEMPRE bloquea primero

        let hasError = false;
        let firstError = null;

        const dateError = document.getElementById('dateError');
        const timeError = document.getElementById('timeError');
        const personsError = document.getElementById('personsError');

        // Limpiar errores previos
        document.querySelectorAll('.error-message').forEach(el => {
            el.textContent = "";
            el.classList.add('hidden');
        });

        form.querySelectorAll('.booking-input').forEach(input => {
            input.classList.remove('error');
        });

        /* ========= VALIDAR FECHA ========= */
        if (!hiddenDate.value) {
            hasError = true;
            if (!firstError) firstError = selectedDateDisplay;

            dateError.textContent = window.appLocale === 'es'
                ? "Debes seleccionar una fecha."
                : "You must select a date.";

            dateError.classList.remove('hidden');
        }

        /* ========= VALIDAR HORA ========= */
        if (!hiddenTime.value) {
            hasError = true;
            if (!firstError) firstError = timeSection;

            timeError.textContent = window.appLocale === 'es'
                ? "Debes seleccionar un horario."
                : "You must select a time.";

            timeError.classList.remove('hidden');
        }

        /* ========= VALIDAR PERSONAS ========= */
        if (parseFloat(hiddenTotal.value || 0) <= 0) {
            hasError = true;
            if (!firstError) firstError = document.getElementById('dynamicPriceOptions');

            personsError.textContent = window.appLocale === 'es'
                ? "Debes seleccionar al menos una persona."
                : "You must select at least one person.";

            personsError.classList.remove('hidden');
        }

        /* ========= VALIDAR CAMPOS ========= */
        const requiredFields = ['name', 'email', 'phone', 'nationality'];

        requiredFields.forEach(fieldName => {

            const input = form.querySelector(`[name="${fieldName}"]`);

            if (!input || !input.value.trim()) {

                hasError = true;
                if (!firstError) firstError = input;

                input.classList.add('error');

                const errorDiv = input.nextElementSibling;

                if (errorDiv) {
                    errorDiv.textContent = window.appLocale === 'es'
                        ? "Este campo es obligatorio."
                        : "This field is required.";

                    errorDiv.classList.remove('hidden');
                }
            }
        });

        /* ========= SI HAY ERROR → SCROLL ========= */
        if (hasError) {

            const scrollContainer =
                document.querySelector('.form-side') ||
                document.querySelector('.booking-container');

            if (firstError && scrollContainer) {

                const containerRect = scrollContainer.getBoundingClientRect();
                const errorRect = firstError.getBoundingClientRect();

                const offset =
                    errorRect.top
                    - containerRect.top
                    + scrollContainer.scrollTop
                    - 120; // espacio superior visual

                scrollContainer.scrollTo({
                    top: offset,
                    behavior: 'smooth'
                });

                setTimeout(() => {
                    firstError.focus({ preventScroll: true });
                }, 400);
            }

            return; // NO ENVÍA
        }

        // SOLO AQUÍ SE ENVÍA
        form.submit();
    });
});