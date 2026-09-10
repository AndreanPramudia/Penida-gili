{{-- Card whose header carries a rounded icon tile, a title, an optional
     description line and an optional trailing badge — the unit used across the
     long console editors (Figma 1:8502, 1:8059, 1:7501). --}}
@props(['title', 'icon', 'description' => null, 'badge' => null, 'badgeTone' => 'brand'])

<section class="rounded-admin border border-[rgba(192,199,211,0.3)] bg-surface shadow-sm">
    <div class="flex items-start justify-between gap-4 border-b border-[rgba(192,199,211,0.3)] p-[20px]">
        <div class="flex items-start gap-[12px]">
            <span class="flex size-[36px] shrink-0 items-center justify-center rounded-[10px] bg-editorial/10">
                <img src="{{ asset('images/icons/admin/'.$icon) }}" alt="" class="size-[18px] object-contain">
            </span>
            <div>
                <h2 class="font-jakarta text-[18px] font-semibold leading-[26px] text-editorial-ink">{{ $title }}</h2>
                @if ($description)
                    <p class="font-jakarta text-[14px] leading-[20px] text-editorial-body">{{ $description }}</p>
                @endif
            </div>
        </div>

        @if ($badge)
            <span @class([
                'shrink-0 rounded-full px-[10px] py-[4px] font-jakarta text-[12px] font-semibold',
                'bg-editorial/10 text-editorial' => $badgeTone === 'brand',
                'bg-[#f1f4f6] text-editorial-body' => $badgeTone === 'muted',
            ])>{{ $badge }}</span>
        @endif
    </div>

    <div class="p-[20px]">
        {{ $slot }}
    </div>
</section>
