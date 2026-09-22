{{-- Figma 1:9306 — hotel "Filters & Control Bar": search left; Destination, Star Rating and Status pills
     plus a reset button on the right. Selects submit on change, the search on Enter. --}}
@props(['action', 'filters' => [], 'destinations' => [], 'statuses' => []])

@php
    $pill = 'appearance-none rounded-[12px] border border-[rgba(192,199,211,0.5)] bg-[#f1f4f6] py-[7px] pr-[36px] text-[12px] leading-[16px] text-editorial-ink focus:outline-2 focus:outline-editorial';
    $chevron = 'pointer-events-none absolute right-[8px] top-1/2 size-[18px] -translate-y-1/2';
@endphp

<form action="{{ $action }}" method="get"
      class="flex flex-wrap items-center gap-[14px]">
    <label class="relative block min-w-[240px] flex-1">
        <span class="sr-only">Search</span>
        <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search by hotel name, beach or area..."
               class="w-full rounded-[12px] border border-[rgba(192,199,211,0.5)] bg-[#f1f4f6] py-[10px] pl-[41px] pr-[17px] text-[14px] text-editorial-ink placeholder:text-editorial-meta focus:outline-2 focus:outline-editorial">
        <img src="{{ asset('images/icons/admin/hotel/filter-search.svg') }}" alt="" class="pointer-events-none absolute left-[15px] top-1/2 size-[13.5px] -translate-y-1/2">
    </label>

    <div class="flex flex-wrap items-center gap-[12px]">
        {{-- Destination --}}
        <label class="relative block">
            <span class="sr-only">Filter by destination</span>
            <img src="{{ asset('images/icons/admin/hotel/filter-destination.svg') }}" alt="" class="pointer-events-none absolute left-[13px] top-1/2 h-[13.3px] w-[9.3px] -translate-y-1/2">
            <select name="destination" onchange="this.form.requestSubmit()" class="{{ $pill }} pl-[32px]">
                <option value="">All Destinations</option>
                @foreach ($destinations as $destination)
                    <option value="{{ $destination }}" @selected(($filters['destination'] ?? '') === $destination)>{{ $destination }}</option>
                @endforeach
            </select>
            <img src="{{ asset('images/icons/admin/hotel/filter-chevron.svg') }}" alt="" class="{{ $chevron }}">
        </label>

        {{-- Star rating --}}
        <label class="relative block">
            <span class="sr-only">Filter by star rating</span>
            <img src="{{ asset('images/icons/admin/hotel/filter-rating.svg') }}" alt="" class="pointer-events-none absolute left-[13px] top-1/2 h-[12.7px] w-[13.3px] -translate-y-1/2">
            <select name="stars" onchange="this.form.requestSubmit()" class="{{ $pill }} pl-[36px]">
                <option value="">All Star Ratings</option>
                @foreach ([5, 4, 3, 2, 1] as $stars)
                    <option value="{{ $stars }}" @selected((string) ($filters['stars'] ?? '') === (string) $stars)>{{ $stars }} Star{{ $stars > 1 ? 's' : '' }}</option>
                @endforeach
            </select>
            <img src="{{ asset('images/icons/admin/hotel/filter-chevron.svg') }}" alt="" class="{{ $chevron }}">
        </label>

        {{-- Status --}}
        <label class="relative block">
            <span class="sr-only">Filter by status</span>
            <img src="{{ asset('images/icons/admin/hotel/filter-status.svg') }}" alt="" class="pointer-events-none absolute left-[13px] top-1/2 h-[8px] w-[14.7px] -translate-y-1/2">
            <select name="status" onchange="this.form.requestSubmit()" class="{{ $pill }} pl-[38px]">
                <option value="">Status: All</option>
                @foreach ($statuses as $value => $label)
                    <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>Status: {{ $label }}</option>
                @endforeach
            </select>
            <img src="{{ asset('images/icons/admin/hotel/filter-chevron.svg') }}" alt="" class="{{ $chevron }}">
        </label>

        {{-- Reset --}}
        <a href="{{ $action }}" aria-label="Reset filters"
           class="flex size-[30px] items-center justify-center rounded-[12px] border border-[rgba(192,199,211,0.5)] transition-colors duration-300 hover:bg-[#f1f4f6]">
            <img src="{{ asset('images/icons/admin/hotel/filter-reset.svg') }}" alt="" class="h-[12.3px] w-[10.7px]">
        </a>
    </div>
</form>
