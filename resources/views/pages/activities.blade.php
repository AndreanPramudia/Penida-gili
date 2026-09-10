{{-- Figma node 1:623 — Activity --}}
@extends('layouts.app')

@section('title', 'Activity')

@section('nav-active', 'activity')

@section('hero')
    @include('partials.page-hero', [
        'image'    => asset('images/activities/hero-activity.png'),
        'title'    => 'Activity',
        'subtitle' => 'A selection of exciting and unique activities to complete your unforgettable holiday experience.',
        'active'   => 'activity',
    ])
@endsection

@section('content')
    <section class="container-page pt-[39px] pb-[45px] lg:pb-[107px]">
        <div class="grid [&>*]:min-w-0 justify-items-center gap-x-[52px] gap-y-[70px] sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($activities as $index => $activity)
                @include('components.place-card', [
                    'delay'       => ($index % 3) * 90,
                    'name'        => $activity['name'],
                    'description' => $activity['description'],
                    'rating'      => $activity['rating'],
                    'image'       => asset('images/activities/'.$activity['image']),
                    'meta'        => $activity['meta'],
                    'price'       => $activity['price'],
                    'href'        => route('activities.show', \Illuminate\Support\Str::slug($activity['name'])),
                ])
            @endforeach
        </div>

        <div class="mt-[30px] lg:mt-[71px]">
            @include('components.pagination', ['paginator' => $activities])
        </div>
    </section>
@endsection
