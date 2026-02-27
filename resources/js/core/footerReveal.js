export function initFooterReveal() {
    const footer = document.getElementById("footer-content");
    if (!footer) return;

    // Agregamos estado inicial desde JS (no desde HTML)
    footer.style.opacity = "0";
    footer.style.transform = "translateY(40px)";
    footer.style.transition = "all 0.8s ease";

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                footer.style.opacity = "1";
                footer.style.transform = "translateY(0)";
            }
        });
    }, { threshold: 0.2 });

    observer.observe(footer);
}