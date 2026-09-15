{{-- Validation summary shown above the traveller form after a failed submit. --}}
@if ($errors->any())
    <div role="alert" class="rounded-[11px] border border-red-200 bg-red-50 px-[20px] py-[16px] font-jakarta text-red-800">
        <p class="text-[16px] font-semibold leading-[24px]">Please check the highlighted details:</p>
        <ul class="mt-[6px] list-disc ps-[20px] text-[15px] leading-[24px]">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
