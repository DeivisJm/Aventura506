document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.password-toggle').forEach((button) => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-target');
            const input = document.getElementById(targetId);

            if (!input) return;

            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            const eyeIcon = button.querySelector('.password-icon-eye');
            const eyeOffIcon = button.querySelector('.password-icon-eye-off');

            if (eyeIcon && eyeOffIcon) {
                eyeIcon.classList.toggle('hidden', isPassword);
                eyeOffIcon.classList.toggle('hidden', !isPassword);
            }

            button.setAttribute('aria-pressed', isPassword ? 'true' : 'false');
        });
    });
});