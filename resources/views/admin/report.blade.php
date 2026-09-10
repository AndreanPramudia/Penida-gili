{{-- Figma node 1:10402 — admin Booking Report --}}
@extends('layouts.admin')

@section('title', 'Booking Report')

@section('admin-active', 'report')

@section('content')
    <x-admin.listing
        heading="Booking Report"
        subtitle="Comprehensive overview of fastboat reservations and performance."
        action="Download Report"
        :columns="['Passenger', 'Route', 'Date & Time', 'Amount', 'Status', 'Action']"
        summary="Showing 1 to 3 of 12 schedules">

        <x-slot:toolbar>
            @include('partials.admin.route-filters')
        </x-slot:toolbar>

        @foreach ($transactions as $row)
            <tr class="border-b border-[rgba(192,199,211,0.2)] last:border-b-0">
                <td class="px-[16px] py-[16px]">
                    <span class="flex items-center gap-[12px]">
                        <span class="flex size-[36px] shrink-0 items-center justify-center rounded-full bg-[#d5e2e9] text-[12px] font-semibold text-editorial">{{ $row['initials'] }}</span>
                        <span>
                            <span class="block text-[14px] font-semibold leading-[20px] text-editorial-ink">{{ $row['name'] }}</span>
                            <span class="block text-[12px] leading-[16px] text-editorial-body">{{ $row['email'] }}</span>
                        </span>
                    </span>
                </td>
                <td class="px-[16px] py-[16px]">
                    <span class="flex items-center gap-[6px] text-[14px] leading-[20px] text-editorial-ink">
                        {{ $row['from'] }}
                        <img src="{{ asset('images/icons/order/arrow-right.svg') }}" alt="to" class="h-[5px] w-[13px]">
                        {{ $row['to'] }}
                    </span>
                    <span class="block text-[12px] leading-[16px] text-editorial-body">{{ $row['vessel'] }}</span>
                </td>
                <td class="px-[16px] py-[16px]">
                    <span class="block text-[14px] leading-[20px] text-editorial-ink">{{ $row['date'] }}</span>
                    <span class="block text-[12px] leading-[16px] text-editorial-body">{{ $row['time'] }}</span>
                </td>
                <td class="px-[16px] py-[16px] text-[14px] font-semibold leading-[20px] text-editorial-ink">{{ $row['amount'] }}</td>
                <td class="px-[16px] py-[16px]">
                    <span @class([
                        'rounded-full px-[10px] py-[4px] text-[12px] font-semibold leading-[16px]',
                        'bg-[#dcfce7] text-[#15803d]' => $row['status'] === 'Confirmed',
                        'bg-[#fef9c3] text-[#a16207]' => $row['status'] === 'Pending',
                    ])>{{ $row['status'] }}</span>
                </td>
                <td class="px-[16px] py-[16px]">
                    <button type="button" aria-label="Actions for {{ $row['name'] }}"
                            class="text-[18px] leading-none text-editorial-body transition-colors hover:text-editorial">&vellip;</button>
                </td>
            </tr>
        @endforeach
    </x-admin.listing>
@endsection
