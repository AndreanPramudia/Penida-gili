{{-- Figma nodes 1:236 (hero) + 1:244 (search bar) --}}
@php
    $fields = [
        ['icon' => 'city-from.svg', 'label' => 'From',     'placeholder' => 'Origin Place',      'name' => 'from'],
        ['icon' => 'city-to.svg',   'label' => 'To',       'placeholder' => 'Destination Place', 'name' => 'to'],
        ['icon' => 'date.svg',      'label' => 'Check In', 'placeholder' => 'Add Your Date',     'name' => 'date'],
        ['icon' => 'people.svg',    'label' => 'Guests',   'placeholder' => 'Number',            'name' => 'guests'],
    ];
@endphp

<header class="relative min-h-[486px] w-full overflow-hidden pb-[48px] lg:h-[1156px] lg:min-h-0 lg:pb-0">
    <img src="{{ asset('images/home/hero-home.png') }}" alt=""
         class="absolute inset-0 size-full object-cover object-bottom">

    <div class="relative z-10">
        @include('partials.nav', ['active' => 'home'])

        <div class="container-page">
            {{-- Intro --}}
            <div class="pt-[34px] lg:pt-[80px] text-center lg:pt-[173px] lg:text-left">
                <span data-reveal class="inline-flex h-[49px] w-[156px] items-center justify-center rounded-[30px] bg-glass-pill text-[16px] font-medium uppercase leading-[30px] text-on-hero">
                    Boat Book
                </span>

                <h1 data-reveal style="--reveal-delay: 100ms" class="mx-auto mt-[24px] max-w-[888px] lg:mx-0 lg:mt-[49px] text-[35px] lg:text-[83px] leading-[55px] lg:leading-[123px] text-on-hero">
                    Explore Tropical Island Beauty Without Limits
                </h1>

                <p data-reveal style="--reveal-delay: 200ms" class="mx-auto mt-[24px] max-w-[795px] lg:mx-0 lg:mt-[63px] text-[16px] leading-[30px] text-on-hero-muted">
                    Book fast boat tickets and private charters to your dream destinations in minutes.
                    Safe, comfortable, and hassle-free journeys.
                </p>
            </div>

            {{-- Search bar --}}
            <form action="{{ route('boats.index') }}" method="get" data-reveal style="--reveal-delay: 320ms"
                  class="mt-[40px] flex flex-col gap-[16px] rounded-search p-[24px] font-jakarta
                         bg-white/10 backdrop-blur-2xl backdrop-saturate-150
                         border border-white/25
                         shadow-[inset_0_1px_0_rgba(255,255,255,0.4),inset_0_-1px_0_rgba(255,255,255,0.1),0_8px_32px_rgba(0,0,0,0.25)]
                         lg:mt-[86px] lg:h-[131px] lg:flex-row lg:items-center lg:gap-[24px] lg:px-[38px] lg:py-0">
                @foreach ($fields as $index => $field)
                    <div class="group flex w-full items-center gap-[16px] {{ $index === 0 ? 'lg:w-auto lg:flex-none' : 'flex-1' }}">
                        <img src="{{ asset('images/icons/search/'.$field['icon']) }}" alt=""
                             class="size-[40px] shrink-0 opacity-80 transition-opacity duration-300 group-focus-within:opacity-100">
                        <label class="block w-full">
                            <span class="block text-[24px] font-medium leading-none text-on-hero">{{ $field['label'] }}</span>
                            <input type="text" name="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] }}"
                                   class="mt-[12px] w-full bg-transparent text-[21px] leading-none text-on-hero placeholder:text-on-hero-soft focus:outline-none {{ $index === 0 ? 'lg:w-[120px]' : '' }}">
                        </label>
                    </div>

                    @if ($index === 0)
                        {{-- Swap icon: centered between From & To --}}
                        <div class="hidden shrink-0 items-center justify-center self-stretch lg:flex">
                            <img src="{{ asset('images/icons/search/transfer.svg') }}" alt="Swap" class="size-[29px]">
                        </div>
                    @elseif ($index < count($fields) - 1)
                        <span class="hidden h-[85px] w-px shrink-0 bg-on-hero/30 lg:block"></span>
                    @endif
                @endforeach

                <button type="submit"
                        class="group flex h-[60px] w-full shrink-0 lg:w-[191px] items-center justify-center gap-[12px] rounded-search-btn bg-brand text-[21px] tracking-[-1px] text-on-brand
                               transition-[transform,box-shadow] duration-300 ease-smooth hover:-translate-y-0.5 hover:shadow-lg hover:shadow-brand/40">
                    <img src="{{ asset('images/icons/search/search.svg') }}" alt=""
                         class="size-[29px] transition-transform duration-500 ease-smooth group-hover:rotate-12">
                    Search
                </button>
            </form>
        </div>
    </div>
</header>   
