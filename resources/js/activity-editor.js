/**
 * Admin activity editor helpers (Figma 1:8502): select-all days, the
 * scheduled "go live" field, dual-tier pricing, the discount hint and the
 * media counter. Inclusion chips reuse the [data-keywords] behaviour.
 */
const form = document.querySelector('[data-activity-form]');

if (form) {
    const days = Array.from(form.querySelectorAll('input[name="days[]"]'));
    form.querySelector('[data-select-all-days]')?.addEventListener('click', () => {
        const all = days.every((day) => day.checked);
        days.forEach((day) => (day.checked = !all));
    });

    const publishAt = form.querySelector('[data-publish-at]');
    const syncStatus = () => {
        const current = form.querySelector('input[name="status"]:checked')?.value;
        publishAt.hidden = current !== 'scheduled';
    };
    form.querySelectorAll('input[name="status"]').forEach((radio) => radio.addEventListener('change', syncStatus));

    // "Displays 50% discount badge to customers" — derived from base vs strikethrough price.
    const base = form.querySelector('input[name="price_adult"]');
    const was = form.querySelector('input[name="price_was"]');
    const note = form.querySelector('[data-discount-note]');
    const digits = (input) => Number((input.value || '').replace(/\D/g, ''));
    const syncDiscount = () => {
        const b = digits(base);
        const w = digits(was);
        const show = w > 0 && b > 0 && w > b;
        note.hidden = !show;
        if (show) {
            note.textContent = `Displays ${Math.round((1 - b / w) * 100)}% discount badge to customers`;
        }
    };
    [base, was].forEach((input) => input.addEventListener('input', syncDiscount));

    // Cover preview + picked-file feedback for the drop zone.
    const cover = form.querySelector('[data-cover-input]');
    cover?.addEventListener('change', () => {
        const file = cover.files?.[0];
        if (!file) return;
        const img = form.querySelector('[data-cover-preview]');
        img.src = URL.createObjectURL(file);
        img.hidden = false;
        form.querySelector('[data-cover-empty]')?.remove();
    });

    const gallery = form.querySelector('[data-gallery-input]');
    gallery?.addEventListener('change', () => {
        const count = gallery.files?.length || 0;
        form.querySelector('[data-gallery-picked]').textContent = count ? `${count} photo${count > 1 ? 's' : ''} selected` : '';
    });
}
