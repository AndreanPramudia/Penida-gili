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
        :columns="['Route & Time', 'Operator / Boat', 'Base Price', 'Days', 'Status', 'Actions']"
        :paginator="$schedules">

        <x-slot:toolbar>
            <x-admin.filters :action="route('admin.schedules')" :filters="$filters" :statuses="\App\Enums\ListingStatus::options()" placeholder="e.g. Sanur" />
        </x-slot:toolbar>

        @forelse ($schedules as $schedule)
            <tr class="border-b border-[rgba(192,199,211,0.2)] last:border-b-0">
                <td class="px-[16px] py-[18px]">
                    <span class="flex items-center gap-[12px]">
                        <span class="flex size-[40px] shrink-0 items-center justify-center rounded-full bg-editorial/10">
                            <img src="{{ asset('images/icons/admin/nav-schedule.svg') }}" alt="" class="size-[18px]">
                        </span>
                        <span>
                            <span class="block text-[16px] font-semibold leading-[24px] text-editorial-ink">{{ $schedule->route_label }}</span>
                            <span class="flex items-center gap-[6px] text-[14px] leading-[20px] text-editorial-meta">
                                {{ $schedule->departure_label }}
                                <img src="{{ asset('images/icons/order/arrow-right.svg') }}" alt="to" class="h-[5px] w-[13px]">
                                {{ $schedule->arrival_label }}
                            </span>
                        </span>
                    </span>
                </td>
                <td class="px-[16px] py-[18px]">
                    <span class="block text-[16px] leading-[24px] text-editorial-body">{{ $schedule->vessel?->name ?? $schedule->operator->name }}</span>
                    <span class="block text-[14px] leading-[20px] text-editorial-meta">{{ $schedule->vessel ? 'Cap: '.$schedule->vessel->capacity : $schedule->operator->name }}</span>
                </td>
                <td class="px-[16px] py-[18px] text-[16px] font-semibold leading-[24px] text-editorial-ink">{{ $schedule->price_label }}</td>
                <td class="px-[16px] py-[18px] text-[14px] leading-[20px] text-editorial-body">{{ $schedule->days ? implode(', ', $schedule->days) : 'Daily' }}</td>
                <td class="px-[16px] py-[18px]"><x-admin.status :label="$schedule->status->label()" :tone="$schedule->status->tone()" /></td>
                <td class="px-[16px] py-[18px]">
                    <x-admin.row-actions :label="$schedule->route_label" :edit-href="route('admin.schedules.edit', $schedule)" :delete-action="route('admin.schedules.destroy', $schedule)" />
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="px-[16px] py-[32px] text-center text-[15px] text-editorial-body">No schedules match this filter.</td></tr>
        @endforelse
    </x-admin.listing>
@endsection
