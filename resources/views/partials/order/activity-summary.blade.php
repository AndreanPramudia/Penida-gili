{{-- Figma node 1:2979 — activity order summary sidebar --}}
@props(['order'])

<aside data-reveal style="--reveal-delay: 120ms" class="flex flex-col gap-[22px] font-jakarta lg:sticky lg:top-8">
    <div class="rounded-detail border border-[rgba(224,227,229,0.5)] bg-surface p-[34.5px] shadow-detail">
        <h2 class="border-b border-[#e0e3e5] pb-[23.5px] text-[33.2px] font-semibold leading-[44.2px] text-editorial-ink">
            {{ $order['summaryTitle'] }}
        </h2>

        <dl class="flex flex-col gap-[16.6px] py-[11px]">
            @foreach ($order['rows'] as $row)
                <div class="flex items-start justify-between gap-[28px]">
                    <dt class="text-[22.1px] leading-[33.2px] text-editorial-body">{{ $row['label'] }}</dt>
                    <dd class="text-right text-[19.3px] font-semibold leading-[27.6px] tracking-[0.97px] text-editorial-ink">{{ $row['value'] }}</dd>
                </div>
            @endforeach
        </dl>

        <div class="mb-[22px] flex items-end justify-between border-t border-[#e0e3e5] pt-[23.5px]">
            <span class="text-[33.2px] font-semibold leading-[44.2px] text-editorial-ink">Total</span>
            <span class="text-[24px] lg:text-[49.7px] font-bold leading-[30px] lg:leading-[60.8px] tracking-[-0.5px] text-brand" data-quote-total>{{ $order['total'] }}</span>
        </div>

        <div class="flex flex-col gap-[16.6px]">
            <button type="submit"
                    class="flex w-full items-center justify-center gap-[11px] rounded-[11px] bg-brand py-[22px] text-[19.3px] font-semibold leading-[27.6px] tracking-[0.97px] text-white shadow-sm
                           transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                Book Now
                <img src="{{ asset('images/icons/order/check-circle.svg') }}" alt="" class="size-[20.7px]">
            </button>

            <a href="{{ $order['emailHref'] }}" target="_blank" rel="noopener" data-email-book
               class="flex w-full items-center justify-center rounded-[11px] border border-editorial-line bg-editorial-rule py-[18px] text-[19.3px] font-semibold leading-[27.6px] tracking-[0.97px] text-editorial-ink
                      transition-colors duration-300 hover:bg-[#dfe4e7]">
                Book With Email
            </a>
        </div>
    </div>

    {{-- Figma node 1:3017 — terms notice --}}
    <p class="flex items-start gap-[16.6px] rounded-[11px] bg-[rgba(213,226,233,0.5)] p-[22px] text-[19.3px] leading-[27.6px] text-editorial-body">
        <img src="{{ asset('images/icons/order/info.svg') }}" alt="" class="h-[30.4px] w-[27.6px] shrink-0">
        By completing this booking, you agree to our terms of service and cancellation policy.
    </p>
</aside>
