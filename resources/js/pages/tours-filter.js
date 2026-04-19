document.addEventListener('DOMContentLoaded', function () {
    const dropdowns = document.querySelectorAll('[data-category-dropdown]');
    const navbar = document.querySelector('.site-header');

    if (!dropdowns.length) return;

    function closeDropdown(dropdown) {
        const trigger = dropdown.querySelector('[data-category-trigger]');
        const panel = dropdown.querySelector('[data-category-panel]');

        dropdown.classList.remove('is-open');

        if (trigger) {
            trigger.setAttribute('aria-expanded', 'false');
        }

        if (panel) {
            panel.hidden = true;
        }
    }

    function openDropdown(dropdown) {
        const trigger = dropdown.querySelector('[data-category-trigger]');
        const panel = dropdown.querySelector('[data-category-panel]');

        dropdown.classList.add('is-open');

        if (trigger) {
            trigger.setAttribute('aria-expanded', 'true');
        }

        if (panel) {
            panel.hidden = false;
        }
    }

    function closeAllDropdowns(except = null) {
        dropdowns.forEach((dropdown) => {
            if (dropdown !== except) {
                closeDropdown(dropdown);
            }
        });
    }

    dropdowns.forEach((dropdown) => {
        const form = dropdown.closest('form');
        const trigger = dropdown.querySelector('[data-category-trigger]');
        const input = dropdown.querySelector('[data-category-input]');
        const label = dropdown.querySelector('[data-category-label]');
        const options = dropdown.querySelectorAll('[data-category-option]');

        if (!form || !trigger || !input || !label || !options.length) return;

        trigger.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            const isOpen = dropdown.classList.contains('is-open');

            closeAllDropdowns(dropdown);

            if (isOpen) {
                closeDropdown(dropdown);
            } else {
                openDropdown(dropdown);
            }
        });

        options.forEach((option) => {
            option.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();

                const newValue = this.dataset.value || 'all';
                const newLabel = this.dataset.label || this.textContent.trim();
                const currentValue = input.value;

                input.value = newValue;
                label.textContent = newLabel;

                options.forEach((item) => item.classList.remove('is-active'));
                this.classList.add('is-active');

                closeDropdown(dropdown);

                if (currentValue !== newValue) {
                    if (typeof form.requestSubmit === 'function') {
                        form.requestSubmit();
                    } else {
                        form.submit();
                    }
                }
            });
        });
    });

    document.addEventListener('click', function (event) {
        dropdowns.forEach((dropdown) => {
            if (!dropdown.contains(event.target)) {
                closeDropdown(dropdown);
            }
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeAllDropdowns();
        }
    });

    if (navbar) {
        ['click', 'touchstart'].forEach((eventName) => {
            navbar.addEventListener(eventName, function () {
                closeAllDropdowns();
            }, { passive: true });
        });
    }

    window.addEventListener('scroll', function () {
        closeAllDropdowns();
    }, { passive: true });

    window.addEventListener('resize', function () {
        closeAllDropdowns();
    });
});