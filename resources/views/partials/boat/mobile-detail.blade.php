{{-- Figma node 1:4759 — "Boat Detail full" (mobile, 390px). Rendered below lg only; the desktop layout is hidden there. --}}
@props(['boat'])

<div class="bg-[#f7fafc] lg:hidden">
    {{-- Hero (1:4803) --}}
    <header class="relative h-[468px] w-full overflow-hidden">
        <img src="{{ $boat['hero_image_url'] }}" alt="{{ $boat['name'] }}" class="absolute inset-0 size-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-[rgba(24,28,30,0.8)] via-[rgba(24,28,30,0.3)] to-[rgba(24,28,30,0)]"></div>

        <div class="absolute inset-x-0 bottom-0 flex flex-col items-start gap-[8px] p-[20px]">
            <span data-reveal class="flex items-center gap-[4px] rounded-full border border-[rgba(192,199,211,0.3)] bg-[rgba(224,227,229,0.2)] px-[13px] py-[5px] backdrop-blur-[2px]">
                <img src="{{ asset('images/icons/mobile/detail/star-badge.svg') }}" alt="" class="h-[11px] w-[12px]">
                <span class="text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-[#f7fafc]">{{ $boat['rating'] }} ({{ $boat['review_count_label'] }} Reviews)</span>
            </span>

            <h1 data-reveal style="--reveal-delay: 100ms" class="text-[28px] font-bold leading-[36px] text-[#f7fafc] drop-shadow-[0px_2px_1px_rgba(0,0,0,0.06)]">{{ $boat['name'] }}</h1>

            <p data-reveal style="--reveal-delay: 180ms" class="max-w-[672px] text-[16px] leading-[24px] text-[#e0e3e5] drop-shadow-[0px_1px_0.5px_rgba(0,0,0,0.05)]">{{ $boat['tagline'] }}</p>
        </div>
    </header>

    <div class="flex flex-col gap-[18px] px-[20px] pt-[32px] pb-[32px]">
        {{-- Boat Information (1:4819) --}}
        <section class="flex flex-col gap-[16px]">
            <h2 data-reveal class="text-[28px] font-bold leading-[36px] text-brand">Boat Information</h2>

            <div class="flex gap-[8px] pt-[16px]">
                @foreach ($boat['specs'] as $index => $spec)
                    <div data-reveal style="--reveal-delay: {{ $index * 90 }}ms"
                         class="flex flex-1 flex-col items-center gap-[8px] rounded-[12px] border border-[rgba(192,199,211,0.2)] bg-surface p-[17px] drop-shadow-[0px_4px_10px_rgba(0,0,0,0.05)]">
                        <span class="mb-[4px] flex size-[48px] items-center justify-center rounded-full bg-[#d5e2e9]">
                            <img src="{{ asset('images/icons/vessel/'.$spec['icon']) }}" alt="" class="h-[16px] w-[22px] object-contain">
                        </span>
                        <span class="text-center text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-[#414751]">{{ $spec['label'] }}</span>
                        <span class="text-center text-[24px] font-semibold leading-[32px] text-[#181c1e]">{{ $spec['value'] }}</span>
                    </div>
                @endforeach
            </div>

            <div data-reveal class="flex flex-col gap-[16px] rounded-[12px] border border-[rgba(192,199,211,0.2)] bg-surface p-[33px] drop-shadow-[0px_4px_10px_rgba(0,0,0,0.05)]">
                <h3 class="text-[24px] font-semibold leading-[32px] text-[#181c1e]">Facilities</h3>

                <ul class="grid grid-cols-2 gap-[16px]">
                    @foreach ($boat['facilities'] as $facility)
                        <li class="flex min-h-[24px] items-center gap-[12px]">
                            <img src="{{ asset('images/icons/vessel/'.$facility['icon']) }}" alt="" class="size-[20px] shrink-0 object-contain">
                            <span class="text-[16px] leading-[24px] text-[#414751]">{{ $facility['label'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        {{-- Fleet Gallery (1:4865) --}}
        <section class="flex flex-col gap-[32px]">
            <h2 data-reveal class="text-[28px] font-bold leading-[36px] text-brand">Fleet Gallery</h2>

            @php [$mainPhoto, $thumbs] = [$boat['gallery_photos'][0], array_slice($boat['gallery_photos'], 1)]; @endphp
            <div class="flex flex-col gap-[8px]">
                <figure data-reveal class="h-[197px] w-full overflow-hidden rounded-[12px] shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)]">
                    <img src="{{ $mainPhoto['url'] }}" alt="{{ $mainPhoto['alt'] }}" class="size-full object-cover">
                </figure>

                <div class="flex gap-[8px]">
                    @foreach ($thumbs as $index => $photo)
                        <figure data-reveal style="--reveal-delay: {{ ($index + 1) * 90 }}ms" class="h-[128px] min-w-0 flex-1 overflow-hidden rounded-[8px] shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)]">
                            <img src="{{ $photo['url'] }}" alt="{{ $photo['alt'] }}" class="size-full object-cover">
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Guest Testimonials (1:4876) --}}
        <section class="flex flex-col gap-[32px]">
            <h2 data-reveal class="text-[28px] font-bold leading-[36px] text-brand">Guest Testimonials</h2>

            <div class="flex flex-col gap-[16px]">
                @foreach ($boat['reviews'] as $index => $review)
                    <figure data-reveal style="--reveal-delay: {{ $index * 90 }}ms"
                            class="flex flex-col gap-[8px] rounded-[12px] border border-[rgba(192,199,211,0.2)] bg-surface p-[33px] drop-shadow-[0px_4px_10px_rgba(0,0,0,0.05)]">
                        <div class="flex gap-[4px]" role="img" aria-label="{{ $review['stars'] }} out of 5 stars">
                            @for ($star = 1; $star <= 5; $star++)
                                <img src="{{ asset('images/icons/mobile/detail/'.($star <= $review['stars'] ? 'star-full.svg' : 'star-empty.svg')) }}" alt="" class="h-[11px] w-[12px]">
                            @endfor
                        </div>

                        <blockquote class="font-jakarta text-[16px] italic leading-[24px] text-[#414751]">{{ $review['quote'] }}</blockquote>

                        <figcaption class="pt-[8px]">
                            <span class="block text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-[#181c1e]">{{ $review['name'] }}</span>
                            <span class="block text-[12px] leading-[18px] text-[#717782]">{{ $review['traveled'] }}</span>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </section>

        {{-- Popular Routes + CTA (1:4919) --}}
        <aside class="flex flex-col gap-[16px] pt-[6px]">
            <div data-reveal class="flex flex-col gap-[16px] rounded-[12px] border border-[rgba(192,199,211,0.2)] bg-surface p-[33px] drop-shadow-[0px_4px_10px_rgba(0,0,0,0.05)]">
                <h2 class="text-[24px] font-semibold leading-[32px] text-[#181c1e]">Popular Routes</h2>

                <ul class="flex flex-col gap-[8px]">
                    @foreach ($boat['schedules'] as $route)
                        <li @class(['flex flex-col gap-[8px]', 'border-b border-[rgba(192,199,211,0.3)] pb-[17px]' => ! $loop->last])>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-[#181c1e]">{{ $route['from'] }}</p>
                                    <p class="text-[12px] leading-[18px] text-[#717782]">{{ $route['departure'] }}</p>
                                </div>

                                <span class="flex items-center gap-[8px]" aria-hidden="true">
                                    <span class="h-px w-[32px] bg-[#c0c7d3]"></span>
                                    <img src="{{ asset('images/icons/mobile/detail/route-arrow.svg') }}" alt="" class="size-[9.3px]">
                                </span>

                                <div class="text-right">
                                    <p class="text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-[#181c1e]">{{ $route['to'] }}</p>
                                    <p class="text-[12px] leading-[18px] text-[#717782]">{{ $route['arrival'] }}</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-[8px]">
                                <p class="flex items-end py-[2px]">
                                    <span class="text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-brand">{{ $route['price'] }}</span>
                                    <span class="text-[12px] leading-[18px] text-[#717782]">&nbsp;/pax</span>
                                </p>

                                <a href="{{ route('boats.order', [$boat['slug'], 'schedule' => $route['id']]) }}"
                                   class="rounded-[8px] bg-[#d2e4ff] px-[16px] py-[8px] text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-[#001d37] transition-colors duration-300 active:bg-[#bcd6fb]">
                                    Book Now
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- CTA Card (1:4970) --}}
            <div data-reveal class="flex flex-col gap-[16px] rounded-[12px] bg-[#d5e2e9] p-[32px]">
                <p class="text-center text-[16px] leading-[24px] text-[#58646a]">Need a custom route or private charter?</p>

                <a href="https://wa.me/6281236300562" target="_blank" rel="noopener"
                   class="flex items-center justify-center rounded-[8px] border border-[rgba(192,199,211,0.3)] bg-surface px-[17px] py-[13px] text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-[#181c1e] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)]">
                    Contact Operator
                </a>
            </div>
        </aside>
    </div>
</div>
