{{-- Figma node 1:2360 — newsletter subscription card --}}
<section class="container-page pt-[34px] lg:pt-[82px] pb-[34px] lg:pb-[82px] font-jakarta">
    <div data-reveal class="relative overflow-hidden rounded-editorial-lg bg-editorial px-6 py-[34px] lg:py-[82px] shadow-xl">
        {{-- Ambient decorative circles --}}
        <span aria-hidden="true" class="absolute -bottom-[101px] -right-[103px] size-[410px] rounded-full bg-white/10 blur-[26px]"></span>
        <span aria-hidden="true" class="absolute -left-[103px] -top-[103px] size-[410px] rounded-full bg-white/5 blur-[26px]"></span>

        <div class="relative mx-auto flex max-w-[862px] flex-col items-center gap-[31px] text-center">
            <span class="rounded-editorial bg-white/10 p-[15px] backdrop-blur-[3px]">
                <img src="{{ asset('images/icons/article/mail.svg') }}" alt="" class="h-[27px] w-[31px]">
            </span>

            <h2 class="pt-[10px] text-[24px] lg:text-[46px] font-bold leading-[30px] lg:leading-[56.4px] tracking-[-0.46px] text-white">
                Get Island Guides &amp; Exclusive Ticket Deals
            </h2>

            <p class="max-w-[657px] text-[20.5px] leading-[33.3px] text-white/85">
                Subscribe to receive monthly harbor timetables, sea weather alerts,
                and insider discounts on Sanjaya Fastboat crossings.
            </p>

            <form action="{{ route('newsletter.store') }}" method="post" data-confirm="newsletter" class="flex w-full max-w-[574px] gap-[15px] pt-[10px]">
                @csrf
                <input type="hidden" name="source" value="articles">
                <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">
                <label for="article-newsletter" class="sr-only">Email address</label>
                <input id="article-newsletter" name="email" type="email" required value="{{ old('email') }}" placeholder="Enter your email address"
                       class="min-w-0 flex-1 rounded-[15px] bg-white px-[26px] py-[19px] text-[17.95px] text-editorial-ink shadow-sm placeholder:text-editorial-meta focus:outline-none">
                <button type="submit"
                        class="shrink-0 rounded-[15px] bg-editorial-btn px-[36px] py-[18px] text-[17.95px] font-semibold leading-[25.6px] tracking-[0.9px] text-white shadow-lg
                               transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                    Subscribe
                </button>
                @if (session('newsletter'))
                    <p class="w-full basis-full text-[15px] text-white">{{ session('newsletter') }}</p>
                @endif
                @error('email')
                    <p class="w-full basis-full text-[15px] text-white !text-red-500">{{ $message }}</p>
                @enderror
            </form>

            <p class="text-[15.4px] leading-[20.5px] text-white/70">
                We respect your privacy. Unsubscribe anytime with one single click.
            </p>
        </div>
    </div>
</section>
