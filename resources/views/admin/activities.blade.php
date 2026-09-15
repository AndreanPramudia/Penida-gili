{{-- Figma node 1:9970 — admin Activity --}}
@extends('layouts.admin')

@section('title', 'Activity')

@section('admin-active', 'activity')

@section('content')
    <x-admin.listing
        heading="Activity"
        subtitle="Curate experiences, tours and cultural shows sold alongside fast boat tickets."
        action="Add New Activity"
        :action-href="route('admin.activities.create')"
        :columns="['Activity', 'Category', 'Location', 'Price', 'Status', 'Sold', 'Actions']"
        :paginator="$activities">

        <x-slot:filters>
            <x-admin.filters :action="route('admin.activities')" :filters="$filters" :statuses="\App\Enums\ListingStatus::options()" placeholder="Search activities..." />
        </x-slot:filters>

        @forelse ($activities as $activity)
            <tr class="border-b border-[rgba(192,199,211,0.2)] last:border-b-0">
                <td class="px-[16px] py-[16px]">
                    <span class="flex items-center gap-[12px]">
                        <img src="{{ $activity->image_url }}" alt="" class="size-[48px] shrink-0 rounded-[8px] object-cover">
                        <span>
                            <span class="block text-[15px] font-semibold leading-[22px] text-editorial-ink">{{ $activity->name }}</span>
                            <span class="flex flex-wrap items-center gap-[8px] text-[13px] leading-[18px] text-editorial-meta">
                                <span class="text-[#ca8a04]">&#9733; {{ $activity->rating }}</span>
                                <span>{{ $activity->hours_label ?? '—' }}</span>
                                <span class="rounded-[4px] bg-[#f1f4f6] px-[6px] py-[1px]">{{ $activity->badge ?? $activity->review_count.' ulasan' }}</span>
                            </span>
                        </span>
                    </span>
                </td>
                <td class="px-[16px] py-[16px]">
                    <span class="rounded-[6px] bg-[#f1f4f6] px-[10px] py-[6px] text-[13px] text-editorial-body">{{ $activity->category }}</span>
                </td>
                <td class="px-[16px] py-[16px] text-[14px] leading-[20px] text-editorial-body">{{ $activity->location }}</td>
                <td class="px-[16px] py-[16px]">
                    <span class="block text-[15px] font-semibold leading-[22px] text-editorial">{{ $activity->price_label }}</span>
                    <span class="block text-[13px] leading-[18px] text-editorial-meta">{{ $activity->price_was_label ?? '/ pax' }}</span>
                </td>
                <td class="px-[16px] py-[16px]"><x-admin.status :label="$activity->status->label()" :tone="$activity->status->tone()" /></td>
                <td class="px-[16px] py-[16px]">
                    <span class="block text-[15px] font-semibold leading-[22px] text-editorial-ink">{{ number_format($activity->sold_count) }}</span>
                </td>
                <td class="px-[16px] py-[16px]">
                    <x-admin.row-actions :label="$activity->name" :edit-href="route('admin.activities.edit', $activity)" :delete-action="route('admin.activities.destroy', $activity)" />
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="px-[16px] py-[32px] text-center text-[15px] text-editorial-body">No activities match this filter.</td></tr>
        @endforelse
    </x-admin.listing>
@endsection
