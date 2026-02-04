document.addEventListener('DOMContentLoaded', () => {

    const elements = document.querySelectorAll('.scroll-hero');
    if (!elements.length) return;

    const observer = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                    obs.unobserve(entry.target);
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
});
