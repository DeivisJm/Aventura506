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
                <button type="button" class="qty-btn" data-action="minus">-</button>
                <span class="qty-value">0</span>
                <button type="button" class="qty-btn" data-action="plus">+</button>

                <!-- INPUT REAL QUE SE ENVÍA A LARAVEL -->
                <input type="hidden"
                    name="prices[${price.id}]"
                    value="0"
                    class="price-input">
            </div>

            <div class="text-right font-semibold">
                ${price.is_free ? 'Free' : '$' + parseFloat(price.price).toFixed(2)}
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

                // 🔥 ACTUALIZA EL INPUT QUE LARAVEL RECIBE
                hiddenInput.value = currentQty;

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
