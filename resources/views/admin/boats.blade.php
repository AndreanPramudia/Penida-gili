{{-- Figma node 1:6901 — admin Boat --}}
@extends('layouts.admin')

@section('title', 'Boat')

@section('admin-active', 'boat')

@section('content')
    <x-admin.listing
        heading="Boat"
        subtitle="Overview of all active vessels, maintenance status, and capacity metrics for Boat Booking."
        action="Add New Boat"
        :action-href="route('admin.boats.create')"
        :columns="['Boat Name', 'Type', 'Capacity', 'Status', 'Last Inspected', 'Actions']"
        summary="Showing 1 to 3 of 12 schedules">

        <x-slot:filters>
            <label class="relative block w-[384px] max-w-full">
                <span class="sr-only">Search boats</span>
                <input type="search" placeholder="Search by boat name or ID..."
                       class="w-full rounded-[8px] border border-[#c0c7d3] bg-surface py-[10px] pl-[41px] pr-[17px] text-[16px] text-editorial-ink placeholder:text-editorial-meta focus:outline-2 focus:outline-editorial">
                <img src="{{ asset('images/icons/admin/table-search.svg') }}" alt=""
                     class="pointer-events-none absolute left-[12px] top-1/2 size-[18px] -translate-y-1/2">
            </label>

            <label class="relative block">
                <span class="sr-only">Filter by status</span>
                <select class="appearance-none rounded-[8px] border border-[#c0c7d3] bg-surface py-[9px] pl-[17px] pr-[44px] text-[16px] leading-[24px] text-editorial-ink focus:outline-2 focus:outline-editorial">
                    <option>All Statuses</option>
                    <option>Active</option>
                    <option>Non-Active</option>
                </select>
                <img src="{{ asset('images/icons/admin/chevron-down.svg') }}" alt=""
                     class="pointer-events-none absolute right-[12px] top-1/2 size-[20px] -translate-y-1/2">
            </label>
        </x-slot:filters>

        @foreach ($boats as $boat)
            <tr class="border-b border-[rgba(192,199,211,0.2)] last:border-b-0">
                <td class="px-[16px] py-[18px]">
                    <span class="flex items-center gap-[12px]">
                        <span class="flex size-[40px] shrink-0 items-center justify-center rounded-[8px] bg-editorial/10">
                            <img src="{{ asset('images/icons/admin/row-boat.svg') }}" alt="" class="h-[20px] w-[18.4px]">
                        </span>
                        <span>
                            <span class="block text-[16px] font-semibold leading-[24px] text-editorial-ink">{{ $boat['name'] }}</span>
                            <span class="block text-[14px] leading-[20px] text-editorial-meta">ID: {{ $boat['code'] }}</span>
                        </span>
                    </span>
                </td>
                <td class="px-[16px] py-[18px] text-[16px] leading-[24px] text-editorial-body">{{ $boat['type'] }}</td>
                <td class="px-[16px] py-[18px] text-[16px] leading-[24px] text-editorial-body">{{ $boat['capacity'] }}</td>
                <td class="px-[16px] py-[18px]"><x-admin.status :label="$boat['status']" :tone="$boat['tone']" /></td>
                <td class="px-[16px] py-[18px] text-[16px] leading-[24px] text-editorial-body">{{ $boat['inspected'] }}</td>
                <td class="px-[16px] py-[18px]"><x-admin.row-actions :label="$boat['name']" /></td>
            </tr>
        @endforeach
    </x-admin.listing>
@endsection
