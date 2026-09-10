<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Penida Gili') — Penida Gili</title>

    {{-- Set before paint so the reveal styles never hide content for no-JS visitors. --}}
    <script>document.documentElement.classList.add('js')</script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('partials.mobile-header')

    @yield('hero')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @include('partials.mobile-tabbar')
</body>
</html>
