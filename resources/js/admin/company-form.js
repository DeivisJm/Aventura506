document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("company-form");
    if (!form) return;

    /* =========================================
       VALIDATION MODAL
    ========================================= */
    const validationAlert = document.querySelector("[data-validation-alert]");
    const validationAlertList = validationAlert?.querySelector("[data-validation-alert-list]");
    const alertCloseButtons = validationAlert?.querySelectorAll("[data-alert-close]");
    const serverErrorsScript = document.getElementById("company-server-errors-json");

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

    /* =========================================
       HELPERS
    ========================================= */
    function getFieldLabel(field) {
        const formField = field.closest(".form-field");
        const label = formField?.querySelector(".form-label");

        if (label) {
            return label.textContent.trim().replace(/\s+/g, " ");
        }

        return field.name || "Este campo";
    }

    function isValidEmail(value) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    }

    function isValidUrl(value) {
        try {
            const url = new URL(value);
            return url.protocol === "http:" || url.protocol === "https:";
        } catch {
            return false;
        }
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
        form.querySelectorAll(".form-input-error-message.is-runtime, .form-input-error-message.is-server").forEach((node) => {
            node.remove();
        });

        form.querySelectorAll(".form-input-error").forEach((field) => {
            field.classList.remove("form-input-error");
        });
    }

    function sanitizeNumericField(field) {
        if (!field) return;

        if (field.name === "phone") {
            field.value = field.value.replace(/\D+/g, "");
        }
    }

    /* =========================================
       FIELD VALIDATION
    ========================================= */
    function validateField(field) {
        const label = getFieldLabel(field);
        const value = String(field.value || "").trim();

        if (field.required && value === "") {
            return `${label} es obligatorio.`;
        }

        if (field.name === "name") {
            if (!/^[A-Za-zÀ-ÿ0-9\s&.'\-()]+$/u.test(value)) {
                return `${label} contiene caracteres no permitidos.`;
            }
            return null;
        }

        if (field.name === "email") {
            if (!isValidEmail(value)) {
                return `${label} debe contener un correo válido.`;
            }
            return null;
        }

        if (field.name === "phone") {
            if (!/^\d{8,15}$/.test(value)) {
                return `${label} debe contener solo números, entre 8 y 15 dígitos.`;
            }
            return null;
        }

        if (field.name === "location_name") {
            if (!/^[A-Za-zÀ-ÿ0-9\s,.\-#]+$/u.test(value)) {
                return `${label} contiene caracteres no permitidos.`;
            }
            return null;
        }

        if (field.name === "map_embed_url") {
            if (!isValidUrl(value)) {
                return `${label} debe contener una URL válida.`;
            }
            return null;
        }

        return null;
    }

    function validateFieldLive(field) {
        removeFieldErrors(field);

        const error = validateField(field);

        if (error) {
            addFieldError(field, error, "is-runtime");
            return false;
        }

        return true;
    }

    /* =========================================
       APPLY SERVER ERRORS
    ========================================= */
    function applyServerErrors() {
        if (!serverErrorsScript) return;

        let errorMap = {};

        try {
            errorMap = JSON.parse(serverErrorsScript.textContent || "{}");
        } catch {
            errorMap = {};
        }

        Object.entries(errorMap).forEach(([key, messages]) => {
            const field = findFieldByErrorKey(key);

            if (!field || !messages || !messages.length) return;

            addFieldError(field, messages[0], "is-server");
        });
    }

    applyServerErrors();

    /* =========================================
       LIVE VALIDATION
    ========================================= */
    const validatableFields = Array.from(
        form.querySelectorAll('input[name="name"], input[name="email"], input[name="phone"], input[name="location_name"], textarea[name="map_embed_url"]')
    );

    validatableFields.forEach((field) => {
        const handleLiveValidation = () => {
            sanitizeNumericField(field);
            validateFieldLive(field);
        };

        field.addEventListener("input", handleLiveValidation);
        field.addEventListener("change", handleLiveValidation);
        field.addEventListener("blur", handleLiveValidation);
    });

    /* =========================================
       MAP PREVIEW
    ========================================= */
    const mapInput = document.getElementById("company_map_embed_url");
    const mapPreviewWrapper = document.getElementById("company-map-preview-wrapper");
    const mapPreview = document.getElementById("company-map-preview");

    function updateMapPreview() {
        if (!mapInput || !mapPreviewWrapper || !mapPreview) return;

        const value = mapInput.value.trim();

        if (isValidUrl(value)) {
            mapPreview.src = value;
            mapPreviewWrapper.classList.remove("hidden");
        } else {
            mapPreview.src = "";
            mapPreviewWrapper.classList.add("hidden");
        }
    }

    if (mapInput) {
        mapInput.addEventListener("input", updateMapPreview);
        mapInput.addEventListener("change", updateMapPreview);
        updateMapPreview();
    }

    /* =========================================
       FORM SUBMIT VALIDATION
    ========================================= */
    form.addEventListener("submit", (event) => {
        removeRuntimeErrors();

        const messages = [];
        let firstInvalidField = null;

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

        if (messages.length) {
            event.preventDefault();
            showValidationAlert(messages);

            if (firstInvalidField) {
                scrollToField(firstInvalidField);
            }
        }
    });
});