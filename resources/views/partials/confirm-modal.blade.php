{{-- Confirmation dialog shown before a visitor form (booking, newsletter) is sent.
     Driven by resources/js/confirm-submit.js; forms opt in with data-confirm="booking|newsletter".
     Without JavaScript the forms submit directly and this markup stays hidden. --}}
<dialog id="confirm-modal"
        class="m-auto w-[calc(100%-32px)] max-w-[440px] rounded-[16px] border border-[rgba(192,199,211,0.3)] bg-white p-0 text-[#181c1e] shadow-[0px_20px_40px_-12px_rgba(0,0,0,0.25)]
               backdrop:bg-[rgba(24,28,30,0.55)] backdrop:backdrop-blur-[2px]"
        aria-labelledby="confirm-modal-title">
    <form method="dialog" class="flex flex-col">
        <div class="border-b border-[rgba(192,199,211,0.3)] px-[24px] py-[20px]">
            <div class="min-w-0">
                <h2 id="confirm-modal-title" class="text-[18px] font-bold leading-[28px]" data-confirm-title>Confirm your booking</h2>
                <p class="text-[14px] leading-[20px] text-[#414751]" data-confirm-intro>Please double-check your details before we send them.</p>
            </div>
        </div>

        <dl class="flex max-h-[50vh] flex-col gap-[10px] overflow-y-auto px-[24px] py-[16px] text-[14px] leading-[20px]" data-confirm-rows></dl>

        <div class="flex items-center justify-between gap-[12px] border-t border-[rgba(192,199,211,0.3)] bg-[#f7fafc] px-[24px] py-[16px] [&>*]:min-w-0">
            <button type="submit" value="cancel"
                    class="rounded-[8px] border border-[#c0c7d3] bg-white px-[18px] py-[10px] text-[14px] font-semibold leading-[20px] text-[#414751] transition-colors hover:bg-[#f1f4f6]">
                Edit details
            </button>
            <button type="submit" value="confirm" data-confirm-accept
                    class="rounded-[8px] bg-brand px-[18px] py-[10px] text-[14px] font-semibold leading-[20px] text-white shadow-[0px_4px_6px_-1px_rgba(0,0,0,0.1)] transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                Confirm &amp; send
            </button>
        </div>
    </form>
</dialog>
