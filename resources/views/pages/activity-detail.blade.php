{{-- Figma node 1:1442 — Activity Detail --}}
@extends('layouts.app')

@section('title', $activity['name'])

@section('nav-active', 'activity')

@section('hero')
    <header class="relative min-h-[150px] w-full overflow-hidden pb-[24px] lg:h-[184px] lg:min-h-0 lg:pb-0">
        <img src="{{ asset('images/activities/detail/hero-strip.png') }}" alt=""
             class="absolute inset-0 size-full object-cover">

        <div class="relative z-10">
            @include('partials.nav', ['active' => 'activity'])
        </div>
    </header>
@endsection

@section('content')
    {{-- Figma node 1:1447 — image grid --}}
    <section class="container-page pt-[43px]">
        <div data-reveal class="grid [&>*]:min-w-0 gap-[21.4px] overflow-hidden rounded-detail md:grid-cols-3 md:grid-rows-2">
            <figure class="group overflow-hidden rounded-detail md:col-span-2 md:row-span-2">
                <img src="{{ asset('images/activities/detail/'.$activity['gallery'][0]['image']) }}" alt="{{ $activity['gallery'][0]['alt'] }}"
                     class="size-full object-cover transition-transform duration-700 ease-smooth group-hover:scale-105">
            </figure>

            @foreach (array_slice($activity['gallery'], 1) as $photo)
                <figure class="group h-[220px] lg:h-[323px] overflow-hidden rounded-detail">
                    <img src="{{ asset('images/activities/detail/'.$photo['image']) }}" alt="{{ $photo['alt'] }}"
                         class="size-full object-cover transition-transform duration-700 ease-smooth group-hover:scale-105">
                </figure>
            @endforeach
        </div>
    </section>

    {{-- Figma node 1:1584 — two column layout --}}
    <div class="container-page mt-[27px] lg:mt-[64px] grid [&>*]:min-w-0 gap-[32px] lg:grid-cols-[minmax(0,986fr)_minmax(0,477fr)] lg:gap-[32px]">
        <div>
            {{-- Figma node 1:1586 — header info --}}
            <div data-reveal class="border-b border-editorial-line pb-[33px]">
                <span class="inline-block rounded-full bg-[#d5e2e9] px-[16px] py-[5.3px] text-[16px] leading-[32px] text-[#58646a]">
                    {{ $activity['badge'] }}
                </span>

                <h1 class="mt-[10.7px] text-[27px] lg:text-[64px] font-bold leading-[36px] lg:leading-[80px] tracking-[-1.28px] text-editorial-ink">{{ $activity['name'] }}</h1>

                <ul class="mt-[21.4px] flex flex-wrap gap-[21.4px] text-[21.4px] leading-[32px] text-editorial-body">
                    @foreach ($activity['meta'] as $item)
                        <li class="flex items-center gap-[10.7px]">
                            <img src="{{ asset('images/icons/detail/'.$item['icon']) }}" alt="" class="size-[26.7px] object-contain">
                            {{ $item['label'] }}
                        </li>
                    @endforeach
                </ul>

                <p class="mt-[21.4px] text-[21.4px] leading-[34.7px] text-editorial-ink">{{ $activity['intro'] }}</p>
            </div>

            {{-- Figma node 1:1613 — feature highlights --}}
            <ul data-reveal style="--reveal-delay: 90ms"
                class="flex flex-col gap-[21.4px] border-b border-editorial-line py-[33px] sm:flex-row">
                @foreach ($activity['highlights'] as $highlight)
                    <li class="flex flex-1 items-start gap-[16px]">
                        <img src="{{ asset('images/icons/detail/'.$highlight['icon']) }}" alt="" class="h-[56px] w-[45px] shrink-0 object-contain">
                        <span>
                            <span class="block text-[21.4px] font-semibold leading-[32px] text-editorial-ink">{{ $highlight['title'] }}</span>
                            <span class="block text-[18.7px] font-semibold leading-[26.7px] tracking-[0.93px] text-editorial-body">{{ $highlight['note'] }}</span>
                        </span>
                    </li>
                @endforeach
            </ul>

            {{-- Figma node 1:1638 — content tabs --}}
            <nav data-reveal class="flex gap-[32px] overflow-x-auto border-b border-editorial-line pb-[12px] pt-[21.4px]" aria-label="Activity sections">
                @foreach ($activity['tabs'] as $tab)
                    <a href="#{{ $tab['anchor'] }}"
                       @class([
                           'shrink-0 whitespace-nowrap pb-[13.3px] text-[21.4px] leading-[32px] transition-colors duration-300',
                           'border-b-[2.7px] border-brand font-bold text-brand' => $loop->first,
                           'text-editorial-body hover:text-brand' => ! $loop->first,
                       ])>
                        {{ $tab['label'] }}
                    </a>
                @endforeach
            </nav>

            {{-- Figma node 1:1647 — summary --}}
            <section id="summary" class="pt-[43px]">
                <h2 data-reveal class="text-[32px] font-semibold leading-[42.7px] text-editorial-ink">Summary</h2>
                <p data-reveal class="mt-[21.4px] text-[21.4px] leading-[34.7px] text-editorial-ink">{{ $activity['summary'] }}</p>

                <figure data-reveal class="group mt-[21.4px] h-[228px] lg:h-[544px] overflow-hidden rounded-detail">
                    <img src="{{ asset('images/activities/detail/'.$activity['summaryImage']['image']) }}" alt="{{ $activity['summaryImage']['alt'] }}"
                         class="size-full object-cover transition-transform duration-700 ease-smooth group-hover:scale-105">
                </figure>
            </section>

            {{-- Figma node 1:1654 — experiences --}}
            <section id="experiences" class="pt-[43px]">
                <h2 data-reveal class="text-[32px] font-semibold leading-[42.7px] text-editorial-ink">Experiences Awaiting You</h2>

                <div class="mt-[32px] flex flex-col gap-[32px]">
                    @foreach ($activity['experiences'] as $index => $experience)
                        <div data-reveal style="--reveal-delay: {{ $index * 90 }}ms" class="flex flex-col gap-[10.7px]">
                            <h3 class="text-[24px] font-semibold leading-[32px] text-editorial-ink">{{ $experience['title'] }}</h3>
                            <p class="text-[21.4px] leading-[32px] text-editorial-body">{{ $experience['body'] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        @include('partials.activity.booking-card', ['activity' => $activity])
    </div>

    {{-- Figma node 1:1454 — other activities carousel --}}
    <section class="container-page pt-[54px] lg:pt-[128px] pb-[31px] lg:pb-[74px]">
        <div data-reveal class="flex items-end justify-between gap-4">
            <h2 class="font-jakarta text-[36px] font-bold leading-[44px] tracking-[-0.36px] text-editorial-ink">
                Other Activities You Might Like
            </h2>

            <a href="{{ route('activities.index') }}" class="flex shrink-0 items-center gap-[5.3px] text-[21.4px] leading-[32px] text-brand">
                See All
                <img src="{{ asset('images/icons/detail/see-all-arrow.svg') }}" alt="" class="size-[16px]">
            </a>
        </div>

        {{-- Scrolls horizontally, matching the Figma carousel row. --}}
        <div class="mt-[37px] lg:mt-[87px] flex gap-[32px] overflow-x-auto pb-4">
            @foreach ($activity['related'] as $index => $related)
                @include('components.activity-mini-card', ['activity' => $related, 'delay' => $index * 90])
            @endforeach
        </div>
    </section>
@endsection
