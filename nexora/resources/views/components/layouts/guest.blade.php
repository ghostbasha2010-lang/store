<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'NEXORA' }}</title>

    <script>
        (function () {
            const stored = localStorage.getItem('nexora-theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (stored === 'dark' || (!stored && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface text-primary-900 antialiased dark:bg-surface-dark dark:text-primary-50">

    <div class="grid min-h-screen lg:grid-cols-2">

        {{-- Form side --}}
        <div class="flex flex-col justify-center px-6 py-12 sm:px-12 lg:px-20">
            <a href="{{ route('home') }}" class="text-2xl font-extrabold tracking-tight text-primary-900 dark:text-white">NEXORA</a>

            <div class="mt-12 w-full max-w-sm">
                {{ $slot }}
            </div>
        </div>

        {{-- Image side --}}
        <div class="relative hidden lg:block">
            <img
                src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?q=80&w=1400&auto=format&fit=crop"
                alt="NEXORA"
                class="h-full w-full object-cover"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-primary-900/80 via-primary-900/10 to-transparent"></div>
            <div class="absolute inset-x-0 bottom-0 p-12">
                <p class="max-w-sm text-xl font-medium leading-relaxed text-white">
                    &ldquo;Modern essentials, made to move with you.&rdquo;
                </p>
                <p class="mt-3 text-sm text-white/70">The NEXORA Fall/Winter Collection</p>
            </div>
        </div>
    </div>

</body>
</html>
