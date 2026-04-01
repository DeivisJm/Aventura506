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
});