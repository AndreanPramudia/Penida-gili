{{-- Search + status filter toolbar shared by the console listings (Figma 1:6928): search on the left,
     status dropdown pinned right. Submits as GET (Enter in the search box, or changing the status). --}}
@props(['action', 'filters' => [], 'statuses' => [], 'placeholder' => 'Search...'])

<form action="{{ $action }}" method="get" class="flex flex-wrap items-center gap-[16px]">
    <label class="relative block w-[384px] max-w-full">
        <span class="sr-only">Search</span>
        <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="{{ $placeholder }}"
               class="w-full rounded-[8px] border border-[#c0c7d3] bg-surface py-[10px] pl-[41px] pr-[17px] text-[16px] text-editorial-ink placeholder:text-editorial-meta focus:outline-2 focus:outline-editorial">
        <img src="{{ asset('images/icons/admin/table-search.svg') }}" alt=""
             class="pointer-events-none absolute left-[12px] top-1/2 size-[18px] -translate-y-1/2">
    </label>

    @if ($statuses)
        <label class="relative ml-auto block">
            <span class="sr-only">Filter by status</span>
            <select name="status" onchange="this.form.requestSubmit()"
                    class="appearance-none rounded-[8px] border border-[#c0c7d3] bg-surface py-[9px] pl-[17px] pr-[44px] text-[16px] leading-[24px] text-editorial-ink focus:outline-2 focus:outline-editorial">
                <option value="">All Statuses</option>
                @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <img src="{{ asset('images/icons/admin/chevron-down.svg') }}" alt=""
                 class="pointer-events-none absolute right-[12px] top-1/2 size-[20px] -translate-y-1/2">
        </label>
    @endif

    {{ $slot }}
</form>
