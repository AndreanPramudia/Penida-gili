{{-- Edit / delete buttons at the end of each console row (Figma 1:6977). --}}
@props(['label'])

<span class="flex items-center justify-end gap-[4px]">
    <button type="button" aria-label="Edit {{ $label }}"
            class="flex size-[32px] items-center justify-center rounded-full transition-colors duration-300 hover:bg-[#f1f4f6]">
        <img src="{{ asset('images/icons/admin/action-edit.svg') }}" alt="" class="size-[15px]">
    </button>

    <button type="button" aria-label="Delete {{ $label }}"
            class="flex size-[32px] items-center justify-center rounded-full transition-colors duration-300 hover:bg-[#fee2e2]">
        <img src="{{ asset('images/icons/admin/action-delete.svg') }}" alt="" class="h-[15px] w-[13.3px]">
    </button>
</span>
