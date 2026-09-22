{{-- Figma node 1:7501 — admin Add New Hotel (also serves Edit). Figma is drawn at 1.5×; sizes here are ÷1.5. --}}
@extends('layouts.admin')

@php
    $editing = $hotel->exists;
    $backHref = route('admin.hotels');
    $roomRows = array_values($rooms);
    $money = fn ($v) => $v ? number_format((int) $v, 0, ',', '.') : '';
    $photoCount = ($hotel->image ? 1 : 0) + count($hotel->gallery ?? []);
    $label = 'font-jakarta text-[12px] font-bold uppercase leading-[16px] tracking-[0.6px] text-editorial-body';
    $input = 'w-full rounded-[8px] border border-[#c0c7d3] bg-surface px-[13px] py-[9px] font-jakarta text-[14px] leading-[20px] text-editorial-ink placeholder:text-editorial-meta focus:outline-2 focus:outline-editorial';
    $icon = fn ($file) => asset('images/icons/admin/hotel/'.$file);
    $chip = 'flex w-fit items-center gap-[8px] rounded-[8px] bg-[#f1f4f6] p-[10px] font-jakarta text-[12px] font-medium leading-[16px] text-editorial-ink';
@endphp

@section('title', $editing ? 'Edit '.$hotel->name : 'Add New Hotel')

@section('admin-active', 'hotel')

