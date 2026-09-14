{{-- Figma nodes 1:5089 (boat) / 1:3848 (activity) — mobile listing hero (390×300): centred title + subtitle over a photo.
     `overlay` = 'brand' paints the photo on brand blue with a light-blue subtitle; 'dark' lays a black gradient over it. --}}
@props(['image', 'title', 'subtitle', 'overlay' => 'brand'])

<header @class(['relative flex h-[300px] items-center justify-center overflow-hidden lg:hidden', 'bg-brand' => $overlay === 'brand'])>
    <img src="{{ $image }}" alt="" class="absolute inset-0 size-full object-cover object-bottom">

    @if ($overlay === 'dark')
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/20 to-black/60 backdrop-blur-[1px]"></div>
    @endif

    <div class="relative flex flex-col items-center gap-[16px] px-[24px] text-center">
        <h1 data-reveal class="text-[28px] font-bold leading-[36px] text-white">{{ $title }}</h1>
        <p data-reveal style="--reveal-delay: 100ms"
           @class(['max-w-[448px] px-[6px] text-[16px] leading-[24px]', 'text-[#d2e4ff]' => $overlay === 'brand', 'text-white/90' => $overlay === 'dark'])>
            {{ $subtitle }}
        </p>
    </div>
</header>
