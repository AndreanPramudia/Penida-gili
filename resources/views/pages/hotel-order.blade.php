{{-- Figma node 1:3024 — hotelorder --}}
@extends('layouts.app')

@section('title', 'Order Summary')

@section('nav-active', 'hotel')

@section('hero')
    <header class="relative min-h-[171px] w-full overflow-hidden pb-[24px] lg:h-[276px] lg:min-h-0 lg:pb-0">
        <img src="{{ asset('images/boats/hero-order.png') }}" alt=""
             class="absolute inset-0 size-full object-cover object-bottom">

        <div class="relative z-10">
            @include('partials.nav', ['active' => 'hotel'])

            <div class="container-page mt-[27px] text-center">
                <h1 data-reveal class="text-[24px] lg:text-[48px] font-bold leading-[30px] lg:leading-[60px] text-on-hero">Order Summary</h1>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <form action="#" method="post"
          class="container-page grid [&>*]:min-w-0 gap-[32px] pt-[43px] pb-[31px] lg:pb-[74px] lg:grid-cols-[minmax(0,988fr)_minmax(0,494fr)]">
        @csrf

        {{-- The traveler + party fields are identical across all three order flows. --}}
        @include('partials.order.booking-form', ['order' => $order])

        @include('partials.order.hotel-summary', ['order' => $order])
    </form>
@endsection
