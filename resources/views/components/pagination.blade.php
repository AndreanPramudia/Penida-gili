{{-- Figma node 1:611 — Pagination (V2) --}}
@props(['paginator'])

@php
    $current = $paginator->currentPage();
    $last    = $paginator->lastPage();
    $window  = collect(range(max(1, $current - 1), min($last, $current + 1)));
    $pages   = collect([1])->merge($window)->push($last)->unique()->sort()->values();
@endphp

<nav class="flex items-start justify-center gap-[6.25px]" aria-label="Pagination">
    @foreach (['first' => $paginator->url(1), 'prev' => $paginator->previousPageUrl()] as $control => $url)
        <a href="{{ $url ?? '#' }}" aria-label="{{ $control }} page"
           @class([
               'flex size-[40px] items-center justify-center rounded-pill border-[1.25px] border-line bg-surface p-[12.5px]',
               'pointer-events-none opacity-40' => $paginator->onFirstPage(),
           ])>
            <img src="{{ asset('images/icons/pg-'.$control.'.svg') }}" alt="" class="size-[20px]">
        </a>
    @endforeach

    @php $previous = 0; @endphp
    @foreach ($pages as $page)
        @if ($page - $previous > 1)
            <span class="flex size-[40px] items-center justify-center rounded-[8px] bg-surface p-[12.5px] text-[20.31px] font-semibold text-ink-soft">...</span>
        @endif

        <a href="{{ $paginator->url($page) }}"
           @class([
               'flex size-[40px] items-center justify-center rounded-pill p-[12.5px] text-[20.31px] font-semibold transition-colors duration-300',
               'bg-brand text-on-brand' => $page === $current,
               'border-[1.25px] border-line bg-surface text-ink-soft hover:border-brand hover:text-brand' => $page !== $current,
           ])
           @if ($page === $current) aria-current="page" @endif>
            {{ $page }}
        </a>
        @php $previous = $page; @endphp
    @endforeach

    @foreach (['next' => $paginator->nextPageUrl(), 'last' => $paginator->url($last)] as $control => $url)
        <a href="{{ $url ?? '#' }}" aria-label="{{ $control }} page"
           @class([
               'flex size-[40px] items-center justify-center rounded-pill border-[1.25px] border-line bg-surface p-[12.5px]',
               'pointer-events-none opacity-40' => ! $paginator->hasMorePages(),
           ])>
            <img src="{{ asset('images/icons/pg-'.$control.'.svg') }}" alt="" class="size-[20px]">
        </a>
    @endforeach
</nav>
