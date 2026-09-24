/**
 * Console image uploader: drag-and-drop, large previews, and per-file removal.
 *
 * The <input type="file"> inside [data-uploader] stays the source of truth, so the
 * form still works with JavaScript disabled — this only adds feedback and editing.
 */
const humanSize = (bytes) => (bytes >= 1024 * 1024
    ? `${(bytes / 1024 / 1024).toFixed(1)} MB`
    : `${Math.max(1, Math.round(bytes / 1024))} KB`);

document.querySelectorAll('[data-uploader]').forEach((root) => {
    const input = root.querySelector('[data-uploader-input]');
    const drop = root.querySelector('[data-uploader-drop]');
    const preview = root.querySelector('[data-uploader-preview]');

    if (!input || !drop || !preview) {
        return;
    }

    /** Write a file list back into the input; DataTransfer is the only supported way. */
    const setFiles = (files) => {
        const bucket = new DataTransfer();
        files.forEach((file) => bucket.items.add(file));
        input.files = bucket.files;
        render();
    };

    const render = () => {
        preview.innerHTML = '';
        const files = [...(input.files ?? [])];
        preview.hidden = files.length === 0;

        files.forEach((file, index) => {
            const figure = document.createElement('figure');
            figure.className = 'group relative overflow-hidden rounded-[12px] border border-[rgba(192,199,211,0.4)] bg-white shadow-sm';

            const img = document.createElement('img');
            img.className = 'h-[200px] w-full object-cover';
            img.alt = file.name;
            img.src = URL.createObjectURL(file);
            img.addEventListener('load', () => URL.revokeObjectURL(img.src), { once: true });

            const remove = document.createElement('button');
            remove.type = 'button';
            remove.className = 'absolute right-[10px] top-[10px] flex size-[32px] items-center justify-center rounded-full bg-white/90 text-[18px] leading-none text-[#b91c1c] shadow-sm'
                + ' transition-colors hover:bg-[#fee2e2]';
            remove.setAttribute('aria-label', `Remove ${file.name}`);
            remove.textContent = '×';
            remove.addEventListener('click', () => setFiles(files.filter((_, i) => i !== index)));

            const caption = document.createElement('figcaption');
            caption.className = 'flex items-center justify-between gap-[10px] px-[12px] py-[10px] font-jakarta text-[13px] text-editorial-body';
            const name = document.createElement('span');
            name.className = 'truncate';
            name.textContent = file.name;
            const size = document.createElement('span');
            size.className = 'shrink-0 text-editorial-meta';
            size.textContent = humanSize(file.size);
            caption.append(name, size);

            figure.append(img, remove, caption);
            preview.appendChild(figure);
        });
    };

    input.addEventListener('change', render);

    ['dragenter', 'dragover'].forEach((type) => {
        drop.addEventListener(type, (event) => {
            event.preventDefault();
            drop.dataset.dragging = 'true';
        });
    });

    ['dragleave', 'drop'].forEach((type) => {
        drop.addEventListener(type, () => { delete drop.dataset.dragging; });
    });

    drop.addEventListener('drop', (event) => {
        event.preventDefault();

        const dropped = [...(event.dataTransfer?.files ?? [])].filter((file) => file.type.startsWith('image/'));

        if (dropped.length === 0) {
            return;
        }

        // Dropping adds to what is already selected when the input takes several files.
        setFiles(input.multiple ? [...(input.files ?? []), ...dropped] : dropped.slice(0, 1));
    });
});
