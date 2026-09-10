{{-- Figma node 1:8502 — admin Add New Activity --}}
@extends('layouts.admin')

@section('title', 'Add New Activity')

@section('admin-active', 'activity')

@section('content')
    <x-admin.form-page
        heading="Add New Activity"
        subtitle="Publish cultural tours, watersports, and day experiences for Sanjaya Fastboat passengers."
        :back-href="route('admin.activities')">

        <x-slot:actions>
            <button type="submit" form="activity-form"
                    class="flex items-center gap-[8px] rounded-[8px] border border-[rgba(192,199,211,0.5)] bg-surface px-[18px] py-[10px] font-jakarta text-[14px] font-semibold text-editorial-ink
                           transition-colors duration-300 hover:bg-[#f1f4f6]">
                <img src="{{ asset('images/icons/admin/form-save.svg') }}" alt="" class="size-[16px]">
                Save Draft
            </button>

            <button type="submit" form="activity-form"
                    class="flex items-center gap-[8px] rounded-[8px] bg-editorial px-[18px] py-[10px] font-jakarta text-[14px] font-semibold text-white
                           transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                <img src="{{ asset('images/icons/admin/nav-activity.svg') }}" alt="" class="size-[16px]">
                Publish Activity
            </button>
        </x-slot:actions>

        <form id="activity-form" action="#" method="post"
              class="grid [&>*]:min-w-0 gap-[24px] lg:grid-cols-[minmax(0,640fr)_minmax(0,320fr)]">
            @csrf

            <div class="flex flex-col gap-[24px]">
                {{-- Basic information --}}
                <x-admin.panel title="Basic Information" description="General identification and core activity categorization" icon="nav-activity.svg">
                    <div class="flex flex-col gap-[20px]">
                        <x-admin.field label="Activity Title" name="title" value="Balinese Traditional Costume Rental at Penglipuran" required />

                        <div class="grid [&>*]:min-w-0 gap-[20px] sm:grid-cols-2">
                            <x-admin.field label="Category" name="category" required
                                           :options="['Cultural & Heritage', 'Water Sports', 'Photography', 'Wildlife & Nature']" />
                            <x-admin.field label="Short Catchy Tagline / Badge" name="badge" value="Best Seller" />
                        </div>

                        <x-admin.field label="Full Description" name="description" type="textarea"
                                       value="Step into the timeless living heritage of Penglipuran Village, celebrated as one of the cleanest traditional villages in the world. Immerse yourself in authentic Balinese culture by donning exquisite royal and customary Balinese attire, hand-woven with intricate songket and prada patterns." />
                    </div>
                </x-admin.panel>

                {{-- Schedule --}}
                <x-admin.panel title="Schedule & Operational Hours" description="Daily timetable, service timeframes, and customer commitment policies" icon="nav-schedule.svg">
                    <fieldset>
                        <div class="flex items-center justify-between">
                            <legend class="font-jakarta text-[14px] font-semibold text-editorial-ink">Operating Days</legend>
                            <label class="flex items-center gap-[8px] font-jakarta text-[14px] text-editorial">
                                <input type="checkbox" checked class="size-[16px] rounded-[4px] accent-[#005ea1]">
                                Select All Days
                            </label>
                        </div>

                        <div class="mt-[12px] flex flex-wrap gap-[10px]">
                            @foreach ($days as $day)
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="days[]" value="{{ $day }}" checked class="peer sr-only">
                                    <span class="block rounded-[8px] border border-editorial bg-editorial/5 px-[18px] py-[9px] font-jakarta text-[15px] text-editorial
                                                 peer-checked:bg-editorial/10">{{ $day }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>

                    <div class="mt-[20px] grid [&>*]:min-w-0 gap-[20px] sm:grid-cols-3">
                        <x-admin.field label="Opening Time" name="opens" type="time" value="08:00" />
                        <x-admin.field label="Closing Time" name="closes" type="time" value="18:00" />
                        <x-admin.field label="Duration Estimate" name="duration" value="1 - 2 Hours" />
                    </div>

                    <div class="mt-[20px] grid [&>*]:min-w-0 items-end gap-[20px] sm:grid-cols-2">
                        <x-admin.toggle name="instant_confirmation" label="Instant Confirmation"
                                        description="Automatically issue ticket vouchers on payment" :checked="true" />
                        <x-admin.field label="Cancellation Policy" name="cancellation"
                                       :options="['Free Cancellation (Up to 24 hours prior)', 'Non-refundable', 'Reschedule only']" />
                    </div>
                </x-admin.panel>

                {{-- Inclusions --}}
                <x-admin.panel title="Experience Highlights & Inclusions" description="Set clear expectations on deliverables and requirements" icon="form-check.svg">
                    <div class="flex flex-col gap-[20px]">
                        <div>
                            <p class="font-jakarta text-[14px] font-semibold text-editorial-ink">What&rsquo;s Included</p>
                            <div class="mt-[10px] flex flex-wrap gap-[10px] rounded-[10px] bg-[#f7fafc] p-[14px]">
                                @foreach ($included as $item)
                                    <span class="flex items-center gap-[8px] rounded-full bg-[#dbeafe] px-[12px] py-[6px] font-jakarta text-[13px] text-[#1d4ed8]">
                                        {{ $item }}
                                        <button type="button" aria-label="Remove {{ $item }}">&times;</button>
                                    </span>
                                @endforeach
                                <button type="button" class="font-jakarta text-[13px] text-editorial-body">+ Add inclusion…</button>
                            </div>
                        </div>

                        <div>
                            <p class="font-jakarta text-[14px] font-semibold text-editorial-ink">What&rsquo;s Excluded</p>
                            <div class="mt-[10px] flex flex-wrap gap-[10px] rounded-[10px] bg-[#f7fafc] p-[14px]">
                                @foreach ($excluded as $item)
                                    <span class="flex items-center gap-[8px] rounded-full bg-[#fee2e2] px-[12px] py-[6px] font-jakarta text-[13px] text-[#b91c1c]">
                                        {{ $item }}
                                        <button type="button" aria-label="Remove {{ $item }}">&times;</button>
                                    </span>
                                @endforeach
                                <button type="button" class="font-jakarta text-[13px] text-editorial-body">+ Add exclusion…</button>
                            </div>
                        </div>

                        <x-admin.field label="Important Notes" name="notes" type="textarea"
                                       value="- Please show your mobile e-voucher at the local reception counter upon arrival.&#10;- Costumes are available for adults and children aged 4 years and above.&#10;- Guests are kindly requested to bring comfortable walking shoes." />
                    </div>
                </x-admin.panel>

                {{-- Media --}}
                <x-admin.panel title="Media & Gallery Upload" description="Drag to reorder photos. High quality imagery increases booking conversions."
                               icon="form-camera.svg" badge="3 / 8 Photos" badge-tone="muted">
                    <x-admin.uploader name="gallery" hint="Upload high-resolution activity photos (PNG, JPG up to 10MB each, min 1280x720)" />

                    <div class="mt-[20px] grid [&>*]:min-w-0 gap-[16px] sm:grid-cols-3">
                        @foreach ($gallery as $index => $photo)
                            <figure class="relative overflow-hidden rounded-[10px]">
                                <img src="{{ asset('images/'.$photo) }}" alt="" class="h-[120px] w-full object-cover">
                                @if ($index === 0)
                                    <figcaption class="absolute left-[8px] top-[8px] rounded-[6px] bg-editorial px-[8px] py-[3px] font-jakarta text-[11px] font-semibold text-white">
                                        Hero Featured Cover
                                    </figcaption>
                                @endif
                            </figure>
                        @endforeach
                    </div>
                </x-admin.panel>
            </div>

            {{-- Right column --}}
            <aside class="flex flex-col gap-[24px]">
                <x-admin.panel title="Publishing Status" icon="form-vessel.svg">
                    <x-admin.radio-cards name="status" :options="$statuses" />

                    <div class="mt-[16px] border-t border-[rgba(192,199,211,0.3)] pt-[16px]">
                        <x-admin.toggle name="public_visibility" label="Public Visibility" description="Show on Sanjaya website portal" :checked="true" />
                    </div>
                </x-admin.panel>

                <x-admin.panel title="Pricing & Quota Capacity" icon="kpi-revenue.svg">
                    <div class="flex flex-col gap-[16px]">
                        <x-admin.field label="Base Price per Pax (IDR)" name="price" value="75.000" prefix="Rp" required />
                        <div>
                            <x-admin.field label="Original / Strikethrough Price" name="price_original" value="150.000" prefix="Rp" />
                            <p class="mt-[6px] font-jakarta text-[13px] text-editorial">Displays 50% discount badge to customers</p>
                        </div>

                        <div class="rounded-[10px] bg-[#f7fafc] p-[14px]">
                            <x-admin.toggle name="dual_pricing" label="Domestic vs Foreign Price" description="Enable dual-tier pricing model" />
                        </div>

                        <x-admin.field label="Max Daily Capacity / Quota" name="quota" type="number" value="50" required />
                    </div>
                </x-admin.panel>

                <x-admin.panel title="Location & Meeting Point" icon="nav-hotel.svg">
                    <div class="flex flex-col gap-[16px]">
                        <x-admin.field label="Destination Area" name="area" required
                                       :options="['Bangli / Penglipuran', 'Gianyar', 'Badung', 'Nusa Penida']" />
                        <x-admin.field label="Full Address / Meeting Point" name="address" type="textarea"
                                       value="Penglipuran Main Gate Information Desk, Jl. Penglipuran, Kubu, Bangli Regency, Bali 80611" />

                        <figure class="overflow-hidden rounded-[10px]">
                            <img src="{{ asset('images/hotels/detail/map.png') }}" alt="Meeting point map" class="h-[130px] w-full object-cover">
                        </figure>

                        <a href="#" class="font-jakarta text-[14px] text-editorial">Adjust Pin Coordinates</a>
                    </div>
                </x-admin.panel>

                <x-admin.panel title="Boat Ticket Bundling" icon="nav-boat.svg">
                    <p class="font-jakarta text-[14px] leading-[20px] text-editorial-body">
                        Cross-sell this experience directly alongside Sanjaya Fastboat maritime passenger tickets.
                    </p>

                    <div class="mt-[16px] flex flex-col gap-[16px]">
                        <x-admin.field label="Eligible Fastboat Route" name="bundle_route"
                                       :options="['Sanur → Banjar Nyuh (Nusa Penida)', 'Sanur → Gili Trawangan', 'Nusa Penida → Sanur']" />
                        <x-admin.field label="Bundle Discount Incentive" name="bundle_discount" type="number" value="15" />

                        <p class="rounded-[10px] bg-editorial/5 p-[14px] font-jakarta text-[13px] leading-[18px] text-editorial">
                            Passengers booking this fastboat route will see this activity as an add-on item during seat checkout.
                        </p>
                    </div>
                </x-admin.panel>
            </aside>
        </form>
    </x-admin.form-page>
@endsection
