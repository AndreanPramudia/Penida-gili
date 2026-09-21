{{-- Pre-submit review dialog for the order forms. Filled and opened by resources/js/order-confirm.js;
     it stays inert on pages without a data-confirm form. --}}
<dialog id="booking-confirm" class="m-auto w-[calc(100%-32px)] max-w-[430px] rounded-[16px] border-0 bg-surface p-0 font-jakarta shadow-[0px_24px_60px_-12px_rgba(0,0,0,0.25)] backdrop:bg-black/40 backdrop:backdrop-blur-[2px]">
    <div class="px-[26px] pb-[20px] pt-[24px]">
        <h2 class="text-[20px] font-bold leading-[28px] text-editorial-ink">Confirm your booking</h2>
        <p class="mt-[4px] text-[14px] leading-[20px] text-editorial-body">Please double-check your details before we send the reservation.</p>
    </div>

    <dl data-confirm-rows class="flex flex-col gap-[10px] border-y border-[#e0e3e5] px-[26px] py-[18px] text-[14px] leading-[20px]"></dl>

    <div class="flex items-center justify-between gap-[12px] bg-[#f7fafc] px-[26px] py-[18px]">
        <button type="button" data-confirm-cancel
                class="rounded-[8px] border border-[#c0c7d3] bg-surface px-[18px] py-[10px] text-[14px] font-semibold text-editorial-ink transition-colors hover:bg-[#f1f4f6]">
            Edit details
        </button>
        <button type="button" data-confirm-submit
                class="rounded-[8px] bg-brand px-[18px] py-[10px] text-[14px] font-semibold text-white transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
            Confirm &amp; book
        </button>
    </div>
</dialog>
