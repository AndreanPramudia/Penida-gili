{{-- Figma node 1:1179 — boat Detail (desktop) / 1:4759 — Boat Detail full (mobile) --}}
@extends('layouts.app')

@section('title', $boat['name'])

@section('nav-active', 'boat')

@section('hero')
    {{-- Mobile (< lg) gets its own hero + sections from the mobile Figma frame. --}}
    @include('partials.boat.mobile-detail', ['boat' => $boat])

    <div class="hidden lg:block">
        @include('partials.boat.detail-hero', ['boat' => $boat])
    </div>
@endsection

@section('content')
    <div class="container-page hidden pt-[161px] pb-[110px] lg:grid [&>*]:min-w-0 lg:grid-cols-[minmax(0,994fr)_minmax(0,481fr)] lg:gap-[140px]">
        <div class="flex flex-col gap-[65px]">
            {{-- Figma node 1:1184 — vessel info bento --}}
            <section>
                <h2 data-reveal class="text-[24px] lg:text-[48.4px] font-bold leading-[30px] lg:leading-[59px] tracking-[-0.48px] text-brand">Vessel Information</h2>

                <div class="mt-[43px] grid [&>*]:min-w-0 gap-[21.5px] sm:grid-cols-4">
                    @foreach ($boat['specs'] as $index => $spec)
                        <div data-reveal style="--reveal-delay: {{ $index * 90 }}ms"
                             class="flex flex-col items-center justify-center gap-[16px] rounded-detail bg-surface px-[32px] py-[51px] shadow-detail
                                    transition-[transform,box-shadow] duration-500 ease-smooth hover:-translate-y-1 hover:shadow-card-hover">
                            <span class="flex size-[64.5px] items-center justify-center rounded-full bg-[#d5e2e9]">
                                <img src="{{ asset('images/icons/vessel/'.$spec['icon']) }}" alt="" class="h-[21.5px] w-[27px] object-contain">
                            </span>
                            <span class="text-center">
                                <span class="block text-[18.8px] font-semibold leading-[27px] tracking-[0.94px] text-editorial-body">{{ $spec['label'] }}</span>
                                <span class="block text-[32px] font-semibold leading-[43px] text-editorial-ink">{{ $spec['value'] }}</span>
                            </span>
                        </div>
                    @endforeach

                    <div data-reveal style="--reveal-delay: 180ms"
                         class="rounded-detail bg-surface p-[32px] shadow-detail sm:col-span-2">
                        <h3 class="pb-[11px] text-[32px] font-semibold leading-[43px] text-editorial-ink">Facilities</h3>

                        <ul class="grid grid-cols-2 gap-[21.5px]">
                            @foreach ($boat['facilities'] as $facility)
                                <li class="flex items-center gap-[11px]">
                                    <img src="{{ asset('images/icons/vessel/'.$facility['icon']) }}" alt="" class="size-[27px] shrink-0 object-contain">
                                    <span class="text-[21.5px] leading-[32px] text-editorial-body">{{ $facility['label'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </section>

            {{-- Figma node 1:1231 — fleet gallery --}}
            <section>
                <h2 data-reveal class="text-[24px] lg:text-[48.4px] font-bold leading-[30px] lg:leading-[59px] tracking-[-0.48px] text-brand">Fleet Gallery</h2>

                <div class="mt-[43px] grid grid-cols-2 gap-[21.5px]">
                    @foreach ($boat['gallery'] as $index => $photo)
                        <figure data-reveal style="--reveal-delay: {{ $index * 90 }}ms"
                                @class([
                                    'group overflow-hidden rounded-detail shadow-editorial',
                                    'col-span-2 h-[220px] lg:h-[344px]' => $loop->first,
                                    'h-[258px]' => ! $loop->first,
                                ])>
                            <img src="{{ asset('images/boats/gallery/'.$photo['image']) }}" alt="{{ $photo['alt'] }}"
                                 class="size-full object-cover transition-transform duration-700 ease-smooth group-hover:scale-105">
                        </figure>
                    @endforeach
                </div>
            </section>

            {{-- Figma node 1:1241 — guest testimonials --}}
            <section>
                <h2 data-reveal class="text-[24px] lg:text-[48.4px] font-bold leading-[30px] lg:leading-[59px] tracking-[-0.48px] text-brand">Guest Testimonials</h2>

                <div class="mt-[43px] grid [&>*]:min-w-0 gap-[32px] sm:grid-cols-2">
                    @foreach ($boat['reviews'] as $index => $review)
                        <figure data-reveal style="--reveal-delay: {{ $index * 90 }}ms"
                                class="flex flex-col gap-[21.5px] rounded-detail border border-editorial-rule bg-surface p-[44px] shadow-detail
                                       transition-[transform,box-shadow] duration-500 ease-smooth hover:-translate-y-1 hover:shadow-card-hover">
                            <div class="flex gap-[5.4px]" role="img" aria-label="{{ $review['stars'] }} out of 5 stars">
                                @for ($star = 1; $star <= 5; $star++)
                                    <img src="{{ asset('images/icons/vessel/'.($star <= $review['stars'] ? 'star-full.svg' : 'star-empty.svg')) }}"
                                         alt="" class="h-[21.3px] w-[22.4px]">
                                @endfor
                            </div>

                            <blockquote class="text-[21.5px] leading-[32px] text-editorial-body">{{ $review['quote'] }}</blockquote>

                            <figcaption class="pt-[11px]">
                                <span class="block text-[18.8px] font-bold leading-[27px] tracking-[0.94px] text-editorial-ink">{{ $review['name'] }}</span>
                                <span class="block text-[18.8px] leading-[27px] text-editorial-meta">{{ $review['traveled'] }}</span>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </section>
        </div>

        @include('partials.boat.booking-widget', ['routes' => $boat['routes'], 'slug' => $boat['slug']])
    </div>
@endsection
