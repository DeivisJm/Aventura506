/* EEDIT TOURS TABS */
document.querySelectorAll(".admin-tab").forEach(tab => {

    tab.addEventListener("click", () => {

        document.querySelectorAll(".admin-tab").forEach(t => t.classList.remove("active"));
        document.querySelectorAll(".admin-tab-content").forEach(c => c.classList.remove("active"));

        tab.classList.add("active");

        document
            .getElementById(tab.dataset.tab)
            .classList.add("active");

    });

});

/*SCHEDULE ACTIVE TOGGLE Handles active / inactive*/
document.addEventListener("change", function (e) {

    if (!e.target.classList.contains("schedule-active-toggle")) return;

    const toggle = e.target;
    const scheduleId = toggle.dataset.id;

    const card = toggle.closest(".schedule-block");
    const label = card.querySelector(".schedule-status-text");

    fetch(`/admin/schedules/${scheduleId}/toggle`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            "Content-Type": "application/json"
        }
    })
        .then(response => response.json())
        .then(data => {

            if (data.active) {

                label.textContent = "Activo";
                label.classList.remove("inactive");
                label.classList.add("active");

                card.classList.remove("schedule-inactive");
                card.classList.add("schedule-active");

            } else {

                label.textContent = "Desactivado";
                label.classList.remove("active");
                label.classList.add("inactive");

                card.classList.remove("schedule-active");
                card.classList.add("schedule-inactive");

            }

        });

});
