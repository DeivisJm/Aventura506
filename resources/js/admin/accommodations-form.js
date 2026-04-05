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

    tabButtons.forEach((button) => {
        button.addEventListener("click", () => {
            activateTab(button.dataset.tab);
        });
    });

    if (activeTabInput && activeTabInput.value) {
        activateTab(activeTabInput.value);
    }

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

    // Aquí se guardan TODAS las imágenes seleccionadas para no sobreescribir
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

    function getAvailableSlots() {
        return Math.max(0, maxGalleryImages - getExistingActiveCount() - selectedGalleryFiles.length);
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

                // Si al desmarcar/marcar cambia el espacio disponible
                if (selectedGalleryFiles.length > getAvailableSlots() + selectedGalleryFiles.length) {
                    selectedGalleryFiles = selectedGalleryFiles.slice(
                        0,
                        Math.max(0, maxGalleryImages - getExistingActiveCount())
                    );
                    syncGalleryStoreInput();
                    renderGalleryPreviews();
                }

                updateGalleryCounter();
                updateGalleryButtonState();
            });
        });
    }

    updateGalleryCounter();
    updateGalleryButtonState();
});