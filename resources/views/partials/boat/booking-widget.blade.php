{{-- Figma node 1:1283 — sticky "Popular Routes" booking aside --}}
@props(['routes', 'slug'])

<aside class="lg:sticky lg:top-8">
    <div data-reveal class="rounded-detail border border-editorial-rule bg-surface p-[34px] shadow-editorial">
        <h2 class="text-[32px] font-bold leading-[44px] text-editorial-ink">Popular Routes</h2>

        <ul class="mt-[22px] space-y-[32px]">
            @foreach ($routes as $route)
                <li class="rounded-[11px] border border-editorial-rule p-[23px]">
                    <div class="flex items-center justify-between gap-[11px]">
                        <div>
                            <p class="text-[18.8px] font-bold leading-[27px] tracking-[0.94px] text-editorial-ink">{{ $route['from'] }}</p>
                            <p class="text-[18.8px] leading-[27px] text-editorial-meta">{{ $route['departure'] }}</p>
                        </div>

                        <span class="relative flex min-w-0 flex-1 items-center justify-center px-[11px]" aria-hidden="true">
                            <span class="h-px w-full bg-[#c0c7d3]"></span>
                            <img src="{{ asset('images/icons/vessel/route-arrow.svg') }}" alt=""
                                 class="absolute size-[12.5px] bg-surface px-[5px] box-content">
                        </span>

                        <div class="text-right">
                            <p class="text-[18.8px] font-bold leading-[27px] tracking-[0.94px] text-editorial-ink">{{ $route['to'] }}</p>
                            <p class="text-[18.8px] leading-[27px] text-editorial-meta">{{ $route['arrival'] }}</p>
                        </div>
                    </div>

                    <div class="mt-[22px] flex items-center justify-between">
                        <p class="text-[23.8px] font-semibold leading-[32px] text-brand">{{ $route['price'] }}</p>
                        <p class="text-[18.8px] leading-[27px] text-editorial-meta">/pax</p>

                        <a href="{{ route('boats.order', [$slug, 'schedule' => $route['id']]) }}"
                           class="rounded-[8px] bg-editorial/10 px-[21px] py-[11px] text-[18.8px] font-semibold leading-[27px] tracking-[0.94px] text-brand
                                  transition-colors duration-300 hover:bg-editorial/20">
                            Book Now
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>

        {{-- Figma node 1:1425 --}}
        <div class="mt-[32px] flex flex-col gap-[22px] border-t border-editorial-rule pt-[44px]">
            <p class="text-center text-[21.5px] leading-[32px] text-editorial-body">
                Need a custom route or private charter?
            </p>

            <a href="https://wa.me/6281236300562" target="_blank" rel="noopener"
               class="flex items-center justify-center bg-[#d5e2e9] px-[21px] py-[16px] text-[18.8px] font-bold leading-[27px] tracking-[0.94px] text-[#58646a]
                      transition-colors duration-300 hover:bg-[#c3d6e0]">
                Contact Operator
            </a>
        </div>
    </div>
</aside>
