document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('register_username');
    const message = document.getElementById('username-availability-message');

    if (!input || !message) return;

    let timeout = null;

    const setErrorState = (show, text = '') => {
        message.textContent = text;
        message.classList.toggle('hidden', !show);
        input.classList.toggle('border-red-500', show);
        input.classList.toggle('dark:border-red-400', show);
    };

    input.addEventListener('input', () => {
        clearTimeout(timeout);

        const value = input.value.trim();
        const url = input.dataset.checkUrl;
        const errorText = input.dataset.errorText;

        if (value === '') {
            setErrorState(false);
            return;
        }

        timeout = setTimeout(async () => {
            try {
                const response = await fetch(`${url}?username=${encodeURIComponent(value)}`);
                const data = await response.json();

                if (data.exists) {
                    setErrorState(true, data.message || errorText);
                } else {
                    setErrorState(false);
                }
            } catch (error) {
                setErrorState(false);
            }
        }, 400);
    });
});