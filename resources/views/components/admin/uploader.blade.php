{{-- Dashed drop zone (Figma 1:7212). A real file input sits behind the label so
     the control works without any JavaScript. --}}
@props(['name' => 'photos', 'hint' => 'SVG, PNG, JPG or GIF (MAX. 800x400px)'])

<label class="flex cursor-pointer flex-col items-center justify-center rounded-admin border-2 border-dashed border-[rgba(192,199,211,0.6)] bg-[#f7fafc] p-[34px]
              transition-colors duration-300 hover:border-editorial hover:bg-[#eef4f8]">
    <input type="file" name="{{ $name }}[]" multiple class="sr-only">

    <span class="mb-[16px] flex size-[64px] items-center justify-center rounded-full bg-[#d5e2e9]">
        <img src="{{ asset('images/icons/admin/form-upload.svg') }}" alt="" class="size-[20px]">
    </span>

    <span class="font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink">Click to upload or drag and drop</span>
    <span class="font-jakarta text-[14px] leading-[20px] text-editorial-body">{{ $hint }}</span>
</label>
