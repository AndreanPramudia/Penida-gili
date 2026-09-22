/**
 * Admin article editor helpers (SEO keyword chips, live word count, body preview,
 * cover-image preview). Every control degrades to a plain form field without JS.
 */

// Keyword chips: typing then Enter / comma adds a chip; the hidden input carries
// the comma-separated list the request expects.
document.querySelectorAll('[data-keywords]').forEach((root) => {
    const hidden = root.querySelector('input[type="hidden"]');
    const entry = root.querySelector('input[type="text"]');
    const list = root.querySelector('[data-keywords-list]');
    let keywords = hidden.value.split(',').map((k) => k.trim()).filter(Boolean);

    const render = () => {
        hidden.value = keywords.join(', ');
        list.innerHTML = '';
        keywords.forEach((keyword, index) => {
            const chip = document.createElement('span');
            chip.className = 'flex items-center gap-[6px] rounded-full px-[10px] py-[4px] font-jakarta text-[13px] font-semibold ' + (root.dataset.chipClass || 'bg-editorial/10 text-editorial');
            chip.textContent = keyword;

            const remove = document.createElement('button');
            remove.type = 'button';
            remove.setAttribute('aria-label', `Remove ${keyword}`);
            remove.className = 'text-editorial-body hover:text-[#dc2626]';
            remove.textContent = '×';
            remove.addEventListener('click', () => {
                keywords.splice(index, 1);
                render();
            });

            chip.appendChild(remove);
            list.appendChild(chip);
        });
    };

    const commit = () => {
        const value = entry.value.replace(/,/g, '').trim();
        if (value && !keywords.includes(value)) {
            keywords.push(value);
        }
        entry.value = '';
        render();
    };

    entry.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' || event.key === ',') {
            event.preventDefault();
            commit();
        } else if (event.key === 'Backspace' && entry.value === '' && keywords.length) {
            keywords.pop();
            render();
        }
    });
    entry.addEventListener('blur', commit);

    render();
});

// Word count + preview for the article body.
document.querySelectorAll('[data-body-editor]').forEach((root) => {
    const textarea = root.querySelector('textarea');
    const counter = root.querySelector('[data-word-count]');
    const toggle = root.querySelector('[data-preview-toggle]');
    const preview = root.querySelector('[data-preview]');

    const count = () => {
        const words = textarea.value.trim().split(/\s+/).filter(Boolean).length;
        counter.textContent = `${words} ${words === 1 ? 'kata' : 'kata'}`;
    };

    textarea.addEventListener('input', count);
    count();

    toggle?.addEventListener('click', () => {
        const showing = !preview.hidden;
        if (showing) {
            preview.hidden = true;
            textarea.hidden = false;
            toggle.textContent = 'Pratinjau';
            return;
        }

        preview.innerHTML = '';
        textarea.value
            .split(/\n\s*\n/)
            .map((p) => p.trim())
            .filter(Boolean)
            .forEach((paragraph) => {
                const el = document.createElement('p');
                el.textContent = paragraph;
                preview.appendChild(el);
            });
        if (!preview.childElementCount) {
            const empty = document.createElement('p');
            empty.className = 'text-editorial-meta';
            empty.textContent = 'Belum ada isi artikel.';
            preview.appendChild(empty);
        }

        preview.hidden = false;
        textarea.hidden = true;
        toggle.textContent = 'Tulis';
    });
});

// Show the chosen cover image before upload.
document.querySelectorAll('[data-cover-picker]').forEach((root) => {
    const input = root.querySelector('input[type="file"]');
    const img = root.querySelector('[data-cover-preview]');
    const name = root.querySelector('[data-cover-name]');

    input.addEventListener('change', () => {
        const file = input.files?.[0];
        if (!file) {
            return;
        }
        img.src = URL.createObjectURL(file);
        img.hidden = false;
        if (name) {
            name.textContent = file.name;
        }
    });
});
