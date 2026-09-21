/**
 * Confirmation step for visitor forms.
 *
 * Forms opt in with `data-confirm="booking"` or `data-confirm="newsletter"`.
 * On submit the native validation runs first; if the form is valid the
 * <dialog id="confirm-modal"> lists what the visitor typed and only a click on
 * "Confirm & send" lets the request through. Without JavaScript (or without
 * <dialog> support) the form submits as usual.
 */
const modal = document.getElementById('confirm-modal');

if (modal && typeof modal.showModal === 'function') {
    const title = modal.querySelector('[data-confirm-title]');
    const intro = modal.querySelector('[data-confirm-intro]');
    const rows = modal.querySelector('[data-confirm-rows]');
    const accept = modal.querySelector('[data-confirm-accept]');

    const COPY = {
        booking: {
            title: 'Confirm your booking',
            intro: 'Please double-check your details before we send the reservation.',
            accept: 'Confirm & book',
        },
        newsletter: {
            title: 'Join the newsletter?',
            intro: 'We will send island guides and ticket deals to this address.',
            accept: 'Confirm & subscribe',
        },
    };

    const text = (form, name) => form.querySelector(`[name="${name}"]`)?.value?.trim() ?? '';
    const selectedLabel = (form, name) => {
        const select = form.querySelector(`select[name="${name}"]`);
        return select ? select.options[select.selectedIndex]?.text?.trim() ?? '' : text(form, name);
    };
    const longDate = (value) => {
        if (!value) return '';
        const date = new Date(`${value}T00:00:00`);
        return Number.isNaN(date.getTime())
            ? value
            : date.toLocaleDateString('en-GB', { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric' });
    };
    const plural = (n, one, many) => `${n} ${n === 1 ? one : many}`;

    /** @returns {Array<[string, string, string?]>} label, value, optional tag pill, optional plain suffix */
    const bookingRows = (form) => {
        const list = [];
        const product = form.dataset.confirmProduct || document.querySelector('main h1')?.textContent?.trim();
        if (product) list.push(['Booking', product]);

        const travel = text(form, 'travel_date');
        const checkOut = text(form, 'check_out');
        if (travel && checkOut) list.push(['Stay', `${longDate(travel)} → ${longDate(checkOut)}`]);
        else if (travel) list.push(['Date', longDate(travel)]);

        const adults = Number(text(form, 'adults') || 0);
        const children = Number(text(form, 'children') || 0);
        const rooms = Number(text(form, 'rooms') || 0);
        if (adults) {
            // "2 adults (+1 child) · 1 room" — the child count is a tag so the adult count stays the headline.
            list.push([
                'Guests',
                plural(adults, 'adult', 'adults'),
                children ? `+${plural(children, 'child', 'children')}` : '',
                rooms ? ` · ${plural(rooms, 'room', 'rooms')}` : '',
            ]);
        }

        list.push(['Full name', text(form, 'full_name')]);
        list.push(['Email', text(form, 'email')]);
        list.push(['Phone', `${text(form, 'dial_code') || '+62'} ${text(form, 'phone')}`.trim()]);
        list.push(['Nationality', selectedLabel(form, 'nationality')]);

        const notes = text(form, 'notes');
        if (notes) list.push(['Notes', notes]);

        const total = form.querySelector('[data-quote-total]:not([data-quote-total="button"])')?.textContent?.trim()
            || document.querySelector('[data-quote-total]:not([data-quote-total="button"])')?.textContent?.trim();
        if (total) list.push(['Total', total]);

        return list.filter(([, value]) => value);
    };

    const newsletterRows = (form) => [['Email', text(form, 'email')]];

    const render = (kind, form) => {
        const copy = COPY[kind] ?? COPY.booking;
        title.textContent = copy.title;
        intro.textContent = copy.intro;
        accept.textContent = copy.accept;

        rows.innerHTML = '';
        (kind === 'newsletter' ? newsletterRows(form) : bookingRows(form)).forEach(([label, value, tag, suffix]) => {
            const row = document.createElement('div');
            row.className = 'flex items-start justify-between gap-[16px]';
            const dt = document.createElement('dt');
            dt.className = 'shrink-0 text-[#717782]';
            dt.textContent = label;
            const dd = document.createElement('dd');
            dd.className = label === 'Total'
                ? 'text-right text-[16px] font-bold text-brand'
                : 'text-right font-semibold text-[#181c1e] [overflow-wrap:anywhere]';
            dd.textContent = value;
            if (tag) {
                const pill = document.createElement('span');
                pill.className = 'ml-[6px] inline-block rounded-full bg-[#d2e4ff] px-[8px] py-[1px] align-[1px] text-[12px] font-semibold leading-[18px] text-[#005ea1]';
                pill.textContent = `(${tag})`;
                dd.appendChild(pill);
            }
            if (suffix) {
                dd.appendChild(document.createTextNode(suffix));
            }
            row.append(dt, dd);
            rows.appendChild(row);
        });
    };

    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        let confirmed = false;

        form.addEventListener('submit', (event) => {
            if (confirmed) {
                // Second pass after "Confirm": let it go, but block double clicks.
                form.querySelectorAll('button[type="submit"]').forEach((b) => { b.disabled = true; });
                return;
            }

            if (!form.checkValidity()) {
                return; // browser shows its own field messages
            }

            event.preventDefault();
            render(form.dataset.confirm, form);

            modal.onclose = () => {
                if (modal.returnValue === 'confirm') {
                    confirmed = true;
                    form.requestSubmit();
                }
                modal.returnValue = '';
            };

            modal.showModal();
        });
    });
}
