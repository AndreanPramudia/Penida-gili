{{-- One-shot success banner after a console action. --}}
@if (session('flash'))
    <div role="status" class="mt-[24px] rounded-[10px] border border-[#bbf7d0] bg-[#f0fdf4] px-[20px] py-[14px] font-jakarta text-[15px] text-[#166534]">
        {{ session('flash') }}
    </div>
@endif

@if ($errors->any())
    <div role="alert" class="mt-[24px] rounded-[10px] border border-red-200 bg-red-50 px-[20px] py-[14px] font-jakarta text-[15px] text-red-800">
        Please fix the highlighted fields below.
    </div>
@endif
