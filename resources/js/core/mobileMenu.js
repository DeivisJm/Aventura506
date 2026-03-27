document.addEventListener('DOMContentLoaded', () => {

    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (!menuBtn || !mobileMenu) return;

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('open');
    });
});
document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.getElementById('mobile-account-toggle');
    const dropdown = document.getElementById('mobile-account-dropdown');
    const chevron = document.getElementById('mobile-account-chevron');

    if (!toggle || !dropdown) return;

    toggle.addEventListener('click', () => {
        const isHidden = dropdown.classList.contains('hidden');

        dropdown.classList.toggle('hidden');
        toggle.setAttribute('aria-expanded', isHidden ? 'true' : 'false');

        if (chevron) {
            chevron.classList.toggle('rotate-180', isHidden);
        }
    });
});