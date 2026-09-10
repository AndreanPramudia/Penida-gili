{{-- Figma node 1:9280 — admin Hotels --}}
@extends('layouts.admin')

@section('title', 'Hotels')

@section('admin-active', 'hotel')

@section('content')
    <x-admin.listing
        heading="Hotels"
        subtitle="Manage fastboat partner accommodations, island room inventories, and direct ticket packages."
        action="Add New Hotels"
        :action-href="route('admin.hotels.create')"
        panel-title="Registered Partner Accommodations"
        panel-badge="5 of 18 Active Listed"
        :columns="['Hotel / Resort', 'Location', 'Rating', 'Room Types', 'Starting Price / Night', 'Status', 'Bookings (mo)', 'Actions']"
        summary="Showing 1 to 3 of 12 schedules">

        <x-slot:toolbar>
            <div class="flex flex-wrap items-center gap-[12px]">
                <label class="relative block flex-1 min-w-[280px]">
                    <span class="sr-only">Search hotels</span>
                    <input type="search" placeholder="Search by hotel name, beach or area..."
                           class="w-full rounded-[8px] border border-[#c0c7d3] bg-surface py-[10px] pl-[41px] pr-[17px] text-[16px] text-editorial-ink placeholder:text-editorial-meta focus:outline-2 focus:outline-editorial">
                    <img src="{{ asset('images/icons/admin/table-search.svg') }}" alt=""
                         class="pointer-events-none absolute left-[12px] top-1/2 size-[18px] -translate-y-1/2">
                </label>

                @foreach (['Nusa Penida', 'All Star Ratings', 'Status: Active'] as $filter)
                    <label class="relative block">
                        <span class="sr-only">{{ $filter }}</span>
                        <select class="appearance-none rounded-[8px] border border-[#c0c7d3] bg-surface py-[9px] pl-[17px] pr-[44px] text-[16px] leading-[24px] text-editorial-ink focus:outline-2 focus:outline-editorial">
                            <option>{{ $filter }}</option>
                        </select>
                        <img src="{{ asset('images/icons/admin/chevron-down.svg') }}" alt=""
                             class="pointer-events-none absolute right-[12px] top-1/2 size-[20px] -translate-y-1/2">
                    </label>
                @endforeach
            </div>
        </x-slot:toolbar>

        @foreach ($hotels as $hotel)
            <tr class="border-b border-[rgba(192,199,211,0.2)] last:border-b-0">
                <td class="px-[16px] py-[16px]">
                    <span class="flex items-center gap-[12px]">
                        <img src="{{ asset('images/'.$hotel['image']) }}" alt="" class="size-[48px] shrink-0 rounded-[8px] object-cover">
                        <span>
                            <span class="block text-[15px] font-semibold leading-[22px] text-editorial-ink">{{ $hotel['name'] }}</span>
                            <span class="block text-[13px] leading-[18px] text-editorial">{{ $hotel['partner'] }}</span>
                        </span>
                    </span>
                </td>
                <td class="px-[16px] py-[16px] text-[14px] leading-[20px] text-editorial-body">{{ $hotel['location'] }}</td>
                <td class="px-[16px] py-[16px] text-[14px] leading-[20px]">
                    <span class="font-semibold text-[#ca8a04]">&#9733; {{ $hotel['rating'] }}</span>
                    <span class="text-editorial-meta">({{ $hotel['reviews'] }})</span>
                </td>
                <td class="px-[16px] py-[16px]">
                    <span class="rounded-[6px] bg-[#f1f4f6] px-[10px] py-[6px] text-[13px] text-editorial-body">{{ $hotel['rooms'] }}</span>
                </td>
                <td class="px-[16px] py-[16px]">
                    <span class="block text-[15px] font-semibold leading-[22px] text-editorial-ink">{{ $hotel['price'] }}</span>
                    <span class="block text-[13px] leading-[18px] text-editorial-meta">Excl. taxes</span>
                </td>
                <td class="px-[16px] py-[16px]"><x-admin.status :label="$hotel['status']" :tone="$hotel['tone']" /></td>
                <td class="px-[16px] py-[16px]">
                    <span class="block text-[15px] font-semibold leading-[22px] text-editorial-ink">{{ $hotel['bookings'] }}</span>
                    <span class="block text-[13px] leading-[18px] text-editorial">{{ $hotel['full'] }}</span>
                </td>
                <td class="px-[16px] py-[16px]"><x-admin.row-actions :label="$hotel['name']" /></td>
            </tr>
        @endforeach
    </x-admin.listing>
@endsection
