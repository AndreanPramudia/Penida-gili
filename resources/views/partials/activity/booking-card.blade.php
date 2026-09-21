{{-- Figma node 1:1673 — right column booking card --}}
@props(['activity'])

<aside data-reveal style="--reveal-delay: 120ms" class="lg:sticky lg:top-8">
    <div class="rounded-detail border border-editorial-line bg-surface p-[32px] shadow-detail">
        <h2 class="text-[32px] font-semibold leading-[42.7px] text-editorial-ink">{{ $activity['name'] }}</h2>

        <p class="mt-[32px] text-[18.7px] leading-[26.7px] text-editorial-body">Only</p>

        <p class="flex items-baseline gap-[8px] pb-[21.4px] pt-[10.7px]">
            <span class="text-[24px] font-bold leading-[32px] text-brand">{{ $activity['price_label'] }}</span>
            <span class="text-[18.7px] leading-[32px] text-editorial-body">/ person</span>
        </p>

        <p class="flex items-start gap-[10.7px] rounded-[10.7px] bg-[rgba(217,227,249,0.3)] p-[16px] text-[16px] leading-[21.4px] text-editorial-body">
            <img src="{{ asset('images/icons/detail/info.svg') }}" alt="" class="size-[20px] shrink-0">
            {{ $activity['price_note'] }}
        </p>

        <a href="{{ route('activities.order', $activity['slug']) }}"
           class="mt-[32px] flex items-center justify-center rounded-[10.7px] bg-brand py-[16px] text-[21.4px] leading-[32px] text-white shadow-sm
                  transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
            Book Now
        </a>

        <a href="https://wa.me/6281236300562" target="_blank" rel="noopener"
           class="mt-[21.4px] flex items-center justify-center gap-[10.7px] rounded-[10.7px] border-[2.7px] border-brand bg-surface py-[18.7px] text-[21.4px] leading-[32px] text-brand
                  transition-colors duration-300 hover:bg-brand/5">
            <img src="{{ asset('images/icons/detail/whatsapp.svg') }}" alt="" class="size-[26.7px]">
            Ask via WhatsApp
        </a>
    </div>
</aside>
