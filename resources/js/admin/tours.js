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
       SMOOTH SCROLL AFTER PAGINATION
    =============================== */
    const paginationLinks = document.querySelectorAll(".custom-pagination a");

    paginationLinks.forEach((link) => {
        link.addEventListener("click", function () {
            sessionStorage.setItem("scrollTopAfterPagination", "true");
        });
    });

    if (sessionStorage.getItem("scrollTopAfterPagination")) {
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
        sessionStorage.removeItem("scrollTopAfterPagination");
    }

    /* ===============================
       TOUR POSITION UPDATE
    =============================== */
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");

    document.querySelectorAll(".tour-position-box").forEach(function (box) {
        const select = box.querySelector(".tour-position-select");
        const updateUrl = box.dataset.updateUrl;

        if (!select || !updateUrl) return;

        select.addEventListener("change", async function () {
            const selectedPosition = this.value;
            const originalValue = this.dataset.originalValue || this.defaultValue;

            this.disabled = true;
            box.classList.add("is-saving");

            try {
                const response = await fetch(updateUrl, {
                    method: "PATCH",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                        "X-Requested-With": "XMLHttpRequest",
                        Accept: "application/json",
                    },
                    body: JSON.stringify({
                        sort_order: selectedPosition,
                    }),
                });

                if (!response.ok) {
                    throw new Error("The position could not be updated.");
                }

                window.location.reload();
            } catch (error) {
                console.error(error);
                this.value = originalValue;
                alert("No se pudo actualizar la posición del tour.");
            } finally {
                this.disabled = false;
                box.classList.remove("is-saving");
            }
        });

        select.dataset.originalValue = select.value;
    });

    /* ===============================
       DELETE TOUR MODAL
    =============================== */
    const modal = document.getElementById("tour-delete-modal");
    const confirmButton = document.getElementById("tour-delete-modal-confirm");
    const description = document.getElementById("tour-delete-modal-description");

    if (!modal || !confirmButton || !description) return;

    let activeForm = null;

    const openModal = (form) => {
        activeForm = form;

        const tourName = form.dataset.tourName || "este tour";
        description.textContent = `Vas a eliminar "${tourName}" de forma permanente.`;

        modal.classList.add("is-open");
        modal.setAttribute("aria-hidden", "false");
        document.body.style.overflow = "hidden";
    };

    const closeModal = () => {
        modal.classList.remove("is-open");
        modal.setAttribute("aria-hidden", "true");
        document.body.style.overflow = "";
        activeForm = null;
    };

    document.querySelectorAll(".js-open-tour-delete-modal").forEach((button) => {
        button.addEventListener("click", () => {
            const form = button.closest(".js-delete-tour-form");
            if (form) {
                openModal(form);
            }
        });
    });

    modal.querySelectorAll("[data-tour-delete-modal-close]").forEach((element) => {
        element.addEventListener("click", closeModal);
    });

    confirmButton.addEventListener("click", () => {
        if (activeForm) {
            activeForm.submit();
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && modal.classList.contains("is-open")) {
            closeModal();
        }
    });
});