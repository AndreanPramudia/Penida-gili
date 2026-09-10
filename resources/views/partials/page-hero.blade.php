{{-- Short banner hero shared by the inner listing pages (Figma: 311px tall). --}}
@props(['image', 'title', 'subtitle', 'active'])

<header class="relative min-h-[193px] w-full overflow-hidden pb-[24px] lg:h-[311px] lg:min-h-0 lg:pb-0">
    <img src="{{ $image }}" alt="" class="absolute inset-0 size-full object-cover object-bottom">

    <div class="relative z-10">
        @include('partials.nav', ['active' => $active])

        <div class="container-page mt-[7px] text-center">
            <h1 data-reveal class="text-[24px] lg:text-[48px] font-bold leading-[30px] lg:leading-[60px] text-on-hero">{{ $title }}</h1>
            <p data-reveal style="--reveal-delay: 100ms"
               class="mx-auto mt-[4px] max-w-[888px] text-[16px] leading-[30px] text-on-hero-muted">
                {{ $subtitle }}
            </p>
        </div>
    </div>
</header>
