{{-- Figma node 1:7269 — admin Add New Schedule --}}
@extends('layouts.admin')

@section('title', 'Add New Schedule')

@section('admin-active', 'schedule')

@section('content')
    <x-admin.form-page
        heading="Add New Schedule"
        subtitle="Configure route timing, vessel assignment, and pricing for a new fastboat dispatch."
        :back-href="route('admin.schedules')">

        <form action="#" method="post" class="grid [&>*]:min-w-0 gap-[24px] lg:grid-cols-[minmax(0,650fr)_minmax(0,315fr)]">
            @csrf

            <div class="flex flex-col gap-[24px]">
                {{-- Schedule details card — the top border is the accent bar in the Figma frame. --}}
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
                            <x-admin.field label="Route Segment" name="route"
                                           :options="['Select an established route...', 'Sanur - Nusa Penida', 'Nusa Penida - Sanur', 'Sanur - Gili Trawangan']" />

                            <x-admin.field label="Assigned Vessel" name="vessel"
                                           :options="['Select available vessel...', 'Sanjaya Ocean Queen', 'Sanjaya Express II', 'Sanjaya Explorer']" />

                            <div class="grid [&>*]:min-w-0 gap-[24px] sm:grid-cols-2">
                                <x-admin.field label="Departure Time" name="departure" type="time" />
                                <x-admin.field label="Est. Arrival Time" name="arrival" type="time" />
                            </div>

                            <fieldset>
                                <legend class="font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink">
                                    Operating Days (Frequency)
                                </legend>

                                <div class="mt-[12px] flex flex-wrap gap-[12px]">
                                    @foreach ($days as $day)
                                        <label class="flex items-center gap-[8px] rounded-[8px] bg-[#f1f4f6] px-[14px] py-[10px]">
                                            <input type="checkbox" name="days[]" value="{{ $day }}" checked
                                                   class="size-[18px] rounded-[4px] accent-[#005ea1]">
                                            <span class="font-jakarta text-[15px] text-editorial-ink">{{ $day }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>

                {{-- Pricing card --}}
                <x-admin.form-section title="Pricing Configuration" icon="kpi-revenue.svg">
                    <p class="flex items-start gap-[12px] rounded-[8px] bg-[#f1f4f6] p-[16px] font-jakarta text-[15px] leading-[24px] text-editorial-body">
                        <span aria-hidden="true" class="text-editorial">&#9432;</span>
                        Set base fares for this specific schedule. These prices will override default route pricing if defined here.
                    </p>

                    <div class="mt-[24px] grid [&>*]:min-w-0 gap-[24px] sm:grid-cols-3">
                        <x-admin.field label="Base Price (Local Pax)" name="price_local" type="number" placeholder="0" prefix="IDR" />
                        <x-admin.field label="Base Price (Foreign Pax)" name="price_foreign" type="number" placeholder="0" prefix="IDR" />
                        <x-admin.field label="Child Price" name="price_child" type="number" placeholder="0" prefix="IDR" />
                    </div>
                </x-admin.form-section>
            </div>

            {{-- Figma 1:7280 right column --}}
            <aside class="flex flex-col gap-[24px] lg:sticky lg:top-8 lg:self-start">
                <div class="rounded-admin bg-gradient-to-b from-[#005ea1] to-[#2178c3] p-[24px] text-white shadow-lg">
                    <span class="flex size-[32px] items-center justify-center rounded-full bg-white/15">&#9728;</span>
                    <h2 class="mt-[16px] font-jakarta text-[24px] font-semibold">High Season Alert</h2>
                    <p class="mt-[8px] font-jakarta text-[15px] leading-[24px] text-white/85">
                        Current demand for Nusa Penida routes is 45% higher than average. Consider increasing frequency
                        or deploying higher capacity vessels.
                    </p>
                    <a href="{{ route('admin.dashboard') }}" class="mt-[16px] inline-flex items-center gap-[6px] font-jakarta text-[15px] font-semibold">
                        View Analytics &rarr;
                    </a>
                </div>

                <div class="rounded-admin border border-[rgba(192,199,211,0.3)] bg-surface p-[24px] shadow-sm">
                    <h2 class="border-b border-[rgba(192,199,211,0.3)] pb-[16px] font-jakarta text-[24px] font-semibold text-editorial-ink">
                        Schedule Summary
                    </h2>

                    <dl class="flex flex-col gap-[16px] py-[16px] font-jakarta text-[15px]">
                        <div class="flex items-center justify-between">
                            <dt class="text-editorial-body">Status</dt>
                            <dd><x-admin.status label="Draft" tone="draft" /></dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-editorial-body">Total Capacity</dt>
                            <dd class="text-editorial-ink">&mdash;&mdash; pax</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-editorial-body">Est. Duration</dt>
                            <dd class="text-editorial-ink">&mdash;&mdash; mins</dd>
                        </div>
                    </dl>

                    <button type="submit"
                            class="w-full rounded-[8px] bg-editorial py-[14px] font-jakarta text-[16px] font-semibold text-white
                                   transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                        Publish Schedule
                    </button>

                    <a href="{{ route('admin.schedules') }}"
                       class="mt-[12px] block rounded-[8px] border border-[rgba(192,199,211,0.5)] bg-[#f7fafc] py-[14px] text-center font-jakarta text-[16px] text-editorial-ink
                              transition-colors duration-300 hover:bg-[#f1f4f6]">
                        Cancel
                    </a>
                </div>
            </aside>
        </form>
    </x-admin.form-page>
@endsection
