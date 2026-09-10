{{-- Switch built from a real checkbox so it submits and works without JS
     (Figma 1:8502 "Public Visibility", "Instant Confirmation"). --}}
@props(['name', 'label', 'description' => null, 'checked' => false])

<label class="flex items-center justify-between gap-[16px]">
    <span>
        <span class="block font-jakarta text-[15px] font-semibold text-editorial-ink">{{ $label }}</span>
        @if ($description)
            <span class="block font-jakarta text-[13px] leading-[18px] text-editorial-body">{{ $description }}</span>
        @endif
    </span>

    <input type="checkbox" name="{{ $name }}" @checked($checked)
           class="peer sr-only">
    <span class="relative h-[24px] w-[44px] shrink-0 rounded-full bg-[#c0c7d3] transition-colors duration-300 peer-checked:bg-editorial
                 after:absolute after:left-[3px] after:top-[3px] after:size-[18px] after:rounded-full after:bg-white
                 after:transition-transform after:duration-300 peer-checked:after:translate-x-[20px]"></span>
</label>
