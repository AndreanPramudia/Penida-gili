{{-- Stacked radio cards — Publishing Status / Publishing Settings
     (Figma 1:8502, 1:8059). --}}
@props(['name', 'options'])

<div class="flex flex-col gap-[10px]">
    @foreach ($options as $option)
        <label @class([
            'flex cursor-pointer items-start gap-[12px] rounded-[10px] border p-[14px] transition-colors duration-300',
            'border-editorial bg-editorial/5' => ! empty($option['checked']),
            'border-[rgba(192,199,211,0.5)] hover:bg-[#f7fafc]' => empty($option['checked']),
        ])>
            <input type="radio" name="{{ $name }}" value="{{ $option['label'] }}" @checked(! empty($option['checked']))
                   class="mt-[3px] size-[16px] accent-[#005ea1]">
            <span>
                <span class="block font-jakarta text-[15px] font-semibold text-editorial-ink">{{ $option['label'] }}</span>
                <span class="block font-jakarta text-[13px] leading-[18px] text-editorial-body">{{ $option['description'] }}</span>
            </span>
        </label>
    @endforeach
</div>
