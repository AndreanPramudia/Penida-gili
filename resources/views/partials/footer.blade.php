{{-- Figma node 1:622 / 1:277 — Footer --}}
@php
    $bookingLinks = [
        'Our Story'     => '#',
        'How We Help'   => '#',
        'Boat  Pricing' => '#',
        'Privacy Policy'=> '#',
    ];
    $socials = [
        'Dribbble'  => 'social-dribbble.svg',
        'Behance'   => 'social-behance.svg',
        'Instagram' => 'social-instagram.svg',
        'Twitter'   => 'social-twitter.svg',
    ];
@endphp

<footer class="border-t border-line-card pt-[36px] lg:pt-[86px] pb-[36px]">
    <div class="container-page grid gap-16 lg:grid-cols-[1fr_1fr_1fr]">
        {{-- Logo + blurb --}}
        <div>
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo/logo-mark-dark.svg') }}" alt="" class="h-[61px] w-[112px]">
                <img src="{{ asset('images/logo/logo-word-dark.svg') }}" alt="Penida Gili" class="h-[61px] w-[231px]">
            </div>
            <p class="mt-[24px] max-w-[310px] text-[16px] leading-[30px] text-ink-muted">
                Penida Gili is your premier Boat. We provide boat rental services.
            </p>
            <p class="mt-[74px] lg:mt-[176px] text-[16px] leading-[30px] text-ink-muted">Penida Gili</p>
        </div>

        {{-- Section 02 --}}
        <div>
            <h2 class="text-[20px] leading-[30px] text-ink">Boat Booking</h2>
            <ul class="mt-[19px]">
                @foreach ($bookingLinks as $label => $href)
                    <li>
                        <a href="{{ $href }}"
                           class="inline-block text-[16px] leading-[30px] lg:leading-[49px] text-ink-muted transition-[color,transform] duration-300 ease-smooth hover:translate-x-1 hover:text-ink">{{ $label }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Section 04 --}}
        <div>
            <h2 class="text-[20px] leading-[30px] text-ink">Join a Newsletter</h2>

            <form action="#" method="post" class="mt-[28px] lg:mt-[67px]">
                @csrf
                <label for="newsletter-email" class="block text-[16px] leading-[30px] text-ink-muted">Your Email</label>
                <div class="mt-[19px] flex items-center gap-[24px]">
                    <input id="newsletter-email" name="email" type="email" placeholder="Enter Your Email"
                           class="h-[58px] w-full max-w-[326px] rounded-field bg-surface-muted px-[26px] text-[16px] leading-[30px] text-ink placeholder:text-ink-muted focus:outline-2 focus:outline-brand">
                    <button type="submit"
                            class="h-[58px] w-[86px] shrink-0 rounded-field bg-brand text-[16px] font-medium leading-[30px] text-on-brand backdrop-blur-[4.7px]
                                   transition-[transform,box-shadow] duration-300 ease-smooth hover:-translate-y-0.5 hover:shadow-lg hover:shadow-brand/30">
                        Submit
                    </button>
                </div>
            </form>

            <ul class="mt-[24px] lg:mt-[57px] flex items-center gap-[18px]">
                @foreach ($socials as $name => $icon)
                    <li>
                        <a href="#" aria-label="{{ $name }}"
                           class="block size-[40px] transition-transform duration-300 ease-smooth hover:-translate-y-1">
                            <img src="{{ asset('images/icons/'.$icon) }}" alt="" class="size-full">
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="container-page mt-[50px] border-t border-line-card pt-[20px]">
        <p class="text-center text-[16px] leading-[30px] text-ink-muted">
            &copy; Copyright Penida Gili  {{ date('Y') }} | Design &amp; Develop MaiHarta
        </p>
    </div>
</footer>
