{{-- Figma node 1:157 — "Popular Routes & Destinations" --}}

<section class="container-page pt-[66px] lg:pt-[157px]">
    <div class="grid [&>*]:min-w-0 gap-[111px] lg:grid-cols-[474px_1fr]">
        <div data-reveal="left" class="group h-[338px] lg:h-[805px] w-full max-w-[474px] overflow-hidden rounded-card">
            <img src="{{ asset('images/home/routes-jetski.png') }}" alt="Jet ski on tropical water"
                 class="size-full object-cover transition-transform duration-700 ease-smooth group-hover:scale-105">
        </div>

        <div data-reveal style="--reveal-delay: 120ms" class="lg:flex lg:h-[805px] lg:flex-col">
            <p class="text-[20px] font-semibold uppercase leading-[30px] text-brand">Popular Routes &amp; Destinations</p>
            <h2 class="mt-[50px] max-w-[857px] text-[30px] lg:text-[71px] leading-[53px] lg:leading-[118px] text-ink">Popular Routes &amp; Destinations</h2>

            <ul class="mt-[39px] lg:mt-[48px] flex flex-col gap-[40px] lg:flex-1 lg:justify-between lg:gap-0">
                @foreach ($popularRoutes as $index => $route)
                    <li data-reveal style="--reveal-delay: {{ 200 + $index * 90 }}ms" class="group flex items-start gap-[60px]">
                        <span class="relative flex size-[111px] shrink-0 items-center justify-center transition-transform duration-500 ease-smooth group-hover:scale-105">
                            <img src="{{ asset('images/icons/service/circle-lg.svg') }}" alt="" class="absolute inset-0 size-full">
                            <img src="{{ asset('images/icons/service/'.$route['icon']) }}" alt="" class="relative h-[60px] w-[68px]">
                        </span>
                        <div class="max-w-[686px]">
                            <h3 class="text-[24px] lg:text-[28px] leading-[39px] text-ink transition-colors duration-300 group-hover:text-brand"><a href="{{ $route['href'] }}" class="hover:underline">{{ $route['title'] }}</a></h3>
                            <p class="mt-[27px] text-[16px] lg:text-[18px] leading-[30px] text-ink-muted">{{ $route['body'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
