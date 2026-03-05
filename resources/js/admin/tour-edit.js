/* ===================================================== */
/* ADMIN TOUR EDIT SCRIPT */
/* Dynamic prices + schedules */
/* Clean architecture for admin panel */
/* ===================================================== */

document.addEventListener("DOMContentLoaded", () => {

    /* ============================================= */
    /* INITIAL INDEX CALCULATION */
    /* Detect existing blocks loaded from database */
    /* ============================================= */

    let priceIndex = document.querySelectorAll(".price-block").length;
    let scheduleIndex = document.querySelectorAll(".schedule-block").length;


    /* ============================================= */
    /* ADD PRICE BLOCK */
    /* ============================================= */

    window.addPrice = function () {

        const container = document.getElementById("prices-container");

        if (!container) return;

        const html = `
        <div class="price-card price-block">

            <div class="admin-grid">

                <div class="admin-field">
                    <label class="admin-label">Tipo (Español)</label>

                    <input type="text"
                        name="prices[${priceIndex}][type][es]"
                        required
                        class="admin-input">
                </div>

                <div class="admin-field">
                    <label class="admin-label">Tipo (Inglés)</label>

                    <input type="text"
                        name="prices[${priceIndex}][type][en]"
                        required
                        class="admin-input">
                </div>

            </div>


            <div class="admin-field">

                <label class="admin-label">Precio (USD)</label>

                <input type="number"
                    step="0.01"
                    min="0"
                    name="prices[${priceIndex}][price]"
                    required
                    class="admin-input">

            </div>


            <button type="button"
                class="admin-remove remove-price">

                Eliminar precio

            </button>

        </div>
        `;

        container.insertAdjacentHTML("beforeend", html);

        priceIndex++;
    };


    /* ============================================= */
    /* ADD SCHEDULE BLOCK */
    /* ============================================= */

    window.addSchedule = function () {

        const container = document.getElementById("schedules-container");

        if (!container) return;

        const html = `
        <div class="schedule-row schedule-block">

            <input type="time"
                name="schedules[${scheduleIndex}][start_time]"
                required
                class="admin-input w-40">

            <button type="button"
                class="admin-remove remove-schedule">

                Eliminar

            </button>

        </div>
        `;

        container.insertAdjacentHTML("beforeend", html);

        scheduleIndex++;
    };


    /* ============================================= */
    /* REMOVE ITEMS (EVENT DELEGATION) */
    /* Handles dynamically created elements */
    /* ============================================= */

    document.addEventListener("click", (e) => {

        /* Remove price block */

        if (e.target.classList.contains("remove-price")) {

            const block = e.target.closest(".price-block");

            if (block) block.remove();
        }


        /* Remove schedule block */

        if (e.target.classList.contains("remove-schedule")) {

            const block = e.target.closest(".schedule-block");

            if (block) block.remove();
        }

    });


    /* ============================================= */
    /* TOAST NOTIFICATION SYSTEM */
    /* Slide animation for admin alerts */
    /* ============================================= */

    const panels = document.querySelectorAll(".toast-panel");

    panels.forEach(panel => {

        /* show animation */

        setTimeout(() => {

            panel.classList.remove("translate-x-full");

        }, 120);


        /* hide after 5 seconds */

        setTimeout(() => {

            panel.classList.add("translate-x-full");

        }, 5000);

    });

});