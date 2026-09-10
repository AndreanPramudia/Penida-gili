{{-- Figma 1:9017 / 1:10402 toolbar — route search, boat select, date, Filter. --}}
<div class="grid [&>*]:min-w-0 gap-[16px] md:grid-cols-[1fr_1fr_1fr_auto] md:items-end">
    <label class="block">
        <span class="block pb-[8px] text-[14px] text-editorial-body">Search Route</span>
        <span class="relative block">
            <input type="search" placeholder="e.g. Sanur to Nusa Penida"
                   class="w-full rounded-[8px] border border-[#c0c7d3] bg-surface py-[10px] pl-[41px] pr-[17px] text-[16px] text-editorial-ink placeholder:text-editorial-meta focus:outline-2 focus:outline-editorial">
            <img src="{{ asset('images/icons/admin/table-search.svg') }}" alt=""
                 class="pointer-events-none absolute left-[12px] top-1/2 size-[18px] -translate-y-1/2">
        </span>
    </label>

    <label class="block">
        <span class="block pb-[8px] text-[14px] text-editorial-body">Boat</span>
        <span class="relative block">
            <select class="w-full appearance-none rounded-[8px] border border-[#c0c7d3] bg-surface py-[11px] pl-[17px] pr-[44px] text-[16px] leading-[24px] text-editorial-ink focus:outline-2 focus:outline-editorial">
                <option>All Boat</option>
                <option>Sanjaya Ocean Queen</option>
                <option>Sanjaya Express II</option>
                <option>Sanjaya Explorer</option>
            </select>
            <img src="{{ asset('images/icons/admin/chevron-down.svg') }}" alt=""
                 class="pointer-events-none absolute right-[12px] top-1/2 size-[20px] -translate-y-1/2">
        </span>
    </label>

    <label class="block">
        <span class="block pb-[8px] text-[14px] text-editorial-body">Date</span>
        <input type="date"
               class="w-full rounded-[8px] border border-[#c0c7d3] bg-surface px-[17px] py-[10px] text-[16px] text-editorial-ink focus:outline-2 focus:outline-editorial">
    </label>

    <button type="button"
            class="h-[46px] rounded-[8px] border border-[#c0c7d3] bg-surface px-[24px] text-[16px] text-editorial-ink transition-colors duration-300 hover:bg-[#f1f4f6]">
        Filter
    </button>
</div>
