{{-- Figma node 1:2095 — article --}}
@extends('layouts.app')

@section('title', 'Article')

@section('nav-active', 'artikel')

@section('hero')
    <header class="relative min-h-[171px] w-full overflow-hidden pb-[24px] lg:h-[276px] lg:min-h-0 lg:pb-0">
        <img src="{{ asset('images/articles/hero-article.png') }}" alt=""
             class="absolute inset-0 size-full object-cover object-bottom">

        <div class="relative z-10">
            @include('partials.nav', ['active' => 'artikel'])

            <div class="container-page mt-[27px] text-center">
                <h1 data-reveal class="text-[24px] lg:text-[48px] font-bold leading-[30px] lg:leading-[60px] text-on-hero">Article</h1>
            </div>
        </div>
    </header>
@endsection

@section('content')
    @include('partials.article.filter-header')

    @include('partials.article.featured', ['article' => $featured])

    {{-- Figma node 1:2174 — article grid section --}}
    <section class="container-page pt-[34px] lg:pt-[82px] font-jakarta">
        <div data-reveal class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <h2 class="text-[30.8px] font-bold leading-[42.3px] text-editorial-ink">Recent Travel Stories</h2>
                <p class="mt-[5px] text-[17.95px] leading-[25.6px] text-editorial-body">
                    Curated perspectives and nautical updates from our skippers and island navigators.
                </p>
            </div>

            <p class="text-[15.4px] leading-[20.5px] text-editorial-meta">
                Showing {{ $articles->firstItem() }}&ndash;{{ $articles->lastItem() }} of {{ $articles->total() }} articles
            </p>
        </div>

        <div class="mt-[48px] lg:mt-[114px] grid [&>*]:min-w-0 items-stretch gap-[31px] md:grid-cols-2 xl:grid-cols-3">
            @foreach ($articles as $index => $article)
                @include('components.article-card', [
                    'delay'    => ($index % 3) * 90,
                    'title'    => $article['title'],
                    'excerpt'  => $article['excerpt'],
                    'category' => $article['category'],
                    'readTime' => $article['readTime'],
                    'date'     => $article['date'],
                    'author'   => $article['author'],
                    'image'    => asset('images/articles/'.$article['image']),
                    'href'     => route('articles.show', \Illuminate\Support\Str::slug($article['title'])),
                ])
            @endforeach
        </div>

        <div class="mt-[26px] lg:mt-[63px]">
            @include('components.pagination', ['paginator' => $articles])
        </div>
    </section>

    @include('partials.article.newsletter')
@endsection
