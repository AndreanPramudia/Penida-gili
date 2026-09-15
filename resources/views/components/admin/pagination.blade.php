{{-- Footer pagination for console tables: summary on the left, page links on the right. --}}
@props(['paginator'])

<p class="text-[14px] leading-[20px] text-editorial-body">
    @if ($paginator->total() > 0)
        Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ number_format($paginator->total()) }} entries
    @else
        No entries yet
    @endif
</p>

@if ($paginator->hasPages())
    <nav class="flex items-center gap-[8px]" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span class="rounded-[6px] border border-editorial-line px-[14px] py-[6px] text-[14px] text-admin-nav">Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="rounded-[6px] border border-editorial-line px-[14px] py-[6px] text-[14px] text-editorial-ink transition-colors hover:bg-[#f1f4f6]">Prev</a>
        @endif

        @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
            @if ($page === $paginator->currentPage())
                <span class="rounded-[6px] bg-editorial px-[14px] py-[6px] text-[14px] text-white">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="rounded-[6px] border border-editorial-line px-[14px] py-[6px] text-[14px] text-editorial-ink transition-colors hover:bg-[#f1f4f6]">{{ $page }}</a>
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="rounded-[6px] border border-editorial-line px-[14px] py-[6px] text-[14px] text-editorial-ink transition-colors hover:bg-[#f1f4f6]">Next</a>
        @else
            <span class="rounded-[6px] border border-editorial-line px-[14px] py-[6px] text-[14px] text-admin-nav">Next</span>
        @endif
    </nav>
@endif
