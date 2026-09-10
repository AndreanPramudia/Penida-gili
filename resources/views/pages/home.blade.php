{{-- Figma node 1:55 — landing --}}
@extends('layouts.app')

@section('title', 'Home')

@section('nav-active', 'home')

@section('hero')
    @include('partials.home.hero')
@endsection

@section('content')
    @include('partials.home.about')
    @include('partials.home.services')
    @include('partials.home.routes')
    @include('partials.home.operators')
    @include('partials.home.testimonials')
@endsection
