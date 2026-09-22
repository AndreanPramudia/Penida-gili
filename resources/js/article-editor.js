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
        hidden.dispatchEvent(new Event('change'));
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
        counter.textContent = words.toLocaleString('en-US');
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
        root.querySelector('[data-cover-empty]')?.remove();
        if (name) {
            name.textContent = file.name;
        }
    });
});

// Figma 1:8059 sidebar: scheduled date reveal, live author signature, SEO counters,
// SERP preview and a rough SEO score; read time follows the word count.
const articleForm = document.querySelector('[data-article-form]');

if (articleForm) {
    const q = (sel) => articleForm.querySelector(sel);
    const value = (name) => q(`[name="${name}"]`)?.value.trim() ?? '';

    const scheduleAt = q('[data-schedule-at]');
    const syncStatus = () => {
        scheduleAt.hidden = q('input[name="status"]:checked')?.value !== 'scheduled';
    };
    articleForm.querySelectorAll('input[name="status"]').forEach((r) => r.addEventListener('change', syncStatus));

    const initials = (name) =>
        name.split(/\s+/).filter(Boolean).map((w) => w[0].toUpperCase()).slice(0, 2).join('') || 'PG';
    const syncAuthor = () => {
        const name = value('author_name');
        const role = value('author_role');
        q('[data-author-avatar]').textContent = initials(name);
        q('[data-author-signature]').textContent = (name || 'Author name') + (role ? ` - ${role}` : '');
    };
    ['author_name', 'author_role'].forEach((n) => q(`[name="${n}"]`).addEventListener('input', syncAuthor));

    const slugify = (text) => text.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    const syncSeo = () => {
        const title = value('title');
        const metaTitle = value('meta_title');
        const metaDescription = value('meta_description');
        const slug = value('slug') || slugify(title) || 'your-article';

        articleForm.querySelectorAll('[data-count-for]').forEach((el) => {
            el.textContent = value(el.dataset.countFor).length;
        });
        q('[data-serp-slug]').textContent = slug.length > 18 ? slug.slice(0, 18) + '…' : slug;
        q('[data-serp-title]').textContent = metaTitle || title || 'Article title';
        q('[data-serp-description]').textContent = metaDescription || value('excerpt') || 'Meta description preview appears here.';

        // Score: each SEO field filled within its ideal length earns points.
        let score = 0;
        if (title) score += 15;
        if (value('excerpt')) score += 10;
        if (metaTitle.length >= 30 && metaTitle.length <= 60) score += 25;
        else if (metaTitle) score += 10;
        if (metaDescription.length >= 100 && metaDescription.length <= 160) score += 25;
        else if (metaDescription) score += 10;
        if (value('meta_keywords')) score += 10;
        if (value('slug') || title) score += 5;
        if (q('[name="hero_alt"]').value.trim()) score += 10;
        q('[data-seo-score]').textContent = score;
    };
    ['title', 'excerpt', 'slug', 'meta_title', 'meta_description', 'hero_alt'].forEach((n) => q(`[name="${n}"]`).addEventListener('input', syncSeo));
    q('[data-keywords] input[type="hidden"]')?.addEventListener('change', syncSeo);
    syncSeo();

    const body = q('[name="body"]');
    const readTime = q('[data-read-time]');
    const syncReadTime = () => {
        const words = body.value.trim().split(/\s+/).filter(Boolean).length;
        readTime.textContent = Math.max(1, Math.ceil(words / 200));
    };
    body.addEventListener('input', syncReadTime);
    if (body.value.trim()) syncReadTime();
}
