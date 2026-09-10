{{-- Figma node 1:5284 — fixed bottom tab bar, mobile only. --}}
@php
    $tabs = [
        'home'     => ['label' => 'Home',    'icon' => 'home.svg',     'route' => route('home')],
        'boat'     => ['label' => 'Boat',    'icon' => 'boat.svg',     'route' => route('boats.index')],
        'activity' => ['label' => 'Activity','icon' => 'activity.svg', 'route' => route('activities.index')],
        'hotel'    => ['label' => 'Hotels',  'icon' => 'hotels.svg',   'route' => route('hotels.index')],
        'artikel'  => ['label' => 'Article', 'icon' => 'article.svg',  'route' => route('articles.index')],
    ];

    // The page's own nav highlight drives the tab bar too, so the two never disagree.
    $current = trim($__env->yieldContent('nav-active')) ?: null;
@endphp

<nav class="fixed inset-x-0 bottom-0 z-50 border-t border-[#e5e7eb] bg-surface lg:hidden" aria-label="Primary">
    <ul class="flex h-[64px] items-center justify-around">
        @foreach ($tabs as $key => $tab)
            <li>
                <a href="{{ $tab['route'] }}"
                   @class(['flex flex-col items-center gap-[4px]'])
                   @if ($current === $key) aria-current="page" @endif>
                    <img src="{{ asset('images/icons/tabbar/'.$tab['icon']) }}" alt=""
                         @class([
                             'size-[20px] object-contain transition-opacity duration-300',
                             'opacity-100' => $current === $key,
                             'opacity-60' => $current !== $key,
                         ])>
                    <span @class([
                        'text-[10px] font-semibold uppercase leading-[15px] tracking-[0.5px]',
                        'text-brand' => $current === $key,
                        'text-[#64748b]' => $current !== $key,
                    ])>{{ $tab['label'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</nav>
