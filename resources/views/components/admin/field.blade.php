{{-- Label + control pair used throughout the console forms (Figma 1:7166). --}}
@props([
    'label',
    'name',
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'options' => null,
    'required' => false,
    'prefix' => null,
])

@php
    $control = 'w-full rounded-[8px] border border-[rgba(192,199,211,0.5)] bg-[#f7fafc] px-[17px] py-[13px]'
        .' font-jakarta text-[16px] leading-[24px] text-editorial-ink placeholder:text-editorial-meta'
        .' focus:border-editorial focus:outline-none';
@endphp

<label class="flex flex-col gap-[8px]">
    <span class="font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink">
        {{ $label }}@if ($required) *@endif
    </span>

    @if ($options)
        <span class="relative block">
            <select name="{{ $name }}" class="{{ $control }} appearance-none pr-[44px]">
                @foreach ($options as $option)
                    <option>{{ $option }}</option>
                @endforeach
            </select>
            <img src="{{ asset('images/icons/admin/form-chevron.svg') }}" alt=""
                 class="pointer-events-none absolute right-[12px] top-1/2 size-[24px] -translate-y-1/2">
        </span>
    @elseif ($type === 'textarea')
        <textarea name="{{ $name }}" rows="4" placeholder="{{ $placeholder }}" class="{{ $control }}">{{ $value }}</textarea>
    @elseif ($prefix)
        <span class="flex items-center rounded-[8px] border border-[rgba(192,199,211,0.5)] bg-[#f7fafc] pl-[17px]">
            <span class="font-jakarta text-[16px] leading-[24px] text-editorial-body">{{ $prefix }}</span>
            <input type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" placeholder="{{ $placeholder }}"
                   class="w-full bg-transparent px-[10px] py-[13px] font-jakarta text-[16px] leading-[24px] text-editorial-ink placeholder:text-editorial-meta focus:outline-none">
        </span>
    @else
        <input type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" placeholder="{{ $placeholder }}" class="{{ $control }}">
    @endif
</label>
