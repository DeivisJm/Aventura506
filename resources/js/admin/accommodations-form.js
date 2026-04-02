document.addEventListener("DOMContentLoaded", () => {
    const storageKey = "admin_accommodation_active_tab";

    /* =====================================================
       TAB PERSISTENCE
    ===================================================== */
    const tabButtons = document.querySelectorAll(".admin-tab");
    const tabContents = document.querySelectorAll(".admin-tab-content");

    const activateTab = (tabId) => {
        tabButtons.forEach((tab) => {
            tab.classList.toggle("active", tab.dataset.tab === tabId);
        });

        tabContents.forEach((content) => {
            content.classList.toggle("active", content.id === tabId);
        });

        sessionStorage.setItem(storageKey, tabId);
    };

    if (tabButtons.length && tabContents.length) {
        const savedTab = sessionStorage.getItem(storageKey);
        const tabExists = [...tabButtons].some((tab) => tab.dataset.tab === savedTab);

        if (savedTab && tabExists) {
            activateTab(savedTab);
        }

        tabButtons.forEach((button) => {
            button.addEventListener("click", () => {
                activateTab(button.dataset.tab);
            });
        });
    }

    const form = document.getElementById("accommodation-form");

    form?.addEventListener("submit", () => {
        const activeTab = document.querySelector(".admin-tab.active")?.dataset.tab;

        if (activeTab) {
            sessionStorage.setItem(storageKey, activeTab);
        }
    });

    /* =====================================================
       MAIN IMAGE PREVIEW
    ===================================================== */
    const mainImageInput = document.getElementById("main-image-input");
    const mainImagePreview = document.getElementById("main-image-preview");
    const mainImagePreviewCard = document.getElementById("main-image-preview-card");

    if (mainImageInput && mainImagePreview) {
        mainImageInput.addEventListener("change", (event) => {
            const file = event.target.files?.[0];
            if (!file) return;

            const reader = new FileReader();

            reader.onload = (e) => {
                mainImagePreview.src = e.target?.result;

                if (mainImagePreviewCard) {
                    mainImagePreviewCard.classList.remove("hidden");
                }
            };

            reader.readAsDataURL(file);
        });
    }

    /* =====================================================
       GALLERY MANAGEMENT
       Counts existing images, checked removals, and new files
    ===================================================== */
    const addGalleryButton = document.getElementById("add-gallery-image-btn");
    const galleryInputTrigger = document.getElementById("gallery-images-input");
    const galleryStoreInput = document.getElementById("gallery-images-store");
    const galleryPreviewGrid = document.getElementById("gallery-preview-grid");
    const galleryCounter = document.getElementById("gallery-counter");
    const removeExistingCheckboxes = document.querySelectorAll(".existing-gallery-remove-checkbox");

    const galleryLimit = Number(galleryCounter?.dataset.max || 7);
    const existingGalleryCount = Number(galleryCounter?.dataset.existingCount || 0);

    let galleryFiles = [];

    const getCheckedExistingRemovalsCount = () => {
        return [...removeExistingCheckboxes].filter((checkbox) => checkbox.checked).length;
    };

    const getEffectiveExistingCount = () => {
        return Math.max(existingGalleryCount - getCheckedExistingRemovalsCount(), 0);
    };

    const getCurrentTotalCount = () => {
        return getEffectiveExistingCount() + galleryFiles.length;
    };

    const getRemainingSlots = () => {
        return Math.max(galleryLimit - getCurrentTotalCount(), 0);
    };

    const updateGalleryCounter = () => {
        if (!galleryCounter) return;

        galleryCounter.textContent = `${getCurrentTotalCount()} / ${galleryLimit} imágenes seleccionadas`;
    };

    const syncGalleryInput = () => {
        if (!galleryStoreInput) return;

        const dataTransfer = new DataTransfer();

        galleryFiles.forEach((file) => {
            dataTransfer.items.add(file);
        });

        galleryStoreInput.files = dataTransfer.files;
    };

    const renderGalleryPreviews = () => {
        if (!galleryPreviewGrid) return;

        galleryPreviewGrid.innerHTML = "";

        galleryFiles.forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = (e) => {
                const card = document.createElement("div");
                card.className = "accommodation-gallery-preview-card";

                card.innerHTML = `
                    <img src="${e.target?.result}" alt="Gallery preview" class="accommodation-gallery-preview-image">
                    <button type="button" class="accommodation-gallery-remove-btn" data-index="${index}" aria-label="Quitar imagen">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                `;

                galleryPreviewGrid.appendChild(card);

                const removeButton = card.querySelector(".accommodation-gallery-remove-btn");

                removeButton?.addEventListener("click", () => {
                    galleryFiles.splice(index, 1);
                    syncGalleryInput();
                    renderGalleryPreviews();
                    updateGalleryCounter();
                    updateGalleryButtonState();
                });
            };

            reader.readAsDataURL(file);
        });
    };

    const updateGalleryButtonState = () => {
        if (!addGalleryButton) return;

        const isLimitReached = getCurrentTotalCount() >= galleryLimit;

        addGalleryButton.disabled = isLimitReached;
        addGalleryButton.classList.toggle("is-disabled", isLimitReached);

        if (galleryInputTrigger) {
            galleryInputTrigger.disabled = isLimitReached;
        }
    };

    const appendGalleryFiles = (fileList) => {
        const incomingFiles = Array.from(fileList || []);
        if (!incomingFiles.length) return;

        let remainingSlots = getRemainingSlots();

        if (remainingSlots <= 0) {
            updateGalleryButtonState();
            updateGalleryCounter();
            return;
        }

        for (const file of incomingFiles) {
            if (remainingSlots <= 0) {
                break;
            }

            galleryFiles.push(file);
            remainingSlots--;
        }

        syncGalleryInput();
        renderGalleryPreviews();
        updateGalleryCounter();
        updateGalleryButtonState();
    };

    addGalleryButton?.addEventListener("click", () => {
        if (getRemainingSlots() <= 0) return;
        galleryInputTrigger?.click();
    });

    galleryInputTrigger?.addEventListener("change", (event) => {
        appendGalleryFiles(event.target.files);
        event.target.value = "";
    });

    removeExistingCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            updateGalleryCounter();
            updateGalleryButtonState();
        });
    });

    updateGalleryCounter();
    updateGalleryButtonState();
});