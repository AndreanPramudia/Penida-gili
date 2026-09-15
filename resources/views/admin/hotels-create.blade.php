{{-- Figma node 1:7501 — admin Add New Hotel (also serves Edit) --}}
@extends('layouts.admin')

@php
    $editing = $hotel->exists;
    $backHref = route('admin.hotels');
    $roomRows = array_values($rooms);
    $roomRows[] = ['id' => null, 'name' => '', 'guests' => 2, 'bed' => '', 'size_label' => '', 'price_per_night' => '', 'stock' => 1];
@endphp

@section('title', $editing ? 'Edit '.$hotel->name : 'Add New Hotel')

@section('admin-active', 'hotel')

@section('content')
    <x-admin.form-page
        :heading="$editing ? 'Edit Hotel' : 'Add New Hotel'"
        subtitle="Onboard partner properties with room inventory and nightly rates."
        :back-href="$backHref">

        <x-slot:actions>
            <button type="submit" form="hotel-form"
                    class="flex items-center gap-[8px] rounded-[8px] bg-editorial px-[18px] py-[10px] font-jakarta text-[14px] font-semibold text-white
                           transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                <img src="{{ asset('images/icons/admin/nav-hotel.svg') }}" alt="" class="size-[16px]">
                {{ $editing ? 'Save Changes' : 'Publish Property' }}
            </button>
        </x-slot:actions>

        <form id="hotel-form" action="{{ $editing ? route('admin.hotels.update', $hotel) : route('admin.hotels.store') }}" method="post" enctype="multipart/form-data"
              class="grid [&>*]:min-w-0 gap-[24px] lg:grid-cols-[minmax(0,640fr)_minmax(0,320fr)]">
            @csrf
            @if ($editing) @method('PUT') @endif

            <div class="flex flex-col gap-[24px]">
                <x-admin.panel title="Property Overview" description="Core identity, hospitality classification, and descriptive narrative" icon="nav-hotel.svg">
                    <div class="flex flex-col gap-[20px]">
                        <x-admin.field label="Property Name" name="name" :value="$hotel->name" :required="true" />

                        <div class="grid [&>*]:min-w-0 gap-[20px] sm:grid-cols-2">
                            <x-admin.field label="Accommodation Type" name="category" :value="$hotel->category" :options="$categories" :required="true" />

                            <fieldset>
                                <legend class="font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink">Star Rating *</legend>
                                <div class="mt-[8px] flex gap-[8px]">
                                    @foreach ([3, 4, 5] as $star)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="stars" value="{{ $star }}" @checked((int) old('stars', $hotel->stars ?? 5) === $star) class="peer sr-only">
                                            <span class="block rounded-[8px] border border-[rgba(192,199,211,0.5)] bg-[#f7fafc] px-[16px] py-[10px] font-jakarta text-[14px] text-editorial-body
                                                         peer-checked:border-editorial peer-checked:bg-editorial/5 peer-checked:font-semibold peer-checked:text-editorial">
                                                &#9733; {{ $star }} Star
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>

                        <x-admin.field label="Partner Label" name="partner_label" :value="$hotel->partner_label" placeholder="Direct Fastboat Partner" />
                        <x-admin.field label="Property Description" name="description" type="textarea" :value="$hotel->description" :required="true" />
                    </div>
                </x-admin.panel>

                <x-admin.panel title="Room Types & Rates" description="Guests pick one of these on the detail page; nightly rate drives the quote." icon="kpi-revenue.svg">
                    @error('rooms') <p class="mb-[12px] font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</p> @enderror
                    <div class="flex flex-col gap-[16px]">
                        @foreach ($roomRows as $i => $room)
                            <fieldset class="rounded-[10px] border border-[rgba(192,199,211,0.4)] bg-[#f7fafc] p-[16px]">
                                <legend class="px-[6px] font-jakarta text-[13px] font-semibold text-editorial-body">
                                    {{ $loop->last ? 'Add another room type (optional)' : 'Room '.($i + 1) }}
                                </legend>
                                <input type="hidden" name="rooms[{{ $i }}][id]" value="{{ $room['id'] ?? '' }}">
                                <div class="grid [&>*]:min-w-0 gap-[12px] sm:grid-cols-6">
                                    <div class="sm:col-span-3"><x-admin.field label="Room Name" name="rooms[{{ $i }}][name]" :value="$room['name'] ?? ''" placeholder="Deluxe Ocean Room" /></div>
                                    <x-admin.field label="Guests" name="rooms[{{ $i }}][guests]" type="number" :value="$room['guests'] ?? 2" />
                                    <div class="sm:col-span-2"><x-admin.field label="Bed" name="rooms[{{ $i }}][bed]" :value="$room['bed'] ?? ''" placeholder="1 King Bed" /></div>
                                    <div class="sm:col-span-2"><x-admin.field label="Size Label" name="rooms[{{ $i }}][size_label]" :value="$room['size_label'] ?? ''" placeholder="45 m² Ocean Terrace" /></div>
                                    <div class="sm:col-span-3"><x-admin.field label="Rate / Night (IDR)" name="rooms[{{ $i }}][price_per_night]" :value="$room['price_per_night'] ?? ''" prefix="Rp" placeholder="2.500.000" /></div>
                                    <x-admin.field label="Units" name="rooms[{{ $i }}][stock]" type="number" :value="$room['stock'] ?? 1" />
                                </div>
                            </fieldset>
                        @endforeach
                    </div>
                </x-admin.panel>

                <x-admin.panel title="Amenities" description="Tick what the property offers" icon="form-check.svg">
                    <div class="grid [&>*]:min-w-0 gap-[12px] sm:grid-cols-2">
                        @foreach ($amenities as $amenity)
                            <label class="flex items-center gap-[12px] rounded-[10px] border border-[rgba(192,199,211,0.4)] p-[12px]">
                                <input type="checkbox" name="amenities[]" value="{{ $amenity['label'] }}" @checked($amenity['checked']) class="size-[18px] rounded-[4px] accent-[#005ea1]">
                                <img src="{{ asset('images/icons/hotel/'.$amenity['icon']) }}" alt="" class="size-[20px] object-contain">
                                <span>
                                    <span class="block font-jakarta text-[14px] font-semibold text-editorial-ink">{{ $amenity['label'] }}</span>
                                    <span class="block font-jakarta text-[12px] text-editorial-body">{{ $amenity['note'] }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </x-admin.panel>

                <x-admin.panel title="Media & Gallery" icon="form-camera.svg">
                    <div class="grid [&>*]:min-w-0 gap-[20px] sm:grid-cols-2">
                        <label class="flex flex-col gap-[8px]">
                            <span class="font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink">Cover Image</span>
                            <input type="file" name="cover" accept="image/*" class="font-jakarta text-[14px] text-editorial-body">
                            @error('cover') <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror
                        </label>
                        <label class="flex flex-col gap-[8px]">
                            <span class="font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink">Gallery (up to 12)</span>
                            <input type="file" name="gallery[]" accept="image/*" multiple class="font-jakarta text-[14px] text-editorial-body">
                            @error('gallery.*') <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror
                        </label>
                    </div>
                    <x-admin.gallery-preview :cover="$hotel->image" :items="$hotel->gallery ?? []" folder="hotels" />
                </x-admin.panel>
            </div>

            <aside class="flex flex-col gap-[24px]">
                <x-admin.panel title="Listing Status" icon="form-vessel.svg">
                    <x-admin.radio-cards name="status" :options="$listingStatuses" :selected="$hotel->status?->value" />
                </x-admin.panel>

                <x-admin.panel title="Location" icon="nav-hotel.svg">
                    <div class="flex flex-col gap-[16px]">
                        <x-admin.field label="Short Location" name="address" :value="$hotel->address" placeholder="Nusa Penida, Bali, Indonesia" :required="true" help="Shown on cards." />
                        <x-admin.field label="Full Address" name="full_address" type="textarea" :value="$hotel->full_address" />
                    </div>
                </x-admin.panel>
            </aside>
        </form>
    </x-admin.form-page>
@endsection
