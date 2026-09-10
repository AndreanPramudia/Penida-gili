/**
 * Number steppers on the order form (Figma 1:1986 / 1:2008).
 *
 * The − and + buttons sit inside the field; the input stays a real number
 * input so keyboard entry and form submission work without JavaScript.
 */
document.querySelectorAll('[data-stepper]').forEach((stepper) => {
    const input = stepper.querySelector('input');

    if (!input) {
        return;
    }

    stepper.querySelectorAll('[data-step]').forEach((button) => {
        button.addEventListener('click', () => {
            const min = Number(input.min || 0);
            const next = Number(input.value || 0) + Number(button.dataset.step);

            input.value = String(Math.max(min, next));
            input.dispatchEvent(new Event('change', { bubbles: true }));
        });
    });
});
