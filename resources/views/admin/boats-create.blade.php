{{-- Figma node 1:7132 — admin Add New Boat (also serves Edit) --}}
@extends('layouts.admin')

@php
    $editing = $vessel->exists;
    $backHref = route('admin.boats');
    $submitLabel = $editing ? 'Save Changes' : 'Save Vessel';
@endphp

@section('title', $editing ? 'Edit '.$vessel->name : 'Add New Boat')

@section('admin-active', 'boat')

@section('content')
    <x-admin.form-page
        :heading="$editing ? 'Edit Boat' : 'Add New Boat'"
        :subtitle="$editing ? 'Update vessel details, status and facilities.' : 'Register a new boat into the active Boat booking.'"
        :back-href="$backHref">

        <form action="{{ $editing ? route('admin.boats.update', $vessel) : route('admin.boats.store') }}" method="post" enctype="multipart/form-data" class="flex flex-col gap-[32px]">
            @csrf
            @if ($editing) @method('PUT') @endif

            {{-- Figma node 1:7159 --}}
            <x-admin.form-section title="Vessel Details" icon="form-vessel.svg">
                <div class="grid [&>*]:min-w-0 gap-[24px] md:grid-cols-2">
                    <div class="md:col-span-2">
                        <x-admin.field label="Boat Name" name="name" :value="$vessel->name" placeholder="e.g. Sanjaya Ocean Queen" :required="true" />
                    </div>

                    <x-admin.field label="Operator" name="boat_operator_id" :value="$vessel->boat_operator_id" :options="$operators->all()" placeholder="Select operator..." :required="true" />

                    <x-admin.field label="Vessel Type" name="type" :value="$vessel->type" :options="$types" placeholder="Select Type" :required="true" />

                    <x-admin.field label="Passenger Capacity (Pax)" name="capacity" type="number" :value="$vessel->capacity ?? 100" :required="true" />

                    <x-admin.field label="Top Speed (Knots)" name="top_speed_knots" type="number" :value="$vessel->top_speed_knots" placeholder="e.g. 28" />

                    <x-admin.field label="Engine Details" name="engine" :value="$vessel->engine" placeholder="4 x 250HP Yamaha Outboards" />

                    <x-admin.field label="Vessel Code" name="code" :value="$vessel->code" placeholder="Auto-generated (SFB-001)" help="Leave blank to assign the next SFB number." />

                    <x-admin.field label="Status" name="status" :value="$vessel->status?->value" :options="\App\Enums\ListingStatus::options()" :required="true" />

                    <x-admin.field label="Last Inspection Date" name="inspected_at" type="date" :value="$vessel->inspected_at?->toDateString()" />
                </div>
            </x-admin.form-section>

            {{-- Figma node 1:7206 --}}
            <x-admin.form-section title="Vessel Photos" icon="form-camera.svg">
                <x-admin.uploader name="photos" />
                @error('photos.*') <p class="mt-[8px] font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</p> @enderror
                <x-admin.gallery-preview :cover="$vessel->image" folder="boats" />
            </x-admin.form-section>

            {{-- Figma node 1:7222 --}}
            <x-admin.form-section title="Vessel Facilities" icon="form-check.svg">
                <div class="grid [&>*]:min-w-0 gap-[16px] sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($facilities as $facility)
                        <label class="flex items-center gap-[12px]">
                            <input type="checkbox" name="facilities[]" value="{{ $facility['label'] }}"
                                   @checked($facility['checked'])
                                   class="size-[20px] rounded-[4px] border border-[rgba(192,199,211,0.5)] bg-[#f7fafc] accent-[#005ea1]">
                            <span class="font-jakarta text-[16px] leading-[24px] text-editorial-ink">{{ $facility['label'] }}</span>
                        </label>
                    @endforeach
                </div>
            </x-admin.form-section>

            {{-- Figma node 1:7261 --}}
            <div class="flex items-center justify-end gap-[16px] border-t border-[rgba(192,199,211,0.3)] pt-[17px]">
                <a href="{{ $backHref }}"
                   class="rounded-[8px] border border-[#717782] px-[25px] py-[13px] font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink
                          transition-colors duration-300 hover:bg-[#f1f4f6]">
                    Cancel
                </a>

                <button type="submit"
                        class="flex items-center gap-[8px] rounded-[8px] bg-editorial px-[24px] py-[12px] font-jakarta text-[14px] font-bold leading-[20px] tracking-[0.7px] text-white shadow-sm
                               transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                    <img src="{{ asset('images/icons/admin/form-save.svg') }}" alt="" class="size-[18px]">
                    {{ $submitLabel }}
                </button>
            </div>
        </form>
    </x-admin.form-page>
@endsection
