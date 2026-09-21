{{-- Figma node 1:7269 — admin Add New Schedule (also serves Edit) --}}
@extends('layouts.admin')

@php
    $editing = $schedule->exists;
    $backHref = route('admin.schedules');
    $selectedDays = old('days', $schedule->days ?? $days);
    $vesselOptions = $vessels->mapWithKeys(fn ($v) => [$v->id => $v->name.' — '.$v->operator->name.' (Cap '.$v->capacity.')'])->all();
@endphp

@section('title', $editing ? 'Edit Schedule' : 'Add New Schedule')

@section('admin-active', 'schedule')

@section('content')
    <x-admin.form-page
        :heading="$editing ? 'Edit Schedule' : 'Add New Schedule'"
        subtitle="Configure route timing, vessel assignment, and pricing for a fastboat dispatch."
        :back-href="$backHref">

        <form action="{{ $editing ? route('admin.schedules.update', $schedule) : route('admin.schedules.store') }}" method="post"
              class="grid [&>*]:min-w-0 gap-[24px] lg:grid-cols-[minmax(0,650fr)_minmax(0,315fr)]">
            @csrf
            @if ($editing) @method('PUT') @endif

            <div class="flex flex-col gap-[24px]">
                <div class="overflow-hidden rounded-admin border border-[rgba(192,199,211,0.3)] bg-surface shadow-sm">
                    <div class="h-[4px] bg-editorial"></div>

                    <div class="p-[24px]">
                        <h2 class="flex items-center gap-[12px]">
                            <span class="flex size-[40px] items-center justify-center rounded-[10px] bg-editorial/10">
                                <img src="{{ asset('images/icons/admin/nav-schedule.svg') }}" alt="" class="size-[18px]">
                            </span>
                            <span class="font-jakarta text-[24px] font-semibold leading-[32px] text-editorial-ink">Schedule Details</span>
                        </h2>

                        <div class="mt-[24px] flex flex-col gap-[24px]">
                            <x-admin.field label="Operator" name="boat_operator_id" :value="$schedule->boat_operator_id" :options="$operators->all()" placeholder="Select operator..." :required="true" />

                            <div class="grid [&>*]:min-w-0 gap-[24px] sm:grid-cols-2">
                                <x-admin.field label="Departure Port" name="from_port_id" :value="$schedule->from_port_id" :options="$ports->all()" placeholder="Select port..." :required="true" />
                                <x-admin.field label="Arrival Port" name="to_port_id" :value="$schedule->to_port_id" :options="$ports->all()" placeholder="Select port..." :required="true" />
                            </div>

                            <x-admin.field label="Assigned Vessel" name="vessel_id" :value="$schedule->vessel_id" :options="$vesselOptions" placeholder="Select available vessel..." help="Optional — must belong to the chosen operator." />

                            <div class="grid [&>*]:min-w-0 gap-[24px] sm:grid-cols-2">
                                <x-admin.field label="Departure Time" name="departure_time" type="time" :value="$schedule->departure_time ? \Illuminate\Support\Carbon::parse($schedule->departure_time)->format('H:i') : null" :required="true" />
                                <x-admin.field label="Est. Arrival Time" name="arrival_time" type="time" :value="$schedule->arrival_time ? \Illuminate\Support\Carbon::parse($schedule->arrival_time)->format('H:i') : null" :required="true" />
                            </div>

                            <fieldset>
                                <legend class="font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink">
                                    Operating Days (Frequency)
                                </legend>

                                <div class="mt-[12px] flex flex-wrap gap-[12px]">
                                    @foreach ($days as $day)
                                        <label class="flex items-center gap-[8px] rounded-[8px] bg-[#f1f4f6] px-[14px] py-[10px]">
                                            <input type="checkbox" name="days[]" value="{{ $day }}" @checked(in_array($day, $selectedDays, true))
                                                   class="size-[18px] rounded-[4px] accent-[#005ea1]">
                                            <span class="font-jakarta text-[15px] text-editorial-ink">{{ $day }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('days.*') <p class="mt-[8px] font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</p> @enderror
                            </fieldset>
                        </div>
                    </div>
                </div>

                <x-admin.panel title="Pricing Configuration" icon="kpi-revenue.svg">
                    <p class="flex items-start gap-[12px] rounded-[8px] bg-[#f1f4f6] p-[16px] font-jakarta text-[15px] leading-[24px] text-editorial-body">
                        <img src="{{ asset('images/icons/order/info.svg') }}" alt="" class="mt-[4px] size-[16px] shrink-0">
                        Set base fares for this specific schedule. These prices will override default route pricing if defined here.
                    </p>

                    <div class="mt-[24px] grid [&>*]:min-w-0 gap-[16px] sm:grid-cols-3">
                        <x-admin.field label="Base Price (Local Pax)" name="price_adult" type="number" :value="$schedule->price_adult" placeholder="0" prefix="IDR" :required="true" />
                        <x-admin.field label="Base Price (Foreign Pax)" name="price_foreign" type="number" :value="$schedule->price_foreign" placeholder="0" prefix="IDR" />
                        <x-admin.field label="Child Price" name="price_child" type="number" :value="$schedule->price_child" placeholder="0" prefix="IDR" :required="true" />
                    </div>
                </x-admin.panel>
            </div>

            {{-- Figma 1:7280 right column --}}
            <aside class="flex flex-col gap-[24px] lg:sticky lg:top-8 lg:self-start">
                <div class="rounded-admin bg-gradient-to-b from-[#005ea1] to-[#2178c3] p-[24px] text-white shadow-lg">
                    <span class="flex size-[32px] items-center justify-center rounded-full bg-white/15">&#9728;</span>
                    <h2 class="mt-[16px] font-jakarta text-[24px] font-semibold">Publishing</h2>
                    <p class="mt-[8px] font-jakarta text-[15px] leading-[24px] text-white/85">
                        Only <strong>Active</strong> schedules appear in the public search and booking widget. Keep new
                        routes as Draft until fares are confirmed.
                    </p>
                </div>

                <div class="rounded-admin border border-[rgba(192,199,211,0.3)] bg-surface p-[24px] shadow-sm">
                    <h2 class="border-b border-[rgba(192,199,211,0.3)] pb-[16px] font-jakarta text-[24px] font-semibold text-editorial-ink">
                        Schedule Summary
                    </h2>

                    <div class="py-[16px]">
                        <x-admin.field label="Status" name="status" :value="$schedule->status?->value" :options="\App\Enums\ListingStatus::options()" :required="true" />
                    </div>

                    <dl class="flex flex-col gap-[16px] pb-[16px] font-jakarta text-[15px]">
                        <div class="flex items-center justify-between">
                            <dt class="text-editorial-body">Est. Duration</dt>
                            <dd class="text-editorial-ink">{{ $editing ? $schedule->duration_minutes.' mins' : '—— mins' }}</dd>
                        </div>
                    </dl>

                    <button type="submit"
                            class="w-full rounded-[8px] bg-editorial py-[14px] font-jakarta text-[16px] font-semibold text-white
                                   transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                        {{ $editing ? 'Save Changes' : 'Save Schedule' }}
                    </button>

                    <a href="{{ $backHref }}"
                       class="mt-[12px] block rounded-[8px] border border-[rgba(192,199,211,0.5)] bg-[#f7fafc] py-[14px] text-center font-jakarta text-[16px] text-editorial-ink
                              transition-colors duration-300 hover:bg-[#f1f4f6]">
                        Cancel
                    </a>
                </div>
            </aside>
        </form>
    </x-admin.form-page>
@endsection
