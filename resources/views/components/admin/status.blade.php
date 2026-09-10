{{-- Status pill used across every console table (Figma 1:6972). --}}
@props(['label', 'tone' => 'active'])

@php
    $tones = [
        'active'    => ['bg-[#dcfce7]', 'text-[#166534]', 'bg-[#16a34a]'],
        'published' => ['bg-[#dcfce7]', 'text-[#166534]', 'bg-[#16a34a]'],
        'draft'     => ['bg-[#fef9c3]', 'text-[#854d0e]', 'bg-[#ca8a04]'],
        'inactive'  => ['bg-[#ffedd5]', 'text-[#9a3412]', 'bg-[#ea580c]'],
    ];

    [$bg, $text, $dot] = $tones[$tone] ?? $tones['active'];
@endphp

<span class="inline-flex items-center gap-[6px] rounded-full {{ $bg }} px-[10px] py-[4px] text-[12px] font-semibold leading-[16px] {{ $text }}">
    <span class="size-[6px] rounded-full {{ $dot }}"></span>
    {{ $label }}
</span>
