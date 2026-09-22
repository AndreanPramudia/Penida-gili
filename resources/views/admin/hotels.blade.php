{{-- Figma node 1:9280 — admin Hotel --}}
@extends('layouts.admin')

@section('title', 'Hotel')

@section('admin-active', 'hotel')

@section('content')
    <x-admin.listing
        heading="Hotel"
        subtitle="Partner properties, room inventory and nightly rates available to island travellers."
        action="Add New Hotel"
        :action-href="route('admin.hotels.create')"
        :columns="['Property', 'Location', 'Rating', 'Rooms', 'From / Night', 'Status', 'Actions']"
        :paginator="$hotels">

        <x-slot:toolbar>
            @include('partials.admin.hotel-filters', [
                'action' => route('admin.hotels'),
                'filters' => $filters,
                'destinations' => $destinations,
                'statuses' => \App\Enums\ListingStatus::options(),
            ])
        </x-slot:toolbar>

        @forelse ($hotels as $hotel)
            <tr class="border-b border-[rgba(192,199,211,0.2)] last:border-b-0">
                <td class="px-[16px] py-[16px]">
                    <span class="flex items-center gap-[12px]">
                        <img src="{{ $hotel->image_url }}" alt="" class="size-[48px] shrink-0 rounded-[8px] object-cover">
                        <span>
                            <span class="block text-[15px] font-semibold leading-[22px] text-editorial-ink">{{ $hotel->name }}</span>
                            <span class="block text-[13px] leading-[18px] text-editorial">{{ $hotel->partner_label ?? $hotel->category }}</span>
                        </span>
                    </span>
                </td>
                <td class="px-[16px] py-[16px] text-[14px] leading-[20px] text-editorial-body">{{ $hotel->address }}</td>
                <td class="px-[16px] py-[16px] text-[14px] leading-[20px]">
                    <span class="font-semibold text-[#ca8a04]">&#9733; {{ $hotel->rating }}</span>
                    <span class="text-editorial-meta">({{ $hotel->review_count }})</span>
                </td>
                <td class="px-[16px] py-[16px]">
                    <span class="rounded-[6px] bg-[#f1f4f6] px-[10px] py-[6px] text-[13px] text-editorial-body">{{ $hotel->rooms_count }} types · {{ (int) $hotel->room_stock }} units</span>
                </td>
                <td class="px-[16px] py-[16px]">
                    <span class="block text-[15px] font-semibold leading-[22px] text-editorial-ink">{{ $hotel->price_from_label }}</span>
                </td>
                <td class="px-[16px] py-[16px]"><x-admin.status :label="$hotel->status->label()" :tone="$hotel->status->tone()" /></td>
                <td class="px-[16px] py-[16px]">
                    <x-admin.row-actions :label="$hotel->name" :edit-href="route('admin.hotels.edit', $hotel)" :delete-action="route('admin.hotels.destroy', $hotel)" />
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="px-[16px] py-[32px] text-center text-[15px] text-editorial-body">No hotels match this filter.</td></tr>
        @endforelse
    </x-admin.listing>
@endsection
