{{-- Figma node 1:946 — hotel --}}
@extends('layouts.app')

@section('title', 'Hotel')

@section('nav-active', 'hotel')

@section('hero')
    @include('partials.page-hero', [
        'image'    => asset('images/hotels/hero-hotel.png'),
        'title'    => 'Hotel',
        'subtitle' => 'A selection of Hotels to complete your unforgettable holiday experience.',
        'active'   => 'hotel',
    ])
@endsection

@section('content')
    <section class="container-page pt-[39px] pb-[45px] lg:pb-[107px]">
        <div class="grid [&>*]:min-w-0 justify-items-center gap-x-[52px] gap-y-[70px] sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($hotels as $index => $hotel)
                @include('components.place-card', [
                    'delay'       => ($index % 3) * 90,
                    'name'        => $hotel['name'],
                    'description' => $hotel['description'],
                    'rating'      => $hotel['rating'],
                    'image'       => asset('images/hotels/'.$hotel['image']),
                    'meta'        => $hotel['meta'],
                    'price'       => $hotel['price'],
                    'href'        => route('hotels.show', \Illuminate\Support\Str::slug($hotel['name'])),
                ])
            @endforeach
        </div>

        <div class="mt-[30px] lg:mt-[71px]">
            @include('components.pagination', ['paginator' => $hotels])
        </div>
    </section>
@endsection
