@props(['name', 'image', 'href' => '#'])

<a href="{{ $href }}" class="group relative block aspect-[4/5] overflow-hidden rounded-2xl bg-primary-100 dark:bg-primary-800">
    <img
        src="{{ $image }}"
        alt="{{ $name }}"
        loading="lazy"
        class="h-full w-full object-cover transition-transform duration-700 ease-out group-hover:scale-110"
    >
    <div class="absolute inset-0 bg-gradient-to-t from-primary-900/70 via-primary-900/10 to-transparent"></div>
    <div class="absolute inset-x-0 bottom-0 p-5">
        <h3 class="text-lg font-semibold text-white">{{ $name }}</h3>
        <span class="mt-1 inline-flex items-center gap-1 text-xs font-medium text-white/80 transition-transform duration-300 group-hover:translate-x-1">
            Shop now
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
            </svg>
        </span>
    </div>
</a>
