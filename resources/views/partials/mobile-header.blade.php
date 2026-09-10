{{-- Figma mobile frames (1:5281 etc.) — centred logo bar that replaces the desktop nav below lg. --}}
<header class="sticky top-0 z-40 border-b border-editorial-rule bg-surface py-[14px] lg:hidden">
    <a href="{{ route('home') }}" class="flex items-center justify-center gap-2">
        <img src="{{ asset('images/logo/logo-mark-dark.svg') }}" alt="" class="h-[30px] w-[55px]">
        <img src="{{ asset('images/logo/logo-word-dark.svg') }}" alt="Penida Gili" class="h-[30px] w-[137px]">
    </a>
</header>
