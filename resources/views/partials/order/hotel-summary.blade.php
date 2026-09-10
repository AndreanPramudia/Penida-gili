{{-- Figma node 1:3129 — hotel order summary sidebar --}}
@props(['order'])

<aside data-reveal style="--reveal-delay: 120ms" class="font-jakarta lg:sticky lg:top-8">
    <div class="rounded-detail border border-[#e0e3e5] bg-surface p-[31px] shadow-detail">
        <h2 class="border-b border-[#e0e3e5] pb-[21px] text-[29.6px] font-semibold leading-[39.5px] text-editorial-ink">
            {{ $order['summaryTitle'] }}
        </h2>

        {{-- Property (1:3133) --}}
        <div class="flex gap-[19.8px] border-b border-[#e0e3e5] py-[21px]">
            <img src="{{ asset('images/hotels/detail/'.$order['thumb']) }}" alt="{{ $order['property'] }}"
                 class="h-[118.5px] w-[108px] shrink-0 rounded-[10px] object-cover">
            <div class="flex flex-col gap-[5px]">
                <p class="text-[17.3px] font-semibold uppercase leading-[24.7px] tracking-[0.86px] text-brand">{{ $order['propertyType'] }}</p>
                <p class="text-[29.6px] font-semibold leading-[37px] text-editorial-ink">{{ $order['property'] }}</p>
            </div>
        </div>

        {{-- Details list (1:3140) --}}
        <dl class="flex flex-col gap-[19.1px] border-b border-[#e0e3e5] py-[19.8px]">
            @foreach ($order['details'] as $detail)
                <div class="flex items-center justify-between gap-4">
                    <dt class="flex items-center gap-[10px] text-[19.8px] leading-[29.6px] text-editorial-body">
                        <img src="{{ asset('images/icons/order/'.$detail['icon']) }}" alt="" class="size-[24.7px] object-contain">
                        {{ $detail['label'] }}
                    </dt>
                    <dd class="text-right">
                        <span class="block text-[17.3px] font-semibold leading-[24.7px] tracking-[0.86px] text-editorial-ink">{{ $detail['value'] }}</span>
                        @if (! empty($detail['note']))
                            <span class="block text-[14.8px] leading-[19.8px] text-editorial-body">{{ $detail['note'] }}</span>
                        @endif
                    </dd>
                </div>
            @endforeach
        </dl>

        {{-- Price breakdown (1:3165) --}}
        <div class="mt-[19.8px] rounded-[10px] bg-editorial-rule px-[19.8px] pb-[29.6px] pt-[19.8px]">
            <div class="flex items-center justify-between gap-3">
                <span class="text-[19.8px] leading-[29.6px] text-editorial-body">{{ $order['lineLabel'] }}</span>
                <span class="text-[19.8px] leading-[29.6px] text-editorial-ink">{{ $order['lineAmount'] }}</span>
            </div>

            <div class="mt-[10px] flex items-center justify-between gap-3 border-t border-[#c0c7d3] pt-[11px]">
                <span class="text-[29.6px] font-semibold leading-[39.5px] text-editorial-ink">Total</span>
                <span class="text-[29.6px] font-semibold leading-[39.5px] text-brand">{{ $order['total'] }}</span>
            </div>
        </div>

        {{-- Actions (1:3176) --}}
        <div class="flex flex-col gap-[14.8px] pt-[19.8px]">
            <button type="submit"
                    class="flex w-full items-center justify-center gap-[10px] rounded-[10px] bg-brand px-[29.6px] py-[15px] text-[17.3px] font-semibold leading-[24.7px] tracking-[0.86px] text-white
                           transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                Book Now
                <img src="{{ asset('images/icons/order/arrow-book.svg') }}" alt="" class="size-[19.8px]">
            </button>

            <a href="mailto:hello@penidagili.com"
               class="flex w-full items-center justify-center rounded-[10px] border border-brand bg-surface px-[31px] py-[16px] text-[19.3px] font-semibold leading-[27.6px] tracking-[0.97px] text-editorial-ink
                      transition-colors duration-300 hover:bg-brand/5">
                Book With Email
            </a>
        </div>
    </div>
</aside>
