{{-- Figma node 1:2102 — hero copy + category tabs + search --}}
@php
    $categories = ['All Articles', 'Travel Guides', 'Nusa Penida Tips', 'Boat Schedules & Safety', 'Hidden Gems', 'Island Activities'];
@endphp

<section class="container-page pt-[34px] lg:pt-[82px] font-jakarta">
    <div data-reveal class="flex max-w-[985px] flex-col items-start gap-[20.5px]">
        <span class="flex items-center gap-[10px] rounded-full bg-editorial-badge px-[18px] py-[7.7px] text-[17.95px] font-semibold leading-[25.6px] tracking-[0.9px] text-editorial-badge-ink">
            <img src="{{ asset('images/icons/article/journal.svg') }}" alt="" class="h-[13.7px] w-[18.8px]">
            Maritime Journal &amp; Island Insights
        </span>

        <h2 class="text-[26px] lg:text-[61.5px] font-bold leading-[35px] lg:leading-[77px] tracking-[-1.23px] text-editorial-ink">
            Travel Articles &amp; Island Guides
        </h2>

        <p class="text-[23px] leading-[37.5px] text-editorial-body">
            Inspiration, guides, and tips for your fast boat travel and island adventures across Bali, Nusa
            Penida, Lembongan, and Gili Islands.
        </p>
    </div>

    <div data-reveal style="--reveal-delay: 120ms"
         class="mt-[51px] flex items-center justify-between gap-6">
        {{-- Figma 1:2113 "Scrollable Category Tabs" — the pill row scrolls, the search field stays put. --}}
        <ul class="flex flex-1 items-center gap-[10px] overflow-x-auto pb-1">
            @foreach ($categories as $category)
                <li class="shrink-0">
                    <a href="#"
                       @class([
                           'block rounded-full px-[27px] py-[14px] text-[17.95px] font-semibold leading-[25.6px] tracking-[0.9px] transition-colors duration-300',
                           'bg-editorial text-white shadow-sm' => $loop->first,
                           'border border-editorial-line bg-surface text-editorial-body hover:border-editorial hover:text-editorial' => ! $loop->first,
                       ])>
                        {{ $category }}
                    </a>
                </li>
            @endforeach
        </ul>

        <form action="{{ route('articles.index') }}" method="get" class="relative w-[333px] shrink-0">
            <img src="{{ asset('images/icons/article/search.svg') }}" alt=""
                 class="pointer-events-none absolute left-[18px] top-1/2 size-[19px] -translate-y-1/2">
            <label for="article-search" class="sr-only">Search guides</label>
            <input id="article-search" name="q" type="search" value="{{ request('q') }}" placeholder="Search guides, ports, tips..."
                   class="w-full rounded-full border border-editorial-line bg-surface py-[15px] pl-[52px] pr-[22px] text-[17.95px] text-editorial-ink placeholder:text-editorial-meta focus:border-editorial focus:outline-none">
        </form>
    </div>
</section>
