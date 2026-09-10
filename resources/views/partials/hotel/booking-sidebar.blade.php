{{-- Figma node 1:1894 — sticky booking sidebar --}}
@props(['hotel'])

<aside data-reveal style="--reveal-delay: 120ms" class="lg:sticky lg:top-8">
    <form action="{{ route('hotels.order', $hotel['slug']) }}" method="get"
          class="flex flex-col gap-[20px] rounded-detail border border-editorial-line bg-surface p-[31px] shadow-[0px_10px_19px_rgba(0,0,0,0.08)]">
        <div>
            <p class="text-[17.4px] font-semibold leading-[25px] tracking-[0.87px] text-editorial-body">Starting from</p>
            <p class="text-[24px] lg:text-[44.8px] font-bold leading-[30px] lg:leading-[55px] tracking-[-0.45px] text-brand">{{ $hotel['priceFrom'] }}</p>
            <p class="pt-[1px] text-[17.4px] leading-[25px] text-editorial-body">/ night, taxes included</p>
        </div>

        {{-- Figma node 1:1903 — date + guest picker --}}
        <div class="overflow-hidden rounded-[10px] border border-[rgba(192,199,211,0.5)]">
            <div class="grid grid-cols-2 divide-x divide-[rgba(192,199,211,0.5)] border-b border-[rgba(192,199,211,0.5)]">
                <label class="flex flex-col gap-[4px] p-[15px]">
                    <span class="text-[15px] font-bold uppercase leading-[20px] tracking-[0.75px] text-editorial-body">Check-in</span>
                    <input type="date" name="check_in"
                           class="bg-transparent text-[20px] leading-[30px] text-editorial-ink focus:outline-none">
                </label>

                <label class="flex flex-col gap-[4px] p-[15px]">
                    <span class="text-[15px] font-bold uppercase leading-[20px] tracking-[0.75px] text-editorial-body">Check-out</span>
                    <input type="date" name="check_out"
                           class="bg-transparent text-[20px] leading-[30px] text-editorial-ink focus:outline-none">
                </label>
            </div>

            <label class="flex flex-col gap-[4px] p-[15px]">
                <span class="text-[15px] font-bold uppercase leading-[20px] tracking-[0.75px] text-editorial-body">Guests</span>
                <select name="guests" class="bg-transparent text-[20px] leading-[30px] text-editorial-ink focus:outline-none">
                    @foreach ($hotel['guestOptions'] as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <button type="submit"
                class="rounded-[10px] bg-brand py-[20px] text-[22.4px] font-bold leading-[35px] tracking-[1.12px] text-white shadow-lg
                       transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
            Reserve Now
        </button>

        <p class="text-center text-[15px] leading-[20px] text-editorial-body">You won&rsquo;t be charged yet.</p>
    </form>
</aside>
