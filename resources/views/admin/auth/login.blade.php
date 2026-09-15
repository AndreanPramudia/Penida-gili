{{-- Console sign-in. Mirrors the Figma editorial palette used by the admin frames. --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in — Penida Gili Console</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-admin-canvas font-jakarta">
    <main class="flex min-h-screen items-center justify-center p-[24px]">
        <div class="w-full max-w-[440px] rounded-[24px] border border-[rgba(192,199,211,0.3)] bg-surface p-[40px] shadow-admin">
            <a href="{{ route('home') }}" class="flex items-center justify-center gap-[6px]">
                <img src="{{ asset('images/logo/logo-mark-dark.svg') }}" alt="" class="h-[36px] w-[70px]">
                <img src="{{ asset('images/logo/logo-word-dark.svg') }}" alt="Penida Gili" class="h-[34px] w-[150px]">
            </a>

            <h1 class="mt-[32px] text-[28px] font-bold tracking-[-0.5px] text-admin-ink">Sign in to the console</h1>
            <p class="mt-[6px] text-[15px] text-admin-muted">Manage vessels, schedules, hotels, activities and bookings.</p>

            <form action="{{ route('admin.login') }}" method="post" class="mt-[28px] flex flex-col gap-[18px]">
                @csrf

                <x-admin.field label="Email" name="email" type="email" placeholder="admin@penidagili.com" :required="true" />
                <x-admin.field label="Password" name="password" type="password" placeholder="••••••••" :required="true" />

                <label class="flex items-center gap-[10px] text-[14px] text-editorial-body">
                    <input type="checkbox" name="remember" value="1" class="size-[16px] rounded-[4px] accent-[#005ea1]" @checked(old('remember'))>
                    Keep me signed in
                </label>

                <button type="submit"
                        class="mt-[6px] w-full rounded-[10px] bg-editorial py-[14px] text-[16px] font-semibold text-white transition-transform duration-300 ease-smooth hover:-translate-y-0.5">
                    Sign in
                </button>
            </form>
        </div>
    </main>
</body>
</html>
