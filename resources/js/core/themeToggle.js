document.addEventListener('DOMContentLoaded', () => {

    const html = document.documentElement;

    const desktopBtn = document.getElementById('theme-toggle');
    const mobileBtn = document.getElementById('theme-toggle-mobile');

    const mobileMenu = document.getElementById('mobile-menu');

    const sunDesktop = document.getElementById('icon-sun');
    const moonDesktop = document.getElementById('icon-moon');

    const sunMobile = document.getElementById('icon-sun-mobile');
    const moonMobile = document.getElementById('icon-moon-mobile');

    /**
     * Apply theme and update UI elements
     * @param {boolean} isDark
     */
    function applyTheme(isDark) {

        // Toggle dark class on <html>
        html.classList.toggle('dark', isDark);

        // Persist theme in localStorage
        localStorage.setItem('theme', isDark ? 'dark' : 'light');

        // 🔥 Update ALL logos that support theme switching
        document.querySelectorAll('[data-light]').forEach(logo => {
            logo.src = isDark ? logo.dataset.dark : logo.dataset.light;
        });

        // Toggle desktop icons
        sunDesktop?.classList.toggle('hidden', isDark);
        moonDesktop?.classList.toggle('hidden', !isDark);

        // Toggle mobile icons
        sunMobile?.classList.toggle('hidden', isDark);
        moonMobile?.classList.toggle('hidden', !isDark);
    }

    // Initialize theme on page load
    const savedTheme = localStorage.getItem('theme');
    applyTheme(savedTheme === 'dark');

    // Desktop toggle
    desktopBtn?.addEventListener('click', () => {
        applyTheme(!html.classList.contains('dark'));
    });

    // Mobile toggle (also closes mobile menu)
    mobileBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        applyTheme(!html.classList.contains('dark'));

        if (mobileMenu) {
            mobileMenu.classList.remove('open');
        }
    });

});