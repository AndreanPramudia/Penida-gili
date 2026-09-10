{{-- Card with a tinted, icon-led header — the repeating unit of every console
     "Add new …" screen (Figma 1:7159, 1:7206, 1:7222). --}}
@props(['title', 'icon'])

<section class="overflow-hidden rounded-admin border border-[rgba(192,199,211,0.3)] bg-surface shadow-sm">
    <h2 class="flex items-center gap-[12px] border-b border-[rgba(192,199,211,0.3)] bg-[#f7fafc] px-[24px] pb-[17px] pt-[16px]">
        <img src="{{ asset('images/icons/admin/'.$icon) }}" alt="" class="size-[20px] object-contain">
        <span class="font-jakarta text-[24px] font-semibold leading-[32px] text-editorial-ink">{{ $title }}</span>
    </h2>

    <div class="p-[24px]">
        {{ $slot }}
    </div>
</section>
