{{-- Figma node 1:2133 — featured article hero card --}}
@props(['article'])

<section class="container-page pt-[34px] lg:pt-[82px] font-jakarta">
    <article data-reveal
             class="group grid overflow-hidden rounded-editorial border border-editorial-line bg-surface shadow-editorial
                    transition-shadow duration-500 ease-smooth hover:shadow-editorial-hover lg:grid-cols-12">
        <div class="relative min-h-[590px] overflow-hidden lg:col-span-7">
            <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}"
                 class="size-full object-cover transition-transform duration-700 ease-smooth group-hover:scale-105">

            <span class="absolute left-[20.5px] top-[20.5px] flex items-center gap-[7.7px] rounded-full bg-editorial px-[18px] py-[7.7px] text-[17.95px] font-semibold leading-[25.6px] tracking-[0.9px] text-white shadow-lg">
                <img src="{{ asset('images/icons/article/featured.svg') }}" alt="" class="size-[17px]">
                Featured Guide
            </span>
        </div>

        <div class="flex flex-col justify-between p-[51px] lg:col-span-5">
            <div class="flex flex-col gap-[20.5px]">
                <p class="flex flex-wrap items-center gap-[10px] text-[17.95px] leading-[25.6px] tracking-[0.9px]">
                    <span class="font-bold text-editorial">{{ $article['category'] }}</span>
                    <span class="font-semibold text-editorial-body" aria-hidden="true">&bull;</span>
                    <span class="font-semibold text-editorial-body">{{ $article['readTime'] }}</span>
                    <span class="font-semibold text-editorial-body" aria-hidden="true">&bull;</span>
                    <span class="font-semibold text-editorial-body">{{ $article['date'] }}</span>
                </p>

                <h3 class="text-[24px] lg:text-[46px] font-bold leading-[30px] lg:leading-[56.4px] tracking-[-0.46px] text-editorial-ink">
                    {{ $article['title'] }}
                </h3>

                <p class="text-[20.5px] leading-[33.3px] text-editorial-body">{{ $article['excerpt'] }}</p>
            </div>

            <div class="mt-[31px] flex items-center justify-between border-t border-editorial-rule pt-[42px]">
                <div class="flex items-center gap-[15px]">
                    <span class="flex size-[56px] shrink-0 items-center justify-center rounded-full border border-editorial-line bg-[#d8e4eb]">
                        <img src="{{ asset('images/icons/article/author.svg') }}" alt="" class="size-[20.5px]">
                    </span>
                    <span>
                        <span class="block text-[17.95px] font-semibold leading-[25.6px] tracking-[0.9px] text-editorial-ink">{{ $article['author'] }}</span>
                        <span class="block text-[15.4px] leading-[20.5px] text-editorial-meta">{{ $article['authorRole'] }}</span>
                    </span>
                </div>

                <a href="{{ $article['href'] }}"
                   class="flex items-center gap-[7.7px] text-[17.95px] font-semibold leading-[25.6px] tracking-[0.9px] text-editorial">
                    Read Article
                    <img src="{{ asset('images/icons/article/arrow-link.svg') }}" alt=""
                         class="size-[15.4px] transition-transform duration-300 ease-smooth group-hover:translate-x-1">
                </a>
            </div>
        </div>
    </article>
</section>
