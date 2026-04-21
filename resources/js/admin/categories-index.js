document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("category-disable-modal");
    if (!modal) return;

    const modalForm = document.getElementById("category-disable-modal-form");
    const modalName = document.getElementById("category-disable-modal-name");
    const modalCount = document.getElementById("category-disable-modal-count");
    const closeButtons = modal.querySelectorAll("[data-category-modal-close]");

    function openModal(action, name, count) {
        if (!modalForm) return;

        modalForm.setAttribute("action", action || "");
        if (modalName) modalName.textContent = name || "—";
        if (modalCount) modalCount.textContent = count || "0";

        modal.classList.add("is-open");
        modal.setAttribute("aria-hidden", "false");
        document.body.classList.add("overflow-hidden");
    }

    function closeModal() {
        modal.classList.remove("is-open");
        modal.setAttribute("aria-hidden", "true");
        document.body.classList.remove("overflow-hidden");
    }

    document.addEventListener("click", (event) => {
        const trigger = event.target.closest(".js-category-disable-modal-trigger");

        if (trigger) {
            event.preventDefault();

            openModal(
                trigger.dataset.categoryAction,
                trigger.dataset.categoryName,
                trigger.dataset.categoryTours
            );
            return;
        }

        const closeButton = event.target.closest("[data-category-modal-close]");
        if (closeButton) {
            closeModal();
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && modal.classList.contains("is-open")) {
            closeModal();
        }
    });
});