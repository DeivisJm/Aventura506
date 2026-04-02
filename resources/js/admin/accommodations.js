document.addEventListener("DOMContentLoaded", function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    document.querySelectorAll('.tour-position-box').forEach(function (box) {
        const select = box.querySelector('.tour-position-select');
        const updateUrl = box.dataset.updateUrl;

        if (!select || !updateUrl) return;

        select.addEventListener('change', async function () {
            const selectedPosition = this.value;
            const originalValue = this.dataset.originalValue || this.defaultValue;

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

                window.location.reload();

            } catch (error) {
                console.error(error);
                this.value = originalValue;
                alert('No se pudo actualizar la posición del hospedaje.');
            } finally {
                this.disabled = false;
                box.classList.remove('is-saving');
            }
        });

        select.dataset.originalValue = select.value;
    });
});