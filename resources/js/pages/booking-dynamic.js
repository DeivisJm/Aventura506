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

    //total price global variable
    let total = 0;
    totalPriceEl.textContent = "$0.00";
    hiddenTotal.value = 0;


    /// ===============================
    // PRICE RENDERING & CALCULATION
    // ===============================
    function renderPrices() {

        priceContainer.innerHTML = "";

        /* ================= ORDER BY TYPE ================= */
        prices.sort((a, b) => {

            const order = {
                'adult': 1,
                'adult_national': 1,
                'adult_international': 1,

                'child': 2,
                'child_national': 2,
                'child_international': 2,

                'young_child': 3,
                'young_child_national': 3,
                'young_child_international': 3,

                'senior_national': 4,
                'senior_international': 4
            };

            return (order[a.type_key] || 99) - (order[b.type_key] || 99);
        });

        /* ================= GROUP BY MARKET ================= */
        const grouped = prices.reduce((acc, price) => {

            const market = price.category_type || 'general';

            if (!acc[market]) acc[market] = [];
            acc[market].push(price);

            return acc;

        }, {});

        const markets = Object.keys(grouped);

        // 🔥 Solo mostrar títulos si existen realmente dos mercados distintos
        const showMarketTitles =
            markets.includes('national') && markets.includes('international');

        markets.forEach(market => {

            /* ================= MARKET TITLE ================= */
            if (showMarketTitles) {

                const title = document.createElement('h4');
                title.className = "text-md font-semibold mt-6 mb-3";

                title.textContent =
                    market === 'national'
                        ? window.marketTranslations.national
                        : window.marketTranslations.international;

                priceContainer.appendChild(title);
            }

            /* ================= PRICE ITEMS ================= */
            grouped[market].forEach(price => {

                const wrapper = document.createElement('div');
                wrapper.className = "grid grid-cols-3 items-center border-b pb-4 gap-4";

                const currencySymbol = price.currency === 'CRC' ? '₡' : '$';

                /* ================= AGE RANGE ================= */
                let ageRange = "";

                if (price.min_age !== null && price.max_age !== null) {
                    ageRange = `<div class="text-xs text-gray-500">${price.min_age} - ${price.max_age}</div>`;
                } else if (price.min_age !== null) {
                    ageRange = `<div class="text-xs text-gray-500">${price.min_age}+</div>`;
                }

                wrapper.innerHTML = `
                <div>
                    <div class="font-medium">${price.type}</div>
                    ${ageRange}
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" class="qty-btn" data-action="minus">-</button>
                    <span class="qty-value">0</span>
                    <button type="button" class="qty-btn" data-action="plus">+</button>

                    <input type="hidden"
                        name="prices[${price.id}]"
                        value="0"
                        class="price-input">
                </div>

                <div class="text-right font-semibold">
                    ${price.is_free
                        ? window.freeText
                        : currencySymbol + parseFloat(price.price).toFixed(2)
                    }
                </div>
            `;

                const qtyValue = wrapper.querySelector('.qty-value');
                const hiddenInput = wrapper.querySelector('.price-input');

                wrapper.querySelectorAll('.qty-btn').forEach(btn => {

                    btn.addEventListener('click', () => {

                        let currentQty = parseInt(qtyValue.textContent);

                        if (btn.dataset.action === 'plus') currentQty++;
                        if (btn.dataset.action === 'minus' && currentQty > 0) currentQty--;

                        qtyValue.textContent = currentQty;
                        hiddenInput.value = currentQty;

                        recalcTotal();
                    });
                });

                priceContainer.appendChild(wrapper);
            });
        });

        recalcTotal();
    }


    function recalcTotal() {

        total = 0;

        const inputs = document.querySelectorAll('.price-input');

        inputs.forEach(input => {

            const qty = parseInt(input.value);
            const priceObj = prices.find(p => p.id == input.name.match(/\d+/)[0]);

            if (priceObj && !priceObj.is_free) {
                total += qty * parseFloat(priceObj.price);
            }
        });

        totalPriceEl.textContent = "$" + total.toFixed(2);
        hiddenTotal.value = total.toFixed(2);
    }

    /* ===============================
       SCHEDULE RENDER
    =============================== */

    let showAll = false;

    function renderSchedules() {

        scheduleContainer.innerHTML = "";

        const visibleSchedules = showAll ? schedules : schedules.slice(0, 6);

        visibleSchedules.forEach(schedule => {

            const btn = document.createElement('button');
            btn.type = "button";
            btn.className = "booking-time transition-all duration-300 ease-in-out";
            btn.dataset.time = schedule.start_time;
            btn.textContent = schedule.start_time;

            btn.addEventListener('click', () => {

                if (btn.disabled) return; // 🔥 evita seleccionar horas inválidas

                document.querySelectorAll('.booking-time')
                    .forEach(b => b.classList.remove('active'));

                btn.classList.add('active');

                document.getElementById('hiddenTime').value = schedule.start_time;
            });

            scheduleContainer.appendChild(btn);
        });

        if (schedules.length > 6) {
            toggleSchedules?.classList.remove('hidden');
        }

        /* 🔥 IMPORTANTE: revalidar horarios después de re-render */
        if (typeof window.validateTimes === "function") {
            window.validateTimes();
        }
    }

    toggleSchedules?.addEventListener('click', () => {

        showAll = !showAll;

        toggleSchedules.textContent = showAll
            ? window.translations.viewLess
            : window.translations.viewMore;

        renderSchedules();
    });

    renderSchedules();

    /* ===============================
       PRECIO SEGUN NACIONALIDAD
    =============================== */
    const nationalityInput = document.getElementById('nationalityInput');

    if (nationalityInput) {

        nationalityInput.addEventListener('change', function () {

            const selectedCountry = this.value.toLowerCase();

            if (selectedCountry.includes('costa rica') || selectedCountry.includes('costarric')) {
                currentMarket = 'national';
            } else {
                currentMarket = 'international';
            }

            renderPrices();
        });
    }

    renderPrices();
});


/* ===============================
   MOBILE CALENDAR COLLAPSE
=============================== */

document.addEventListener('click', function (e) {

    if (e.target.classList.contains('calendar-day')) {

        if (window.innerWidth < 768) {

            const calendarSide = document.querySelector('.calendar-side');
            if (!calendarSide) return;

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

/* ===============================
   NATIONALITY PRE-MODAL (MULTILANG)
=============================== */
let selectedMarket = 'international';

const nationalityModal = document.getElementById('nationalityModal');
const openNationalityBtn = document.getElementById('openNationality');
const bookingModal = document.getElementById('bookingModal');
const nationalityInputField = document.getElementById('nationalityInput');
const phoneInputField = document.getElementById('phoneInput');

if (openNationalityBtn && nationalityModal) {

    openNationalityBtn.addEventListener('click', () => {
        nationalityModal.classList.remove('hidden');
    });

    document.querySelectorAll('.nationality-option').forEach(btn => {

        btn.addEventListener('click', () => {

            selectedMarket = btn.dataset.market;
            currentMarket = selectedMarket;

            if (nationalityInputField) {
                nationalityInputField.value = btn.dataset.country;
            }

            if (phoneInputField && btn.dataset.code) {
                phoneInputField.value = btn.dataset.code + " ";
            }

            nationalityModal.classList.add('hidden');
            bookingModal.classList.remove('hidden');

            renderPrices();
        });
    });
}
