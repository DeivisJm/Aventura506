/**
 * =====================================================
 * ACCOMMODATIONS PAGE INTERACTIONS
 * =====================================================
 * Handles the image slider behavior for accommodation cards.
 */

document.addEventListener("DOMContentLoaded", () => {
    const sliders = document.querySelectorAll("[data-slider]");

    sliders.forEach((slider) => {
        const track = slider.querySelector(".accommodation-slider-track");
        const slides = slider.querySelectorAll(".accommodation-slide");
        const prevBtn = slider.querySelector("[data-slider-prev]");
        const nextBtn = slider.querySelector("[data-slider-next]");
        const indicators = slider.querySelectorAll("[data-slide-to]");

        if (!track || slides.length <= 1) {
            return;
        }

        let currentIndex = 0;

        /**
         * Updates the current slide position and active indicator.
         */
        const updateSlider = () => {
            track.style.transform = `translateX(-${currentIndex * 100}%)`;

            indicators.forEach((indicator, index) => {
                indicator.classList.toggle("is-active", index === currentIndex);
            });
        };

        /**
         * Previous slide handler.
         */
        prevBtn?.addEventListener("click", () => {
            currentIndex = currentIndex === 0 ? slides.length - 1 : currentIndex - 1;
            updateSlider();
        });

        /**
         * Next slide handler.
         */
        nextBtn?.addEventListener("click", () => {
            currentIndex = currentIndex === slides.length - 1 ? 0 : currentIndex + 1;
            updateSlider();
        });

        /**
         * Direct slide navigation from indicators.
         */
        indicators.forEach((indicator) => {
            indicator.addEventListener("click", () => {
                currentIndex = Number(indicator.dataset.slideTo);
                updateSlider();
            });
        });

        /**
         * Touch swipe support for mobile devices.
         */
        let startX = 0;
        let endX = 0;

        slider.addEventListener(
            "touchstart",
            (event) => {
                startX = event.changedTouches[0].clientX;
            },
            { passive: true }
        );

        slider.addEventListener(
            "touchend",
            (event) => {
                endX = event.changedTouches[0].clientX;
                const diff = startX - endX;

                if (Math.abs(diff) < 40) {
                    return;
                }

                if (diff > 0) {
                    currentIndex = currentIndex === slides.length - 1 ? 0 : currentIndex + 1;
                } else {
                    currentIndex = currentIndex === 0 ? slides.length - 1 : currentIndex - 1;
                }

                updateSlider();
            },
            { passive: true }
        );

        updateSlider();
    });

    const filterToggle = document.querySelector("[data-filter-toggle]");
    const filterPanel = document.querySelector("[data-filter-panel]");
    const filterSummary = document.querySelector("[data-filter-summary]");
    const stepButtons = document.querySelectorAll(".accommodation-airbnb-stepper button");

    const updateSummary = () => {
        const guests = Number(document.querySelector('[data-input="guests"]')?.value || 0);
        const bedrooms = Number(document.querySelector('[data-input="bedrooms"]')?.value || 0);
        const beds = Number(document.querySelector('[data-input="beds"]')?.value || 0);
        const bathrooms = Number(document.querySelector('[data-input="bathrooms"]')?.value || 0);

        const parts = [];

        const summaryPlaceholder = filterSummary?.dataset.placeholder || "Select filters";
        const guestsLabel = filterSummary?.dataset.labelGuests || "guests";
        const bedroomsLabel = filterSummary?.dataset.labelBedrooms || "bedrooms";
        const bedsLabel = filterSummary?.dataset.labelBeds || "beds";
        const bathroomsLabel = filterSummary?.dataset.labelBathrooms || "bathrooms";

        if (guests > 0) parts.push(`${guests} ${guestsLabel}`);
        if (bedrooms > 0) parts.push(`${bedrooms} ${bedroomsLabel}`);
        if (beds > 0) parts.push(`${beds} ${bedsLabel}`);
        if (bathrooms > 0) parts.push(`${bathrooms} ${bathroomsLabel}`);

        filterSummary.textContent = parts.length ? parts.join(" · ") : summaryPlaceholder;
    };

    if (filterToggle && filterPanel) {
        const closeFilterPanel = () => {
            filterPanel.setAttribute("hidden", "");
            filterToggle.setAttribute("aria-expanded", "false");
        };

        filterToggle.addEventListener("click", () => {
            const isHidden = filterPanel.hasAttribute("hidden");

            if (isHidden) {
                filterPanel.removeAttribute("hidden");
                filterToggle.setAttribute("aria-expanded", "true");
            } else {
                closeFilterPanel();
            }
        });

        document.addEventListener("click", (event) => {
            if (!filterPanel.contains(event.target) && !filterToggle.contains(event.target)) {
                closeFilterPanel();
            }
        });

        window.addEventListener("resize", () => {
            if (!filterPanel.hasAttribute("hidden")) {
                closeFilterPanel();
            }
        });
        const navbar =
            document.querySelector(".site-header") ||
            document.querySelector(".navbar") ||
            document.querySelector("header");

        window.addEventListener(
            "scroll",
            () => {
                if (
                    window.innerWidth < 768 ||
                    !navbar ||
                    filterPanel.hasAttribute("hidden")
                ) {
                    return;
                }

                const navbarRect = navbar.getBoundingClientRect();
                const panelRect = filterPanel.getBoundingClientRect();

                const navbarIsOverPanel = navbarRect.bottom >= panelRect.top;

                if (navbarIsOverPanel) {
                    closeFilterPanel();
                }
            },
            { passive: true }
        );
    }

    stepButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const target = button.dataset.target;
            const action = button.dataset.action;
            const input = document.querySelector(`[data-input="${target}"]`);
            const value = document.querySelector(`[data-value="${target}"]`);

            if (!input || !value) return;

            let current = Number(input.value || 0);

            if (action === "plus") {
                current++;
            } else {
                current = Math.max(0, current - 1);
            }

            input.value = current;
            value.textContent = current;

            updateSummary();
        });
    });

    updateSummary();
});