document.addEventListener("DOMContentLoaded", () => {

    /* =====================================================
    INITIAL CARD INDEXES
    Count already rendered cards from database records
    ===================================================== */
    let priceIndex = document.querySelectorAll("#prices-container .form-card").length;
    let scheduleIndex = document.querySelectorAll("#schedules-container .form-card").length;

    /* =====================================================
    ADD PRICE CARD
    Create a new dynamic price block
    ===================================================== */
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
                      <p class="form-help">
                                    Ingresa siempre el precio en dólares ($) usando el formato 00.00
                                </p>
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
                        class="form-input">
                </div>

                <div class="form-field">
                    <label class="form-label">
                        Edad máxima
                    </label>

                    <input
                        type="number"
                        name="prices[${priceIndex}][max_age]"
                        class="form-input">

                    <p class="form-help">
                        Déjalo vacío si no hay límite.
                    </p>
                </div>

            </div>

        </div>
        `;

        container.insertAdjacentHTML("beforeend", html);

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

    /* =====================================================
    ADD SCHEDULE CARD
    Create a new dynamic schedule block
    ===================================================== */
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
                                checked>

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

    /* =====================================================
    REMOVE DYNAMIC BLOCKS
    Use event delegation for dynamically injected elements
    ===================================================== */
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

    /* =====================================================
    TOAST NOTIFICATION ANIMATION
    Slide in and slide out notification panels
    ===================================================== */
    const panels = document.querySelectorAll(".toast-panel");

    panels.forEach(panel => {
        setTimeout(() => {
            panel.classList.remove("translate-x-full");
        }, 120);

        setTimeout(() => {
            panel.classList.add("translate-x-full");
        }, 5000);
    });

    /* =====================================================
    IMAGE PREVIEW
    Show selected image before submitting the form
    ===================================================== */
    const imageInput = document.getElementById("tour-image-input");
    const imagePreview = document.getElementById("tour-image-preview");

    if (imageInput && imagePreview) {
        imageInput.addEventListener("change", function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            };

            reader.readAsDataURL(file);
        });
    }

    /* =====================================================
    COMPANY EXTRA INFO
    Fill email and phone based on selected company
    If no data exists, keep the field empty and use placeholder
    ===================================================== */
    const companySelect = document.getElementById("company_select");
    const companyEmailField = document.getElementById("company_email");
    const companyPhoneField = document.getElementById("company_phone");

    function updateCompanyInfo() {
        if (!companySelect || !companyEmailField || !companyPhoneField) return;

        const selectedOption = companySelect.options[companySelect.selectedIndex];
        if (!selectedOption) return;

        const selectedEmail = (selectedOption.getAttribute("data-email") || "").trim();
        const selectedPhone = (selectedOption.getAttribute("data-phone") || "").trim();
        const isNewCompany = companySelect.value === "new";

        /* If the user is creating a new company, keep fields fully editable and blank */
        if (isNewCompany) {
            companyEmailField.value = "";
            companyPhoneField.value = "";
            companyEmailField.placeholder = "Ej: reservas@empresa.com";
            companyPhoneField.placeholder = "Ej: 8888-8888";
            return;
        }

        /* Only auto-fill when there is actual data */
        companyEmailField.value = selectedEmail;
        companyPhoneField.value = selectedPhone;

        /* Use placeholders when the selected company has no saved data */
        companyEmailField.placeholder = selectedEmail ? "" : "Correo de la compañía";
        companyPhoneField.placeholder = selectedPhone ? "" : "Teléfono de la compañía";
    }

    if (companySelect && companyEmailField && companyPhoneField) {
        companySelect.addEventListener("change", updateCompanyInfo);
        updateCompanyInfo();
    }

    /* =====================================================
    NEW CATEGORY TOGGLE
    Show multilingual category inputs only when needed
    ===================================================== */
    const categorySelect = document.getElementById("category_id");
    const newCategoryWrapper = document.getElementById("new-category-wrapper");
    const newCategoryEs = document.getElementById("new_category_es");
    const newCategoryEn = document.getElementById("new_category_en");

    function toggleNewCategoryField() {
        if (!categorySelect || !newCategoryWrapper || !newCategoryEs || !newCategoryEn) return;

        const isNewCategory = categorySelect.value === "new";

        newCategoryWrapper.classList.toggle("hidden", !isNewCategory);

        newCategoryEs.required = isNewCategory;
        newCategoryEn.required = isNewCategory;

        if (!isNewCategory) {
            newCategoryEs.value = "";
            newCategoryEn.value = "";
        }
    }

    if (categorySelect && newCategoryWrapper && newCategoryEs && newCategoryEn) {
        categorySelect.addEventListener("change", toggleNewCategoryField);
        toggleNewCategoryField();
    }

    /* =====================================================
    NEW COMPANY TOGGLE
    Show new company name input only when needed
    ===================================================== */
    const newCompanyWrapper = document.getElementById("new-company-wrapper");
    const newCompanyInput = document.getElementById("new_company");

    function toggleNewCompanyField() {
        if (!companySelect || !newCompanyWrapper || !newCompanyInput) return;

        const isNewCompany = companySelect.value === "new";

        newCompanyWrapper.classList.toggle("hidden", !isNewCompany);
        newCompanyInput.required = isNewCompany;

        if (!isNewCompany) {
            newCompanyInput.value = "";
        }

        /* Also refresh company extra fields depending on the selected option */
        updateCompanyInfo();
    }

    if (companySelect && newCompanyWrapper && newCompanyInput) {
        companySelect.addEventListener("change", toggleNewCompanyField);
        toggleNewCompanyField();
    }

});
