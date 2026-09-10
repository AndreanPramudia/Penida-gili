{{-- Figma node 1:7501 — admin Add New Hotel --}}
@extends('layouts.admin')

@section('title', 'Add New Hotel')

@section('admin-active', 'hotel')

@section('content')
    <x-admin.form-page
        heading="Add New Hotel"
        subtitle="Register island partner accommodations, room categories, and instant fastboat transfer bundles"
        :back-href="route('admin.hotels')">

        <x-slot:actions>
            <button type="submit" form="hotel-form"
                    class="flex items-center gap-[8px] rounded-[8px] border border-[rgba(192,199,211,0.5)] bg-surface px-[18px] py-[10px] font-jakarta text-[14px] font-semibold text-editorial-ink
                           transition-colors duration-300 hover:bg-[#f1f4f6]">
                <img src="{{ asset('images/icons/admin/form-save.svg') }}" alt="" class="size-[16px]">
                Save Draft
            </button>

            <button type="submit" form="hotel-form"
                    class="flex items-center gap-[8px] rounded-[8px] bg-editorial px-[18px] py-[10px] font-jakarta text-[14px] font-semibold text-white
                           transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                <img src="{{ asset('images/icons/admin/nav-hotel.svg') }}" alt="" class="size-[16px]">
                Publish Hotel Listing
            </button>
        </x-slot:actions>

        <form id="hotel-form" action="#" method="post"
              class="grid [&>*]:min-w-0 gap-[24px] lg:grid-cols-[minmax(0,640fr)_minmax(0,320fr)]">
            @csrf

            <div class="flex flex-col gap-[24px]">
                <x-admin.panel title="Property Overview" description="Core identity, hospitality classification, and descriptive narrative" icon="nav-hotel.svg">
                    <div class="flex flex-col gap-[20px]">
                        <x-admin.field label="Property Name" name="name" value="The Nusa Penida Resort & Spa" required />

                        <div class="grid [&>*]:min-w-0 gap-[20px] sm:grid-cols-2">
                            <x-admin.field label="Accommodation Type" name="type" required
                                           :options="['Luxury Resort', 'Boutique Hotel', 'Private Villa', 'Guest House']" />

                            <fieldset>
                                <legend class="font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink">Star Rating *</legend>
                                <div class="mt-[8px] flex gap-[8px]">
                                    @foreach ([3, 4, 5] as $star)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="stars" value="{{ $star }}" @checked($star === 5) class="peer sr-only">
                                            <span class="block rounded-[8px] border border-[rgba(192,199,211,0.5)] bg-[#f7fafc] px-[16px] py-[10px] font-jakarta text-[14px] text-editorial-body
                                                         peer-checked:border-editorial peer-checked:bg-editorial/5 peer-checked:font-semibold peer-checked:text-editorial">
                                                &#9733; {{ $star }} Star
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>

                        <x-admin.field label="Property Description" name="description" type="textarea"
                                       value="Perched along the dramatic cliff edges of Nusa Penida, The Nusa Penida Resort & Spa offers an unrivaled sanctuary where azure waters meet refined Balinese hospitality. Each masterfully crafted suite features sweeping panoramic views across the Badung Strait toward Mount Agung." />
                    </div>
                </x-admin.panel>

                {{-- Figma 1:7501 room categories --}}
                <x-admin.panel title="Room Categories & Inventory Manager" description="Configure suite classifications, nightly rack rates, and live allotment"
                               icon="form-vessel.svg" badge="2 Categories Active" badge-tone="muted">
                    <div class="flex flex-col gap-[16px]">
                        @foreach ($rooms as $index => $room)
                            <article class="rounded-[10px] border border-[rgba(192,199,211,0.5)] p-[16px]">
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <h3 class="flex items-center gap-[10px]">
                                        <span class="flex size-[24px] items-center justify-center rounded-full bg-editorial font-jakarta text-[12px] font-bold text-white">{{ $index + 1 }}</span>
                                        <span class="font-jakarta text-[16px] font-semibold text-editorial-ink">{{ $room['name'] }}</span>
                                        <span @class([
                                            'rounded-full px-[10px] py-[3px] font-jakarta text-[12px] font-semibold',
                                            'bg-[#dcfce7] text-[#166534]' => $room['tone'] === 'available',
                                            'bg-[#fef9c3] text-[#854d0e]' => $room['tone'] === 'demand',
                                        ])>{{ $room['badge'] }}</span>
                                    </h3>

                                    <span class="flex items-center gap-[14px] font-jakarta text-[13px]">
                                        <button type="button" class="text-editorial">Edit</button>
                                        <button type="button" class="text-[#b91c1c]">Remove</button>
                                    </span>
                                </div>

                                <div class="mt-[14px] grid [&>*]:min-w-0 gap-[12px] sm:grid-cols-4">
                                    @foreach ($room['stats'] as $stat)
                                        <div class="rounded-[8px] border border-[rgba(192,199,211,0.4)] p-[12px]">
                                            <p class="font-jakarta text-[12px] leading-[16px] text-editorial-body">{{ $stat['label'] }}</p>
                                            <p @class([
                                                'font-jakarta text-[14px] font-semibold leading-[20px]',
                                                'text-editorial' => ! empty($stat['accent']),
                                                'text-editorial-ink' => empty($stat['accent']),
                                            ])>{{ $stat['value'] }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </article>
                        @endforeach

                        <button type="button"
                                class="rounded-[10px] border-2 border-dashed border-[rgba(192,199,211,0.6)] py-[14px] font-jakarta text-[14px] text-editorial
                                       transition-colors duration-300 hover:border-editorial hover:bg-editorial/5">
                            + Add Another Room Category
                        </button>
                    </div>
                </x-admin.panel>

                <x-admin.panel title="Premium Hotel Amenities" description="Select facility highlights that appear on booking search filters and passenger vouchers" icon="form-check.svg">
                    <div class="grid [&>*]:min-w-0 gap-[16px] sm:grid-cols-2 xl:grid-cols-4">
                        @foreach ($amenities as $amenity)
                            <label class="flex cursor-pointer flex-col gap-[8px] rounded-[10px] border border-editorial bg-editorial/5 p-[14px]">
                                <span class="flex items-center justify-between">
                                    <input type="checkbox" name="amenities[]" value="{{ $amenity['label'] }}" checked
                                           class="size-[16px] rounded-[4px] accent-[#005ea1]">
                                    <img src="{{ asset('images/icons/'.$amenity['icon']) }}" alt="" class="size-[18px] object-contain">
                                </span>
                                <span class="font-jakarta text-[14px] font-semibold leading-[18px] text-editorial-ink">{{ $amenity['label'] }}</span>
                                <span class="font-jakarta text-[12px] leading-[16px] text-editorial-body">{{ $amenity['note'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </x-admin.panel>

                <x-admin.panel title="Photo Gallery & Room Images" description="High-resolution imagery for property highlights, suites, dining, and scenic ocean views"
                               icon="form-camera.svg" badge="4 images uploaded" badge-tone="muted">
                    <x-admin.uploader name="gallery" hint="Recommended size 2560x1440px (Max 12MB per photo). Minimum 4 images required." />

                    <div class="mt-[20px] grid [&>*]:min-w-0 gap-[16px] sm:grid-cols-4">
                        @foreach ($gallery as $photo)
                            <figure class="relative overflow-hidden rounded-[10px]">
                                <img src="{{ asset('images/'.$photo['image']) }}" alt="" class="h-[110px] w-full object-cover">
                                <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-[8px] font-jakarta text-[11px] font-semibold text-white">
                                    {{ $photo['label'] }}
                                </figcaption>
                            </figure>
                        @endforeach
                    </div>
                </x-admin.panel>
            </div>

            <aside class="flex flex-col gap-[24px]">
                <x-admin.panel title="Location & Harbor Proximity" icon="nav-hotel.svg">
                    <div class="flex flex-col gap-[16px]">
                        <x-admin.field label="Island / Region" name="region" :options="['Nusa Penida', 'Nusa Lembongan', 'Gili Trawangan', 'Sanur']" />
                        <x-admin.field label="Specific Coastal Area" name="area" value="Toya Pakeh, Crystal Bay Road" />
                        <x-admin.field label="Harbor Transfer Distance" name="distance" value="8 minutes from Banjar Nyuh Harbor" />

                        <div>
                            <p class="pb-[8px] font-jakarta text-[14px] font-semibold tracking-[0.7px] text-editorial-ink">Map Pin Coordinates</p>
                            <figure class="relative overflow-hidden rounded-[10px]">
                                <img src="{{ asset('images/hotels/detail/map.png') }}" alt="Map pin" class="h-[110px] w-full object-cover">
                                <figcaption class="absolute bottom-[8px] left-[8px] rounded-[6px] bg-black/60 px-[8px] py-[3px] font-jakarta text-[11px] text-white">
                                    -8.6792&deg; S, 115.4851&deg; E
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                </x-admin.panel>

                <x-admin.panel title="Fastboat Transfer Bundle" icon="nav-boat.svg" badge="Sanjaya Exclusive">
                    <div class="flex flex-col gap-[16px]">
                        <div class="rounded-[10px] border border-[rgba(192,199,211,0.4)] p-[14px]">
                            <x-admin.toggle name="link_transfers" label="Link with Sanjaya Fastboat transfers"
                                            description="Enable automated combo ticketing" :checked="true" />
                        </div>

                        <x-admin.field label="Recommended Departure Port" name="departure_port" value="Sanur Beach Terminal (Berth 3 & 4)" />
                        <x-admin.field label="Preferred Ferry Arrival Pier" name="arrival_pier" value="Banjar Nyuh Pier, Nusa Penida" />

                        <label class="flex items-center gap-[10px] font-jakarta text-[14px] text-editorial-ink">
                            <input type="checkbox" name="free_pickup" checked class="size-[16px] rounded-[4px] accent-[#005ea1]">
                            Free Harbor Pick-up included in bundle
                        </label>
                    </div>
                </x-admin.panel>

                <x-admin.panel title="Channel Manager & OTA Sync" icon="nav-report.svg">
                    <p class="flex items-start gap-[10px] rounded-[10px] bg-[#dcfce7] p-[14px] font-jakarta text-[13px] leading-[18px] text-[#166534]">
                        <span aria-hidden="true">&#10003;</span>
                        <span>
                            <strong class="block font-semibold">Direct Sync Status</strong>
                            Connected to Agoda &amp; Booking.com API
                        </span>
                    </p>

                    <div class="mt-[16px]">
                        <x-admin.toggle name="auto_sync" label="Auto-sync inventory" description="Update allotment every 15 minutes" :checked="true" />
                    </div>
                </x-admin.panel>

                <x-admin.panel title="Publishing & Commission" icon="kpi-revenue.svg">
                    <div class="flex flex-col gap-[16px]">
                        <div>
                            <x-admin.field label="Partner Commission Rate" name="commission" type="number" value="15" />
                            <p class="mt-[6px] font-jakarta text-[12px] text-editorial-body">Net payout generated monthly on the 5th</p>
                        </div>

                        <div>
                            <p class="pb-[8px] font-jakarta text-[14px] font-semibold tracking-[0.7px] text-editorial-ink">Listing Status</p>
                            <x-admin.radio-cards name="listing_status" :options="$listingStatuses" />
                        </div>

                        <button type="submit"
                                class="flex w-full items-center justify-center gap-[8px] rounded-[8px] bg-editorial py-[14px] font-jakarta text-[15px] font-semibold text-white
                                       transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                            <img src="{{ asset('images/icons/admin/form-check.svg') }}" alt="" class="size-[16px]">
                            Confirm &amp; Publish Partner
                        </button>
                    </div>
                </x-admin.panel>
            </aside>
        </form>
    </x-admin.form-page>
@endsection
