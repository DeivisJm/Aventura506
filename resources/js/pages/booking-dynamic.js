document.addEventListener('DOMContentLoaded', () => {

    if (!window.tourData) return;

    const pricesContainer = document.querySelector('.booking-prices');
    const timeSection = document.querySelector('#timeSection .grid');
    const basePriceEl = document.getElementById('basePrice');
    const personsInput = document.getElementById('personsInput');
    const totalPriceEl = document.getElementById('totalPrice');
    const hiddenTotal = document.getElementById('hiddenTotal');

    let selectedBasePrice = 0;

    /* ===============================
       LOAD PRICES (ADAPTADO)
    =============================== */

    if (window.tourData.prices.length) {

        pricesContainer.innerHTML = "";

        window.tourData.prices.forEach((price, index) => {

            const div = document.createElement('div');
            div.className = "flex justify-between items-center border-b pb-2 cursor-pointer booking-price-option";

            const label = price.is_free
                ? `${price.type} (${price.age_range}) - Gratis`
                : `${price.type} (${price.age_range})`;

            const priceText = price.is_free
                ? "Gratis"
                : "$" + parseFloat(price.price).toFixed(2);

            div.innerHTML = `
                <span>${label}</span>
                <span class="font-semibold">${priceText}</span>
            `;

            div.addEventListener('click', () => {

                document.querySelectorAll('.booking-price-option')
                    .forEach(el => el.classList.remove('active'));

                div.classList.add('active');

                selectedBasePrice = price.is_free ? 0 : parseFloat(price.price);
                basePriceEl.textContent = priceText;

                updateTotal();
            });

            pricesContainer.appendChild(div);

            if (index === 0) {
                div.click();
            }

        });
    }

    /* ===============================
       LOAD SCHEDULES (ADAPTADO)
    =============================== */

    if (window.tourData.schedules.length) {

        timeSection.innerHTML = "";

        window.tourData.schedules.forEach(schedule => {

            const btn = document.createElement('button');
            btn.type = "button";
            btn.dataset.time = schedule.start_time;
            btn.className = "booking-time";
            btn.textContent = schedule.start_time;

            btn.addEventListener('click', () => {

                document.querySelectorAll('.booking-time')
                    .forEach(b => b.classList.remove('active'));

                btn.classList.add('active');

                document.getElementById('hiddenTime').value = schedule.start_time;
            });

            timeSection.appendChild(btn);
        });
    }

    /* ===============================
       TOTAL CALCULATION
    =============================== */

    function updateTotal() {

        const persons = Math.max(1, parseInt(personsInput.value) || 1);
        const total = persons * selectedBasePrice;

        totalPriceEl.textContent = "$" + total.toFixed(2);
        hiddenTotal.value = total.toFixed(2);
    }

    personsInput?.addEventListener('input', updateTotal);

});

document.addEventListener('DOMContentLoaded', function () {

    const dataContainer = document.getElementById('tourDynamicData');
    if (!dataContainer) return;

    const prices = JSON.parse(dataContainer.dataset.prices || '[]');
    const schedules = JSON.parse(dataContainer.dataset.schedules || '[]');

    const priceContainer = document.getElementById('dynamicPriceOptions');
    const scheduleContainer = document.getElementById('dynamicSchedules');
    const toggleSchedules = document.getElementById('toggleSchedules');
    const totalPriceEl = document.getElementById('totalPrice');
    const hiddenTotal = document.getElementById('hiddenTotal');

    let total = 0;

    /* ===============================
       PRICE RENDER
    =============================== */

    prices.forEach(price => {

        const wrapper = document.createElement('div');
        wrapper.className = "grid grid-cols-3 items-center border-b pb-4 gap-4";

        wrapper.innerHTML = `
    <div>
        <div class="font-medium">${price.type}</div>
        <div class="text-xs text-gray-500">${price.age_range ?? ''}</div>
    </div>

    <div class="flex items-center gap-3">
        <div class="flex items-center gap-3">
    <button type="button"
        class="qty-btn w-8 h-8 rounded-md
        bg-gray-200 text-gray-800
        hover:bg-gray-300
        dark:bg-gray-700 dark:text-white
        dark:hover:bg-gray-600
        transition"
        data-action="minus">-</button>

    <span class="qty-value w-6 text-center font-medium text-gray-900 dark:text-white">0</span>

    <button type="button"
        class="qty-btn w-8 h-8 rounded-md
        bg-gray-200 text-gray-800
        hover:bg-gray-300
        dark:bg-gray-700 dark:text-white
        dark:hover:bg-gray-600
        transition"
        data-action="plus">+</button>
</div>

    </div>

   <div class="text-right font-semibold text-gray-900 dark:text-white">
        ${price.is_free ? 'Free' : '$' + parseFloat(price.price).toFixed(2)}
   </div>
`;


        const qtyValue = wrapper.querySelector('.qty-value');

        wrapper.querySelectorAll('.qty-btn').forEach(btn => {

            btn.addEventListener('click', () => {

                let currentQty = parseInt(qtyValue.textContent);

                if (btn.dataset.action === 'plus') {
                    currentQty++;
                }

                if (btn.dataset.action === 'minus' && currentQty > 0) {
                    currentQty--;
                }

                qtyValue.textContent = currentQty;

                recalcTotal();
            });
        });

        priceContainer.appendChild(wrapper);
    });

    function recalcTotal() {

        total = 0;

        const rows = priceContainer.children;

        Array.from(rows).forEach((row, index) => {

            const qty = parseInt(row.querySelector('.qty-value').textContent);
            const price = prices[index];

            if (!price.is_free) {
                total += qty * parseFloat(price.price);
            }
        });

        totalPriceEl.textContent = "$" + total.toFixed(2);
        hiddenTotal.value = total;
    }

    /* ===============================
   SCHEDULE RENDER
=============================== */

    let showAll = false;

    function validateDynamicTimes() {

        if (!window.selectedDate) return;

        const now = new Date();
        const buttons = document.querySelectorAll('.booking-time');

        buttons.forEach(btn => {

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
                btn.classList.add('time-disabled');
            } else {
                btn.disabled = false;
                btn.classList.remove('time-disabled');
            }

        });
    }


    function renderSchedules() {

        scheduleContainer.innerHTML = "";

        const visibleSchedules = showAll ? schedules : schedules.slice(0, 6);

        visibleSchedules.forEach(schedule => {

            const btn = document.createElement('button');
            btn.type = "button";
            btn.className = "booking-time transition-all duration-300 ease-in-out";
            btn.dataset.time = schedule.start_time;
            btn.textContent = schedule.start_time;

            scheduleContainer.appendChild(btn);
        });

        if (schedules.length > 6) {
            toggleSchedules.classList.remove('hidden');
        }
        validateDynamicTimes();

    }


    toggleSchedules?.addEventListener('click', () => {
        showAll = !showAll;
        renderSchedules();
    });

    renderSchedules();


});

/* ===============================
   MOBILE CALENDAR COLLAPSE
=============================== */

document.addEventListener('click', function (e) {

    if (e.target.classList.contains('calendar-day')) {

        if (window.innerWidth < 768) {

            const calendarSide = document.querySelector('.calendar-side');

            calendarSide.style.transition = "all 0.4s ease";
            calendarSide.style.maxHeight = "0px";
            calendarSide.style.overflow = "hidden";
            calendarSide.style.opacity = "0";

            setTimeout(() => {
                calendarSide.style.display = "none";
            }, 400);
        }

    }

});
