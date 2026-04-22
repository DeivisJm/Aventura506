import Cropper from "cropperjs";
import "cropperjs/dist/cropper.css";

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("tour-form");

    if (!form) return;

    /* =====================================================
       TABS
       Keep the active admin tab in sync so validation can
       redirect the user to the correct section.
    ===================================================== */
    const activeTabInput = document.getElementById("active-tab-input");
    const tabButtons = document.querySelectorAll(".admin-tab");
    const tabContents = document.querySelectorAll(".admin-tab-content");

    function activateTab(tabId) {
        tabButtons.forEach((button) => {
            button.classList.toggle("active", button.dataset.tab === tabId);
        });

        tabContents.forEach((content) => {
            content.classList.toggle("active", content.id === tabId);
        });

        if (activeTabInput) {
            activeTabInput.value = tabId;
        }
    }

    function activateTabForField(field) {
        const tabContent = field.closest(".admin-tab-content");
        if (!tabContent) return;
        activateTab(tabContent.id);
    }

    tabButtons.forEach((button) => {
        button.addEventListener("click", () => {
            activateTab(button.dataset.tab);
        });
    });

    if (activeTabInput && activeTabInput.value) {
        activateTab(activeTabInput.value);
    }

    /* =====================================================
       VALIDATION MODAL
       Same UX behavior used in accommodations.
    ===================================================== */
    const validationAlert = document.querySelector("[data-validation-alert]");
    const validationAlertList = validationAlert?.querySelector("[data-validation-alert-list]");
    const alertCloseButtons = validationAlert?.querySelectorAll("[data-alert-close]");
    const serverErrorsScript = document.getElementById("tour-server-errors-json");

    function showValidationAlert(messages) {
        if (!validationAlert || !validationAlertList) return;

        validationAlertList.innerHTML = "";

        messages.forEach((message) => {
            const li = document.createElement("li");
            li.textContent = message;
            validationAlertList.appendChild(li);
        });

        validationAlert.classList.add("is-open");
        validationAlert.setAttribute("aria-hidden", "false");
    }

    function hideValidationAlert() {
        if (!validationAlert) return;

        validationAlert.classList.remove("is-open");
        validationAlert.setAttribute("aria-hidden", "true");
    }

    function getFirstInvalidField() {
        return form.querySelector(".form-input-error, .form-textarea.form-input-error");
    }

    function scrollToField(field) {
        if (!field) return;

        activateTabForField(field);

        setTimeout(() => {
            field.scrollIntoView({
                behavior: "smooth",
                block: "center",
            });

            if (typeof field.focus === "function") {
                field.focus({ preventScroll: true });
            }
        }, 180);
    }

    if (alertCloseButtons?.length) {
        alertCloseButtons.forEach((button) => {
            button.addEventListener("click", () => {
                hideValidationAlert();
                const firstInvalidField = getFirstInvalidField();
                scrollToField(firstInvalidField);
            });
        });
    }

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && validationAlert?.classList.contains("is-open")) {
            hideValidationAlert();
        }
    });

    /* =====================================================
       FIELD HELPERS
    ===================================================== */
    function getFieldLabel(field) {
        const formField = field.closest(".form-field");
        const label = formField?.querySelector(".form-label");

        if (label) {
            return label.textContent.trim().replace(/\s+/g, " ");
        }

        return field.name || "Este campo";
    }

    function isValidUrl(value) {
        try {
            const url = new URL(value);
            return url.protocol === "http:" || url.protocol === "https:";
        } catch {
            return false;
        }
    }

    function isValidEmail(value) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    }

    function splitCommaList(value) {
        return String(value || "")
            .split(",")
            .map((item) => item.trim())
            .filter((item) => item !== "");
    }

    function dotKeyToInputName(dotKey) {
        const segments = String(dotKey).split(".");
        if (!segments.length) return dotKey;

        return segments.reduce((result, segment, index) => {
            return index === 0 ? segment : `${result}[${segment}]`;
        }, "");
    }

    function findFieldByErrorKey(dotKey) {
        const inputName = dotKeyToInputName(dotKey);
        return form.querySelector(`[name="${CSS.escape(inputName)}"]`);
    }

    function shouldValidateField(field) {
        if (!field || field.disabled) return false;

        if (field.type === "hidden") return false;
        if (field.type === "button") return false;
        if (field.type === "submit") return false;
        if (field.type === "reset") return false;
        if (field.type === "checkbox") return false;
        if (field.type === "radio") return false;

        if (field.id === "gallery-images-input") return false;
        if (field.id === "cropped-image-input") return false;

        if (field.id === "tour-image-input") {
            return field.required || (field.files && field.files.length > 0);
        }

        return true;
    }

    function removeFieldErrors(field) {
        if (!field) return;

        field.classList.remove("form-input-error");

        const formField = field.closest(".form-field");
        if (!formField) return;

        formField.querySelectorAll(".form-input-error-message").forEach((node) => {
            node.remove();
        });
    }

    function addFieldError(field, message, extraClass = "is-runtime") {
        if (!field) return;

        field.classList.add("form-input-error");

        const formField = field.closest(".form-field");
        if (!formField) return;

        const existing = formField.querySelector(`.form-input-error-message.${extraClass}`);
        if (existing) {
            existing.textContent = message;
            return;
        }

        const errorNode = document.createElement("p");
        errorNode.className = `form-input-error-message ${extraClass}`;
        errorNode.textContent = message;
        formField.appendChild(errorNode);
    }

    function removeRuntimeErrors() {
        form.querySelectorAll(".form-input-error-message.is-runtime, .form-input-error-message.is-pair-error, .form-input-error-message.is-server").forEach((node) => {
            node.remove();
        });

        form.querySelectorAll(".form-input-error").forEach((field) => {
            field.classList.remove("form-input-error");
        });
    }

    function sanitizeNumericField(field) {
        if (!field) return;

        const name = field.name || "";

        if (name === "company[phone]") {
            field.value = field.value.replace(/\D+/g, "");
            return;
        }

        if (field.type !== "number") return;

        const allowsDecimal = name.includes("[price]") || String(field.step || "").includes(".");

        if (allowsDecimal) {
            let cleaned = field.value.replace(/[^0-9.]/g, "");
            const parts = cleaned.split(".");
            if (parts.length > 2) {
                cleaned = `${parts[0]}.${parts.slice(1).join("")}`;
            }
            field.value = cleaned;
            return;
        }

        field.value = field.value.replace(/\D+/g, "");
    }

    /* =====================================================
       FIELD VALIDATION RULES
    ===================================================== */
    function validateField(field) {
        if (!shouldValidateField(field)) return null;

        const label = getFieldLabel(field);
        const value = String(field.value || "").trim();
        const name = field.name || "";

        if (field.required && value === "" && field.type !== "file") {
            return `${label} es obligatorio.`;
        }

        if (field.type === "file") {
            if (field.required && (!field.files || field.files.length === 0)) {
                return `${label} es obligatorio.`;
            }
            return null;
        }

        if (!field.required && value === "") {
            return null;
        }

        if (name === "slug") {
            if (!/^[a-z0-9]+(?:-[a-z0-9]+)*$/.test(value)) {
                return `${label} debe usar solo minúsculas, números y guiones.`;
            }
            return null;
        }

        if (field.type === "email" || name === "company[email]") {
            if (!isValidEmail(value)) {
                return `${label} debe contener un correo válido.`;
            }
            return null;
        }

        if (field.type === "url") {
            if (!isValidUrl(value)) {
                return `${label} debe contener una URL válida.`;
            }
            return null;
        }

        if (name === "company[phone]") {
            if (!/^\d{8,15}$/.test(value)) {
                return `${label} debe contener solo números, entre 8 y 15 dígitos.`;
            }
            return null;
        }

        if (field.type === "number") {
            const numericValue = Number(value);
            const min = field.getAttribute("min");

            if (Number.isNaN(numericValue)) {
                return `${label} debe ser un número válido.`;
            }

            if (min !== null && value !== "" && numericValue < Number(min)) {
                return `${label} debe ser mayor o igual a ${min}.`;
            }

            return null;
        }

        if (field.tagName === "SELECT") {
            if (field.required && value === "") {
                return `${label} es obligatorio.`;
            }
            return null;
        }

        if (field.type === "time") {
            if (field.required && value === "") {
                return `${label} es obligatorio.`;
            }
            return null;
        }

        if (field.tagName === "TEXTAREA") {
            if (field.required && value.length < 10) {
                return `${label} debe tener al menos 10 caracteres.`;
            }
            return null;
        }

        const isCommaListField =
            name.includes("detail[includes]") ||
            name.includes("detail[ideal_for]") ||
            name.includes("detail[recommendations]");

        if (isCommaListField) {
            if (field.required && splitCommaList(value).length === 0) {
                return `${label} debe incluir al menos un elemento válido.`;
            }
            return null;
        }

        return null;
    }

    function validateFieldLive(field) {
        if (!shouldValidateField(field)) return true;

        removeFieldErrors(field);

        const error = validateField(field);

        if (error) {
            addFieldError(field, error, "is-runtime");
            return false;
        }

        return true;
    }

    /* =====================================================
       PAIRED COMMA LIST VALIDATION
       Keep bilingual list counts aligned.
    ===================================================== */
    function clearPairError(field) {
        if (!field) return;

        const formField = field.closest(".form-field");
        formField?.querySelectorAll(".form-input-error-message.is-pair-error").forEach((node) => node.remove());
        field.classList.remove("form-input-error");
    }

    function validatePairCount(esSelector, enSelector, message) {
        const fieldEs = form.querySelector(esSelector);
        const fieldEn = form.querySelector(enSelector);

        if (!fieldEs || !fieldEn) return null;

        clearPairError(fieldEs);
        clearPairError(fieldEn);

        const countEs = splitCommaList(fieldEs.value).length;
        const countEn = splitCommaList(fieldEn.value).length;

        if (fieldEs.value.trim() === "" || fieldEn.value.trim() === "") {
            return null;
        }

        if (countEs !== countEn) {
            fieldEn.classList.add("form-input-error");
            addFieldError(fieldEn, message, "is-pair-error");
            return message;
        }

        return null;
    }

    function validateBilingualLists() {
        const messages = [];

        const includesError = validatePairCount(
            '[name="detail[includes][es]"]',
            '[name="detail[includes][en]"]',
            "La cantidad de elementos en 'Qué incluye el tour' debe coincidir en ambos idiomas."
        );

        const idealForError = validatePairCount(
            '[name="detail[ideal_for][es]"]',
            '[name="detail[ideal_for][en]"]',
            "La cantidad de elementos en 'Ideal para' debe coincidir en ambos idiomas."
        );

        const recommendationsError = validatePairCount(
            '[name="detail[recommendations][es]"]',
            '[name="detail[recommendations][en]"]',
            "La cantidad de elementos en 'Recomendaciones' debe coincidir en ambos idiomas."
        );

        [includesError, idealForError, recommendationsError].forEach((error) => {
            if (error) messages.push(error);
        });

        return messages;
    }

    /* =====================================================
       APPLY SERVER-SIDE ERRORS TO FIELDS
    ===================================================== */
    function applyServerErrors() {
        if (!serverErrorsScript) return;

        let errorMap = {};

        try {
            errorMap = JSON.parse(serverErrorsScript.textContent || "{}");
        } catch {
            errorMap = {};
        }

        let firstInvalidField = null;

        Object.entries(errorMap).forEach(([key, messages]) => {
            const field = findFieldByErrorKey(key);

            if (!field || !messages || !messages.length) return;

            if (!firstInvalidField) {
                firstInvalidField = field;
            }

            addFieldError(field, messages[0], "is-server");
        });

        if (firstInvalidField) {
            activateTabForField(firstInvalidField);
        }
    }

    applyServerErrors();

    /* =====================================================
       LIVE VALIDATION EVENTS
       Remove the red state as soon as the user corrects
       the field, matching the accommodations UX.
    ===================================================== */
    form.addEventListener("input", (event) => {
        const field = event.target;

        if (!(field instanceof HTMLInputElement || field instanceof HTMLTextAreaElement || field instanceof HTMLSelectElement)) {
            return;
        }

        sanitizeNumericField(field);
        validateFieldLive(field);

        if (
            field.name === "detail[includes][es]" ||
            field.name === "detail[includes][en]" ||
            field.name === "detail[ideal_for][es]" ||
            field.name === "detail[ideal_for][en]" ||
            field.name === "detail[recommendations][es]" ||
            field.name === "detail[recommendations][en]"
        ) {
            validateBilingualLists();
        }
    });

    form.addEventListener("change", (event) => {
        const field = event.target;

        if (!(field instanceof HTMLInputElement || field instanceof HTMLTextAreaElement || field instanceof HTMLSelectElement)) {
            return;
        }

        sanitizeNumericField(field);
        validateFieldLive(field);

        if (
            field.name === "detail[includes][es]" ||
            field.name === "detail[includes][en]" ||
            field.name === "detail[ideal_for][es]" ||
            field.name === "detail[ideal_for][en]" ||
            field.name === "detail[recommendations][es]" ||
            field.name === "detail[recommendations][en]"
        ) {
            validateBilingualLists();
        }
    });

    form.addEventListener("focusout", (event) => {
        const field = event.target;

        if (!(field instanceof HTMLInputElement || field instanceof HTMLTextAreaElement || field instanceof HTMLSelectElement)) {
            return;
        }

        sanitizeNumericField(field);
        validateFieldLive(field);
    });

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
                        min="0"
                        name="prices[${priceIndex}][min_age]"
                        class="form-input">
                </div>

                <div class="form-field">
                    <label class="form-label">
                        Edad máxima
                    </label>

                    <input
                        type="number"
                        min="0"
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
       COMPANY EXTRA INFO
       Fill email and phone based on selected company
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

        if (isNewCompany) {
            companyEmailField.value = "";
            companyPhoneField.value = "";
            companyEmailField.placeholder = "Ej: reservas@empresa.com";
            companyPhoneField.placeholder = "Ej: 88888888";
            return;
        }

        companyEmailField.value = selectedEmail;
        companyPhoneField.value = selectedPhone;

        companyEmailField.placeholder = selectedEmail ? "" : "Correo de la compañía";
        companyPhoneField.placeholder = selectedPhone ? "" : "Teléfono de la compañía";
    }

    if (companySelect && companyEmailField && companyPhoneField) {
        companySelect.addEventListener("change", updateCompanyInfo);
        updateCompanyInfo();
    }

    /* =====================================================
       NEW CATEGORY TOGGLE
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
            removeFieldErrors(newCategoryEs);
            removeFieldErrors(newCategoryEn);
        }
    }

    if (categorySelect && newCategoryWrapper && newCategoryEs && newCategoryEn) {
        categorySelect.addEventListener("change", toggleNewCategoryField);
        toggleNewCategoryField();
    }

    /* =====================================================
       NEW COMPANY TOGGLE
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
            removeFieldErrors(newCompanyInput);
        }

        updateCompanyInfo();
    }

    if (companySelect && newCompanyWrapper && newCompanyInput) {
        companySelect.addEventListener("change", toggleNewCompanyField);
        toggleNewCompanyField();
    }

    /* =====================================================
       TOUR IMAGE CROPPER
       Professional crop workflow for tour card images
    ===================================================== */
    let tourCropper = null;
    let currentImageSource = "";

    const imageInput = document.getElementById("tour-image-input");
    const imagePreview = document.getElementById("tour-image-preview");
    const imagePreviewCard = document.getElementById("tour-image-preview-card");
    const croppedImageInput = document.getElementById("cropped-image-input");

    const cropperModal = document.getElementById("tour-cropper-modal");
    const cropperImage = document.getElementById("tour-cropper-image");
    const cropperPreviewThumb = document.getElementById("tour-cropper-preview-thumb");

    const openCropperBtn = document.getElementById("open-tour-cropper");
    const closeCropperBtn = document.getElementById("tour-cropper-close");
    const closeCropperBackdrop = document.getElementById("tour-cropper-close-backdrop");
    const cancelCropperBtn = document.getElementById("tour-cropper-cancel");
    const applyCropperBtn = document.getElementById("tour-cropper-apply");

    const zoomInBtn = document.getElementById("tour-cropper-zoom-in");
    const zoomOutBtn = document.getElementById("tour-cropper-zoom-out");
    const resetCropperBtn = document.getElementById("tour-cropper-reset");

    function updateCropperPreview() {
        if (!tourCropper || !cropperPreviewThumb) return;

        const canvas = tourCropper.getCroppedCanvas({
            width: 1280,
            height: 720,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: "high",
        });

        if (!canvas) return;

        cropperPreviewThumb.src = canvas.toDataURL("image/jpeg", 0.92);
    }

    function openTourCropperModal(source) {
        if (!cropperModal || !cropperImage || !source) return;

        currentImageSource = source;
        cropperImage.src = source;
        cropperPreviewThumb.src = source;

        cropperModal.classList.remove("hidden");
        document.body.classList.add("tour-cropper-open");

        if (tourCropper) {
            tourCropper.destroy();
            tourCropper = null;
        }

        cropperImage.onload = () => {
            if (tourCropper) {
                tourCropper.destroy();
                tourCropper = null;
            }

            tourCropper = new Cropper(cropperImage, {
                aspectRatio: 16 / 9,
                viewMode: 1,
                dragMode: "move",
                autoCropArea: 1,
                background: true,
                responsive: true,
                restore: false,
                guides: true,
                center: true,
                highlight: true,
                movable: true,
                zoomable: true,
                rotatable: false,
                scalable: false,
                minCropBoxWidth: 320,
                minCropBoxHeight: 180,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,

                ready() {
                    updateCropperPreview();
                },

                crop() {
                    updateCropperPreview();
                },
            });
        };
    }

    function closeTourCropperModal() {
        if (!cropperModal) return;

        cropperModal.classList.add("hidden");
        document.body.classList.remove("tour-cropper-open");

        if (tourCropper) {
            tourCropper.destroy();
            tourCropper = null;
        }
    }

    function applyTourCrop() {
        if (!tourCropper || !imagePreview || !croppedImageInput) return;

        const canvas = tourCropper.getCroppedCanvas({
            width: 1280,
            height: 720,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: "high",
        });

        if (!canvas) return;

        const croppedBase64 = canvas.toDataURL("image/jpeg", 0.92);

        imagePreview.src = croppedBase64;
        croppedImageInput.value = croppedBase64;

        if (imagePreviewCard) {
            imagePreviewCard.classList.remove("hidden");
        }

        closeTourCropperModal();
    }

    function handleTourImageSelection(file) {
        if (!file) return;

        const reader = new FileReader();

        reader.onload = function (e) {
            const source = e.target?.result;
            if (!source) return;

            if (imagePreviewCard) {
                imagePreviewCard.classList.remove("hidden");
            }

            openTourCropperModal(source);
        };

        reader.readAsDataURL(file);
    }

    if (imageInput) {
        imageInput.addEventListener("change", function () {
            const file = this.files && this.files[0];
            if (!file) return;

            removeFieldErrors(this);
            handleTourImageSelection(file);
        });
    }

    if (openCropperBtn) {
        openCropperBtn.addEventListener("click", function () {
            const source = croppedImageInput?.value || imagePreview?.src || currentImageSource;
            if (!source) return;

            openTourCropperModal(source);
        });
    }

    if (closeCropperBtn) {
        closeCropperBtn.addEventListener("click", closeTourCropperModal);
    }

    if (closeCropperBackdrop) {
        closeCropperBackdrop.addEventListener("click", closeTourCropperModal);
    }

    if (cancelCropperBtn) {
        cancelCropperBtn.addEventListener("click", closeTourCropperModal);
    }

    if (applyCropperBtn) {
        applyCropperBtn.addEventListener("click", applyTourCrop);
    }

    if (zoomInBtn) {
        zoomInBtn.addEventListener("click", () => {
            if (!tourCropper) return;
            tourCropper.zoom(0.1);
            updateCropperPreview();
        });
    }

    if (zoomOutBtn) {
        zoomOutBtn.addEventListener("click", () => {
            if (!tourCropper) return;
            tourCropper.zoom(-0.1);
            updateCropperPreview();
        });
    }

    if (resetCropperBtn) {
        resetCropperBtn.addEventListener("click", () => {
            if (!tourCropper) return;
            tourCropper.reset();
            setTimeout(() => {
                updateCropperPreview();
            }, 30);
        });
    }

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && cropperModal && !cropperModal.classList.contains("hidden")) {
            closeTourCropperModal();
        }
    });

    /* =====================================================
       FORM SUBMIT VALIDATION
       Prevent submission, open modal, and scroll to the
       first missing or invalid field.
    ===================================================== */
    form.addEventListener("submit", (event) => {
        removeRuntimeErrors();

        const messages = [];
        let firstInvalidField = null;

        const validatableFields = Array.from(form.querySelectorAll("input, textarea, select"))
            .filter((field) => shouldValidateField(field));

        validatableFields.forEach((field) => {
            const error = validateField(field);

            if (error) {
                if (!firstInvalidField) {
                    firstInvalidField = field;
                }

                addFieldError(field, error, "is-runtime");
                messages.push(error);
            }
        });

        const pairErrors = validateBilingualLists();

        if (pairErrors.length) {
            const detailsEnglishField =
                form.querySelector('[name="detail[includes][en]"]') ||
                form.querySelector('[name="detail[ideal_for][en]"]') ||
                form.querySelector('[name="detail[recommendations][en]"]');

            if (!firstInvalidField && detailsEnglishField) {
                firstInvalidField = detailsEnglishField;
            }

            messages.push(...pairErrors);
        }

        if (messages.length) {
            event.preventDefault();
            showValidationAlert(messages);

            if (firstInvalidField) {
                activateTabForField(firstInvalidField);
            }
        }
    });
});