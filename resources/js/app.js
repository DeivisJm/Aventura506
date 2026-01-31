import './bootstrap';
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuBtn) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
// Scroll reveal effect
document.addEventListener("DOMContentLoaded", () => {

    const elements = document.querySelectorAll(".scroll-hero");

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("show");
                    observer.unobserve(entry.target); // solo una vez
                }
            });
        },
        {
            root: null,
            threshold: 0,
            // obliga a que el usuario baje para ver (quienes somos)
            rootMargin: "0px 0px -20% 0px"
        }
    );

    elements.forEach(el => observer.observe(el));
});


