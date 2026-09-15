{{-- Figma nodes 1:1180 + 1:1430 — full-bleed detail hero with rating badge --}}
@props(['boat'])

<header class="relative min-h-[363px] w-full overflow-hidden pb-[32px] lg:h-[865px] lg:min-h-0 lg:pb-0">
    <img src="{{ $boat['hero_image_url'] }}" alt="{{ $boat['name'] }}"
         class="absolute inset-0 size-full object-cover">

    <div class="relative z-10">
        @include('partials.nav', ['active' => 'boat'])
    </div>

    <div class="container-page relative z-10 mt-[40px] flex flex-col items-start gap-[16px] font-jakarta lg:absolute lg:inset-x-0 lg:bottom-[53px] lg:mt-0">
        <span data-reveal
              class="flex items-center gap-[8px] rounded-full bg-white/20 px-[16px] py-[8px] backdrop-blur-[6px]">
            <img src="{{ asset('images/icons/vessel/star-badge.svg') }}" alt="" class="h-[19px] w-[20px]">
            <span class="text-[14px] font-bold leading-[20px] tracking-[0.7px] text-white">
                {{ $boat['rating'] }} ({{ $boat['review_count_label'] }} Reviews)
            </span>
        </span>

        <h1 data-reveal style="--reveal-delay: 100ms"
            class="text-[24px] lg:text-[48px] font-bold leading-[30px] lg:leading-[48px] tracking-[-0.96px] text-white">
            {{ $boat['name'] }}
        </h1>

        <p data-reveal style="--reveal-delay: 180ms"
           class="max-w-[672px] text-[18px] leading-[28px] text-[#e5e7eb]">
            {{ $boat['tagline'] }}
        </p>
    </div>
</header>
