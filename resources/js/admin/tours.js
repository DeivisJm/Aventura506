document.addEventListener("DOMContentLoaded", function () {
    /* ===============================
       DATABASE SEARCH WITH AUTO SUBMIT
       Searches across all tours, not only the current page
    =============================== */

    const searchForm = document.getElementById("search-form");
    const searchInput = document.getElementById("search-input");

    if (searchForm && searchInput) {
        let searchTimeout;

        searchInput.addEventListener("input", function () {
            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(() => {
                searchForm.submit();
            }, 500);
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


    /* Read CSRF token once for all async position updates */
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    /* Bind every position selector on the current page */
    document.querySelectorAll('.tour-position-box').forEach(function (box) {

        const select = box.querySelector('.tour-position-select');
        const updateUrl = box.dataset.updateUrl;

        if (!select || !updateUrl) return;

        select.addEventListener('change', async function () {

            const selectedPosition = this.value;
            const originalValue = this.dataset.originalValue || this.defaultValue;

            /* Lock the selector while the request is in progress */
            this.disabled = true;
            box.classList.add('is-saving');

            try {
                const response = await fetch(updateUrl, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        sort_order: selectedPosition
                    })
                });

                if (!response.ok) {
                    throw new Error('The position could not be updated.');
                }

                const data = await response.json();

                /* Refresh the page so cards and pagination keep the correct order */
                window.location.reload();

            } catch (error) {
                console.error(error);

                /* Restore previous selection if save fails */
                this.value = originalValue;

                alert('No se pudo actualizar la posición del tour.');
            } finally {
                this.disabled = false;
                box.classList.remove('is-saving');
            }
        });

        /* Keep the current selected value as the fallback state */
        select.dataset.originalValue = select.value;
    });

});

