document.addEventListener('DOMContentLoaded', () => {

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

        if (logo) {
            logo.src = isDark ? logo.dataset.dark : logo.dataset.light;
        }

        toggles.forEach(t => {
            if (!t.btn) return;
            t.sun?.classList.toggle('hidden', isDark);
            t.moon?.classList.toggle('hidden', !isDark);
        });

        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    };

    applyTheme(localStorage.getItem('theme') === 'dark');

    toggles.forEach(t => {
        if (!t.btn) return;
        t.btn.addEventListener('click', () => {
            applyTheme(!html.classList.contains('dark'));
        });
    });
});
