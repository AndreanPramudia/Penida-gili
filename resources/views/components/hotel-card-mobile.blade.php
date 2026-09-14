{{-- Figma node 1:3244 — Hotel card (mobile, 350px wide): photo with floating rating pill, location, name, 2-line blurb, price + "Book". --}}
@props([
    'name',
    'description',
    'rating',
    'image',
    'price',
    'location' => '',
    'href' => '#',
    'delay' => 0,
])

<a href="{{ $href }}" data-reveal style="--reveal-delay: {{ $delay }}ms"
   class="group flex w-full flex-col overflow-hidden rounded-[12px] bg-surface shadow-[0px_4px_20px_0px_rgba(0,0,0,0.05)]
          transition-[transform,box-shadow] duration-500 ease-smooth active:scale-[0.99]">
    <div class="relative h-[248px] w-full overflow-hidden bg-[#e0e3e5]">
        <img src="{{ $image }}" alt="{{ $name }}" class="size-full object-cover transition-transform duration-700 ease-smooth group-hover:scale-105">

        <span class="absolute right-[16px] top-[16px] flex items-center gap-[4px] rounded-full bg-[rgba(247,250,252,0.9)] px-[12px] py-[4px] shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)] backdrop-blur-[4px]">
            <img src="{{ asset('images/icons/mobile/list/star-dark.svg') }}" alt="" class="h-[11px] w-[12px]">
            <span class="text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-[#181c1e]">{{ $rating }}</span>
        </span>
    </div>

    <div class="flex flex-col gap-[8px] p-[24px]">
        @if ($location)
            <p class="flex items-center gap-[4px] pb-[4px] text-[14px] leading-[20px] tracking-[0.7px] text-[#414751]">
                <img src="{{ asset('images/icons/mobile/list/pin-outline.svg') }}" alt="" class="h-[13.3px] w-[10.7px]">
                {{ $location }}
            </p>
        @endif

        <h3 class="text-[16px] leading-[24px] text-[#181c1e]">{{ $name }}</h3>

        <p class="line-clamp-2 text-[16px] leading-[24px] text-[#414751]">{{ $description }}</p>

        <div class="mt-[16px] flex items-end justify-between border-t border-[rgba(192,199,211,0.3)] pt-[9px]">
            <p>
                <span class="block text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-[#414751]">Starting from</span>
                <span class="text-[16px] leading-[24px] text-brand">{{ $price }}</span>
                <span class="text-[14px] leading-[20px] text-[#414751]">/night</span>
            </p>

            <span class="rounded-[8px] bg-brand px-[24px] py-[12px] text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-white shadow-[0px_4px_6px_-1px_rgba(0,0,0,0.1),0px_2px_4px_-2px_rgba(0,0,0,0.1)]">
                Book
            </span>
        </div>
    </div>
</a>
