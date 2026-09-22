/**
 * Live "Schedule Summary" on the admin schedule editor: status pill follows the
 * publishing choice, capacity follows the chosen vessel, duration follows the
 * two time fields. Purely cosmetic — the server recomputes everything on save.
 */
document.querySelectorAll('form[data-schedule-form]').forEach((form) => {
    const status = form.querySelector('[data-summary-status]');
    const capacity = form.querySelector('[data-summary-capacity]');
    const duration = form.querySelector('[data-summary-duration]');
    const vessel = form.querySelector('select[name="vessel_id"]');
    const depart = form.querySelector('input[name="departure_time"]');
    const arrive = form.querySelector('input[name="arrival_time"]');

    let capacities = {};
    try {
        capacities = JSON.parse(form.dataset.vesselCapacities || '{}');
    } catch {
        capacities = {};
    }

    const minutes = (value) => {
        const [h, m] = (value || '').split(':').map(Number);
        return Number.isFinite(h) && Number.isFinite(m) ? h * 60 + m : null;
    };

    const render = () => {
        const draft = form.querySelector('input[name="publish"]:checked')?.value === 'draft';
        if (status) {
            status.textContent = draft ? 'Draft' : 'Active';
            status.classList.toggle('bg-[#ebeef0]', draft);
            status.classList.toggle('text-editorial-ink', draft);
            status.classList.toggle('bg-[#dcfce7]', !draft);
            status.classList.toggle('text-[#166534]', !draft);
        }

        if (capacity && vessel) {
            const cap = capacities[vessel.value];
            capacity.textContent = cap ? `${cap} pax` : '-- pax';
        }

        if (duration && depart && arrive) {
            const from = minutes(depart.value);
            const to = minutes(arrive.value);
            duration.textContent = from !== null && to !== null && to > from ? `${to - from} mins` : '-- mins';
        }
    };

    form.addEventListener('change', render);
    form.addEventListener('input', render);
    render();
});
