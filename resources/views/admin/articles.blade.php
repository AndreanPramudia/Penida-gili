{{-- Figma node 1:9637 — admin Article --}}
@extends('layouts.admin')

@section('title', 'Article')

@section('admin-active', 'article')

@section('content')
    <x-admin.listing
        heading="Article"
        subtitle="Travel guides, boat tips and island stories published on the blog."
        action="Add New Article"
        :action-href="route('admin.articles.create')"
        :columns="['Article', 'Category', 'Author', 'Views', 'Date', 'Status', 'Actions']"
        :paginator="$articles">

        <x-slot:filters>
            <x-admin.filters :action="route('admin.articles')" :filters="$filters"
                             :statuses="collect(\App\Enums\ArticleStatus::cases())->mapWithKeys(fn ($s) => [$s->value => $s->label()])->all()"
                             placeholder="Search articles..." />
        </x-slot:filters>

        @forelse ($articles as $article)
            <tr class="border-b border-[rgba(192,199,211,0.2)] last:border-b-0">
                <td class="px-[16px] py-[16px]">
                    <span class="flex items-center gap-[12px]">
                        <img src="{{ $article->image_url }}" alt="" class="h-[42px] w-[56px] shrink-0 rounded-[8px] object-cover">
                        <span class="min-w-0">
                            <span class="block truncate text-[15px] font-semibold leading-[22px] text-editorial-ink">{{ $article->title }}</span>
                            <span class="block text-[13px] leading-[18px] text-editorial-meta">{{ \Illuminate\Support\Str::limit($article->excerpt, 60) }} • {{ $article->read_time_label }}</span>
                        </span>
                    </span>
                </td>
                <td class="px-[16px] py-[16px]">
                    <span class="rounded-full bg-[#d2e4ff] px-[10px] py-[4px] text-[13px] text-[#001d37]">{{ $article->category }}</span>
                </td>
                <td class="px-[16px] py-[16px]">
                    <span class="flex items-center gap-[10px]">
                        <span class="flex size-[28px] shrink-0 items-center justify-center rounded-full bg-[#d5e2e9] text-[11px] font-semibold text-editorial">{{ $article->author_initials }}</span>
                        <span>
                            <span class="block text-[14px] font-semibold leading-[20px] text-editorial-ink">{{ $article->author_name }}</span>
                            <span class="block text-[12px] leading-[16px] text-editorial-meta">{{ $article->author_role }}</span>
                        </span>
                    </span>
                </td>
                <td class="px-[16px] py-[16px] text-[14px] font-semibold leading-[20px] text-editorial-ink">{{ number_format($article->views) }}</td>
                <td class="px-[16px] py-[16px] text-[14px] leading-[20px] text-editorial-body">{{ $article->published_at?->format('d M Y') ?? '—' }}</td>
                <td class="px-[16px] py-[16px]"><x-admin.status :label="$article->status->label()" :tone="$article->status->tone()" /></td>
                <td class="px-[16px] py-[16px]">
                    <x-admin.row-actions :label="$article->title" :edit-href="route('admin.articles.edit', $article)" :delete-action="route('admin.articles.destroy', $article)" />
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="px-[16px] py-[32px] text-center text-[15px] text-editorial-body">No articles match this filter.</td></tr>
        @endforelse
    </x-admin.listing>
@endsection
