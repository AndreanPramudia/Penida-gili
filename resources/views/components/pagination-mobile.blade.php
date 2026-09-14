{{-- Figma nodes 1:5187 (boat: first/prev … next/last pills) / 1:4003 (activity: simplified prev · pages · next).
     Pass `simple => true` for the second style. Shown below lg only. --}}
@props(['paginator', 'simple' => false])

@php
    $current = $paginator->currentPage();
    $last    = $paginator->lastPage();
    $window  = collect(range(max(1, $current - 1), min($last, $current + 1)));
    $pages   = collect([1])->merge($window)->push($last)->unique()->sort()->values();

    $before = $simple
        ? ['prev' => $paginator->previousPageUrl()]
        : ['first' => $paginator->url(1), 'prev' => $paginator->previousPageUrl()];
    $after = $simple
        ? ['next' => $paginator->nextPageUrl()]
        : ['next' => $paginator->nextPageUrl(), 'last' => $paginator->url($last)];

    $arrowClass = $simple
        ? 'flex size-[40px] items-center justify-center rounded-full border border-[#717782] bg-surface'
        : 'flex h-[40px] w-[25.5px] items-center justify-center rounded-full border border-[#c0c7d3] bg-surface';
    $arrowIcon = fn (string $control) => asset('images/icons/mobile/list/pg-'.$control.($simple ? '-simple' : '').'.svg');
@endphp

<nav @class(['flex items-center justify-center', 'gap-[8px]' => true]) aria-label="Pagination">
    @foreach ($before as $control => $url)
        <a href="{{ $url ?? '#' }}" aria-label="{{ $control }} page"
           @class([$arrowClass, 'pointer-events-none opacity-40' => $paginator->onFirstPage()])>
            <img src="{{ $arrowIcon($control) }}" alt="" @class(['w-auto', 'h-[10px]' => $simple, 'h-[7px]' => ! $simple])>
        </a>
    @endforeach

    <div @class(['flex items-center', 'gap-[8px]' => $simple, 'gap-[4px]' => ! $simple])>
        @php $previous = 0; @endphp
        @foreach ($pages as $page)
            @if ($page - $previous > 1)
                <span @class(['flex items-center justify-center text-[16px] leading-[24px] text-[#414751]', 'size-[40px]' => ! $simple])>...</span>
            @endif

            <a href="{{ $paginator->url($page) }}"
               @class([
                   'flex size-[40px] items-center justify-center rounded-full transition-colors duration-300',
                   'text-[16px] font-semibold leading-[24px]' => $simple,
                   'text-[14px] font-semibold leading-[20px] tracking-[0.7px]' => ! $simple,
                   'bg-brand text-white drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)]' => $page === $current,
                   'border border-[#717782] font-normal text-[#181c1e]' => $simple && $page !== $current,
                   'text-[#414751]' => ! $simple && $page !== $current,
               ])
               @if ($page === $current) aria-current="page" @endif>
                {{ $page }}
            </a>
            @php $previous = $page; @endphp
        @endforeach
    </div>

    @foreach ($after as $control => $url)
        <a href="{{ $url ?? '#' }}" aria-label="{{ $control }} page"
           @class([$arrowClass, 'pointer-events-none opacity-40' => ! $paginator->hasMorePages()])>
            <img src="{{ $arrowIcon($control) }}" alt="" @class(['w-auto', 'h-[10px]' => $simple, 'h-[7px]' => ! $simple])>
        </a>
    @endforeach
</nav>
