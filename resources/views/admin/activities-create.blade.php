{{-- Figma node 1:8502 — admin Add New Activity (also serves Edit). --}}
@extends('layouts.admin')

@php
    $editing = $activity->exists;
    $backHref = route('admin.activities');
    $selectedDays = old('days', $activity->days ?? $days);
    $time = fn ($v) => $v ? \Illuminate\Support\Carbon::parse($v)->format('H:i') : null;
    $money = fn ($v) => $v ? number_format($v, 0, ',', '.') : null;
    $currentStatus = old('status', $activity->publish_at ? 'scheduled' : $activity->status?->value);
    $chips = fn ($items) => is_array($items) ? implode(', ', $items) : (string) $items;
    $photoCount = ($activity->image ? 1 : 0) + count($activity->gallery ?? []);
@endphp

@section('title', $editing ? 'Edit '.$activity->name : 'Add New Activity')

@section('admin-active', 'activity')

@section('content')
    <x-admin.form-page
        :heading="$editing ? 'Edit Activity' : 'Add New Activity'"
        subtitle="Publish cultural tours, watersports, and day experiences for Penida Gili passengers."
        :back-href="$backHref">

        {{-- Action Controls (1:8513) --}}
        <x-slot:actions>
            <button type="submit" form="activity-form" name="submit_as" value="draft"
                    class="flex items-center gap-[8px] rounded-[8px] border border-[#c0c7d3] bg-surface px-[18px] py-[10px] font-jakarta text-[14px] font-semibold text-editorial-ink
                           transition-colors duration-300 hover:bg-[#f1f4f6]">
                <img src="{{ asset('images/icons/admin/form-save.svg') }}" alt="" class="size-[16px]">
                Save Draft
            </button>
            <button type="submit" form="activity-form" name="submit_as" value="publish"
                    class="flex items-center gap-[8px] rounded-[8px] bg-editorial px-[18px] py-[10px] font-jakarta text-[14px] font-semibold text-white
                           transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                <img src="{{ asset('images/icons/admin/nav-activity.svg') }}" alt="" class="size-[16px]">
                Publish Activity
            </button>
        </x-slot:actions>

        <form id="activity-form" action="{{ $editing ? route('admin.activities.update', $activity) : route('admin.activities.store') }}" method="post" enctype="multipart/form-data"
              class="grid [&>*]:min-w-0 gap-[24px] lg:grid-cols-[minmax(0,640fr)_minmax(0,320fr)]" data-activity-form>
            @csrf
            @if ($editing) @method('PUT') @endif

            <div class="flex flex-col gap-[24px]">
                {{-- 1. Basic Information (1:8525) --}}
                <x-admin.panel title="Basic Information" description="General identification and core activity categorization" icon="nav-activity.svg">
                    <div class="flex flex-col gap-[20px]">
                        <x-admin.field label="Activity Title" name="name" :value="$activity->name" placeholder="Balinese Traditional Costume Rental at Penglipuran" :required="true" />

                        <div class="grid [&>*]:min-w-0 gap-[20px] sm:grid-cols-2">
                            <x-admin.field label="Category" name="category" :value="$activity->category" :options="$categories" placeholder="Select category..." :required="true" />
                            <x-admin.field label="Short Catchy Tagline / Badge" name="badge" :value="$activity->badge" placeholder="Best Seller" />
                        </div>

                        <div class="flex flex-col gap-[8px]">
                            <label for="activity-description" class="font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink">Full Description *</label>
                            <div @class(['overflow-hidden rounded-[8px] border bg-[#f7fafc]', 'border-[#dc2626]' => $errors->has('description'), 'border-[rgba(192,199,211,0.5)]' => ! $errors->has('description')])>
                                {{-- Rich-text toolbar strip (1:8566) — plain text is stored; the strip mirrors the design. --}}
                                <div class="flex items-center gap-[4px] border-b border-[rgba(192,199,211,0.3)] bg-surface px-[8px] py-[6px] font-jakarta text-[13px] text-editorial-body" aria-hidden="true">
                                    <span class="rounded-[4px] px-[8px] py-[2px] font-bold">B</span>
                                    <span class="rounded-[4px] px-[8px] py-[2px] italic">I</span>
                                    <span class="rounded-[4px] px-[8px] py-[2px] underline">U</span>
                                    <span class="mx-[4px] h-[16px] w-px bg-[rgba(192,199,211,0.5)]"></span>
                                    <span class="rounded-[4px] px-[8px] py-[2px]">&bull; List</span>
                                    <span class="rounded-[4px] px-[8px] py-[2px]">1. List</span>
                                </div>
                                <textarea id="activity-description" name="description" rows="8" required
                                          placeholder="Step into the timeless living heritage of Penglipuran Village…"
                                          class="w-full resize-y bg-transparent px-[17px] py-[13px] font-jakarta text-[16px] leading-[26px] text-editorial-ink placeholder:text-editorial-meta focus:outline-none">{{ old('description', $activity->description) }}</textarea>
                            </div>
                            @error('description') <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </x-admin.panel>

                {{-- 2. Schedule & Operational Hours (1:8599) --}}
                <x-admin.panel title="Schedule & Operational Hours" description="Daily timetable, service timeframes, and customer commitment policies" icon="nav-schedule.svg">
                    <fieldset>
                        <div class="flex items-center justify-between">
                            <legend class="font-jakarta text-[14px] font-semibold text-editorial-ink">Operating Days</legend>
                            <button type="button" data-select-all-days class="font-jakarta text-[13px] font-semibold text-editorial hover:underline">Select All Days</button>
                        </div>
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

                    {{-- Toggles & Dropdown Rules (1:8676) --}}
                    <div class="mt-[20px] grid [&>*]:min-w-0 gap-[20px] sm:grid-cols-2">
                        <div class="rounded-[8px] border border-[rgba(192,199,211,0.5)] bg-[#f7fafc] px-[16px] py-[14px]">
                            <x-admin.toggle name="instant_confirmation" label="Instant Confirmation" description="Automatically issue ticket vouchers on payment" :checked="old('instant_confirmation', $activity->instant_confirmation ?? true)" />
                        </div>
                        <x-admin.field label="Cancellation Policy" name="cancellation_policy" :value="$activity->cancellation_policy ?? 'free_24h'" :options="$cancellationPolicies" />
                    </div>
                </x-admin.panel>

                {{-- 3. Experience Highlights & Inclusions (1:8695) --}}
                <x-admin.panel title="Experience Highlights & Inclusions" description="Set clear expectations on deliverables and requirements" icon="form-check.svg">
                    <div class="flex flex-col gap-[20px]">
                        @foreach (['included' => ["What's Included", '+ Add inclusion...', 'bg-editorial/10 text-editorial'], 'excluded' => ["What's Excluded", '+ Add exclusion...', 'bg-[#fee2e2] text-[#991b1b]']] as $field => [$label, $placeholder, $tone])
                            <div class="flex flex-col gap-[8px]" data-keywords data-chip-class="{{ $tone }}">
                                <span class="font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink">{{ $label }}</span>
                                <input type="hidden" name="{{ $field }}" value="{{ $chips(old($field, $activity->{$field} ?? [])) }}">
                                <div class="flex flex-wrap items-center gap-[8px] rounded-[8px] border border-[rgba(192,199,211,0.5)] bg-[#f7fafc] px-[12px] py-[8px] focus-within:border-editorial">
                                    <span class="contents" data-keywords-list></span>
                                    <input type="text" placeholder="{{ $placeholder }}" autocomplete="off"
                                           class="min-w-[160px] flex-1 bg-transparent py-[5px] font-jakarta text-[14px] leading-[20px] text-editorial-ink placeholder:text-editorial-meta focus:outline-none">
                                </div>
                                @error($field) <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror
                            </div>
                        @endforeach

                        <x-admin.field label="Important Notes" name="important_notes" type="textarea" :value="$activity->important_notes"
                                       placeholder="- Please show your mobile e-voucher at the local reception counter upon arrival.&#10;- Costumes are available for adults and children (ages 5+).&#10;- Hands-on help with sarongs and sashes is included." />
                    </div>
                </x-admin.panel>

                {{-- 4. Media & Gallery Upload (1:8775) --}}
                <x-admin.panel title="Media & Gallery Upload" description="Drag to reorder photos. High quality imagery increases booking conversions." icon="form-camera.svg" :badge="$photoCount.' / 8 Photos'" badge-tone="muted">
                    <div class="flex flex-col gap-[20px]" data-media>
                        <label class="flex cursor-pointer flex-col items-center justify-center rounded-admin border-2 border-dashed border-[rgba(192,199,211,0.6)] bg-[#f7fafc] p-[34px]
                                      transition-colors duration-300 hover:border-editorial hover:bg-[#eef4f8]">
                            <input type="file" name="gallery[]" accept="image/png,image/jpeg,image/webp" multiple class="sr-only" data-gallery-input>
                            <span class="mb-[16px] flex size-[64px] items-center justify-center rounded-full bg-[#d5e2e9]">
                                <img src="{{ asset('images/icons/admin/form-upload.svg') }}" alt="" class="size-[20px]">
                            </span>
                            <span class="font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink">Click to browse or drop images here</span>
                            <span class="font-jakarta text-[14px] leading-[20px] text-editorial-body">Upload high-resolution activity photos (PNG, JPG up to 10MB each, min 1280x720)</span>
                            <span data-gallery-picked class="mt-[6px] font-jakarta text-[13px] text-editorial"></span>
                        </label>
                        @error('gallery.*') <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror

                        {{-- Image Thumbnails Grid (1:8796) — first tile is the hero cover --}}
                        <div class="grid [&>*]:min-w-0 gap-[16px] sm:grid-cols-3">
                            <label class="relative block cursor-pointer overflow-hidden rounded-[10px] border-2 border-editorial">
                                <input type="file" name="cover" accept="image/png,image/jpeg,image/webp" class="sr-only" data-cover-input>
                                <img data-cover-preview src="{{ $activity->image ? \App\Support\ImagePath::url($activity->image, 'activities') : '' }}" alt="" @if (! $activity->image) hidden @endif class="h-[120px] w-full object-cover">
                                @if (! $activity->image)
                                    <span data-cover-empty class="flex h-[120px] items-center justify-center bg-[#f1f4f6] font-jakarta text-[13px] text-editorial-body">Choose cover image</span>
                                @endif
                                <span class="absolute left-[8px] top-[8px] rounded-[6px] bg-editorial px-[8px] py-[3px] font-jakarta text-[11px] font-semibold text-white">Hero Featured Cover</span>
                            </label>
                            @foreach ($activity->gallery ?? [] as $photo)
                                <figure class="overflow-hidden rounded-[10px]">
                                    <img src="{{ \App\Support\ImagePath::url($photo['image'] ?? $photo, 'activities/detail') }}" alt="{{ $photo['alt'] ?? '' }}" class="h-[120px] w-full object-cover">
                                </figure>
                            @endforeach
                        </div>
                        @error('cover') <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror
                    </div>
                </x-admin.panel>
            </div>

            <aside class="flex flex-col gap-[24px]">
                {{-- 1. Publishing Status (1:8828) --}}
                <x-admin.panel title="Publishing Status" icon="form-vessel.svg">
                    <x-admin.radio-cards name="status" :options="$statuses" :selected="$currentStatus" />

                    <div data-publish-at class="mt-[12px]" @if ($currentStatus !== 'scheduled') hidden @endif>
                        <x-admin.field label="Go live at" name="publish_at" type="datetime-local" :value="$activity->publish_at?->format('Y-m-d\TH:i')" />
                    </div>

                    <div class="mt-[16px] border-t border-[rgba(192,199,211,0.3)] pt-[16px]">
                        <x-admin.toggle name="is_public" label="Public Visibility" description="Show on Penida Gili website portal" :checked="old('is_public', $activity->is_public ?? true)" />
                    </div>
                </x-admin.panel>

                {{-- 2. Pricing & Quota Capacity (1:8875) --}}
                <x-admin.panel title="Pricing & Quota Capacity" icon="kpi-revenue.svg">
                    <div class="flex flex-col gap-[16px]">
                        <x-admin.field label="Base Price per Pax (IDR)" name="price_adult" :value="$money($activity->price_adult)" placeholder="75.000" prefix="Rp" :required="true" />
                        <div>
                            <x-admin.field label="Original / Strikethrough Price" name="price_was" :value="$money($activity->price_was)" placeholder="150.000" prefix="Rp" />
                            <p data-discount-note class="mt-[6px] font-jakarta text-[13px] leading-[18px] text-editorial" @if (! $activity->price_was) hidden @endif>
                                Displays {{ $activity->price_was ? round((1 - $activity->price_adult / max(1, $activity->price_was)) * 100) : 0 }}% discount badge to customers
                            </p>
                        </div>

                        <div class="rounded-[8px] border border-[rgba(192,199,211,0.5)] bg-[#f7fafc] px-[16px] py-[14px]">
                            <x-admin.toggle name="dual_pricing" label="Domestic vs Foreign Price" description="Enable dual-tier pricing model" :checked="old('dual_pricing', $activity->dual_pricing ?? false)" />
                        </div>
                        <div class="flex flex-col gap-[8px]">
                            <label for="max-daily-capacity" class="font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink">Max Daily Capacity / Quota *</label>
                            <span @class(['flex items-center rounded-[8px] border bg-[#f7fafc] pr-[17px]', 'border-[#dc2626]' => $errors->has('max_daily_capacity'), 'border-[rgba(192,199,211,0.5)]' => ! $errors->has('max_daily_capacity')])>
                                <input id="max-daily-capacity" name="max_daily_capacity" type="number" min="1" value="{{ old('max_daily_capacity', $activity->max_daily_capacity ?? 50) }}" required
                                       class="w-full bg-transparent px-[17px] py-[13px] font-jakarta text-[16px] leading-[24px] text-editorial-ink focus:outline-none">
                                <span class="whitespace-nowrap font-jakarta text-[14px] text-editorial-body">pax / day</span>
                            </span>
                            @error('max_daily_capacity') <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </x-admin.panel>
            </aside>
        </form>
    </x-admin.form-page>
@endsection
