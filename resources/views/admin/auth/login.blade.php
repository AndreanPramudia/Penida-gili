{{-- Admin portal sign-in: brand panel on the left, credentials card on the right. --}}
<!DOCTYPE html>
{{-- data-no-zoom: this page is authored at real browser size, not the 1920px marketing grid. --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-no-zoom class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Portal Sign In — Penida Gili</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full min-h-screen bg-gradient-to-br from-[#eef4f9] via-white to-[#e7eff7] font-jakarta">
    <main class="grid h-full min-h-screen lg:grid-cols-[minmax(0,588fr)_minmax(0,412fr)]">
        {{-- Brand panel --}}
        <section class="relative hidden overflow-hidden lg:block">
            {{-- Swap this file to change the panel photo; it is cropped to fill whatever shape the column takes. --}}
            <img src="{{ asset('images/admin/login-hero.png') }}" alt="" class="absolute inset-0 size-full object-cover object-center">
            <div class="absolute inset-0 bg-gradient-to-b from-[rgba(9,58,97,0.45)] via-[rgba(7,49,84,0.6)] to-[rgba(4,30,54,0.88)]"></div>

            <div class="relative flex h-full items-center p-[48px] text-white">
                {{-- The logo floats in the corner so the copy centres against the whole panel. --}}
                <a href="{{ route('home') }}" class="absolute left-[48px] top-[48px] flex items-center gap-[8px]">
                    <img src="{{ asset('images/logo/logo-mark-light.svg') }}" alt="" class="h-[34px] w-[62px]">
                    <img src="{{ asset('images/logo/logo-word-light.svg') }}" alt="Penida Gili" class="h-[30px] w-[132px]">
                </a>

                <div class="max-w-[520px]">
                    <span class="inline-flex items-center gap-[8px] rounded-full border border-white/25 bg-white/15 px-[14px] py-[6px] text-[13px] font-semibold leading-[20px] backdrop-blur-[4px]">
                        <img src="{{ asset('images/icons/admin/anchor.svg') }}" alt="" class="size-[14px] brightness-0 invert">
                        Harbor Fleet Grid v4.2.8
                    </span>

                    <h1 class="mt-[20px] text-[42px] font-bold leading-[52px] tracking-[-0.5px]">
                        Secure Dispatch &amp; Island Transit Operations
                    </h1>

                    <p class="mt-[16px] text-[16px] leading-[26px] text-white/80">
                        Real-time coordination for Bali, Nusa Penida, Lembongan, and Gili archipelago lines.
                        High-speed vessel telemetry, manifest validation, and weather clearance protocols.
                    </p>
                </div>
            </div>
        </section>

        {{-- Credentials --}}
        <section class="flex items-center justify-center p-[24px] lg:p-[48px]">
            <div class="w-full max-w-[400px] rounded-[16px] border border-[rgba(192,199,211,0.35)] bg-white p-[32px] shadow-[0px_18px_40px_-16px_rgba(0,45,80,0.25)]">
                <a href="{{ route('home') }}" class="mb-[24px] flex items-center gap-[6px] lg:hidden">
                    <img src="{{ asset('images/logo/logo-mark-dark.svg') }}" alt="" class="h-[30px] w-[58px]">
                    <img src="{{ asset('images/logo/logo-word-dark.svg') }}" alt="Penida Gili" class="h-[26px] w-[120px]">
                </a>

                <h2 class="text-[22px] font-bold leading-[30px] text-[#181c1e]">Admin Portal Sign In</h2>
                <p class="mt-[6px] text-[14px] leading-[21px] text-[#717782]">
                    Enter your maritime credentials to access dispatch, bookings, and fleet control.
                </p>

                <form action="{{ route('admin.login') }}" method="post" class="mt-[24px] flex flex-col gap-[16px]">
                    @csrf

                    <label class="flex flex-col gap-[8px]">
                        <span class="text-[13px] font-semibold leading-[18px] text-[#181c1e]">Work Email / Officer ID</span>
                        <span class="relative block">
                            <img src="{{ asset('images/icons/admin/anchor.svg') }}" alt=""
                                 class="pointer-events-none absolute left-[13px] top-1/2 size-[15px] -translate-y-1/2 opacity-60">
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                   placeholder="Username"
                                   @class([
                                       'w-full rounded-[8px] border bg-[#f7fafc] py-[11px] pl-[38px] pr-[14px] text-[14px] leading-[22px] text-[#181c1e] placeholder:text-[#9aa3ad] focus:border-editorial focus:bg-white focus:outline-none',
                                       'border-[#dc2626]' => $errors->has('email'),
                                       'border-[rgba(192,199,211,0.7)]' => ! $errors->has('email'),
                                   ])>
                        </span>
                    </label>

                    <label class="flex flex-col gap-[8px]">
                        <span class="text-[13px] font-semibold leading-[18px] text-[#181c1e]">Password</span>
                        {{-- data-password-field: the eye button toggles the input type (resources/js/admin-login.js). --}}
                        <span class="relative block" data-password-field>
                            <img src="{{ asset('images/icons/admin/anchor.svg') }}" alt=""
                                 class="pointer-events-none absolute left-[13px] top-1/2 size-[15px] -translate-y-1/2 opacity-60">
                            <input type="password" name="password" required autocomplete="current-password" placeholder="Password"
                                   @class([
                                       'w-full rounded-[8px] border bg-[#f7fafc] py-[11px] pl-[38px] pr-[42px] text-[14px] leading-[22px] text-[#181c1e] placeholder:text-[#9aa3ad] focus:border-editorial focus:bg-white focus:outline-none',
                                       'border-[#dc2626]' => $errors->has('email'),
                                       'border-[rgba(192,199,211,0.7)]' => ! $errors->has('email'),
                                   ])>
                            <button type="button" data-password-toggle aria-label="Show password"
                                    class="absolute right-[10px] top-1/2 flex size-[26px] -translate-y-1/2 items-center justify-center rounded-[6px] text-[#717782] transition-colors hover:bg-[#f1f4f6]">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="size-[17px]" aria-hidden="true">
                                    <path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12Z" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="12" cy="12" r="3.2"/>
                                </svg>
                            </button>
                        </span>
                    </label>

                    @error('email')
                        <p role="alert" class="rounded-[8px] bg-[#fef2f2] px-[12px] py-[9px] text-[13px] leading-[19px] text-[#b91c1c]">{{ $message }}</p>
                    @enderror

                    <label class="flex items-start gap-[9px] text-[13px] leading-[19px] text-[#414751]">
                        <input type="checkbox" name="remember" value="1" @checked(old('remember'))
                               class="mt-[2px] size-[15px] shrink-0 rounded-[3px] accent-[#005ea1]">
                        Keep me signed in on this dispatch terminal
                    </label>

                    <button type="submit"
                            class="mt-[4px] flex w-full items-center justify-center gap-[8px] rounded-[8px] bg-editorial py-[12px] text-[15px] font-semibold leading-[22px] text-white
                                   transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                        Sign In
                        <span aria-hidden="true">&rarr;</span>
                    </button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
