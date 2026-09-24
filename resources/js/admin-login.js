/**
 * Password visibility toggle on the admin sign-in form.
 *
 * The eye button lives inside [data-password-field]; without JavaScript the
 * field simply stays masked, which is the safe default.
 */
document.querySelectorAll('[data-password-field]').forEach((field) => {
    const input = field.querySelector('input');
    const toggle = field.querySelector('[data-password-toggle]');

    if (!input || !toggle) {
        return;
    }

    toggle.addEventListener('click', () => {
        const showing = input.type === 'text';

        input.type = showing ? 'password' : 'text';
        toggle.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
        input.focus({ preventScroll: true });
    });
});
