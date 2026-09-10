{{-- Figma node 1:9637 — admin Articles --}}
@extends('layouts.admin')

@section('title', 'Articles')

@section('admin-active', 'article')

@section('content')
    <x-admin.listing
        heading="Articles"
        subtitle="Manage fastboat partner accommodations, island room inventories, and direct ticket packages."
        action="Add New Articles"
        :action-href="route('admin.articles.create')"
        :columns="['Article Details', 'Category', 'Author & Role', 'Views', 'Published Date', 'Status', 'Quick Actions']"
        summary="Showing 1 to 3 of 12 schedules">

        <x-slot:toolbar>
            <div class="flex flex-wrap items-center gap-[12px]">
                <label class="relative block flex-1 min-w-[280px]">
                    <span class="sr-only">Search articles</span>
                    <input type="search" placeholder="Search by title, keyword, or author..."
                           class="w-full rounded-[8px] border border-[#c0c7d3] bg-surface py-[10px] pl-[41px] pr-[17px] text-[16px] text-editorial-ink placeholder:text-editorial-meta focus:outline-2 focus:outline-editorial">
                    <img src="{{ asset('images/icons/admin/table-search.svg') }}" alt=""
                         class="pointer-events-none absolute left-[12px] top-1/2 size-[18px] -translate-y-1/2">
                </label>

                @foreach (['All Authors', 'All Categories', 'All Statuses'] as $filter)
                    <label class="relative block">
                        <span class="sr-only">{{ $filter }}</span>
                        <select class="appearance-none rounded-[8px] border border-[#c0c7d3] bg-surface py-[9px] pl-[17px] pr-[44px] text-[16px] leading-[24px] text-editorial-ink focus:outline-2 focus:outline-editorial">
                            <option>{{ $filter }}</option>
                        </select>
                        <img src="{{ asset('images/icons/admin/chevron-down.svg') }}" alt=""
                             class="pointer-events-none absolute right-[12px] top-1/2 size-[20px] -translate-y-1/2">
                    </label>
                @endforeach
            </div>

            {{-- Figma 1:9637 "Active Filters" chips --}}
            <div class="mt-[16px] flex flex-wrap items-center gap-[10px] text-[13px]">
                <span class="text-editorial-body">Active Filters:</span>
                @foreach (['Category: All', 'Status: Published & Active'] as $chip)
                    <span class="flex items-center gap-[6px] rounded-[6px] bg-[#e0eaf5] px-[10px] py-[4px] text-editorial-ink">
                        {{ $chip }}
                        <button type="button" aria-label="Remove filter {{ $chip }}" class="text-editorial-body transition-colors hover:text-editorial-ink">&times;</button>
                    </span>
                @endforeach
                <button type="button" class="text-editorial transition-colors hover:underline">Clear all</button>
            </div>
        </x-slot:toolbar>

        @foreach ($articles as $article)
            <tr class="border-b border-[rgba(192,199,211,0.2)] last:border-b-0">
                <td class="px-[16px] py-[16px]">
                    <span class="flex items-center gap-[12px]">
                        <img src="{{ asset('images/'.$article['image']) }}" alt="" class="h-[42px] w-[56px] shrink-0 rounded-[8px] object-cover">
                        <span>
                            <span class="block text-[15px] font-semibold leading-[22px] text-editorial-ink">{{ $article['title'] }}</span>
                            <span class="block text-[13px] leading-[18px] text-editorial-meta">{{ $article['excerpt'] }}</span>
                        </span>
                    </span>
                </td>
                <td class="px-[16px] py-[16px]">
                    <span class="rounded-full bg-[#d2e4ff] px-[10px] py-[4px] text-[13px] text-[#001d37]">{{ $article['category'] }}</span>
                </td>
                <td class="px-[16px] py-[16px]">
                    <span class="flex items-center gap-[10px]">
                        <span class="flex size-[28px] shrink-0 items-center justify-center rounded-full bg-[#d5e2e9] text-[11px] font-semibold text-editorial">{{ $article['initials'] }}</span>
                        <span>
                            <span class="block text-[14px] font-semibold leading-[20px] text-editorial-ink">{{ $article['author'] }}</span>
                            <span class="block text-[12px] leading-[16px] text-editorial-meta">{{ $article['role'] }}</span>
                        </span>
                    </span>
                </td>
                <td class="px-[16px] py-[16px] text-[14px] font-semibold leading-[20px] text-editorial-ink">{{ $article['views'] }}</td>
                <td class="px-[16px] py-[16px] text-[14px] leading-[20px] text-editorial-body">{{ $article['date'] }}</td>
                <td class="px-[16px] py-[16px]"><x-admin.status :label="$article['status']" :tone="$article['tone']" /></td>
                <td class="px-[16px] py-[16px]"><x-admin.row-actions :label="$article['title']" /></td>
            </tr>
        @endforeach
    </x-admin.listing>
@endsection
