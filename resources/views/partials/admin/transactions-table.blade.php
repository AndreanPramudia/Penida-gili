{{-- Figma node 1:6778 — transactions table.

     Booking Report reuses this, so the status palette and the row shape live
     here rather than in either page. --}}
@props(['rows', 'summary'])

<div class="overflow-x-auto">
    <table class="w-full min-w-[900px] border-collapse text-left">
        <thead class="bg-[#f1f4f6]">
            <tr>
                @foreach (['Passenger', 'Route', 'Date & Time', 'Amount', 'Status', 'Action'] as $header)
                    <th scope="col" class="px-[24px] py-[14px] text-[14px] font-semibold leading-[20px] text-editorial-body">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach ($rows as $row)
                <tr class="border-b border-editorial-line last:border-b-0">
                    <td class="px-[24px] py-[16px]">
                        <span class="flex items-center gap-[12px]">
                            <span class="flex size-[36px] shrink-0 items-center justify-center rounded-full bg-[#d5e2e9] text-[12px] font-semibold text-editorial">
                                {{ $row['initials'] }}
                            </span>
                            <span>
                                <span class="block text-[14px] font-semibold leading-[20px] text-editorial-ink">{{ $row['name'] }}</span>
                                <span class="block text-[12px] leading-[16px] text-editorial-body">{{ $row['email'] }}</span>
                            </span>
                        </span>
                    </td>

                    <td class="px-[24px] py-[16px]">
                        <span class="flex items-center gap-[6px] text-[14px] leading-[20px] text-editorial-ink">
                            {{ $row['from'] }}
                            <img src="{{ asset('images/icons/order/arrow-right.svg') }}" alt="to" class="h-[5px] w-[13px]">
                            {{ $row['to'] }}
                        </span>
                        <span class="block text-[12px] leading-[16px] text-editorial-body">{{ $row['vessel'] }}</span>
                    </td>

                    <td class="px-[24px] py-[16px]">
                        <span class="block text-[14px] leading-[20px] text-editorial-ink">{{ $row['date'] }}</span>
                        <span class="block text-[12px] leading-[16px] text-editorial-body">{{ $row['time'] }}</span>
                    </td>

                    <td class="px-[24px] py-[16px] text-[14px] font-semibold leading-[20px] text-editorial-ink">{{ $row['amount'] }}</td>

                    <td class="px-[24px] py-[16px]">
                        <span @class([
                            'rounded-full px-[10px] py-[4px] text-[12px] font-semibold leading-[16px]',
                            'bg-[#dcfce7] text-[#15803d]' => $row['status'] === 'Confirmed',
                            'bg-[#fef9c3] text-[#a16207]' => $row['status'] === 'Pending',
                            'bg-[#fee2e2] text-[#b91c1c]' => $row['status'] === 'Cancelled',
                        ])>{{ $row['status'] }}</span>
                    </td>

                    <td class="px-[24px] py-[16px]">
                        <button type="button" aria-label="Actions for {{ $row['name'] }}"
                                class="text-[18px] leading-none text-editorial-body transition-colors hover:text-editorial">&vellip;</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="flex flex-wrap items-center justify-between gap-4 border-t border-editorial-line px-[24px] py-[16px]">
    <p class="text-[14px] leading-[20px] text-editorial-body">{{ $summary }}</p>

    <div class="flex gap-[8px]">
        <button type="button" class="rounded-[6px] border border-editorial-line px-[14px] py-[6px] text-[14px] text-editorial-ink transition-colors hover:bg-[#f1f4f6]">Prev</button>
        <button type="button" class="rounded-[6px] border border-editorial-line px-[14px] py-[6px] text-[14px] text-editorial-ink transition-colors hover:bg-[#f1f4f6]">Next</button>
    </div>
</div>
