{{-- Figma node 1:9970 — admin Activity --}}
@extends('layouts.admin')

@section('title', 'Activity')

@section('admin-active', 'activity')

@section('content')
    <x-admin.listing
        heading="Activity"
        subtitle="Manage Balinese cultural tours, day passes, watersports, and photography packages."
        action="Add New Activity"
        :action-href="route('admin.activities.create')"
        :columns="['Activity Details', 'Category', 'Location', 'Price / Pax', 'Status', 'Total Sold', 'Actions']"
        summary="Showing 1 to 3 of 12 schedules">

        <x-slot:filters>
            <label class="relative block flex-1 min-w-[280px]">
                <span class="sr-only">Search activities</span>
                <input type="search" placeholder="Search by title, location or vendor..."
                       class="w-full rounded-[8px] border border-[#c0c7d3] bg-surface py-[10px] pl-[41px] pr-[17px] text-[16px] text-editorial-ink placeholder:text-editorial-meta focus:outline-2 focus:outline-editorial">
                <img src="{{ asset('images/icons/admin/table-search.svg') }}" alt=""
                     class="pointer-events-none absolute left-[12px] top-1/2 size-[18px] -translate-y-1/2">
            </label>

            <div class="flex flex-wrap items-center gap-[10px]">
                @foreach (['Cultural & Heritage', 'Status: All', 'Most Booked'] as $filter)
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
        </x-slot:filters>

        @foreach ($activities as $activity)
            <tr class="border-b border-[rgba(192,199,211,0.2)] last:border-b-0">
                <td class="px-[16px] py-[16px]">
                    <span class="flex items-center gap-[12px]">
                        <img src="{{ asset('images/'.$activity['image']) }}" alt=""
                             class="size-[48px] shrink-0 rounded-[8px] object-cover">
                        <span>
                            <span class="block text-[15px] font-semibold leading-[22px] text-editorial-ink">{{ $activity['name'] }}</span>
                            <span class="flex flex-wrap items-center gap-[8px] text-[13px] leading-[18px] text-editorial-meta">
                                <span class="text-[#ca8a04]">&#9733; {{ $activity['rating'] }}</span>
                                <span>{{ $activity['hours'] }}</span>
                                <span class="rounded-[4px] bg-[#f1f4f6] px-[6px] py-[1px]">{{ $activity['tag'] }}</span>
                            </span>
                        </span>
                    </span>
                </td>
                <td class="px-[16px] py-[16px]">
                    <span class="rounded-[6px] bg-[#f1f4f6] px-[10px] py-[6px] text-[13px] text-editorial-body">{{ $activity['category'] }}</span>
                </td>
                <td class="px-[16px] py-[16px] text-[14px] leading-[20px] text-editorial-body">{{ $activity['location'] }}</td>
                <td class="px-[16px] py-[16px]">
                    <span class="block text-[15px] font-semibold leading-[22px] text-editorial">{{ $activity['price'] }}</span>
                    <span class="block text-[13px] leading-[18px] text-editorial-meta">{{ $activity['unit'] }}</span>
                </td>
                <td class="px-[16px] py-[16px]"><x-admin.status :label="$activity['status']" :tone="$activity['tone']" /></td>
                <td class="px-[16px] py-[16px]">
                    <span class="block text-[15px] font-semibold leading-[22px] text-editorial-ink">{{ $activity['sold'] }}</span>
                    <span class="block text-[13px] leading-[18px] text-editorial-meta">pax</span>
                </td>
                <td class="px-[16px] py-[16px]"><x-admin.row-actions :label="$activity['name']" /></td>
            </tr>
        @endforeach
    </x-admin.listing>
@endsection
