{{-- Figma node 1:1463 — "Other Activities You Might Like" carousel card --}}
@props(['activity', 'delay' => 0])

<article data-reveal style="--reveal-delay: {{ $delay }}ms"
         class="group relative flex w-[300px] shrink-0 flex-col lg:w-[350px] overflow-hidden rounded-detail border border-editorial-line bg-surface shadow-detail
                transition-[transform,box-shadow] duration-500 ease-smooth hover:-translate-y-2 hover:shadow-card-hover">
    <div class="h-[256px] shrink-0 overflow-hidden">
        <img src="{{ asset('images/activities/detail/'.$activity['image']) }}" alt="{{ $activity['name'] }}"
             class="size-full object-cover transition-transform duration-700 ease-smooth group-hover:scale-105">
    </div>

    <div class="flex flex-col gap-[10.7px] p-[21.4px]">
        <h3 class="text-[21.4px] font-semibold leading-[32px] text-editorial-ink transition-colors duration-300 group-hover:text-brand">
            <a href="{{ $activity['href'] }}" class="before:absolute before:inset-0">{{ $activity['name'] }}</a>
        </h3>

        <ul class="flex items-start gap-[16px] text-[16px] leading-[21.4px] text-editorial-body">
            <li class="flex items-center gap-[5.3px]">
                <img src="{{ asset('images/icons/detail/pin-sm.svg') }}" alt="" class="h-[15.6px] w-[12.5px]">
                {{ $activity['place'] }}
            </li>
            <li class="flex items-center gap-[5.3px]">
                <img src="{{ asset('images/icons/detail/clock-sm.svg') }}" alt="" class="size-[15.6px]">
                {{ $activity['duration'] }}
            </li>
        </ul>

        <p class="flex items-center gap-[5.3px] pt-[5.3px]">
            <img src="{{ asset('images/icons/detail/star-sm.svg') }}" alt="" class="h-[17px] w-[17.8px]">
            <span class="text-[18.7px] font-bold leading-[26.7px] text-editorial-ink">{{ $activity['rating'] }}</span>
            <span class="text-[16px] leading-[21.4px] text-editorial-body">({{ $activity['reviews'] }} Review)</span>
        </p>

        <p class="pt-[10.7px] text-right">
            <span class="block text-[16px] leading-[21.4px] text-editorial-body line-through">{{ $activity['priceWas'] }}</span>
            <span class="text-[24px] font-bold leading-[32px] text-brand">{{ $activity['price'] }}</span>
            <span class="text-[16px] leading-[21.4px] text-editorial-body">/ Pax</span>
        </p>
    </div>
</article>
