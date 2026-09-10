{{-- Figma node 1:621 — Nav (sits on top of the hero image) --}}
@props(['active' => null])

@php
    $links = [
        'home'     => ['label' => 'Home',     'route' => route('home')],
        'boat'     => ['label' => 'Boat',     'route' => route('boats.index')],
        'activity' => ['label' => 'Activity', 'route' => route('activities.index')],
        'hotel'    => ['label' => 'Hotel',    'route' => route('hotels.index')],
        'artikel'  => ['label' => 'Artikel',  'route' => route('articles.index')],
    ];
@endphp

<nav class="container-page hidden items-center justify-between pt-[33px] lg:flex">
    <a href="/" class="flex items-center gap-2 shrink-0">
        <img src="{{ asset('images/logo/logo-mark-light.svg') }}" alt="" class="h-[61px] w-[123px]">
        <img src="{{ asset('images/logo/logo-word-light.svg') }}" alt="Penida Gili" class="h-[61px] w-[278px]">
    </a>

    <ul class="hidden items-center gap-[70px] text-[16px] leading-[30px] lg:flex">
        @foreach ($links as $key => $link)
            <li>
                <a href="{{ $link['route'] }}"
                   class="{{ $active === $key ? 'font-bold text-on-hero' : 'font-normal text-on-hero-muted hover:text-on-hero' }}
                          relative transition-colors duration-300
                          after:absolute after:-bottom-1 after:left-0 after:h-px after:w-full after:origin-left after:bg-current
                          after:transition-transform after:duration-300 after:ease-smooth
                          {{ $active === $key ? 'after:scale-x-100' : 'after:scale-x-0 hover:after:scale-x-100' }}">
                    {{ $link['label'] }}
                </a>
            </li>
        @endforeach
    </ul>

    <a href="https://wa.me/6281236300562" target="_blank" rel="noopener"
       class="flex h-[58px] w-[206px] items-center justify-center rounded-field bg-brand text-[16px] font-medium leading-[30px] text-on-brand backdrop-blur-[4.7px]
              transition-[transform,box-shadow] duration-300 ease-smooth hover:-translate-y-0.5 hover:shadow-lg hover:shadow-brand/30">
        Contact Us
    </a>
</nav>
