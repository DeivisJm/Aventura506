/* =====================================================
ADMIN TOUR EDIT SCRIPT
Handles dynamic creation of prices and schedules
Compatible with tour-form.css component system
===================================================== */

document.addEventListener("DOMContentLoaded", () => {

    /* =============================================
    INITIAL INDEX CALCULATION
    Detect cards loaded from database
    ============================================= */

    let priceIndex = document.querySelectorAll("#prices-container .form-card").length;
    let scheduleIndex = document.querySelectorAll("#schedules-container .form-card").length;



    /* =============================================
    ADD PRICE CARD
    Creates a new price configuration block
    ============================================= */
    window.addPrice = function () {

        const container = document.getElementById("prices-container");
        if (!container) return;

        const number = priceIndex + 1;

        const html = `
        <div class="form-card price-block new-price">

            <div class="form-card-header">

                <h3 class="form-card-title">
                    Tipo de precio #${number}
                </h3>

                <button type="button" class="form-delete remove-price">
                    Eliminar
                </button>

            </div>


            <div class="form-grid">

                <div class="form-field">

                    <label class="form-label">
                        Nombre del tipo (Español)
                    </label>

                    <input
                        type="text"
                        name="prices[${priceIndex}][type][es]"
                        class="form-input"
                        placeholder="Ej: Adultos nacionales"
                        required>

                    <p class="form-help">
                        Nombre que se mostrará en la página del tour.
                    </p>

                </div>


                <div class="form-field">

                    <label class="form-label">
                        Name (English)
                    </label>

                    <input
                        type="text"
                        name="prices[${priceIndex}][type][en]"
                        class="form-input"
                        placeholder="Example: Adults"
                        required>

                </div>

            </div>


            <div class="form-grid">

                <div class="form-field">

                    <label class="form-label">
                        Tipo de visitante
                    </label>

                    <select
                        name="prices[${priceIndex}][category_type]"
                        class="form-input"
                        required>

                        <option value="international">
                            Internacional
                        </option>

                        <option value="national">
                            Nacional (Costa Rica)
                        </option>

                    </select>

                </div>


                <div class="form-field">

                    <label class="form-label">
                        Precio por persona
                    </label>

                    <div class="form-money">

                        <span>$</span>

                        <input
                            type="number"
                            step="0.01"
                            name="prices[${priceIndex}][price]"
                            class="form-input"
                            placeholder="Ej: 55.00"
                            required>

                    </div>

                </div>

            </div>


            <div class="form-grid">

                <div class="form-field">

                    <label class="form-label">
                        Edad mínima
                    </label>

                    <input
                        type="number"
                        name="prices[${priceIndex}][min_age]"
                        class="form-input"
                        required>

                </div>


                <div class="form-field">

                    <label class="form-label">
                        Edad máxima
                    </label>

                    <input
                        type="number"
                        name="prices[${priceIndex}][max_age]"
                        class="form-input"
                        required>

                    <p class="form-help">
                        Déjalo vacío si no hay límite.
                    </p>

                </div>

            </div>

        </div>
        `;

        container.insertAdjacentHTML("beforeend", html);


        /* smooth scroll to new card */

        setTimeout(() => {

            const card = container.lastElementChild;

            if (card) {
                card.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });
            }

        }, 120);

        priceIndex++;
    };


    /* =============================================
    ADD SCHEDULE CARD
    Creates new schedule configuration block
    ============================================= */
    window.addSchedule = function () {

        const container = document.getElementById("schedules-container");
        if (!container) return;

        const number = scheduleIndex + 1;

        const html = `
        <div class="form-card schedule-block new-schedule">

            <div class="form-card-header">

                <h3 class="form-card-title">
                    Horario #${number}
                </h3>

                <button type="button" class="form-delete remove-schedule">
                    Eliminar
                </button>

            </div>


            <div class="form-grid">

                <div class="form-field">

                    <label class="form-label">
                        Hora de inicio
                    </label>

                    <input
                        type="time"
                        name="schedules[${scheduleIndex}][start_time]"
                        class="form-input"
                        required>

                    <p class="form-help">
                        Hora en la que inicia el tour.
                    </p>

                </div>


                <div class="form-field">

                    <label class="form-label">
                        Estado
                    </label>

                    <div class="schedule-status">

                        <label class="schedule-toggle">

                            <input
                                type="checkbox"
                                name="schedules[${scheduleIndex}][active]"
                                value="1"
                                checked
                                required>

                            <span class="schedule-slider"></span>

                        </label>

                        <span class="schedule-status-text active">
                            Activo
                        </span>

                    </div>

                </div>

            </div>

        </div>
        `;

        container.insertAdjacentHTML("beforeend", html);


        /* smooth scroll to new schedule */

        setTimeout(() => {

            const card = container.lastElementChild;

            if (card) {
                card.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });
            }

        }, 120);

        scheduleIndex++;
    };



    /* =============================================
    REMOVE ITEMS
    Uses event delegation for dynamic elements
    ============================================= */

    document.addEventListener("click", (e) => {

        if (e.target.classList.contains("remove-price")) {

            const block = e.target.closest(".price-block");
            if (block) block.remove();

        }

        if (e.target.classList.contains("remove-schedule")) {

            const block = e.target.closest(".schedule-block");
            if (block) block.remove();

        }

    });

    /* TOAST NOTIFICATION SYSTEM */
    const panels = document.querySelectorAll(".toast-panel");

    panels.forEach(panel => {

        setTimeout(() => {
            panel.classList.remove("translate-x-full");
        }, 120);

        setTimeout(() => {
            panel.classList.add("translate-x-full");
        }, 5000);

    });

});

/* IMAGE PREVIEW */
document.addEventListener("DOMContentLoaded", () => {

    const input = document.getElementById("tour-image-input");
    const preview = document.getElementById("tour-image-preview");

    if (!input || !preview) return;

    input.addEventListener("change", function () {

        const file = this.files[0];

        if (!file) return;

        const reader = new FileReader();

        reader.onload = function (e) {

            preview.src = e.target.result;

        };

        reader.readAsDataURL(file);

    });

});
// COMPANY INFO UPDATE ON SELECT
document.addEventListener('DOMContentLoaded', function () {

    const select = document.getElementById('company_select');
    const emailField = document.getElementById('company_email');
    const phoneField = document.getElementById('company_phone');

    if (!select || !emailField || !phoneField) return;

    function updateCompanyInfo() {
        const selectedOption = select.options[select.selectedIndex];

        const email = selectedOption.getAttribute('data-email') || 'No registrado';
        const phone = selectedOption.getAttribute('data-phone') || 'No registrado';

        emailField.value = email !== '' ? email : 'No registrado';
        phoneField.value = phone !== '' ? phone : 'No registrado';
    }

    select.addEventListener('change', updateCompanyInfo);

});

