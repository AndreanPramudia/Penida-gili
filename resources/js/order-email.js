/**
 * "Book With Email" — open a Gmail draft pre-filled with what the guest has
 * typed on the order form, so nothing has to be retyped. A plain mailto: is
 * silently ignored on devices without a default mail client, hence the web
 * composer. The server-rendered href stays as the no-JavaScript fallback.
 */
const text = (form, name) => form.querySelector(`[name="${name}"]`)?.value?.trim() ?? '';

const selectedLabel = (form, name) => {
    const select = form.querySelector(`select[name="${name}"]`);

    return select ? select.options[select.selectedIndex]?.text?.trim() ?? '' : text(form, name);
};

const plural = (n, one, many) => `${n} ${n === 1 ? one : many}`;

const longDate = (value) => {
    if (!value) {
        return '';
    }

    const date = new Date(`${value}T00:00:00`);

    return Number.isNaN(date.getTime())
        ? value
        : date.toLocaleDateString('en-GB', { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric' });
};

document.querySelectorAll('[data-email-book]').forEach((link) => {
    link.addEventListener('click', (event) => {
        const form = link.closest('form[data-email]') ?? document.querySelector('form[data-email]');

        if (!form) {
            return; // fall back to the href rendered by BookingQuote
        }

        const product = form.dataset.confirmProduct || document.querySelector('main h1')?.textContent?.trim() || 'Penida Gili';
        const travel = text(form, 'travel_date');
        const checkOut = text(form, 'check_out');
        const adults = Number(text(form, 'adults')) || 1;
        const children = Number(text(form, 'children')) || 0;
        const rooms = Number(text(form, 'rooms')) || 0;
        const total = (form.querySelector('[data-quote-total]:not([data-quote-total="button"])')
            ?? document.querySelector('[data-quote-total]:not([data-quote-total="button"])'))?.textContent?.trim() ?? '';

        const body = [
            'Hi Penida Gili, I would like to book the following:',
            '',
            `Booking: ${product}`,
            checkOut ? `Stay: ${longDate(travel)} → ${longDate(checkOut)}` : `Date: ${longDate(travel)}`,
            `Guests: ${plural(adults, 'adult', 'adults')}${children ? `, ${plural(children, 'child', 'children')}` : ''}${rooms ? `, ${plural(rooms, 'room', 'rooms')}` : ''}`,
            `Total: ${total}`,
            '',
            `Full Name: ${text(form, 'full_name')}`,
            `Email Address: ${text(form, 'email')}`,
            `Nationality: ${selectedLabel(form, 'nationality')}`,
            `Phone Number: ${`${text(form, 'dial_code') || '+62'} ${text(form, 'phone')}`.trim()}`,
            `Order Notes: ${text(form, 'notes')}`,
        ].join('\n');

        event.preventDefault();
        window.open(
            `https://mail.google.com/mail/?view=cm&fs=1&to=${encodeURIComponent(form.dataset.email)}`
                + `&su=${encodeURIComponent(`Booking request — ${product}`)}&body=${encodeURIComponent(body)}`,
            '_blank',
            'noopener',
        );
    });
});
