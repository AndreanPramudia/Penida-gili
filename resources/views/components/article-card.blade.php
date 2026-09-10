{{-- Figma node 1:2186 — Article grid card --}}
@props([
    'title',
    'excerpt',
    'category',
    'readTime',
    'date',
    'author',
    'image',
    'href' => '#',
    'delay' => 0,
])

<article data-reveal style="--reveal-delay: {{ $delay }}ms"
         class="group relative flex h-full flex-col overflow-hidden rounded-editorial border border-editorial-line bg-surface shadow-editorial
                transition-[transform,box-shadow] duration-500 ease-smooth hover:-translate-y-2 hover:shadow-editorial-hover">
    <div class="relative h-[287px] shrink-0 overflow-hidden">
        <img src="{{ $image }}" alt="{{ $title }}"
             class="size-full object-cover transition-transform duration-700 ease-smooth group-hover:scale-105">

        <span class="absolute left-[15px] top-[15px] rounded-full bg-white/90 px-[15px] py-[5px] text-[15.4px] font-semibold leading-[20.5px] text-editorial backdrop-blur-[8px]">
            {{ $category }}
        </span>
    </div>

    <div class="flex flex-1 flex-col justify-between p-[31px] font-jakarta">
        <div class="flex flex-col gap-[13px]">
            <p class="flex items-center gap-[10px] text-[15.4px] font-medium leading-[20.5px] text-editorial-meta">
                <span>{{ $readTime }}</span>
                <span aria-hidden="true">&bull;</span>
                <span>{{ $date }}</span>
            </p>

            <h3 class="text-[30.8px] font-semibold leading-[42.3px] text-editorial-ink transition-colors duration-300 group-hover:text-editorial">
                <a href="{{ $href }}" class="before:absolute before:inset-0">{{ $title }}</a>
            </h3>

            <p class="text-[17.95px] leading-[25.6px] text-editorial-body">{{ $excerpt }}</p>
        </div>

        <div class="mt-[20px] flex items-center justify-between border-t border-editorial-rule pt-[27px]">
            <span class="text-[15.4px] font-medium leading-[20.5px] text-editorial-body">By {{ $author }}</span>

            <span class="flex items-center gap-[5px] text-[15.4px] font-semibold leading-[20.5px] text-editorial">
                Read Guide
                <img src="{{ asset('images/icons/article/arrow-small.svg') }}" alt=""
                     class="size-[13.7px] transition-transform duration-300 ease-smooth group-hover:translate-x-1">
            </span>
        </div>
    </div>
</article>
