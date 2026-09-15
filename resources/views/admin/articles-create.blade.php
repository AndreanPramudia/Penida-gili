{{-- Figma node 1:8059 — admin Add New Article (also serves Edit) --}}
@extends('layouts.admin')

@php
    $editing = $article->exists;
    $backHref = route('admin.articles');
@endphp

@section('title', $editing ? 'Edit Article' : 'Add New Article')

@section('admin-active', 'article')

@section('content')
    <x-admin.form-page
        :heading="$editing ? 'Edit Article' : 'Add New Article'"
        subtitle="Write travel guides, boat tips and island stories for the blog."
        :back-href="$backHref">

        <x-slot:actions>
            <button type="submit" form="article-form"
                    class="flex items-center gap-[8px] rounded-[8px] bg-editorial px-[18px] py-[10px] font-jakarta text-[14px] font-semibold text-white
                           transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                <img src="{{ asset('images/icons/admin/nav-article.svg') }}" alt="" class="size-[16px]">
                {{ $editing ? 'Save Changes' : 'Save Article' }}
            </button>
        </x-slot:actions>

        <form id="article-form" action="{{ $editing ? route('admin.articles.update', $article) : route('admin.articles.store') }}" method="post" enctype="multipart/form-data"
              class="grid [&>*]:min-w-0 gap-[24px] lg:grid-cols-[minmax(0,640fr)_minmax(0,320fr)]">
            @csrf
            @if ($editing) @method('PUT') @endif

            <div class="flex flex-col gap-[24px]">
                <x-admin.panel title="Headline & Summary" icon="nav-article.svg">
                    <div class="flex flex-col gap-[20px]">
                        <x-admin.field label="Article Title" name="title" :value="$article->title" :required="true" />
                        <x-admin.field label="Excerpt (card summary)" name="excerpt" type="textarea" :value="$article->excerpt" :required="true" />
                        <x-admin.field label="Subtitle / Summary Hook" name="subtitle" type="textarea" :value="$article->subtitle" />
                        <x-admin.field label="Primary Category" name="category" :value="$article->category" :options="$categories" :required="true" />
                    </div>
                </x-admin.panel>

                <section class="overflow-hidden rounded-admin border border-[rgba(192,199,211,0.3)] bg-surface shadow-sm">
                    <div class="border-b border-[rgba(192,199,211,0.3)] bg-[#f7fafc] px-[24px] py-[14px] font-jakarta text-[14px] font-semibold text-editorial-ink">
                        Article Body <span class="font-normal text-editorial-body">— separate paragraphs with a blank line</span>
                    </div>
                    <div class="p-[24px]">
                        <label for="article-body" class="sr-only">Article body</label>
                        <textarea id="article-body" name="body" rows="16" required
                                  class="w-full resize-y bg-transparent font-jakarta text-[16px] leading-[28px] text-editorial-ink focus:outline-none">{{ old('body', $article->body) }}</textarea>
                        @error('body') <p class="mt-[8px] font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</p> @enderror
                    </div>
                </section>

                <x-admin.panel title="Featured Hero Image" icon="form-camera.svg">
                    <label class="flex flex-col gap-[8px]">
                        <span class="font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink">Cover Image</span>
                        <input type="file" name="cover" accept="image/*" class="font-jakarta text-[14px] text-editorial-body">
                        @error('cover') <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror
                    </label>
                    <x-admin.gallery-preview :cover="$article->image" folder="articles" />
                    <div class="mt-[20px]">
                        <x-admin.field label="Image Caption" name="hero_caption" :value="$article->hero_caption" />
                    </div>
                </x-admin.panel>
            </div>

            <aside class="flex flex-col gap-[24px]">
                <x-admin.panel title="Publishing Settings" icon="nav-schedule.svg">
                    <x-admin.radio-cards name="status" :options="$publishModes" :selected="$article->status?->value" />

                    <div class="mt-[16px] flex flex-col gap-[16px] border-t border-[rgba(192,199,211,0.3)] pt-[16px]">
                        <x-admin.field label="Scheduled Release Date & Time" name="published_at" type="datetime-local" :value="$article->published_at?->format('Y-m-d\TH:i')" help="Required when scheduling." />
                        <label class="flex items-center gap-[10px] font-jakarta text-[14px] text-editorial-ink">
                            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $article->is_featured)) class="size-[16px] rounded-[4px] accent-[#005ea1]">
                            Feature at the top of the blog
                        </label>
                    </div>
                </x-admin.panel>

                <x-admin.panel title="Author & SEO" icon="form-vessel.svg">
                    <div class="flex flex-col gap-[16px]">
                        <x-admin.field label="Author" name="author_name" :value="$article->author_name" :required="true" />
                        <x-admin.field label="Author Role" name="author_role" :value="$article->author_role" placeholder="Marine Operations Lead" />
                        <x-admin.field label="URL Permalink Slug" name="slug" :value="$article->slug" prefix="/artikel/" help="Leave blank to generate from the title." />
                        <x-admin.field label="Read Time (minutes)" name="read_time_minutes" type="number" :value="$article->read_time_minutes" help="Estimated from the body when blank." />
                        <x-admin.field label="Tags" name="tags" :value="implode(' ', $article->tags ?? [])" placeholder="#NusaPenida #FastBoatBali" help="Space or comma separated." />
                    </div>
                </x-admin.panel>
            </aside>
        </form>
    </x-admin.form-page>
@endsection
