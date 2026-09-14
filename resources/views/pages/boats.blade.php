{{-- Figma node 1:408 — Boat Operators (desktop) / 1:5045 — boat full (mobile) --}}
@extends('layouts.app')

@section('title', 'Boat Operators')

@section('nav-active', 'boat')

@section('hero')
    {{-- Mobile (< lg): three cards, as drawn in Figma 1:5089 --}}
    @include('partials.mobile-page-hero', [
        'image'    => asset('images/boats/hero-boat.png'),
        'title'    => 'Boat Operators',
        'subtitle' => 'Discover our trusted boat operators and their routes across the pristine waters.',
    ])

    <div class="hidden lg:block">
        @include('partials.page-hero', [
            'image'    => asset('images/boats/hero-boat.png'),
            'title'    => 'Boat Operators',
            'subtitle' => 'Discover all the fast boat operators and their routes',
            'active'   => 'boat',
        ])
    </div>
@endsection

@section('content')
    {{-- Mobile (< lg): Figma 1:5095 — Operator Cards List --}}
    <section class="px-[20px] py-[32px] lg:hidden">
        <div class="flex flex-col gap-[32px]">
            @foreach ($operators->take(3) as $index => $operator)
                @include('components.boat-card-mobile', [
                    'delay'       => $index * 90,
                    'name'        => $operator['name'],
                    'description' => $operator['description'],
                    'rating'      => $operator['rating'],
                    'image'       => asset('images/boats/'.$operator['image']),
                    'routes'      => $operator['routes'],
                    'vessels'     => $operator['vessels'],
                    'href'        => route('boats.show', \Illuminate\Support\Str::slug($operator['name'])),
                ])
            @endforeach
        </div>

        <div class="mt-[64px]">
            @include('components.pagination-mobile', ['paginator' => $operators])
        </div>
    </section>

    <section class="container-page hidden pb-[107px] pt-[71px] lg:block">
        <div class="grid [&>*]:min-w-0 justify-items-center gap-x-[52px] gap-y-[71px] sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($operators as $index => $operator)
                @include('components.boat-card', [
                    'delay'       => ($index % 3) * 90,
                    'name'        => $operator['name'],
                    'description' => $operator['description'],
                    'rating'      => $operator['rating'],
                    'image'       => asset('images/boats/'.$operator['image']),
                    'routes'      => $operator['routes'],
                    'vessels'     => $operator['vessels'],
                    'href'        => route('boats.show', \Illuminate\Support\Str::slug($operator['name'])),
                ])
            @endforeach
        </div>

        <div class="mt-[71px]">
            @include('components.pagination', ['paginator' => $operators])
        </div>
    </section>
@endsection
