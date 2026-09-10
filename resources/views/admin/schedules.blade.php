{{-- Figma node 1:9017 — admin Schedule --}}
@extends('layouts.admin')

@section('title', 'Schedule')

@section('admin-active', 'schedule')

@section('content')
    <x-admin.listing
        heading="Schedule"
        subtitle="View and modify active routes, timings, and fare structures."
        action="Add New Schedule"
        :action-href="route('admin.schedules.create')"
        :columns="['Route & Time', 'Boat', 'Base Price', 'Status', 'Actions']"
        summary="Showing 1 to 3 of 12 schedules">

        <x-slot:toolbar>
            @include('partials.admin.route-filters')
        </x-slot:toolbar>

        @foreach ($schedules as $schedule)
            <tr class="border-b border-[rgba(192,199,211,0.2)] last:border-b-0">
                <td class="px-[16px] py-[18px]">
                    <span class="flex items-center gap-[12px]">
                        <span class="flex size-[40px] shrink-0 items-center justify-center rounded-full bg-editorial/10">
                            <img src="{{ asset('images/icons/admin/nav-schedule.svg') }}" alt="" class="size-[18px]">
                        </span>
                        <span>
                            <span class="block text-[16px] font-semibold leading-[24px] text-editorial-ink">{{ $schedule['route'] }}</span>
                            <span class="flex items-center gap-[6px] text-[14px] leading-[20px] text-editorial-meta">
                                {{ $schedule['depart'] }}
                                <img src="{{ asset('images/icons/order/arrow-right.svg') }}" alt="to" class="h-[5px] w-[13px]">
                                {{ $schedule['arrive'] }}
                            </span>
                        </span>
                    </span>
                </td>
                <td class="px-[16px] py-[18px]">
                    <span class="block text-[16px] leading-[24px] text-editorial-body">{{ $schedule['boat'] }}</span>
                    <span class="block text-[14px] leading-[20px] text-editorial-meta">{{ $schedule['cap'] }}</span>
                </td>
                <td class="px-[16px] py-[18px] text-[16px] font-semibold leading-[24px] text-editorial-ink">{{ $schedule['price'] }}</td>
                <td class="px-[16px] py-[18px]"><x-admin.status :label="$schedule['status']" :tone="$schedule['tone']" /></td>
                <td class="px-[16px] py-[18px]"><x-admin.row-actions :label="$schedule['route']" /></td>
            </tr>
        @endforeach
    </x-admin.listing>
@endsection
