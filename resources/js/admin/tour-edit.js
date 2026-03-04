document.addEventListener("DOMContentLoaded", () => {

    let priceIndex = document.querySelectorAll('.price-block').length;
    let scheduleIndex = document.querySelectorAll('.schedule-block').length;

    window.addPrice = function () {

        const container = document.getElementById('prices-container');

        const html = `
        <div class="border p-6 rounded-xl space-y-4 price-block">

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label>Type (ES)</label>
                    <input type="text"
                        name="prices[${priceIndex}][type][es]"
                        required
                        class="input-admin">
                </div>

                <div>
                    <label>Type (EN)</label>
                    <input type="text"
                        name="prices[${priceIndex}][type][en]"
                        required
                        class="input-admin">
                </div>
            </div>

            <div>
                <label>Price (USD)</label>
                <input type="number"
                    step="0.01"
                    name="prices[${priceIndex}][price]"
                    required
                    class="input-admin">
            </div>

            <button type="button"
                class="text-red-500 text-sm remove-price">
                Remove
            </button>

        </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
        priceIndex++;
    };

    window.addSchedule = function () {

        const container = document.getElementById('schedules-container');

        const html = `
        <div class="flex gap-4 items-center schedule-block">
            <input type="time"
                name="schedules[${scheduleIndex}][start_time]"
                required
                class="input-admin">

            <button type="button"
                class="text-red-500 text-sm remove-schedule">
                Remove
            </button>
        </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
        scheduleIndex++;
    };

    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("remove-price")) {
            e.target.closest(".price-block").remove();
        }

        if (e.target.classList.contains("remove-schedule")) {
            e.target.closest(".schedule-block").remove();
        }
    });

});

// Toast animation
document.addEventListener('DOMContentLoaded', function () {

    const panels = document.querySelectorAll('.toast-panel');

    panels.forEach(panel => {

        setTimeout(() => {
            panel.classList.remove('translate-x-full');
        }, 100);

        setTimeout(() => {
            panel.classList.add('translate-x-full');
        }, 5000);

    });

    // Add schedule dynamically
    const addBtn = document.getElementById('addScheduleBtn');
    const container = document.getElementById('schedules-container');

    if (addBtn) {
        addBtn.addEventListener('click', function () {

            const index = container.children.length;

            const div = document.createElement('div');
            div.classList.add('flex', 'gap-4', 'items-center', 'schedule-block');

            div.innerHTML = `
                <input type="time"
                    name="schedules[${index}][start_time]"
                    class="saas-input w-40">

                <button type="button"
                    class="text-red-500 hover:text-red-700 remove-schedule">
                    Eliminar
                </button>
            `;

            container.appendChild(div);
        });
    }

    // Remove schedule
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-schedule')) {
            e.target.closest('.schedule-block').remove();
        }
    });

});