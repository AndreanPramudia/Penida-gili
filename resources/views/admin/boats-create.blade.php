{{-- Figma node 1:7132 — admin Add New Boat --}}
@extends('layouts.admin')

@section('title', 'Add New Boat')

@section('admin-active', 'boat')

@section('content')
    <x-admin.form-page
        heading="Add New Boat"
        subtitle="Register a new boat into the active Boat booking."
        :back-href="route('admin.boats')">

        <form action="#" method="post" class="flex flex-col gap-[32px]">
            @csrf

            {{-- Figma node 1:7159 --}}
            <x-admin.form-section title="Vessel Details" icon="form-vessel.svg">
                <div class="grid [&>*]:min-w-0 gap-[24px] md:grid-cols-2">
                    <div class="md:col-span-2">
                        <x-admin.field label="Boat Name" name="name" value="Maruti Fast Boat" required />
                    </div>

                    <x-admin.field label="Vessel Type" name="type" required
                                   :options="['Select Type', 'Catamaran Fast Ferry', 'Mono-hull Fastboat', 'Luxury Catamaran']" />

                    <x-admin.field label="Passenger Capacity (Pax)" name="capacity" type="number" value="100" required />

                    <x-admin.field label="Engine Details" name="engine" value="4 x 250HP Yamaha Outboards" />

                    <x-admin.field label="Initial Status" name="status"
                                   :options="['Active (Ready for Routes)', 'Non-Active', 'Under Maintenance']" />
                </div>
            </x-admin.form-section>

            {{-- Figma node 1:7206 --}}
            <x-admin.form-section title="Vessel Photos" icon="form-camera.svg">
                <x-admin.uploader name="photos" />
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
                <a href="{{ route('admin.boats') }}"
                   class="rounded-[8px] border border-[#717782] px-[25px] py-[13px] font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink
                          transition-colors duration-300 hover:bg-[#f1f4f6]">
                    Cancel
                </a>

                <button type="submit"
                        class="flex items-center gap-[8px] rounded-[8px] bg-editorial px-[24px] py-[12px] font-jakarta text-[14px] font-bold leading-[20px] tracking-[0.7px] text-white shadow-sm
                               transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                    <img src="{{ asset('images/icons/admin/form-save.svg') }}" alt="" class="size-[18px]">
                    Save Vessel
                </button>
            </div>
        </form>
    </x-admin.form-page>
@endsection
