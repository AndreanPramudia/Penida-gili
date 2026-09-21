/**
 * Review step before the order form posts.
 *
 * Every form with `data-confirm` gets intercepted on submit; the dialog lists
 * the product rows from the server plus what the guest typed and the live
 * total, then "Confirm & book" performs the real submission.
 */
const dialog = document.getElementById('booking-confirm');

if (dialog && typeof dialog.showModal === 'function') {
    const rowsEl = dialog.querySelector('[data-confirm-rows]');
    let pending = null;

    const row = (label, value, accent = false) => `
        <div class="flex items-start justify-between gap-[16px]">
            <dt class="shrink-0 text-editorial-body">${label}</dt>
            <dd class="text-right ${accent ? 'text-[18px] font-bold text-brand' : 'font-semibold text-editorial-ink'}">${value}</dd>
        </div>`;

    const esc = (s) => String(s).replace(/[&<>"]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));
    const val = (form, name) => form.querySelector(`[name="${name}"]`)?.value?.trim() ?? '';
    const plural = (n, one, many) => `${n} ${n === 1 ? one : many}`;

    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (form.dataset.confirmed === '1') {
                return;
            }

            event.preventDefault();

            let staticRows = [];
            try {
                staticRows = JSON.parse(form.dataset.confirm);
            } catch {
                /* no static rows */
            }

            const adults = Number(val(form, 'adults')) || 1;
            const children = Number(val(form, 'children')) || 0;
            const rooms = Number(val(form, 'rooms')) || 0;
            const guests = [plural(adults, 'adult', 'adults'), children ? plural(children, 'child', 'children') : null, rooms ? plural(rooms, 'room', 'rooms') : null]
                .filter(Boolean)
                .join(' · ');

            const total = form.querySelector('[data-quote-total]:not([data-quote-total="button"])')?.textContent
                ?? document.querySelector('[data-quote-total]:not([data-quote-total="button"])')?.textContent
                ?? '';

            rowsEl.innerHTML = [
                ...staticRows.map((r) => row(esc(r.label), esc(r.value))),
                row('Guests', esc(guests)),
                row('Full name', esc(val(form, 'full_name'))),
                row('Email', esc(val(form, 'email'))),
                row('Phone', esc(`${val(form, 'dial_code')} ${val(form, 'phone')}`)),
                row('Nationality', esc(val(form, 'nationality'))),
                val(form, 'notes') ? row('Notes', esc(val(form, 'notes'))) : '',
                row('Total', esc(total.trim()), true),
            ].join('');

            pending = form;
            dialog.showModal();
        });
    });

    /**
     * "Book With Email": compose the Gmail draft from whatever the guest has
     * typed so far, so the message arrives with their details filled in.
     */
    document.querySelectorAll('[data-email-book]').forEach((link) => {
        link.addEventListener('click', (event) => {
            const form = link.closest('form[data-email]') || document.querySelector('form[data-email]');
            if (!form) {
                return;
            }

            let staticRows = [];
            try {
                staticRows = JSON.parse(form.dataset.confirm || '[]');
            } catch {
                /* keep the server-rendered link */
            }

            const adults = Number(val(form, 'adults')) || 1;
            const children = Number(val(form, 'children')) || 0;
            const rooms = Number(val(form, 'rooms')) || 0;
            const total = (form.querySelector('[data-quote-total]:not([data-quote-total="button"])')
                ?? document.querySelector('[data-quote-total]:not([data-quote-total="button"])'))?.textContent.trim() ?? '';

            const body = [
                'Hi Penida Gili, I would like to book the following:',
                '',
                ...staticRows.map((r) => `${r.label}: ${r.value}`),
                `Guests: ${plural(adults, 'adult', 'adults')}${children ? `, ${plural(children, 'child', 'children')}` : ''}${rooms ? `, ${plural(rooms, 'room', 'rooms')}` : ''}`,
                `Total: ${total}`,
                '',
                `Full Name: ${val(form, 'full_name')}`,
                `Email Address: ${val(form, 'email')}`,
                `Nationality: ${val(form, 'nationality')}`,
                `Phone Number: ${val(form, 'dial_code')} ${val(form, 'phone')}`.trim(),
                `Order Notes: ${val(form, 'notes')}`,
            ].join('\n');

            const subject = `Booking request — ${staticRows[0]?.value ?? 'Penida Gili'}`;

            event.preventDefault();
            window.open(
                `https://mail.google.com/mail/?view=cm&fs=1&to=${encodeURIComponent(form.dataset.email)}&su=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`,
                '_blank',
                'noopener',
            );
        });
    });

    dialog.querySelector('[data-confirm-cancel]').addEventListener('click', () => dialog.close());
    dialog.addEventListener('close', () => { pending = null; });

    dialog.querySelector('[data-confirm-submit]').addEventListener('click', () => {
        if (!pending) {
            return;
        }

        const form = pending;
        form.dataset.confirmed = '1';
        dialog.close();
        form.requestSubmit();
    });
}
