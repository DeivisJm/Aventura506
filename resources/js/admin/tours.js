document.addEventListener("DOMContentLoaded", function () {

    /* ===============================
       BUSCADOR EN TIEMPO REAL
    =============================== */

    const input = document.getElementById("search-input");
    const cards = document.querySelectorAll(".tour-card");

    function normalize(text) {
        return text
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "");
    }

    if (input) {
        input.addEventListener("input", function () {

            let value = normalize(this.value.trim());

            cards.forEach(card => {

                let title = normalize(card.dataset.name);

                if (title.includes(value)) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }

            });

        });
    }

    /* ===============================
       SCROLL SUAVE PAGINACIÓN
    =============================== */

    const paginationLinks = document.querySelectorAll('.custom-pagination a');

    paginationLinks.forEach(link => {
        link.addEventListener('click', function () {
            sessionStorage.setItem('scrollTopAfterPagination', 'true');
        });
    });

    if (sessionStorage.getItem('scrollTopAfterPagination')) {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
        sessionStorage.removeItem('scrollTopAfterPagination');
    }

});