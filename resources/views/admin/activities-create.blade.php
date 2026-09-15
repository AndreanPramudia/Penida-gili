{{-- Figma node 1:8502 — admin Add New Activity (also serves Edit) --}}
@extends('layouts.admin')

@php
    $editing = $activity->exists;
    $backHref = route('admin.activities');
    $selectedDays = old('days', $activity->days ?? $days);
    $time = fn ($v) => $v ? \Illuminate\Support\Carbon::parse($v)->format('H:i') : null;
@endphp

@section('title', $editing ? 'Edit '.$activity->name : 'Add New Activity')

@section('admin-active', 'activity')

@section('content')
    <x-admin.form-page
        :heading="$editing ? 'Edit Activity' : 'Add New Activity'"
        subtitle="Publish cultural tours, watersports, and day experiences for Penida Gili passengers."
        :back-href="$backHref">

        <x-slot:actions>
            <button type="submit" form="activity-form"
                    class="flex items-center gap-[8px] rounded-[8px] bg-editorial px-[18px] py-[10px] font-jakarta text-[14px] font-semibold text-white
                           transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                <img src="{{ asset('images/icons/admin/nav-activity.svg') }}" alt="" class="size-[16px]">
                {{ $editing ? 'Save Changes' : 'Save Activity' }}
            </button>
        </x-slot:actions>

        <form id="activity-form" action="{{ $editing ? route('admin.activities.update', $activity) : route('admin.activities.store') }}" method="post" enctype="multipart/form-data"
              class="grid [&>*]:min-w-0 gap-[24px] lg:grid-cols-[minmax(0,640fr)_minmax(0,320fr)]">
            @csrf
            @if ($editing) @method('PUT') @endif

            <div class="flex flex-col gap-[24px]">
                <x-admin.panel title="Basic Information" description="General identification and core activity categorization" icon="nav-activity.svg">
                    <div class="flex flex-col gap-[20px]">
                        <x-admin.field label="Activity Title" name="name" :value="$activity->name" placeholder="e.g. Balinese Traditional Costume Rental" :required="true" />

                        <div class="grid [&>*]:min-w-0 gap-[20px] sm:grid-cols-2">
                            <x-admin.field label="Category" name="category" :value="$activity->category" :options="$categories" placeholder="Select category..." :required="true" />
                            <x-admin.field label="Short Catchy Tagline / Badge" name="badge" :value="$activity->badge" placeholder="Best Seller" />
                        </div>

                        <x-admin.field label="Card Description" name="description" type="textarea" :value="$activity->description" :required="true" help="Shown on the listing cards (1–2 sentences)." />
                        <x-admin.field label="Intro Paragraph" name="intro" type="textarea" :value="$activity->intro" help="Opens the detail page." />
                        <x-admin.field label="Full Summary" name="summary" type="textarea" :value="$activity->summary" help="Long-form text under the Summary tab." />
                    </div>
                </x-admin.panel>

                <x-admin.panel title="Schedule & Operational Hours" description="Daily timetable and service timeframes" icon="nav-schedule.svg">
                    <fieldset>
                        <legend class="font-jakarta text-[14px] font-semibold text-editorial-ink">Operating Days</legend>
                        <div class="mt-[12px] flex flex-wrap gap-[10px]">
                            @foreach ($days as $day)
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="days[]" value="{{ $day }}" @checked(in_array($day, $selectedDays, true)) class="peer sr-only">
                                    <span class="block rounded-[8px] border border-[rgba(192,199,211,0.5)] bg-[#f7fafc] px-[18px] py-[9px] font-jakarta text-[15px] text-editorial-body
                                                 peer-checked:border-editorial peer-checked:bg-editorial/10 peer-checked:text-editorial">{{ $day }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>

                    <div class="mt-[20px] grid [&>*]:min-w-0 gap-[20px] sm:grid-cols-3">
                        <x-admin.field label="Opening Time" name="opens_at" type="time" :value="$time($activity->opens_at)" />
                        <x-admin.field label="Closing Time" name="closes_at" type="time" :value="$time($activity->closes_at)" />
                        <x-admin.field label="Duration Estimate" name="duration_label" :value="$activity->duration_label" placeholder="1 - 2 Hours" />
                    </div>
                </x-admin.panel>

                <x-admin.panel title="Experience Highlights & Inclusions" description="Set clear expectations on deliverables and requirements" icon="form-check.svg">
                    <div class="grid [&>*]:min-w-0 gap-[20px] sm:grid-cols-2">
                        <x-admin.field label="What's Included" name="included" type="textarea" :value="implode(PHP_EOL, $activity->included ?? [])" placeholder="One item per line" />
                        <x-admin.field label="What's Excluded" name="excluded" type="textarea" :value="implode(PHP_EOL, $activity->excluded ?? [])" placeholder="One item per line" />
                    </div>
                </x-admin.panel>

                <x-admin.panel title="Media & Gallery Upload" description="High quality imagery increases booking conversions." icon="form-camera.svg">
                    <div class="grid [&>*]:min-w-0 gap-[20px] sm:grid-cols-2">
                        <label class="flex flex-col gap-[8px]">
                            <span class="font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink">Cover Image</span>
                            <input type="file" name="cover" accept="image/*" class="font-jakarta text-[14px] text-editorial-body">
                            @error('cover') <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror
                        </label>
                        <label class="flex flex-col gap-[8px]">
                            <span class="font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink">Gallery (up to 8)</span>
                            <input type="file" name="gallery[]" accept="image/*" multiple class="font-jakarta text-[14px] text-editorial-body">
                            @error('gallery.*') <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror
                        </label>
                    </div>
                    <x-admin.gallery-preview :cover="$activity->image" :items="$activity->gallery ?? []" folder="activities" />
                </x-admin.panel>
            </div>

            <aside class="flex flex-col gap-[24px]">
                <x-admin.panel title="Publishing Status" icon="form-vessel.svg">
                    <x-admin.radio-cards name="status" :options="$statuses" :selected="$activity->status?->value" />
                </x-admin.panel>

                <x-admin.panel title="Pricing" icon="kpi-revenue.svg">
                    <div class="flex flex-col gap-[16px]">
                        <x-admin.field label="Base Price per Adult (IDR)" name="price_adult" :value="$activity->price_adult ? number_format($activity->price_adult, 0, ',', '.') : null" placeholder="75.000" prefix="Rp" :required="true" />
                        <x-admin.field label="Child Price (IDR)" name="price_child" :value="$activity->price_child ? number_format($activity->price_child, 0, ',', '.') : null" placeholder="50.000" prefix="Rp" />
                        <x-admin.field label="Original / Strikethrough Price" name="price_was" :value="$activity->price_was ? number_format($activity->price_was, 0, ',', '.') : null" placeholder="150.000" prefix="Rp" help="Shown crossed out next to the price." />
                        <x-admin.field label="Price Note" name="price_note" :value="$activity->price_note" placeholder="Price is valid for Domestic tourists or KITAS Holders" />
                    </div>
                </x-admin.panel>

                <x-admin.panel title="Location & Meeting Point" icon="nav-hotel.svg">
                    <div class="flex flex-col gap-[16px]">
                        <x-admin.field label="Destination Area" name="place_label" :value="$activity->place_label" placeholder="Penglipuran" :required="true" />
                        <x-admin.field label="Full Address / Meeting Point" name="location" type="textarea" :value="$activity->location" :required="true" />
                    </div>
                </x-admin.panel>
            </aside>
        </form>
    </x-admin.form-page>
@endsection
