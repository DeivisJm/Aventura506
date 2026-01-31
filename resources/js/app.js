import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {

    /* =====================================================
       MOBILE MENU TOGGLE
    ===================================================== */
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    /* =====================================================
       SCROLL REVEAL (SCROLL-HERO)
    ===================================================== */
    const elements = document.querySelectorAll('.scroll-hero');

    if (elements.length) {
        const observer = new IntersectionObserver(
            (entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('show');
                        obs.unobserve(entry.target); // solo una vez
                    }
                });
            },
            {
                root: null,
                threshold: 0,
                rootMargin: '0px 0px -20% 0px',
            }
        );

        elements.forEach(el => observer.observe(el));
    }

    /* =====================================================
       THEME TOGGLE (DESKTOP + MOBILE) + LOGO SWITCH
    ===================================================== */
    const html = document.documentElement;
    const logo = document.getElementById('navbar-logo');

    const toggles = [
        {
            btn: document.getElementById('theme-toggle'),
            sun: document.getElementById('icon-sun'),
            moon: document.getElementById('icon-moon'),
        },
        {
            btn: document.getElementById('theme-toggle-mobile'),
            sun: document.getElementById('icon-sun-mobile'),
            moon: document.getElementById('icon-moon-mobile'),
        },
    ];

    const applyTheme = (isDark) => {
        html.classList.toggle('dark', isDark);

        // Logo switch
        if (logo) {
            logo.src = isDark ? logo.dataset.dark : logo.dataset.light;
        }

        // Icons switch (desktop + mobile)
        toggles.forEach(t => {
            if (!t.btn) return;
            t.sun.classList.toggle('hidden', isDark);
            t.moon.classList.toggle('hidden', !isDark);
        });

        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    };

    // Load saved theme
    applyTheme(localStorage.getItem('theme') === 'dark');

    // Click events
    toggles.forEach(t => {
        if (!t.btn) return;
        t.btn.addEventListener('click', () => {
            applyTheme(!html.classList.contains('dark'));
        });
    });

});
