document.addEventListener('DOMContentLoaded', () => {

    const html = document.documentElement;
    const logo = document.getElementById('navbar-logo');

    const desktopBtn = document.getElementById('theme-toggle');
    const mobileBtn  = document.getElementById('theme-toggle-mobile');

    const mobileMenu = document.getElementById('mobile-menu');

    const sunDesktop  = document.getElementById('icon-sun');
    const moonDesktop = document.getElementById('icon-moon');

    const sunMobile  = document.getElementById('icon-sun-mobile');
    const moonMobile = document.getElementById('icon-moon-mobile');

    function applyTheme(isDark) {
        html.classList.toggle('dark', isDark);
        localStorage.setItem('theme', isDark ? 'dark' : 'light');

        if (logo) {
            logo.src = isDark ? logo.dataset.dark : logo.dataset.light;
        }

        sunDesktop?.classList.toggle('hidden', isDark);
        moonDesktop?.classList.toggle('hidden', !isDark);

        sunMobile?.classList.toggle('hidden', isDark);
        moonMobile?.classList.toggle('hidden', !isDark);
    }

    applyTheme(localStorage.getItem('theme') === 'dark');

    desktopBtn?.addEventListener('click', () => {
        applyTheme(!html.classList.contains('dark'));
    });

    // 🔥 MOBILE: cambia tema + CIERRA MENÚ CON ANIMACIÓN
    mobileBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        applyTheme(!html.classList.contains('dark'));

        if (mobileMenu) {
            mobileMenu.classList.remove('open');
        }
    });
});
