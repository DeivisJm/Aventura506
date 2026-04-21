document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("accommodation-form");
    if (!form) return;

    /* =========================================
       TABS
    ========================================= */
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

    /* =========================================
       VALIDATION MODAL
    ========================================= */
    const validationAlert = document.querySelector("[data-validation-alert]");
    const validationAlertList = validationAlert?.querySelector("[data-validation-alert-list]");
    const alertCloseButtons = validationAlert?.querySelectorAll("[data-alert-close]");

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

            field.focus({ preventScroll: true });
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
       FIELD VALIDATION
    ========================================= */
    const fieldsToValidate = form.querySelectorAll("[data-validate]");

    function isValidUrl(value) {
        try {
            const url = new URL(value);
            return url.protocol === "http:" || url.protocol === "https:";
        } catch {
            return false;
        }
    }

    function splitAmenities(value) {
        return value
            .split(",")
            .map((item) => item.trim())
            .filter((item) => item !== "");
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
        form.querySelectorAll(".form-input-error-message.is-runtime, .form-input-error-message.is-pair-error").forEach((node) => node.remove());

        fieldsToValidate.forEach((field) => {
            field.classList.remove("form-input-error");
        });
    }

    function validateField(field) {
        const rule = field.dataset.validate;
        const label = field.dataset.label || "Este campo";
        const value = (field.value || "").trim();

        if (value === "") {
            return `${label} es obligatorio.`;
        }

        switch (rule) {
            case "text":
                if (!/^[A-Za-zÀ-ÿ0-9\s\-&.'()]+$/u.test(value)) {
                    return `${label} contiene caracteres no permitidos.`;
                }
                break;

            case "letters":
                if (!/^[A-Za-zÀ-ÿ\s]+$/u.test(value)) {
                    return `${label} solo debe contener letras y espacios.`;
                }
                break;

            case "slug":
                if (!/^[a-z0-9]+(?:-[a-z0-9]+)*$/.test(value)) {
                    return `${label} debe usar solo minúsculas, números y guiones.`;
                }
                break;

            case "location":
                if (!/^[A-Za-zÀ-ÿ0-9\s,.\-#]+$/u.test(value)) {
                    return `${label} contiene caracteres no permitidos.`;
                }
                break;

            case "phone":
                if (!/^\d{8,15}$/.test(value)) {
                    return `${label} debe contener solo números, entre 8 y 15 dígitos.`;
                }
                break;

            case "url":
                if (!isValidUrl(value)) {
                    return `${label} debe contener una URL válida.`;
                }
                break;

            case "number": {
                const numericValue = Number(value);
                const min = field.getAttribute("min");

                if (Number.isNaN(numericValue)) {
                    return `${label} debe ser un número válido.`;
                }

                if (min !== null && numericValue < Number(min)) {
                    return `${label} debe ser mayor o igual a ${min}.`;
                }

                break;
            }

            case "textarea":
                if (value.length < 10) {
                    return `${label} debe tener al menos 10 caracteres.`;
                }
                break;

            case "amenities":
                if (!/^[A-Za-zÀ-ÿ0-9\s,\-\/&.+]+$/u.test(value)) {
                    return `${label} contiene caracteres no permitidos.`;
                }

                if (splitAmenities(value).length === 0) {
                    return `${label} debe incluir al menos una amenidad.`;
                }

                break;

            default:
                break;
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

    function clearAmenitiesPairError() {
        const amenitiesEs = form.querySelector("#amenities-es");
        const amenitiesEn = form.querySelector("#amenities-en");

        if (amenitiesEs) {
            const formFieldEs = amenitiesEs.closest(".form-field");
            formFieldEs?.querySelectorAll(".form-input-error-message.is-pair-error").forEach((node) => node.remove());
        }

        if (amenitiesEn) {
            const formFieldEn = amenitiesEn.closest(".form-field");
            formFieldEn?.querySelectorAll(".form-input-error-message.is-pair-error").forEach((node) => node.remove());
            amenitiesEn.classList.remove("form-input-error");
        }
    }

    function validateAmenitiesPair() {
        const amenitiesEs = form.querySelector("#amenities-es");
        const amenitiesEn = form.querySelector("#amenities-en");

        if (!amenitiesEs || !amenitiesEn) return null;

        clearAmenitiesPairError();

        const countEs = splitAmenities(amenitiesEs.value.trim()).length;
        const countEn = splitAmenities(amenitiesEn.value.trim()).length;

        if (countEs !== countEn) {
            amenitiesEn.classList.add("form-input-error");
            addFieldError(
                amenitiesEn,
                "La cantidad de amenidades en inglés debe coincidir con la cantidad de amenidades en español.",
                "is-pair-error"
            );
            return "La cantidad de amenidades en inglés debe coincidir con la cantidad de amenidades en español.";
        }

        return null;
    }

    fieldsToValidate.forEach((field) => {
        const handleLiveValidation = () => {
            validateFieldLive(field);

            if (field.id === "amenities-es" || field.id === "amenities-en") {
                const amenitiesEsValid = validateFieldLive(form.querySelector("#amenities-es"));
                const amenitiesEnValid = validateFieldLive(form.querySelector("#amenities-en"));

                if (amenitiesEsValid && amenitiesEnValid) {
                    validateAmenitiesPair();
                }
            }
        };

        field.addEventListener("input", handleLiveValidation);
        field.addEventListener("change", handleLiveValidation);
        field.addEventListener("blur", handleLiveValidation);
    });

    /* =========================================
       MAIN IMAGE
    ========================================= */
    const mainImageInput = document.getElementById("main-image-input");
    const mainImagePreview = document.getElementById("main-image-preview");
    const mainImagePreviewCard = document.getElementById("main-image-preview-card");

    if (mainImageInput && mainImagePreview && mainImagePreviewCard) {
        mainImageInput.addEventListener("change", function () {
            const file = this.files?.[0];
            if (!file) return;

            const reader = new FileReader();

            reader.onload = function (event) {
                mainImagePreview.src = event.target?.result || "";
                mainImagePreviewCard.classList.remove("hidden");
            };

            reader.readAsDataURL(file);
        });
    }

    /* =========================================
       GALLERY
    ========================================= */
    const addGalleryButton = document.getElementById("add-gallery-image-btn");
    const galleryPickerInput = document.getElementById("gallery-images-input");
    const galleryStoreInput = document.getElementById("gallery-images-store");
    const galleryPreviewGrid = document.getElementById("gallery-preview-grid");
    const galleryCounter = document.getElementById("gallery-counter");
    const existingGalleryGrid = document.getElementById("existing-gallery-grid");

    const maxGalleryImages = Number(galleryCounter?.dataset.max || 7);
    let selectedGalleryFiles = [];

    function getExistingActiveCount() {
        if (!existingGalleryGrid) return 0;

        let count = 0;

        existingGalleryGrid.querySelectorAll("[data-existing-gallery-item]").forEach((item) => {
            const checkbox = item.querySelector(".existing-gallery-remove-checkbox");
            if (!checkbox || !checkbox.checked) {
                count++;
            }
        });

        return count;
    }

    function getTotalSelectedCount() {
        return getExistingActiveCount() + selectedGalleryFiles.length;
    }

    function getAvailableSlots() {
        return Math.max(0, maxGalleryImages - getExistingActiveCount() - selectedGalleryFiles.length);
    }

    function updateGalleryCounter() {
        if (!galleryCounter) return;
        galleryCounter.textContent = `${getTotalSelectedCount()} / ${maxGalleryImages} imágenes seleccionadas`;
    }

    function updateGalleryButtonState() {
        if (!addGalleryButton) return;

        const disable = getTotalSelectedCount() >= maxGalleryImages;
        addGalleryButton.disabled = disable;
        addGalleryButton.classList.toggle("is-disabled", disable);
    }

    function syncGalleryStoreInput() {
        if (!galleryStoreInput) return;

        const dataTransfer = new DataTransfer();

        selectedGalleryFiles.forEach((file) => {
            dataTransfer.items.add(file);
        });

        galleryStoreInput.files = dataTransfer.files;
    }

    function renderGalleryPreviews() {
        if (!galleryPreviewGrid) return;

        galleryPreviewGrid.innerHTML = "";

        selectedGalleryFiles.forEach((file, index) => {
            const card = document.createElement("div");
            card.className = "accommodation-gallery-preview-card";

            const image = document.createElement("img");
            image.className = "accommodation-gallery-preview-image";
            image.alt = `Gallery preview ${index + 1}`;
            image.src = URL.createObjectURL(file);

            const removeButton = document.createElement("button");
            removeButton.type = "button";
            removeButton.className = "accommodation-gallery-remove-btn";
            removeButton.setAttribute("aria-label", "Quitar imagen");
            removeButton.innerHTML = `
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18" />
                </svg>
            `;

            removeButton.addEventListener("click", () => {
                selectedGalleryFiles.splice(index, 1);
                syncGalleryStoreInput();
                renderGalleryPreviews();
                updateGalleryCounter();
                updateGalleryButtonState();
            });

            card.appendChild(image);
            card.appendChild(removeButton);
            galleryPreviewGrid.appendChild(card);
        });
    }

    function addFilesToSelection(fileList) {
        const incomingFiles = Array.from(fileList || []);
        if (!incomingFiles.length) return;

        const availableSlots = getAvailableSlots();

        if (availableSlots <= 0) {
            alert("Ya alcanzaste el máximo de 7 imágenes.");
            return;
        }

        const filesToAdd = incomingFiles.slice(0, availableSlots);

        if (incomingFiles.length > filesToAdd.length) {
            alert(`Solo puedes agregar ${availableSlots} imagen(es) más.`);
        }

        selectedGalleryFiles.push(...filesToAdd);

        syncGalleryStoreInput();
        renderGalleryPreviews();
        updateGalleryCounter();
        updateGalleryButtonState();
    }

    if (addGalleryButton && galleryPickerInput) {
        addGalleryButton.addEventListener("click", () => {
            if (getAvailableSlots() <= 0) return;
            galleryPickerInput.click();
        });
    }

    if (galleryPickerInput) {
        galleryPickerInput.addEventListener("change", function () {
            addFilesToSelection(this.files);
            this.value = "";
        });
    }

    if (existingGalleryGrid) {
        existingGalleryGrid.querySelectorAll(".existing-gallery-remove-checkbox").forEach((checkbox) => {
            checkbox.addEventListener("change", () => {
                const item = checkbox.closest("[data-existing-gallery-item]");
                if (item) {
                    item.classList.toggle("is-marked-for-removal", checkbox.checked);
                }

                updateGalleryCounter();
                updateGalleryButtonState();
            });
        });
    }

    updateGalleryCounter();
    updateGalleryButtonState();

    /* =========================================
       FORM SUBMIT VALIDATION
    ========================================= */
    form.addEventListener("submit", (event) => {
        removeRuntimeErrors();

        const messages = [];
        let firstInvalidField = null;

        fieldsToValidate.forEach((field) => {
            const error = validateField(field);

            if (error) {
                if (!firstInvalidField) {
                    firstInvalidField = field;
                }

                addFieldError(field, error, "is-runtime");
                messages.push(error);
            }
        });

        const amenitiesPairError = validateAmenitiesPair();
        if (amenitiesPairError) {
            const amenitiesEn = form.querySelector("#amenities-en");
            if (!firstInvalidField && amenitiesEn) {
                firstInvalidField = amenitiesEn;
            }
            messages.push(amenitiesPairError);
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