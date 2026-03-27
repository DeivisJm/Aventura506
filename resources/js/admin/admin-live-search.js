document.addEventListener("DOMContentLoaded", () => {
    const liveSearchConfigs = [
        {
            formId: "category-search-form",
            inputId: "category-search-input",
        },
        {
            formId: "company-search-form",
            inputId: "company-search-input",
        },
        {
            formId: "search-form",
            inputId: "search-input",
        },
    ];

    liveSearchConfigs.forEach(({ formId, inputId }) => {
        const form = document.getElementById(formId);
        const input = document.getElementById(inputId);

        if (!form || !input) return;

        let timeout = null;
        let lastValue = input.value.trim();

        input.addEventListener("input", () => {
            clearTimeout(timeout);

            timeout = setTimeout(() => {
                const currentValue = input.value.trim();

                if (currentValue === lastValue) return;

                lastValue = currentValue;
                form.submit();
            }, 350);
        });

        input.addEventListener("keydown", (event) => {
            if (event.key === "Enter") {
                event.preventDefault();
            }
        });
    });
});