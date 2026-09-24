/**
 * Photo lightbox.
 *
 * Any element with `data-lightbox="<url>"` opens <dialog id="photo-lightbox">.
 * Controls that share a `data-lightbox-group` form a gallery: the arrows, the
 * counter and the ← / → keys page through it. A lone photo hides the arrows.
 * Escape and a backdrop click close the dialog (native <dialog> behaviour).
 */
const dialog = document.getElementById('photo-lightbox');

if (dialog && typeof dialog.showModal === 'function') {
    const image = dialog.querySelector('[data-lightbox-image]');
    const counter = dialog.querySelector('[data-lightbox-counter]');
    const prev = dialog.querySelector('[data-lightbox-prev]');
    const next = dialog.querySelector('[data-lightbox-next]');

    let slides = [];
    let index = 0;

    const show = (i) => {
        index = (i + slides.length) % slides.length;
        const slide = slides[index];

        image.src = slide.url;
        image.alt = slide.alt;

        const many = slides.length > 1;
        prev.hidden = ! many;
        next.hidden = ! many;
        counter.textContent = many ? `${index + 1} / ${slides.length}` : '';
    };

    const open = (trigger) => {
        const group = trigger.dataset.lightboxGroup;
        const peers = group
            ? [...document.querySelectorAll(`[data-lightbox-group="${group}"]`)]
            : [trigger];

        slides = peers.map((el) => ({ url: el.dataset.lightbox, alt: el.dataset.lightboxAlt ?? '' }));
        show(Math.max(0, peers.indexOf(trigger)));
        dialog.showModal();
    };

    document.querySelectorAll('[data-lightbox]').forEach((trigger) => {
        trigger.addEventListener('click', () => open(trigger));
    });

    prev.addEventListener('click', () => show(index - 1));
    next.addEventListener('click', () => show(index + 1));
    dialog.querySelector('[data-lightbox-close]').addEventListener('click', () => dialog.close());

    dialog.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft') {
            show(index - 1);
        } else if (event.key === 'ArrowRight') {
            show(index + 1);
        }
    });

    // A click that lands on the dialog itself (not the picture) is a backdrop click.
    dialog.addEventListener('click', (event) => {
        if (event.target === dialog) {
            dialog.close();
        }
    });

    dialog.addEventListener('close', () => { image.src = ''; });
}
