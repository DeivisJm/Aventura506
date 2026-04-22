/* =====================================================
   BOOKING FORM ENHANCED VALIDATION
   Client-side validation layer for the booking modal
   using localized strings loaded from Blade.
===================================================== */

window.bookingEnhancedValidationEnabled = true;

document.addEventListener("DOMContentLoaded", () => {
    const bookingModal = document.getElementById("bookingModal");
    const form = document.getElementById("bookingForm");

    if (!bookingModal || !form) return;

    /* =====================================================
       LOCALIZED STRINGS
       Loaded from a JSON script tag generated in Blade.
    ===================================================== */
    function getJsonScriptData(id) {
        const element = document.getElementById(id);

        if (!element) {
            return {};
        }

        try {
            return JSON.parse(element.textContent || "{}");
        } catch (error) {
            console.warn(`Invalid JSON found in #${id}`, error);
            return {};
        }
    }

    const translations = getJsonScriptData("booking-validation-translations");

    function t(key, fallback = "") {
        return translations[key] || fallback;
    }

    /* =====================================================
       ELEMENT REFERENCES
    ===================================================== */
    const validationModal = document.getElementById("bookingValidationModal");
    const validationList = validationModal?.querySelector("[data-booking-validation-list]");
    const validationCloseButtons = validationModal?.querySelectorAll("[data-booking-validation-close]");

    const scrollContainer =
        bookingModal.querySelector(".form-side") ||
        bookingModal.querySelector(".booking-content");

    const nameInput = form.querySelector('[name="name"]');
    const emailInput = form.querySelector('[name="email"]');
    const phoneInput = form.querySelector('[name="phone"]');
    const nationalityInput = form.querySelector('[name="nationality"]');

    const hiddenDate = document.getElementById("hiddenDate");
    const hiddenTime = document.getElementById("hiddenTime");
    const hiddenTotal = document.getElementById("hiddenTotal");

    const selectedDateDisplay = document.getElementById("selectedDateDisplay");
    const timeSection = document.getElementById("timeSection");
    const dynamicPriceOptions = document.getElementById("dynamicPriceOptions");

    const dateError = document.getElementById("dateError");
    const timeError = document.getElementById("timeError");
    const personsError = document.getElementById("personsError");

    /* =====================================================
       VALIDATION MODAL HELPERS
    ===================================================== */
    function showValidationModal(messages) {
        if (!validationModal || !validationList) return;

        validationList.innerHTML = "";

        messages.forEach((message) => {
            const li = document.createElement("li");
            li.textContent = message;
            validationList.appendChild(li);
        });

        validationModal.classList.add("is-open");
        validationModal.setAttribute("aria-hidden", "false");
    }

    function hideValidationModal() {
        if (!validationModal) return;

        validationModal.classList.remove("is-open");
        validationModal.setAttribute("aria-hidden", "true");
    }

    validationCloseButtons?.forEach((button) => {
        button.addEventListener("click", () => {
            hideValidationModal();

            const firstInvalidField = form.querySelector(".booking-input.error");

            if (firstInvalidField) {
                scrollToTarget(firstInvalidField);
            }
        });
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && validationModal?.classList.contains("is-open")) {
            hideValidationModal();
        }
    });

    /* =====================================================
       GENERIC HELPERS
    ===================================================== */
    function getItiInstance() {
        if (!phoneInput || !window.intlTelInputGlobals) return null;

        return window.intlTelInputGlobals.getInstance(phoneInput);
    }

    function getNationalityCountryData() {
        if (!nationalityInput || typeof window.$ === "undefined") return null;
        if (typeof $.fn.countrySelect === "undefined") return null;

        try {
            return $(nationalityInput).countrySelect("getSelectedCountryData");
        } catch {
            return null;
        }
    }

    function getPhoneCountryData() {
        const iti = getItiInstance();

        if (!iti) return null;

        try {
            return iti.getSelectedCountryData();
        } catch {
            return null;
        }
    }

    function getFieldErrorElement(input) {
        if (!input) return null;

        const formGroup = input.closest(".form-group");

        if (!formGroup) return null;

        return formGroup.querySelector(".error-message");
    }

    function showFieldError(input, message) {
        if (!input) return;

        input.classList.add("error");

        const errorElement = getFieldErrorElement(input);

        if (!errorElement) return;

        errorElement.textContent = message;
        errorElement.classList.remove("hidden");
    }

    function clearFieldError(input) {
        if (!input) return;

        input.classList.remove("error");

        const errorElement = getFieldErrorElement(input);

        if (!errorElement) return;

        errorElement.textContent = "";
        errorElement.classList.add("hidden");
    }

    function clearGlobalError(element) {
        if (!element) return;

        element.textContent = "";
        element.classList.add("hidden");
    }

    function clearAllErrors() {
        [nameInput, emailInput, phoneInput, nationalityInput].forEach(clearFieldError);

        clearGlobalError(dateError);
        clearGlobalError(timeError);
        clearGlobalError(personsError);
    }

    function scrollToTarget(target) {
        if (!target || !scrollContainer) return;

        const containerRect = scrollContainer.getBoundingClientRect();
        const targetRect = target.getBoundingClientRect();

        const offset =
            targetRect.top -
            containerRect.top +
            scrollContainer.scrollTop -
            110;

        scrollContainer.scrollTo({
            top: offset,
            behavior: "smooth",
        });

        if (typeof target.focus === "function") {
            setTimeout(() => {
                target.focus({ preventScroll: true });
            }, 350);
        }
    }

    /* =====================================================
       SANITIZERS
    ===================================================== */
    function sanitizeNameValue(value) {
        return value.replace(/[^a-zA-ZÀ-ÿ\s'-]/g, "");
    }

    function normalizePhoneDigits() {
        if (!phoneInput) return "";

        let digits = phoneInput.value.replace(/\D+/g, "");
        const phoneCountry = getPhoneCountryData();
        const dialCode = phoneCountry?.dialCode || "";

        if (dialCode && digits.startsWith(dialCode) && digits.length > dialCode.length + 6) {
            digits = digits.slice(dialCode.length);
        }

        phoneInput.value = digits;

        return digits;
    }

    function syncPhoneCountryWithNationality() {
        const iti = getItiInstance();
        const nationalityCountry = getNationalityCountryData();

        if (!iti || !nationalityCountry?.iso2) return;

        try {
            iti.setCountry(nationalityCountry.iso2);
        } catch {
            /* no-op */
        }
    }

    /* =====================================================
       VALIDATION RULES
    ===================================================== */
    function validateName() {
        const value = nameInput?.value.trim() || "";

        if (!value) {
            return t("error_name_required", "El nombre es obligatorio.");
        }

        if (!/^[a-zA-ZÀ-ÿ\s'-]+$/.test(value)) {
            return t("error_name_invalid", "El nombre solo puede contener letras y espacios.");
        }

        return null;
    }

    function validateEmail() {
        const value = emailInput?.value.trim() || "";

        if (!value) {
            return t("error_email_required", "El correo es obligatorio.");
        }

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
            return t("error_email_invalid", "Debes ingresar un correo válido.");
        }

        return null;
    }

    async function validatePhone() {
        const digits = normalizePhoneDigits();
        const iti = getItiInstance();

        if (!digits) {
            return t("error_phone_required", "El teléfono es obligatorio.");
        }

        if (!/^\d+$/.test(digits)) {
            return t("error_phone_digits_only", "El teléfono debe contener solo números.");
        }

        if (window.bookingPhoneItiPromise) {
            await window.bookingPhoneItiPromise;
        }

        const validationError = window.intlTelInputUtils?.validationError;

        if (!iti || typeof iti.isValidNumber !== "function" || !validationError) {
            if (digits.length < 7 || digits.length > 15) {
                return t(
                    "error_phone_invalid",
                    "El teléfono debe contener solo números y entre 7 y 15 dígitos."
                );
            }

            return null;
        }

        if (iti.isValidNumber()) {
            return null;
        }

        const errorCode = iti.getValidationError();

        switch (errorCode) {
            case validationError.TOO_SHORT:
                return t(
                    "error_phone_too_short",
                    "El número es demasiado corto para el país seleccionado."
                );

            case validationError.TOO_LONG:
                return t(
                    "error_phone_too_long",
                    "El número es demasiado largo para el país seleccionado."
                );

            case validationError.INVALID_COUNTRY_CODE:
            case validationError.NOT_A_NUMBER:
            case validationError.INVALID_LENGTH:
            default:
                return t(
                    "error_phone_country_invalid",
                    "El número no coincide con el formato del país seleccionado."
                );
        }
    }

    function validateNationality() {
        const value = nationalityInput?.value.trim() || "";
        const nationalityCountry = getNationalityCountryData();
        const phoneCountry = getPhoneCountryData();

        if (!value) {
            return t("error_nationality_required", "La nacionalidad es obligatoria.");
        }

        if (
            nationalityCountry?.iso2 &&
            phoneCountry?.iso2 &&
            nationalityCountry.iso2 !== phoneCountry.iso2
        ) {
            return t(
                "error_nationality_phone_mismatch",
                "La nacionalidad seleccionada no coincide con el país del teléfono."
            );
        }

        return null;
    }

    function validateDate() {
        if (!hiddenDate?.value) {
            return t("error_date_required", "Debes seleccionar una fecha.");
        }

        return null;
    }

    function validateTime() {
        if (!hiddenTime?.value) {
            return t("error_time_required", "Debes seleccionar un horario.");
        }

        return null;
    }

    function validatePersons() {
        const total = parseFloat(hiddenTotal?.value || "0");

        if (Number.isNaN(total) || total <= 0) {
            return t(
                "error_persons_required",
                "Debes seleccionar al menos una persona."
            );
        }

        return null;
    }

    /* =====================================================
       LIVE RESET OF ERROR STATES
       The red state disappears as the user corrects the field.
    ===================================================== */
    if (nameInput) {
        nameInput.addEventListener("input", () => {
            nameInput.value = sanitizeNameValue(nameInput.value);
            clearFieldError(nameInput);
        });

        nameInput.addEventListener("blur", () => {
            const error = validateName();

            if (error) {
                showFieldError(nameInput, error);
            }
        });
    }

    if (emailInput) {
        emailInput.addEventListener("input", () => {
            clearFieldError(emailInput);
        });

        emailInput.addEventListener("blur", () => {
            const error = validateEmail();

            if (error) {
                showFieldError(emailInput, error);
            }
        });
    }

    if (phoneInput) {
        phoneInput.addEventListener("input", () => {
            normalizePhoneDigits();
            clearFieldError(phoneInput);
        });

        phoneInput.addEventListener("blur", async () => {
            const error = await validatePhone();

            if (error) {
                showFieldError(phoneInput, error);
            }
        });

        phoneInput.addEventListener("countrychange", () => {
            clearFieldError(phoneInput);
            clearFieldError(nationalityInput);
        });
    }

    if (nationalityInput) {
        nationalityInput.addEventListener("input", () => {
            clearFieldError(nationalityInput);
        });

        nationalityInput.addEventListener("change", () => {
            syncPhoneCountryWithNationality();
            clearFieldError(nationalityInput);
            clearFieldError(phoneInput);
        });

        nationalityInput.addEventListener("blur", () => {
            const error = validateNationality();

            if (error) {
                showFieldError(nationalityInput, error);
            }
        });
    }

    /* =====================================================
       RESET GLOBAL ERRORS WHEN USER INTERACTS
    ===================================================== */
    document.addEventListener("click", (event) => {
        if (event.target.closest("#calendarGrid button")) {
            setTimeout(() => clearGlobalError(dateError), 30);
        }

        if (event.target.classList.contains("booking-time")) {
            setTimeout(() => clearGlobalError(timeError), 30);
        }

        if (event.target.classList.contains("qty-btn")) {
            setTimeout(() => clearGlobalError(personsError), 30);
        }
    });

    /* =====================================================
       SUBMIT VALIDATION
    ===================================================== */
    form.addEventListener("submit", async (event) => {
        event.preventDefault();

        clearAllErrors();

        const messages = [];
        let firstInvalidTarget = null;

        const nameError = validateName();
        if (nameError) {
            showFieldError(nameInput, nameError);
            messages.push(nameError);
            firstInvalidTarget = firstInvalidTarget || nameInput;
        }

        const emailError = validateEmail();
        if (emailError) {
            showFieldError(emailInput, emailError);
            messages.push(emailError);
            firstInvalidTarget = firstInvalidTarget || emailInput;
        }

        const phoneError = await validatePhone();
        if (phoneError) {
            showFieldError(phoneInput, phoneError);
            messages.push(phoneError);
            firstInvalidTarget = firstInvalidTarget || phoneInput;
        }

        const nationalityError = validateNationality();
        if (nationalityError) {
            showFieldError(nationalityInput, nationalityError);
            messages.push(nationalityError);
            firstInvalidTarget = firstInvalidTarget || nationalityInput;
        }

        const dateValidationError = validateDate();
        if (dateValidationError) {
            dateError.textContent = dateValidationError;
            dateError.classList.remove("hidden");
            messages.push(dateValidationError);
            firstInvalidTarget = firstInvalidTarget || selectedDateDisplay;
        }

        const timeValidationError = validateTime();
        if (timeValidationError) {
            timeError.textContent = timeValidationError;
            timeError.classList.remove("hidden");
            messages.push(timeValidationError);
            firstInvalidTarget = firstInvalidTarget || timeSection;
        }

        const personsValidationError = validatePersons();
        if (personsValidationError) {
            personsError.textContent = personsValidationError;
            personsError.classList.remove("hidden");
            messages.push(personsValidationError);
            firstInvalidTarget = firstInvalidTarget || dynamicPriceOptions;
        }

        if (messages.length) {
            showValidationModal(messages);

            if (firstInvalidTarget) {
                scrollToTarget(firstInvalidTarget);
            }

            return;
        }

        form.submit();
    });
});