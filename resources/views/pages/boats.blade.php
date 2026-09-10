{{-- Figma node 1:408 — Boat Operators --}}
@extends('layouts.app')

@section('title', 'Boat Operators')

@section('nav-active', 'boat')

@section('hero')
    @include('partials.page-hero', [
        'image'    => asset('images/boats/hero-boat.png'),
        'title'    => 'Boat Operators',
        'subtitle' => 'Discover all the fast boat operators and their routes',
        'active'   => 'boat',
    ])
@endsection

@section('content')
    <section class="container-page pt-[30px] lg:pt-[71px] pb-[45px] lg:pb-[107px]">
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

        <div class="mt-[30px] lg:mt-[71px]">
            @include('components.pagination', ['paginator' => $operators])
        </div>
    </section>
@endsection
