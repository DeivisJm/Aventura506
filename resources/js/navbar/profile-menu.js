document.addEventListener('DOMContentLoaded', () => {
    const wrapper = document.getElementById('profile-menu-wrapper');
    const button = document.getElementById('profile-menu-button');
    const dropdown = document.getElementById('profile-menu-dropdown');
    const chevron = document.getElementById('profile-menu-chevron');

    if (!wrapper || !button || !dropdown) return;

    const closeMenu = () => {
        dropdown.classList.add('hidden');
        button.setAttribute('aria-expanded', 'false');
        if (chevron) chevron.classList.remove('rotate-180');
    };

    const openMenu = () => {
        dropdown.classList.remove('hidden');
        button.setAttribute('aria-expanded', 'true');
        if (chevron) chevron.classList.add('rotate-180');
    };

    button.addEventListener('click', (event) => {
        event.stopPropagation();

        const isHidden = dropdown.classList.contains('hidden');
        if (isHidden) {
            openMenu();
        } else {
            closeMenu();
        }
    });

    document.addEventListener('click', (event) => {
        if (!wrapper.contains(event.target)) {
            closeMenu();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeMenu();
        }
    });
});