@section('content')
    <x-admin.form-page
        :heading="$editing ? 'Edit Hotel' : 'Add New Hotel'"
        subtitle="Register island partner accommodations, room categories, and instant fastboat transfer bundles"
        :back-href="$backHref">

        {{-- Header actions (1:7512 / 1:7516) --}}
        <x-slot:actions>
            <button type="submit" form="hotel-form" name="submit_as" value="draft"
                    class="flex items-center gap-[8px] rounded-[8px] border border-[#c0c7d3] bg-surface px-[21px] py-[11px] font-jakarta text-[14px] font-semibold text-editorial-ink
                           transition-colors duration-300 hover:bg-[#f1f4f6]">
                <img src="{{ asset('images/icons/admin/form-save.svg') }}" alt="" class="size-[13.5px]">
                Save Draft
            </button>
            <button type="submit" form="hotel-form" name="submit_as" value="publish"
                    class="flex items-center gap-[8px] rounded-[8px] bg-editorial px-[24px] py-[10px] font-jakarta text-[14px] font-semibold text-white shadow-[0_4px_6px_-1px_rgba(0,0,0,0.1)]
                           transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                <img src="{{ asset('images/icons/admin/nav-hotel.svg') }}" alt="" class="size-[12px]">
                Publish Hotel Listing
            </button>
        </x-slot:actions>

        <form id="hotel-form" action="{{ $editing ? route('admin.hotels.update', $hotel) : route('admin.hotels.store') }}" method="post" enctype="multipart/form-data"
              class="grid [&>*]:min-w-0 gap-[24px] lg:grid-cols-[minmax(0,642fr)_minmax(0,309fr)]" data-hotel-form>
            @csrf
            @if ($editing) @method('PUT') @endif

            <div class="flex flex-col gap-[24px]">
                {{-- 1. Property Overview (1:7523) --}}
                <section class="rounded-[12px] border border-[rgba(192,199,211,0.3)] bg-surface p-[33px] shadow-[0_4px_10px_rgba(0,0,0,0.05)]">
                    <div class="flex items-center gap-[12px] border-b border-[#ebeef0] pb-[17px]">
                        <span class="flex size-[40px] shrink-0 items-center justify-center rounded-[8px] bg-[rgba(210,228,255,0.5)]">
                            <img src="{{ $icon('editor-overview.svg') }}" alt="" class="h-[18px] w-[20px]">
                        </span>
                        <div>
                            <h2 class="font-jakarta text-[18px] font-semibold leading-[28px] text-editorial-ink">Property Overview</h2>
                            <p class="font-jakarta text-[12px] leading-[16px] text-editorial-body">Core identity, hospitality classification, and descriptive narrative</p>
                        </div>
                    </div>

                    <div class="mt-[24px] flex flex-col gap-[20px]">
                        <div class="flex flex-col gap-[8px]">
                            <label for="hotel-name" class="{{ $label }}">Property Name <span class="text-[#ba1a1a]">*</span></label>
                            <span class="relative block">
                                <img src="{{ $icon('field-hotel.svg') }}" alt="" class="pointer-events-none absolute left-[14px] top-1/2 h-[11px] w-[11px] -translate-y-1/2">
                                <input id="hotel-name" name="name" value="{{ old('name', $hotel->name) }}" required placeholder="The Nusa Penida Resort &amp; Spa"
                                       class="{{ $input }} py-[11px] pl-[45px] pr-[17px]">
                            </span>
                            @error('name') <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid [&>*]:min-w-0 gap-[16px] sm:grid-cols-2">
                            <div class="flex flex-col gap-[8px]">
                                <label for="hotel-category" class="{{ $label }}">Accommodation Type <span class="text-[#ba1a1a]">*</span></label>
                                <span class="relative block">
                                    <select id="hotel-category" name="category" class="{{ $input }} appearance-none py-[11px] pl-[15px] pr-[40px]">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category }}" @selected(old('category', $hotel->category) === $category)>{{ $category }}</option>
                                        @endforeach
                                    </select>
                                    <img src="{{ $icon('field-chevron.svg') }}" alt="" class="pointer-events-none absolute right-[9px] top-1/2 size-[21px] -translate-y-1/2">
                                </span>
                            </div>

                            <fieldset class="flex flex-col gap-[8px]">
                                <legend class="{{ $label }} mb-[8px]">Star Rating <span class="text-[#ba1a1a]">*</span></legend>
                                <div class="flex gap-[8px]">
                                    @foreach ([3, 4, 5] as $star)
                                        <label class="flex-1 cursor-pointer">
                                            <input type="radio" name="stars" value="{{ $star }}" @checked((int) old('stars', $hotel->stars ?? 5) === $star) class="peer sr-only">
                                            <span class="flex items-center justify-center gap-[6px] rounded-[8px] border border-[rgba(192,199,211,0.8)] px-[13px] py-[9px] font-jakarta text-[12px] font-bold text-editorial-ink
                                                         peer-checked:border-editorial peer-checked:bg-[rgba(210,228,255,0.4)] peer-checked:text-editorial">
                                                <img src="{{ $icon('field-star.svg') }}" alt="" class="h-[11px] w-[11.6px]">
                                                {{ $star }} Star
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>

                        <x-admin.field label="Partner Label" name="partner_label" :value="$hotel->partner_label" placeholder="Direct Fastboat Partner" />

                        {{-- Rich Text Property Description (1:7572): toolbar strip mirrors the design; plain text is stored --}}
                        <div class="flex flex-col gap-[8px]">
                            <label for="hotel-description" class="{{ $label }}">Property Description</label>
                            <div class="flex items-center gap-[4px] rounded-t-[8px] border border-[#c0c7d3] bg-[#f1f4f6] px-[13px] py-[9px] font-jakarta text-[12px] text-editorial-body" aria-hidden="true">
                                <span class="rounded-[4px] p-[6px] font-bold">B</span>
                                <span class="rounded-[4px] p-[6px]">I</span>
                                <span class="rounded-[4px] p-[6px] underline">U</span>
                                <span class="mx-[4px] h-[16px] w-px bg-[#c0c7d3]"></span>
                                <img src="{{ $icon('rte-list.svg') }}" alt="" class="mx-[4px] h-[9.3px] w-[10.5px]">
                                <img src="{{ $icon('rte-ol.svg') }}" alt="" class="mx-[4px] h-[11.6px] w-[10.5px]">
                                <img src="{{ $icon('rte-align.svg') }}" alt="" class="mx-[4px] h-[5.8px] w-[11.6px]">
                                <img src="{{ $icon('rte-link.svg') }}" alt="" class="mx-[4px] h-[7px] w-[9.9px]">
                            </div>
                            <textarea id="hotel-description" name="description" rows="6" required
                                      placeholder="Perched along the dramatic cliff edges of Nusa Penida…"
                                      class="-mt-[8px] w-full resize-y rounded-b-[8px] border border-t-0 border-[#c0c7d3] bg-surface px-[17px] py-[16px] font-jakarta text-[14px] leading-[20px] text-editorial-ink placeholder:text-editorial-meta focus:outline-2 focus:outline-editorial">{{ old('description', $hotel->description) }}</textarea>
                            @error('description') <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </section>

                {{-- 2. Room Categories & Inventory Manager (1:7599) --}}
                <section class="rounded-[12px] border border-[rgba(192,199,211,0.3)] bg-surface p-[33px] shadow-[0_4px_10px_rgba(0,0,0,0.05)]" data-rooms>
                    <div class="flex items-center justify-between gap-[12px] border-b border-[#ebeef0] pb-[17px]">
                        <div class="flex items-center gap-[12px]">
                            <span class="flex size-[40px] shrink-0 items-center justify-center rounded-[8px] bg-[rgba(210,228,255,0.5)]">
                                <img src="{{ $icon('editor-rooms.svg') }}" alt="" class="h-[14px] w-[20px]">
                            </span>
                            <div>
                                <h2 class="font-jakarta text-[18px] font-semibold leading-[28px] text-editorial-ink">Room Categories &amp; Inventory Manager</h2>
                                <p class="font-jakarta text-[12px] leading-[16px] text-editorial-body">Configure suite classifications, nightly rack rates, and live allotment</p>
                            </div>
                        </div>
                        <span class="shrink-0 rounded-full bg-[#d5e2e9] px-[10px] py-[4px] font-jakarta text-[12px] font-semibold leading-[16px] text-[#58646a]">
                            <span data-rooms-count>{{ count($roomRows) }}</span> Categories Active
                        </span>
                    </div>
                    @error('rooms') <p class="mt-[12px] font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</p> @enderror

                    <div class="mt-[24px] flex flex-col gap-[16px]" data-rooms-list>
                        @foreach ($roomRows as $i => $room)
                            @include('partials.admin.hotel-room-card', ['i' => $i, 'room' => $room, 'open' => $errors->has("rooms.$i.*") || empty($room['name']), 'money' => $money, 'icon' => $icon, 'input' => $input, 'label' => $label])
                        @endforeach
                    </div>

                    {{-- Button to Add Room (1:7709) --}}
                    <button type="button" data-room-add
                            class="mt-[16px] flex w-full items-center justify-center gap-[8px] rounded-[12px] border-2 border-dashed border-[rgba(0,94,161,0.4)] px-[2px] py-[14px] font-jakarta text-[14px] font-bold text-editorial
                                   transition-colors duration-300 hover:bg-[rgba(210,228,255,0.2)]">
                        <img src="{{ $icon('room-add.svg') }}" alt="" class="size-[15px]">
                        + Add Another Room Category
                    </button>

                    <template data-room-template>
                        @include('partials.admin.hotel-room-card', ['i' => '__INDEX__', 'room' => ['id' => null, 'name' => '', 'guests' => 2, 'bed' => '', 'size_label' => '', 'price_per_night' => '', 'stock' => 1], 'open' => true, 'money' => $money, 'icon' => $icon, 'input' => $input, 'label' => $label])
                    </template>
                </section>

                {{-- 3. Premium Hotel Amenities (1:7714) --}}
                <section class="rounded-[12px] border border-[rgba(192,199,211,0.3)] bg-surface p-[33px] shadow-[0_4px_10px_rgba(0,0,0,0.05)]">
                    <div class="flex items-center gap-[12px] border-b border-[#ebeef0] pb-[17px]">
                        <span class="flex size-[40px] shrink-0 items-center justify-center rounded-[8px] bg-[rgba(210,228,255,0.5)]">
                            <img src="{{ $icon('editor-amenities.svg') }}" alt="" class="h-[15px] w-[20px]">
                        </span>
                        <div>
                            <h2 class="font-jakarta text-[18px] font-semibold leading-[28px] text-editorial-ink">Premium Hotel Amenities</h2>
                            <p class="font-jakarta text-[12px] leading-[16px] text-editorial-body">Select facility highlights that appear on booking search filters and passenger vouchers</p>
                        </div>
                    </div>

                    <div class="mt-[24px] grid [&>*]:min-w-0 gap-[12px] sm:grid-cols-2 xl:grid-cols-4">
                        @foreach ($amenities as $amenity)
                            <label class="cursor-pointer">
                                <input type="checkbox" name="amenities[]" value="{{ $amenity['label'] }}" @checked($amenity['checked']) class="peer sr-only">
                                <span class="flex h-full gap-[12px] rounded-[8px] border border-[rgba(192,199,211,0.6)] p-[15px] transition-colors duration-300
                                             peer-checked:border-editorial peer-checked:bg-[rgba(210,228,255,0.2)] peer-checked:[&>span:first-child]:bg-editorial peer-checked:[&>span:first-child>img]:opacity-100">
                                    <span class="flex size-[18px] shrink-0 items-center justify-center rounded-[4px] border border-[#c0c7d3] bg-surface">
                                        <img src="{{ $icon('amenity-check.svg') }}" alt="" class="size-[16px] opacity-0">
                                    </span>
                                    <span class="flex min-w-0 flex-col">
                                        <img src="{{ $icon($amenity['editorIcon']) }}" alt="" class="mb-[4px] h-[16px] w-fit max-w-[24px] object-contain object-left">
                                        <span class="font-jakarta text-[12px] font-bold leading-[16px] text-editorial-ink">{{ $amenity['label'] }}</span>
                                        <span class="font-jakarta text-[11px] leading-[24px] text-editorial-body">{{ $amenity['note'] }}</span>
                                    </span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </section>

                {{-- 4. Photo Gallery & Room Images (1:7829) --}}
                <section class="rounded-[12px] border border-[rgba(192,199,211,0.3)] bg-surface p-[33px] shadow-[0_4px_10px_rgba(0,0,0,0.05)]" data-gallery>
                    <div class="flex items-center justify-between gap-[12px] border-b border-[#ebeef0] pb-[17px]">
                        <div class="flex items-center gap-[12px]">
                            <span class="flex h-[40px] w-[36px] shrink-0 items-center justify-center rounded-[8px] bg-[rgba(210,228,255,0.5)]">
                                <img src="{{ $icon('editor-gallery.svg') }}" alt="" class="size-[20px]">
                            </span>
                            <div>
                                <h2 class="font-jakarta text-[18px] font-semibold leading-[28px] text-editorial-ink">Photo Gallery &amp; Room Images</h2>
                                <p class="font-jakarta text-[12px] leading-[16px] text-editorial-body">High-resolution imagery for property highlights, suites, dining, and scenic ocean views</p>
                            </div>
                        </div>
                        <span class="shrink-0 font-jakarta text-[12px] font-medium leading-[16px] text-editorial-body"><span data-gallery-count>{{ $photoCount }}</span> images uploaded</span>
                    </div>

                    {{-- Multi-image dropzone (1:7842) --}}
                    <label class="mt-[24px] flex cursor-pointer flex-col items-center gap-[4px] rounded-[12px] border-2 border-dashed border-[#c0c7d3] bg-[rgba(241,244,246,0.3)] p-[26px] transition-colors duration-300 hover:border-editorial">
                        <input type="file" name="gallery[]" accept="image/png,image/jpeg,image/webp" multiple class="sr-only" data-gallery-input>
                        <span class="flex size-[48px] items-center justify-center rounded-full bg-[rgba(210,228,255,0.4)]">
                            <img src="{{ $icon('editor-upload.svg') }}" alt="" class="h-[16px] w-[22px]">
                        </span>
                        <span class="pt-[8px] font-jakarta text-[14px] font-bold leading-[20px] text-editorial-ink">Drag &amp; drop high-resolution JPG or PNG files here</span>
                        <span class="pb-[8px] font-jakarta text-[12px] leading-[16px] text-editorial-body">Recommended size 2560x1440px (Max 12MB per photo). Minimum 4 images required.</span>
                        <span class="rounded-[8px] bg-[#ebeef0] px-[16px] py-[6px] font-jakarta text-[12px] font-bold leading-[16px] text-editorial-ink">Browse Files</span>
                        <span data-gallery-picked class="font-jakarta text-[12px] text-editorial"></span>
                    </label>
                    @error('gallery.*') <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror

                    {{-- Image Preview Grid (1:7852): first tile is the featured hero cover --}}
                    <div class="mt-[24px] grid [&>*]:min-w-0 gap-[16px] sm:grid-cols-2 xl:grid-cols-4">
                        <label class="relative block aspect-[4/3] cursor-pointer overflow-hidden rounded-[8px] border border-[rgba(192,199,211,0.5)] shadow-[0_1px_2px_rgba(0,0,0,0.05)]">
                            <input type="file" name="cover" accept="image/png,image/jpeg,image/webp" class="sr-only" data-cover-input>
                            <img data-cover-preview src="{{ $hotel->image ? \App\Support\ImagePath::url($hotel->image, 'hotels') : '' }}" alt="" @if (! $hotel->image) hidden @endif class="size-full object-cover">
                            @if (! $hotel->image)
                                <span data-cover-empty class="flex size-full items-center justify-center bg-[#f1f4f6] font-jakarta text-[12px] text-editorial-body">Choose hero image</span>
                            @endif
                            <span class="absolute inset-0 flex flex-col justify-end bg-gradient-to-t from-[rgba(0,0,0,0.7)] via-transparent to-transparent p-[10px]">
                                <span class="font-jakarta text-[10px] font-bold uppercase leading-[24px] tracking-[0.5px] text-[#fcd34d]">Featured Hero</span>
                                <span class="truncate font-jakarta text-[12px] font-medium leading-[16px] text-white">{{ $hotel->name ?: 'Property cover' }}</span>
                            </span>
                        </label>
                        @foreach ($hotel->gallery ?? [] as $photo)
                            <figure class="relative aspect-[4/3] overflow-hidden rounded-[8px] border border-[rgba(192,199,211,0.5)] shadow-[0_1px_2px_rgba(0,0,0,0.05)]">
                                <img src="{{ \App\Support\ImagePath::url($photo['image'] ?? $photo, 'hotels/detail') }}" alt="{{ $photo['alt'] ?? '' }}" class="size-full object-cover">
                                <figcaption class="absolute inset-0 flex flex-col justify-end bg-gradient-to-t from-[rgba(0,0,0,0.7)] via-transparent to-transparent p-[10px]">
                                    <span class="font-jakarta text-[10px] font-bold uppercase leading-[24px] tracking-[0.5px] text-[#9fcaff]">Gallery</span>
                                    <span class="truncate font-jakarta text-[12px] font-medium leading-[16px] text-white">{{ $photo['alt'] ?? $hotel->name }}</span>
                                </figcaption>
                            </figure>
                        @endforeach
                    </div>
                    @error('cover') <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror
                </section>
            </div>

            <aside class="flex flex-col gap-[24px]">
                {{-- 1. Location & Harbor Proximity (1:7894) --}}
                <section class="rounded-[12px] border border-[rgba(192,199,211,0.3)] bg-surface p-[25px] shadow-[0_4px_10px_rgba(0,0,0,0.05)]">
                    <div class="flex items-center gap-[10px] border-b border-[#ebeef0] pb-[13px]">
                        <img src="{{ $icon('side-location.svg') }}" alt="" class="h-[16.6px] w-[11.6px]">
                        <h2 class="font-jakarta text-[24px] font-semibold leading-[32px] text-editorial-ink">Location &amp; Harbor Proximity</h2>
                    </div>

                    <div class="mt-[16px] flex flex-col gap-[16px]">
                        <div class="flex flex-col gap-[6px]">
                            <label for="hotel-region" class="{{ $label }}">Island / Region</label>
                            <span class="relative block">
                                <select id="hotel-region" name="region" class="{{ $input }} appearance-none py-[9px] pl-[13px] pr-[40px] text-[16px] leading-[24px]">
                                    <option value="">Select island…</option>
                                    @foreach ($regions as $region)
                                        <option value="{{ $region }}" @selected(old('region', $hotel->region) === $region)>{{ $region }}</option>
                                    @endforeach
                                </select>
                                <img src="{{ $icon('side-chevron.svg') }}" alt="" class="pointer-events-none absolute right-[9px] top-1/2 size-[24px] -translate-y-1/2">
                            </span>
                        </div>

                        <div class="flex flex-col gap-[6px]">
                            <label for="hotel-address" class="{{ $label }}">Specific Coastal Area</label>
                            <input id="hotel-address" name="address" value="{{ old('address', $hotel->address) }}" required placeholder="Toya Pakeh, Crystal Bay Road"
                                   class="{{ $input }} text-[16px] leading-[24px]">
                            @error('address') <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex flex-col gap-[6px]">
                            <label for="hotel-harbor" class="{{ $label }}">Harbor Transfer Distance</label>
                            <span class="flex items-center gap-[8px] rounded-[8px] border border-[rgba(192,199,211,0.4)] bg-[#f1f4f6] px-[13px] py-[9px]">
                                <img src="{{ $icon('side-harbor.svg') }}" alt="" class="h-[9.3px] w-[11.6px] shrink-0">
                                <input id="hotel-harbor" name="harbor_distance" value="{{ old('harbor_distance', $hotel->harbor_distance) }}" placeholder="8 minutes from Banjar Nyuh Harbor"
                                       class="w-full bg-transparent font-jakarta text-[12px] font-semibold leading-[16px] text-editorial-ink placeholder:font-normal placeholder:text-editorial-meta focus:outline-none">
                            </span>
                        </div>

                        {{-- Map Picker Card (1:7924) --}}
                        <div class="flex flex-col gap-[6px]">
                            <label for="hotel-coordinates" class="{{ $label }}">Map Pin Coordinates</label>
                            <div class="relative h-[128px] overflow-hidden rounded-[8px] border border-[rgba(192,199,211,0.6)] p-px">
                                <img src="{{ $icon('map-nusa-penida.png') }}" alt="" class="size-full rounded-[7px] object-cover">
                                <span class="absolute inset-0 flex items-center justify-center bg-[rgba(0,0,0,0.2)]">
                                    <span class="flex items-center gap-[6px] rounded-full bg-[rgba(255,255,255,0.9)] px-[12px] py-[4px] shadow-[0_1px_3px_rgba(0,0,0,0.1)] backdrop-blur-[4px]">
                                        <img src="{{ $icon('side-pin.svg') }}" alt="" class="h-[10px] w-[8px]">
                                        <input id="hotel-coordinates" name="coordinates" value="{{ old('coordinates', $hotel->coordinates) }}" placeholder="-8.6792° S, 115.4851° E" size="22"
                                               class="bg-transparent font-jakarta text-[12px] font-bold leading-[16px] text-editorial placeholder:font-normal placeholder:text-editorial-meta focus:outline-none">
                                    </span>
                                </span>
                            </div>
                        </div>

                        <x-admin.field label="Full Address" name="full_address" type="textarea" :value="$hotel->full_address" placeholder="Jalan Raya Toya Pakeh - Ped, Nusa Penida, Bali 80771" />
                    </div>
                </section>

                {{-- 2. Fastboat Transfer Bundle (1:7935) --}}
                <section class="rounded-[12px] border border-[rgba(192,199,211,0.3)] bg-surface p-[25px] shadow-[0_4px_10px_rgba(0,0,0,0.05)]">
                    <div class="flex items-center justify-between gap-[10px] border-b border-[#ebeef0] pb-[13px]">
                        <div class="flex items-center gap-[10px]">
                            <img src="{{ $icon('side-boat.svg') }}" alt="" class="h-[16.6px] w-[15.3px]">
                            <h2 class="font-jakarta text-[24px] font-semibold leading-[32px] text-editorial-ink">Fastboat Transfer Bundle</h2>
                        </div>
                        <span class="shrink-0 rounded-[4px] bg-[#d2e4ff] px-[8px] py-[2px] text-center font-jakarta text-[10px] font-bold uppercase leading-[24px] text-editorial">Sanjaya Exclusive</span>
                    </div>

                    <div class="mt-[16px] flex flex-col gap-[16px]">
                        <div class="rounded-[8px] border border-[rgba(0,94,161,0.3)] bg-[rgba(210,228,255,0.2)] p-[13px]">
                            <x-admin.toggle name="transfer_bundle" label="Link with Sanjaya Fastboat transfers" description="Enable automated combo ticketing" :checked="old('transfer_bundle', $hotel->transfer_bundle ?? true)" />
                        </div>

                        <div class="flex flex-col gap-[6px]">
                            <label for="hotel-port" class="{{ $label }}">Recommended Departure Port</label>
                            <span class="flex items-center gap-[8px] rounded-[8px] bg-[#f1f4f6] p-[10px]">
                                <img src="{{ $icon('side-port.svg') }}" alt="" class="h-[13.3px] w-[12px] shrink-0">
                                <input id="hotel-port" name="departure_port" value="{{ old('departure_port', $hotel->departure_port) }}" placeholder="Sanur Beach Terminal (Berth 3 &amp; 4)"
                                       class="w-full bg-transparent font-jakarta text-[12px] font-medium leading-[16px] text-editorial-ink placeholder:text-editorial-meta focus:outline-none">
                            </span>
                        </div>

                        <div class="flex flex-col gap-[6px]">
                            <label for="hotel-pier" class="{{ $label }}">Preferred Ferry Arrival Pier</label>
                            <span class="flex items-center gap-[8px] rounded-[8px] bg-[#f1f4f6] p-[10px]">
                                <img src="{{ $icon('side-pier.svg') }}" alt="" class="h-[14.6px] w-[8.7px] shrink-0">
                                <input id="hotel-pier" name="arrival_pier" value="{{ old('arrival_pier', $hotel->arrival_pier) }}" placeholder="Banjar Nyuh Pier, Nusa Penida"
                                       class="w-full bg-transparent font-jakarta text-[12px] font-medium leading-[16px] text-editorial-ink placeholder:text-editorial-meta focus:outline-none">
                            </span>
                        </div>

                        <label class="flex cursor-pointer items-center gap-[8px]">
                            <input type="checkbox" name="harbor_pickup" @checked(old('harbor_pickup', $hotel->harbor_pickup ?? true)) class="peer sr-only">
                            <span class="flex size-[18px] shrink-0 items-center justify-center rounded-[4px] border border-[#c0c7d3] bg-surface peer-checked:border-editorial peer-checked:bg-editorial [&>img]:opacity-0 peer-checked:[&>img]:opacity-100">
                                <img src="{{ $icon('side-check.svg') }}" alt="" class="size-[16px]">
                            </span>
                            <span class="font-jakarta text-[12px] font-semibold leading-[16px] text-editorial-ink">Free Harbor Pick-up included in bundle</span>
                        </label>
                    </div>
                </section>

                {{-- 3. Channel Manager & OTA Sync (1:7974) --}}
                <section class="rounded-[12px] border border-[rgba(192,199,211,0.3)] bg-surface p-[25px] shadow-[0_4px_10px_rgba(0,0,0,0.05)]">
                    <div class="flex items-center gap-[10px] border-b border-[#ebeef0] pb-[13px]">
                        <img src="{{ $icon('side-sync.svg') }}" alt="" class="h-[15px] w-[16.6px]">
                        <h2 class="font-jakarta text-[24px] font-semibold leading-[32px] text-editorial-ink">Channel Manager &amp; OTA Sync</h2>
                    </div>

                    <div class="mt-[16px] flex flex-col gap-[16px]">
                        <div class="flex items-center gap-[12px] rounded-[8px] border border-[#a7f3d0] bg-[#ecfdf5] p-[13px]">
                            <img src="{{ $icon('side-sync-ok.svg') }}" alt="" class="size-[16.6px] shrink-0">
                            <span>
                                <span class="block font-jakarta text-[12px] font-bold leading-[16px] text-[#022c22]">Direct Sync Status</span>
                                <span class="block font-jakarta text-[11px] leading-[16px] text-[#065f46]">Connected to Agoda &amp; Booking.com API</span>
                            </span>
                        </div>
                        <x-admin.toggle name="auto_sync" label="Auto-sync inventory" description="Update allotment every 15 minutes" :checked="old('auto_sync', $hotel->auto_sync ?? true)" />
                    </div>
                </section>

                {{-- 4. Publishing & Commission (1:7998) --}}
                <section class="rounded-[12px] border border-[rgba(192,199,211,0.3)] bg-surface p-[25px] shadow-[0_4px_10px_rgba(0,0,0,0.05)]">
                    <div class="flex items-center gap-[10px] border-b border-[#ebeef0] pb-[13px]">
                        <img src="{{ $icon('side-commission.svg') }}" alt="" class="h-[13.3px] w-[18.3px]">
                        <h2 class="font-jakarta text-[24px] font-semibold leading-[32px] text-editorial-ink">Publishing &amp; Commission</h2>
                    </div>

                    <div class="mt-[16px] flex flex-col gap-[16px]">
                        <div class="flex flex-col gap-[4px]">
                            <label for="hotel-commission" class="{{ $label }}">Partner Commission Rate</label>
                            <span class="relative block pt-[2px]">
                                <input id="hotel-commission" name="commission_rate" type="number" min="0" max="100" value="{{ old('commission_rate', $hotel->commission_rate ?? 15) }}" required
                                       class="{{ $input }} py-[9px] pl-[13px] pr-[33px] text-[14px] font-bold leading-[20px]">
                                <span class="pointer-events-none absolute right-[12px] top-1/2 -translate-y-1/2 font-jakarta text-[12px] font-bold text-editorial-body">%</span>
                            </span>
                            <span class="font-jakarta text-[10px] leading-[16px] text-editorial-body">Net payout generated monthly on the 5th</span>
                            @error('commission_rate') <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror
                        </div>

                        <fieldset class="flex flex-col gap-[6px] pb-[8px]">
                            <legend class="{{ $label }} mb-[6px]">Listing Status</legend>
                            <div class="flex flex-col gap-[8px]">
                                @foreach ($listingStatuses as $option)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="status" value="{{ $option['value'] }}" @checked(old('status', $hotel->status?->value) === $option['value']) class="peer sr-only">
                                        <span class="flex items-center gap-[10px] rounded-[8px] border border-[#c0c7d3] p-[9px] font-jakarta text-[12px] font-medium leading-[16px] text-editorial-body
                                                     peer-checked:border-editorial peer-checked:bg-[rgba(210,228,255,0.2)] peer-checked:font-bold peer-checked:text-editorial-ink
                                                     peer-checked:[&>span]:border-editorial peer-checked:[&>span]:bg-editorial peer-checked:[&>span>img]:opacity-100">
                                            <span class="flex size-[16px] shrink-0 items-center justify-center rounded-full border border-[#6b7280] bg-surface">
                                                <img src="{{ $icon('side-radio.svg') }}" alt="" class="size-[16px] opacity-0">
                                            </span>
                                            {{ $option['label'] }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>

                        {{-- Quick Confirmation Box (1:8038) --}}
                        <button type="submit" name="submit_as" value="publish"
                                class="flex w-full items-center justify-center gap-[8px] rounded-[8px] bg-editorial py-[12px] font-jakarta text-[14px] font-semibold tracking-[0.7px] text-white shadow-[0_4px_6px_-1px_rgba(0,0,0,0.1)]
                                       transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                            <img src="{{ $icon('side-publish.svg') }}" alt="" class="h-[8px] w-[10.8px]">
                            Confirm &amp; Publish Partner
                        </button>
                    </div>
                </section>
            </aside>
        </form>
    </x-admin.form-page>
@endsection
