@php
    $navLinks = [
        ['label' => 'Men', 'href' => route('products.index')],
        ['label' => 'Women', 'href' => route('products.index')],
        ['label' => 'Kids', 'href' => route('products.index')],
        ['label' => 'Shoes', 'href' => route('products.index')],
        ['label' => 'Accessories', 'href' => route('products.index')],
    ];

    $cartCount = \App\Models\Cart::where('session_id', session()->getId())->first()?->items()->sum('quantity') ?? 0;
@endphp

<div x-data="{ mobileOpen: false, dark: document.documentElement.classList.contains('dark') }" x-init="$watch('dark', v => { document.documentElement.classList.toggle('dark', v); localStorage.setItem('nexora-theme', v ? 'dark' : 'light'); })">

    <!-- Announcement bar -->
    <div class="bg-primary-900 text-white dark:bg-black">
        <p class="container-nexora py-2 text-center text-xs font-medium tracking-wide">
            Free shipping on orders over $100 &middot; New arrivals dropping weekly
        </p>
    </div>

    <header class="sticky top-0 z-40 border-b border-primary-900/5 bg-white/80 backdrop-blur-md dark:border-white/10 dark:bg-surface-dark/80">
        <div class="container-nexora flex h-18 items-center justify-between gap-4 py-3">

            <!-- Mobile menu button -->
            <button @click="mobileOpen = true" class="-ml-2 inline-flex items-center justify-center rounded-lg p-2 text-primary-700 hover:bg-primary-900/5 lg:hidden dark:text-primary-200 dark:hover:bg-white/10" aria-label="Open menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                </svg>
            </button>

            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex shrink-0 items-center gap-2">
                <span class="text-2xl font-extrabold tracking-tight text-primary-900 dark:text-white">NEXORA</span>
            </a>

            <!-- Desktop nav -->
            <nav class="hidden items-center gap-8 lg:flex">
                @foreach ($navLinks as $link)
                    <a href="{{ $link['href'] }}" class="text-sm font-medium text-primary-700 transition-colors hover:text-accent-600 dark:text-primary-200 dark:hover:text-accent-400">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            <!-- Right icons -->
            <div class="flex items-center gap-1 sm:gap-2">

                <button class="hidden rounded-full p-2.5 text-primary-700 transition-colors hover:bg-primary-900/5 hover:text-accent-600 sm:inline-flex dark:text-primary-200 dark:hover:bg-white/10" aria-label="Search">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M18 10.5a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />
                    </svg>
                </button>

                <!-- Dark mode toggle -->
                <button @click="dark = !dark" class="rounded-full p-2.5 text-primary-700 transition-colors hover:bg-primary-900/5 hover:text-accent-600 dark:text-primary-200 dark:hover:bg-white/10" aria-label="Toggle dark mode">
                    <svg x-show="!dark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1.5m0 15V21m9-9h-1.5M4.5 12H3m15.364-6.364-1.06 1.06M6.697 17.303l-1.06 1.06m12.727 0-1.06-1.06M6.697 6.697l-1.06-1.06M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" />
                    </svg>
                    <svg x-cloak x-show="dark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                    </svg>
                </button>

                <!-- Wishlist -->
                <a href="{{ route('dashboard.wishlist') }}" class="hidden rounded-full p-2.5 text-primary-700 transition-colors hover:bg-primary-900/5 hover:text-accent-600 sm:inline-flex dark:text-primary-200 dark:hover:bg-white/10" aria-label="Wishlist">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </a>

                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="relative rounded-full p-2.5 text-primary-700 transition-colors hover:bg-primary-900/5 hover:text-accent-600 dark:text-primary-200 dark:hover:bg-white/10" aria-label="Cart">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.98-4.716 2.53-7.223.155-.71-.386-1.362-1.113-1.362H5.106M7.5 14.25 5.106 5.25M7.5 14.25 5.106 5.25m0 0-.383-1.437M6 18.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                    @if ($cartCount > 0)
                        <span class="absolute -right-0.5 -top-0.5 flex h-4.5 w-4.5 items-center justify-center rounded-full bg-accent-600 text-[10px] font-semibold text-white">{{ $cartCount }}</span>
                    @endif
                </a>

                <!-- Account -->
                <a href="{{ Auth::check() ? route('dashboard') : route('login') }}" class="ml-1 hidden rounded-full p-2.5 text-primary-700 transition-colors hover:bg-primary-900/5 hover:text-accent-600 sm:inline-flex dark:text-primary-200 dark:hover:bg-white/10" aria-label="Account">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <!-- Mobile drawer -->
    <div x-cloak x-show="mobileOpen" class="fixed inset-0 z-50 lg:hidden" role="dialog" aria-modal="true">
        <div x-show="mobileOpen" x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="mobileOpen = false" class="fixed inset-0 bg-primary-900/40 backdrop-blur-sm"></div>

        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="fixed inset-y-0 left-0 w-full max-w-xs bg-white p-6 shadow-2xl dark:bg-primary-900">
            <div class="flex items-center justify-between">
                <span class="text-xl font-extrabold tracking-tight text-primary-900 dark:text-white">NEXORA</span>
                <button @click="mobileOpen = false" class="rounded-lg p-2 text-primary-700 hover:bg-primary-900/5 dark:text-primary-200 dark:hover:bg-white/10" aria-label="Close menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="mt-8 flex flex-col gap-1">
                @foreach ($navLinks as $link)
                    <a href="{{ $link['href'] }}" class="rounded-lg px-3 py-3 text-base font-medium text-primary-800 hover:bg-primary-900/5 dark:text-primary-100 dark:hover:bg-white/10">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="mt-8 flex flex-col gap-3 border-t border-primary-900/10 pt-6 dark:border-white/10">
                <a href="{{ Auth::check() ? route('dashboard') : route('login') }}" class="btn-outline w-full">My Account</a>
                <a href="{{ Auth::check() ? route('dashboard.wishlist') : route('login') }}" class="btn-primary w-full">Wishlist</a>
            </div>
        </div>
    </div>
</div>
