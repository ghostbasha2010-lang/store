@props([
    'name',
    'image',
    'category' => null,
    'regularPrice',
    'salePrice' => null,
    'rating' => 0,
    'ratingCount' => 0,
    'href' => '#',
    'badge' => null,
])

<div class="card-surface group relative overflow-hidden">
    <a href="{{ $href }}" class="block">
        <div class="relative aspect-[3/4] overflow-hidden rounded-t-2xl bg-primary-100 dark:bg-primary-800">
            <img
                src="{{ $image }}"
                alt="{{ $name }}"
                loading="lazy"
                class="h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-105"
            >

            @if ($badge)
                <span class="absolute left-3 top-3 rounded-full bg-primary-900 px-3 py-1 text-xs font-semibold text-white dark:bg-accent-600">
                    {{ $badge }}
                </span>
            @endif

            <button
                type="button"
                aria-label="Add to wishlist"
                onclick="event.preventDefault()"
                class="absolute right-3 top-3 flex h-9 w-9 items-center justify-center rounded-full bg-white/90 text-primary-700 opacity-0 shadow-sm transition-all duration-300 hover:text-red-500 group-hover:opacity-100 dark:bg-primary-900/90 dark:text-primary-200"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                </svg>
            </button>

            <div class="absolute inset-x-3 bottom-3 translate-y-4 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                <span class="block w-full rounded-full bg-primary-900/90 py-2.5 text-center text-xs font-semibold text-white backdrop-blur-sm dark:bg-white/90 dark:text-primary-900">
                    Quick Add
                </span>
            </div>
        </div>

        <div class="p-4">
            @if ($category)
                <p class="text-xs font-medium uppercase tracking-wide text-primary-400 dark:text-primary-400">{{ $category }}</p>
            @endif
            <h3 class="mt-1 truncate text-sm font-medium text-primary-900 dark:text-white">{{ $name }}</h3>

            <div class="mt-2">
                <x-star-rating :rating="$rating" :count="$ratingCount" size="xs" />
            </div>

            <div class="mt-2">
                <x-price-display :regular-price="$regularPrice" :sale-price="$salePrice" size="sm" />
            </div>
        </div>
    </a>
</div>
