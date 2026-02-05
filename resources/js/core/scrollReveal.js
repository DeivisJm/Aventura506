// Scroll Reveal global
document.addEventListener('DOMContentLoaded', () => {

    const elements = document.querySelectorAll('.scroll-hero');

    if (!elements.length) return;

    const observer = new IntersectionObserver(
        entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.15 }
    );

    elements.forEach(el => observer.observe(el));

    // 👇 disponible para elementos dinámicos (cards, etc.)
    window.scrollObserver = observer;
});
