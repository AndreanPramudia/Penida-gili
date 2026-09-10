{{-- Figma node 1:8059. The frame is named "add activity" in Figma but its
     content is the article editor — the sidebar highlights Article and the
     panels are editorial/SEO, so it belongs to this route. --}}
@extends('layouts.admin')

@section('title', 'Add New Article')

@section('admin-active', 'article')

@section('content')
    <x-admin.form-page
        heading="Add New Article"
        subtitle="Compose editorial guides, maritime safety tips, island port advice, and SEO content for passengers."
        :back-href="route('admin.articles')">

        <x-slot:actions>
            <button type="submit" form="article-form"
                    class="flex items-center gap-[8px] rounded-[8px] border border-[rgba(192,199,211,0.5)] bg-surface px-[18px] py-[10px] font-jakarta text-[14px] font-semibold text-editorial-ink
                           transition-colors duration-300 hover:bg-[#f1f4f6]">
                <img src="{{ asset('images/icons/admin/form-save.svg') }}" alt="" class="size-[16px]">
                Save Draft
            </button>

            <button type="submit" form="article-form"
                    class="flex items-center gap-[8px] rounded-[8px] bg-editorial px-[18px] py-[10px] font-jakarta text-[14px] font-semibold text-white
                           transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                <img src="{{ asset('images/icons/admin/nav-article.svg') }}" alt="" class="size-[16px]">
                Publish Activity
            </button>
        </x-slot:actions>

        <form id="article-form" action="#" method="post"
              class="grid [&>*]:min-w-0 gap-[24px] lg:grid-cols-[minmax(0,640fr)_minmax(0,320fr)]">
            @csrf

            <div class="flex flex-col gap-[24px]">
                <x-admin.panel title="Article Core Editorial" icon="nav-article.svg" badge="6 min read" badge-tone="muted">
                    <div class="flex flex-col gap-[20px]">
                        <x-admin.field label="Article Title" name="title" required
                                       value="Complete Guide to Nusa Penida Fast Boat Transfers: Schedules, Ports, and Travel Tips" />

                        <x-admin.field label="Subtitle / Summary Hook" name="subtitle" type="textarea" required
                                       value="Everything travelers need to know about navigating crossings from Sanur Harbor to Banjar Nyuh seamlessly: sea state safety advisories, boarding gates, and recommended vessel choices." />

                        <div class="grid [&>*]:min-w-0 gap-[20px] sm:grid-cols-2">
                            <x-admin.field label="Primary Category" name="category"
                                           :options="['Travel Guides', 'Boat Tips', 'Activities', 'Culture', 'Weather & Seasons']" />
                            <x-admin.field label="Target Reader Segment" name="segment"
                                           :options="['First-time Island Travelers', 'Returning Guests', 'Surfers & Divers', 'Families']" />
                        </div>
                    </div>
                </x-admin.panel>

                {{-- Figma 1:8059 rich-text editor --}}
                <section class="rounded-admin border border-[rgba(192,199,211,0.3)] bg-surface shadow-sm">
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-[rgba(192,199,211,0.3)] p-[12px]">
                        <div class="flex flex-wrap items-center gap-[8px]">
                            @foreach ($toolbarGroups as $group)
                                <div class="flex items-center gap-[2px] rounded-[8px] bg-[#f1f4f6] p-[4px]">
                                    @foreach ($group as $tool)
                                        <button type="button" aria-label="{{ $tool['label'] }}"
                                                class="flex size-[28px] items-center justify-center rounded-[6px] font-jakarta text-[13px] text-editorial-body
                                                       transition-colors duration-300 hover:bg-surface hover:text-editorial-ink">
                                            {!! $tool['glyph'] !!}
                                        </button>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                        <p class="font-jakarta text-[13px] text-editorial-body">Word Count: <strong class="text-editorial-ink">1,248</strong></p>
                    </div>

                    <div class="p-[24px]">
                        <label for="article-body" class="sr-only">Article body</label>
                        <textarea id="article-body" name="body" rows="16"
                                  class="w-full resize-y bg-transparent font-jakarta text-[16px] leading-[28px] text-editorial-ink focus:outline-none">{{ $body }}</textarea>
                    </div>
                </section>

                <x-admin.panel title="Featured Hero Image" icon="form-camera.svg">
                    <figure class="relative overflow-hidden rounded-[10px]">
                        <img src="{{ asset('images/articles/detail/hero-fastboat.png') }}" alt="" class="h-[260px] w-full object-cover">
                        <figcaption class="absolute bottom-[10px] left-[10px] rounded-[6px] bg-black/60 px-[10px] py-[4px] font-jakarta text-[12px] text-white">
                            Dimensions: 1920 &times; 1080px (Optimized WebP &middot; 324 KB)
                        </figcaption>
                    </figure>

                    <div class="mt-[20px] grid [&>*]:min-w-0 gap-[20px] sm:grid-cols-2">
                        <x-admin.field label="Image Caption" name="caption"
                                       value="En route to Nusa Penida: Sanjaya Express III crossing Badung Strait" />
                        <x-admin.field label="Descriptive Alt Text (Accessibility & SEO)" name="alt"
                                       value="Sanjaya Express III fastboat sailing towards Nusa Penida limestone cliffs" />
                    </div>
                </x-admin.panel>
            </div>

            <aside class="flex flex-col gap-[24px]">
                <x-admin.panel title="Publishing Settings" icon="nav-schedule.svg">
                    <x-admin.radio-cards name="publish_mode" :options="$publishModes" />

                    <div class="mt-[16px] flex flex-col gap-[16px]">
                        <x-admin.field label="Scheduled Release Date & Time" name="release_at" type="datetime-local" />
                        <x-admin.field label="Author & Signature" name="author"
                                       :options="['Capt. Wayan Sudira - Master Mariner', 'Dewa Krisna - Divemaster & Guide', 'Ayu Pradnya - Travel Concierge']" />
                    </div>
                </x-admin.panel>

                <x-admin.panel title="SEO Optimization" icon="nav-report.svg" badge="Score: 92/100">
                    <div class="flex flex-col gap-[16px]">
                        <x-admin.field label="URL Permalink Slug" name="slug" prefix="/blog/"
                                       value="nusa-penida-fast-boat-transfers-guide" />

                        <div>
                            <x-admin.field label="Meta Title" name="meta_title" value="Nusa Penida Fast Boat Transfers Guide | Sanjaya Fastboat" />
                            <p class="mt-[6px] font-jakarta text-[12px] text-editorial-body"><span class="text-editorial">54</span>/60 chars</p>
                        </div>

                        <div>
                            <x-admin.field label="Meta Description" name="meta_description" type="textarea"
                                           value="Planning a boat trip to Nusa Penida? Read official harbor reviews, departure timetables, luggage rules, and captain tips for a smooth strait crossing." />
                            <p class="mt-[6px] font-jakarta text-[12px] text-editorial-body"><span class="text-editorial">142</span>/160 chars</p>
                        </div>

                        {{-- Figma 1:8059 SERP preview --}}
                        <div class="rounded-[10px] bg-[#f7fafc] p-[14px]">
                            <p class="pb-[8px] font-jakarta text-[12px] font-semibold uppercase tracking-[0.5px] text-editorial-body">Live Google SERP Preview</p>
                            <p class="font-jakarta text-[12px] text-editorial-body">sanjayaferry.com &rsaquo; blog &rsaquo; nusa-penida…</p>
                            <p class="font-jakarta text-[14px] font-semibold leading-[20px] text-editorial">Nusa Penida Fast Boat Transfers Guide | Sanjaya Fastboat</p>
                            <p class="font-jakarta text-[12px] leading-[17px] text-editorial-body">
                                Planning a boat trip to Nusa Penida? Read official harbor reviews, departure timetables,
                                luggage rules, and captain tips for a smooth strait crossing.
                            </p>
                        </div>
                    </div>
                </x-admin.panel>

                <x-admin.panel title="Tags & Taxonomy" icon="form-check.svg">
                    <div class="flex flex-wrap gap-[8px]">
                        @foreach ($tags as $tag)
                            <span class="flex items-center gap-[8px] rounded-full bg-[#f1f4f6] px-[12px] py-[6px] font-jakarta text-[13px] text-editorial-ink">
                                {{ $tag }}
                                <button type="button" aria-label="Remove {{ $tag }}" class="text-editorial-body">&times;</button>
                            </span>
                        @endforeach
                    </div>

                    <label class="mt-[14px] block">
                        <span class="sr-only">Add tag</span>
                        <input type="text" name="tag" placeholder="Type tag and hit Enter…"
                               class="w-full rounded-[8px] border border-[rgba(192,199,211,0.5)] bg-[#f7fafc] px-[14px] py-[10px] font-jakarta text-[14px] text-editorial-ink placeholder:text-editorial-meta focus:border-editorial focus:outline-none">
                    </label>
                </x-admin.panel>

                <x-admin.panel title="Contextual Fast Ticket Desk" icon="nav-boat.svg">
                    <label class="flex items-start gap-[10px]">
                        <input type="checkbox" name="embed_widget" checked class="mt-[3px] size-[16px] rounded-[4px] accent-[#005ea1]">
                        <span>
                            <span class="block font-jakarta text-[14px] font-semibold text-editorial-ink">Embed Quick Fast Ticket Desk Widget</span>
                            <span class="block font-jakarta text-[12px] leading-[17px] text-editorial-body">
                                Renders an interactive route booking form within the article side rail on public view.
                            </span>
                        </span>
                    </label>

                    <div class="mt-[16px] flex flex-col gap-[10px]">
                        <x-admin.field label="Pre-selected Route" name="widget_route"
                                       :options="['Sanur Harbor → Banjar Nyuh (Penida)', 'Sanur → Gili Trawangan', 'Nusa Penida → Sanur']" />
                        <p class="font-jakarta text-[12px] text-editorial">Direct conversion tracking enabled</p>
                    </div>
                </x-admin.panel>
            </aside>
        </form>
    </x-admin.form-page>
@endsection
