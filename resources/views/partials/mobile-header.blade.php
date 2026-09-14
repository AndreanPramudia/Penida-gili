{{-- Figma node 1:2692 — Navigation: centred logo bar that replaces the desktop nav below lg. --}}
<header class="sticky top-0 z-40 bg-surface px-[16px] py-[19px] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)] lg:hidden">
    <a href="{{ route('home') }}" class="flex items-center justify-center gap-[4px]">
        <img src="{{ asset('images/logo/logo-mark-dark.svg') }}" alt="" class="h-[24px] w-[50px]">
        <img src="{{ asset('images/logo/logo-word-dark.svg') }}" alt="Penida Gili" class="h-[23px] w-[107px]">
    </a>
</header>
