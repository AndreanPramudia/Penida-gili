{{-- Sidebar destination that is not built yet; keeps every admin link resolvable. --}}
@extends('layouts.admin')

@section('title', $heading)

@section('admin-active', $section)

@section('content')
    <div class="pt-[24px]">
        <h1 class="text-[36px] font-bold tracking-[-0.96px] text-admin-ink">{{ $heading }}</h1>
        <p class="mt-[4px] text-[16px] text-admin-muted">This console page has not been built yet.</p>
    </div>
@endsection
