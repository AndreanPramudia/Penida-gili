{{-- Figma node 1:55 — landing (desktop) / 1:2386 — Dashboard full (mobile) --}}
@extends('layouts.app')

@section('title', 'Home')

@section('nav-active', 'home')

@section('hero')
    {{-- Mobile (< lg) gets its own hero + sections from the mobile Figma frame. --}}
    @include('partials.home.mobile')

    <div class="hidden lg:block">
        @include('partials.home.hero')
    </div>
@endsection

@section('content')
    <div class="hidden lg:block">
        @include('partials.home.about')
        @include('partials.home.services')
        @include('partials.home.routes')
        @include('partials.home.operators')
        @include('partials.home.testimonials')
    </div>
@endsection
