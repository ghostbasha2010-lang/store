@props(['active' => 'overview', 'title' => 'My Account'])

@php
    $navItems = [
        'overview' => ['label' => 'Overview', 'href' => route('dashboard'), 'icon' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75'],
        'orders' => ['label' => 'Order History', 'href' => route('dashboard.orders'), 'icon' => 'M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z'],
        'addresses' => ['label' => 'Addresses', 'href' => route('dashboard.addresses'), 'icon' => 'M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 0c0 7.5-9 13.5-9 13.5S3 18 3 10.5a9 9 0 1 1 18 0Z'],
        'wishlist' => ['label' => 'Wishlist', 'href' => route('dashboard.wishlist'), 'icon' => 'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z'],
        'profile' => ['label' => 'Profile Settings', 'href' => '#', 'icon' => 'M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z'],
    ];
@endphp

<x-layouts.app :title="$title.' — NEXORA'">

    <div class="container-nexora py-10">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-[260px_1fr]">

            {{-- Sidebar --}}
            <aside>
                <div class="card-surface p-4">
                    <div class="flex items-center gap-3 border-b border-primary-900/10 px-2 pb-4 dark:border-white/10">
                        <div class="flex h-11 w-11 items-center justify-center rounded-full bg-accent-600/10 text-sm font-semibold text-accent-600">
                            {{ collect(explode(' ', Auth::user()->name))->map(fn ($part) => strtoupper($part[0]))->take(2)->implode('') }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-primary-900 dark:text-white">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-primary-400">{{ Auth::user()->email }}</p>
                        </div>
                    </div>

                    <nav class="mt-3 space-y-1">
                        @foreach ($navItems as $key => $item)
                            <a href="{{ $item['href'] }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ $active === $key ? 'bg-primary-900 text-white dark:bg-white dark:text-primary-900' : 'text-primary-600 hover:bg-primary-900/5 dark:text-primary-300 dark:hover:bg-white/10' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" /></svg>
                                {{ $item['label'] }}
                            </a>
                        @endforeach

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-red-500 transition-colors hover:bg-red-50 dark:hover:bg-red-500/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3H15" /></svg>
                                Sign Out
                            </button>
                        </form>
                    </nav>
                </div>
            </aside>

            {{-- Content --}}
            <div>
                {{ $slot }}
            </div>
        </div>
    </div>

</x-layouts.app>
