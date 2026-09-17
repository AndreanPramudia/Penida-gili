{{-- Figma node 1:8059 — admin Add New Article (also serves Edit).
     Section order follows the "Tambah Artikel" reference: SEO → article info → image & body → actions. --}}
@extends('layouts.admin')

@php
    $editing = $article->exists;
    $backHref = route('admin.articles');
    $keywords = old('meta_keywords', $article->meta_keywords ?? []);
    $keywords = is_array($keywords) ? implode(', ', $keywords) : $keywords;
@endphp

@section('title', $editing ? 'Edit Article' : 'Add New Article')

@section('admin-active', 'article')

@section('content')
    <x-admin.form-page
        :heading="$editing ? 'Edit Article' : 'Add New Article'"
        subtitle="Fill in the article content — everything here is saved to the database."
        :back-href="$backHref">

        <x-slot:actions>
            <button type="submit" form="article-form"
                    class="flex items-center gap-[8px] rounded-[8px] bg-editorial px-[18px] py-[10px] font-jakarta text-[14px] font-semibold text-white
                           transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                <img src="{{ asset('images/icons/admin/form-save.svg') }}" alt="" class="size-[16px]">
                {{ $editing ? 'Save Changes' : 'Save Article' }}
            </button>
        </x-slot:actions>

        <form id="article-form" action="{{ $editing ? route('admin.articles.update', $article) : route('admin.articles.store') }}" method="post" enctype="multipart/form-data"
              class="grid [&>*]:min-w-0 gap-[24px] lg:grid-cols-[minmax(0,640fr)_minmax(0,320fr)]">
            @csrf
            @if ($editing) @method('PUT') @endif

            <div class="flex flex-col gap-[24px]">
                {{-- SEO (Google) --}}
                <x-admin.panel title="SEO (Google)" icon="search.svg" description="How the article appears in search results." badge="Optional" badge-tone="muted">
                    <div class="flex flex-col gap-[20px]">
                        <x-admin.field label="Meta Title" name="meta_title" :value="$article->meta_title"
                                       placeholder="Nusa Penida Fast Boat Guide 2026 | Penida Gili" help="Up to 70 characters." />
                        <x-admin.field label="Meta Description" name="meta_description" type="textarea" :value="$article->meta_description"
                                       placeholder="Complete fast boat schedules, ports and travel tips for Nusa Penida." help="Up to 160 characters." />

                        <div class="flex flex-col gap-[8px]" data-keywords>
                            <span class="font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink">Keywords</span>
                            <input type="hidden" name="meta_keywords" value="{{ $keywords }}">
                            <div @class([
                                'flex flex-wrap items-center gap-[8px] rounded-[8px] border bg-[#f7fafc] px-[12px] py-[8px] focus-within:border-editorial',
                                'border-[#dc2626]' => $errors->has('meta_keywords') || $errors->has('meta_keywords.*'),
                                'border-[rgba(192,199,211,0.5)]' => ! ($errors->has('meta_keywords') || $errors->has('meta_keywords.*')),
                            ])>
                                <span class="contents" data-keywords-list></span>
                                <input type="text" placeholder="Type, then press Enter or comma" autocomplete="off"
                                       class="min-w-[180px] flex-1 bg-transparent py-[5px] font-jakarta text-[16px] leading-[24px] text-editorial-ink placeholder:text-editorial-meta focus:outline-none">
                            </div>
                            <span class="font-jakarta text-[13px] leading-[18px] text-editorial-body">
                                Optional. When left blank the page falls back to the article title and excerpt for SEO.
                            </span>
                            @error('meta_keywords') <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </x-admin.panel>

                {{-- Article information --}}
                <x-admin.panel title="Article Information" icon="nav-article.svg" description="Headline, summary and who wrote it.">
                    <div class="flex flex-col gap-[20px]">
                        <x-admin.field label="Title" name="title" :value="$article->title" placeholder="Enter the article title" :required="true" />
                        <x-admin.field label="Excerpt" name="excerpt" type="textarea" :value="$article->excerpt" placeholder="Short summary shown on listing cards" :required="true" />
                        <x-admin.field label="Subtitle / Summary Hook" name="subtitle" type="textarea" :value="$article->subtitle" placeholder="One-line hook under the headline" />

                        <div class="grid [&>*]:min-w-0 gap-[20px] sm:grid-cols-2">
                            <x-admin.field label="Category" name="category" :value="$article->category" :options="$categories" :required="true" />
                            <x-admin.field label="Author" name="author_name" :value="$article->author_name" placeholder="Penida Gili Team" :required="true" />
                            <x-admin.field label="Author Role" name="author_role" :value="$article->author_role" placeholder="Marine Operations Lead" />
                            <x-admin.field label="Publish Date & Time" name="published_at" type="datetime-local" :value="$article->published_at?->format('Y-m-d\TH:i')" help="Required when scheduling." />
                        </div>

                        <div class="flex flex-col gap-[14px] border-t border-[rgba(192,199,211,0.3)] pt-[20px]">
                            <x-admin.toggle name="is_featured" label="Feature at the top of the blog" description="Shows this article as the featured guide on the article page." :checked="old('is_featured', $article->is_featured)" />
                        </div>
                    </div>
                </x-admin.panel>

                {{-- Image & body --}}
                <x-admin.panel title="Image & Content" icon="form-camera.svg" description="Cover image and the article body.">
                    <div class="flex flex-col gap-[20px]">
                        <div class="flex flex-col gap-[8px]" data-cover-picker>
                            <span class="font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink">Cover Image</span>
                            <label class="flex cursor-pointer flex-col items-center justify-center rounded-admin border-2 border-dashed border-[rgba(192,199,211,0.6)] bg-[#f7fafc] p-[28px]
                                          transition-colors duration-300 hover:border-editorial hover:bg-[#eef4f8]">
                                <input type="file" name="cover" accept="image/jpeg,image/png,image/webp" class="sr-only">
                                <img data-cover-preview alt="" hidden class="mb-[16px] h-[160px] w-full max-w-[360px] rounded-[10px] object-cover">
                                <span class="mb-[12px] flex size-[56px] items-center justify-center rounded-full bg-[#d5e2e9]">
                                    <img src="{{ asset('images/icons/admin/form-upload.svg') }}" alt="" class="size-[20px]">
                                </span>
                                <span class="font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink">Drag &amp; drop or click to upload</span>
                                <span class="font-jakarta text-[14px] leading-[20px] text-editorial-body">JPG, PNG, WEBP (max. 4 MB)</span>
                                <span data-cover-name class="mt-[6px] font-jakarta text-[13px] text-editorial"></span>
                            </label>
                            @error('cover') <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror
                            <x-admin.gallery-preview :cover="$article->image" folder="articles" />
                        </div>

                        <x-admin.field label="Image Caption" name="hero_caption" :value="$article->hero_caption" placeholder="En route to Nusa Penida: Sanjaya Express at 35 knots" />

                        <div class="flex flex-col gap-[8px]" data-body-editor>
                            <div class="flex items-center justify-between">
                                <label for="article-body" class="font-jakarta text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-editorial-ink">Article Body *</label>
                                <span class="rounded-full bg-[#f1f4f6] px-[10px] py-[3px] font-jakarta text-[12px] font-semibold text-editorial-body">Paragraph</span>
                            </div>

                            <div @class([
                                'rounded-[8px] border bg-[#f7fafc]',
                                'border-[#dc2626]' => $errors->has('body'),
                                'border-[rgba(192,199,211,0.5)]' => ! $errors->has('body'),
                            ])>
                                <textarea id="article-body" name="body" rows="14" required placeholder="Start writing your article here…"
                                          class="w-full resize-y bg-transparent px-[17px] py-[13px] font-jakarta text-[16px] leading-[28px] text-editorial-ink placeholder:text-editorial-meta focus:outline-none">{{ old('body', $article->body) }}</textarea>
                                <div data-preview hidden class="flex flex-col gap-[16px] px-[17px] py-[13px] font-jakarta text-[16px] leading-[28px] text-editorial-ink"></div>

                                <div class="flex items-center justify-between border-t border-[rgba(192,199,211,0.3)] px-[17px] py-[10px]">
                                    <span data-word-count class="font-jakarta text-[13px] text-editorial-body">0 kata</span>
                                    <button type="button" data-preview-toggle
                                            class="rounded-[8px] border border-[rgba(192,199,211,0.5)] bg-surface px-[14px] py-[6px] font-jakarta text-[13px] font-semibold text-editorial-ink transition-colors hover:bg-[#f1f4f6]">
                                        Pratinjau
                                    </button>
                                </div>
                            </div>
                            <span class="font-jakarta text-[13px] leading-[18px] text-editorial-body">Separate paragraphs with a blank line.</span>
                            @error('body') <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </x-admin.panel>

                {{-- Actions --}}
                <div class="flex flex-wrap items-center gap-[12px]">
                    <button type="submit"
                            class="flex items-center gap-[8px] rounded-[8px] bg-editorial px-[22px] py-[12px] font-jakarta text-[14px] font-semibold text-white
                                   transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                        <img src="{{ asset('images/icons/admin/form-save.svg') }}" alt="" class="size-[16px]">
                        {{ $editing ? 'Save Changes' : 'Add Article' }}
                    </button>
                    <a href="{{ $backHref }}"
                       class="rounded-[8px] border border-[rgba(192,199,211,0.5)] bg-surface px-[22px] py-[12px] font-jakarta text-[14px] font-semibold text-editorial-ink transition-colors hover:bg-[#f1f4f6]">
                        Cancel
                    </a>
                </div>
            </div>

            <aside class="flex flex-col gap-[24px]">
                <x-admin.panel title="Publishing" icon="nav-schedule.svg">
                    <x-admin.radio-cards name="status" :options="$publishModes" :selected="$article->status?->value" />
                </x-admin.panel>

                <x-admin.panel title="Permalink & Tags" icon="form-vessel.svg">
                    <div class="flex flex-col gap-[16px]">
                        <x-admin.field label="URL Slug" name="slug" :value="$article->slug" prefix="/artikel/" help="Leave blank to generate from the title." />
                        <x-admin.field label="Read Time (minutes)" name="read_time_minutes" type="number" :value="$article->read_time_minutes" help="Estimated from the body when blank." />
                        <x-admin.field label="Tags" name="tags" :value="implode(' ', $article->tags ?? [])" placeholder="#NusaPenida #FastBoatBali" help="Space or comma separated." />
                    </div>
                </x-admin.panel>
            </aside>
        </form>
    </x-admin.form-page>
@endsection
