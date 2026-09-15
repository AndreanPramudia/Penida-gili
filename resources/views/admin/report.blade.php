{{-- Figma node 1:10402 — admin Booking Report --}}
@extends('layouts.admin')

@section('title', 'Booking Report')

@section('admin-active', 'report')

@section('content')
    <x-admin.listing
        heading="Booking Report"
        subtitle="Comprehensive overview of fastboat, hotel and activity reservations."
        action="Download CSV"
        :action-href="route('admin.report.export', request()->query())"
        :columns="['Passenger', 'Product', 'Date & Time', 'Amount', 'Status', 'Action']"
        :paginator="$bookings">

        <x-slot:toolbar>
            <x-admin.filters :action="route('admin.report')" :filters="$filters"
                             :statuses="collect($statuses)->mapWithKeys(fn ($s) => [$s->value => $s->label()])->all()"
                             placeholder="Reference, name or email">
                <label class="relative block">
                    <span class="sr-only">Travel date</span>
                    <input type="date" name="date" value="{{ $filters['date'] ?? '' }}"
                           class="rounded-[8px] border border-[#c0c7d3] bg-surface px-[17px] py-[9px] text-[16px] leading-[24px] text-editorial-ink focus:outline-2 focus:outline-editorial">
                </label>
            </x-admin.filters>
        </x-slot:toolbar>

        @forelse ($rows as $row)
            <tr class="border-b border-[rgba(192,199,211,0.2)] last:border-b-0">
                <td class="px-[16px] py-[16px]">
                    <span class="flex items-center gap-[12px]">
                        <span class="flex size-[36px] shrink-0 items-center justify-center rounded-full bg-[#d5e2e9] text-[12px] font-semibold text-editorial">{{ $row['initials'] }}</span>
                        <span>
                            <span class="block text-[14px] font-semibold leading-[20px] text-editorial-ink">{{ $row['name'] }}</span>
                            <span class="block text-[12px] leading-[16px] text-editorial-body">{{ $row['email'] }} · {{ $row['reference'] }}</span>
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
                        'bg-[#fee2e2] text-[#b91c1c]' => $row['status'] === 'Cancelled',
                    ])>{{ $row['status'] }}</span>
                </td>
                <td class="px-[16px] py-[16px]">
                    <form action="{{ route('admin.report.update', $row['reference']) }}" method="post" class="flex items-center gap-[6px]">
                        @csrf
                        @method('PATCH')
                        <label class="sr-only" for="status-{{ $row['id'] }}">Change status</label>
                        <select id="status-{{ $row['id'] }}" name="status" onchange="this.form.requestSubmit()"
                                class="rounded-[6px] border border-editorial-line bg-surface px-[8px] py-[4px] text-[13px] text-editorial-ink focus:outline-2 focus:outline-editorial">
                            @foreach ($statuses as $status)
                                <option value="{{ $status->value }}" @selected($status->value === $row['status_value'])>{{ $status->label() }}</option>
                            @endforeach
                        </select>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="px-[16px] py-[32px] text-center text-[15px] text-editorial-body">No bookings match this filter.</td></tr>
        @endforelse
    </x-admin.listing>
@endsection
