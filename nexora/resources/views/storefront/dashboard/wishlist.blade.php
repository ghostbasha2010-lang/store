<x-layouts.dashboard active="wishlist" title="Wishlist">

    <h1 class="text-2xl font-semibold tracking-tight text-primary-900 dark:text-white">My Wishlist</h1>
    <p class="mt-1 text-sm text-primary-500 dark:text-primary-400">{{ count($items) }} saved items.</p>

    @if (count($items) > 0)
        <div class="mt-6 grid grid-cols-2 gap-5 sm:grid-cols-3">
            @foreach ($items as $item)
                <div class="card-surface group relative overflow-hidden">
                    <div class="relative aspect-[3/4] overflow-hidden rounded-t-2xl bg-primary-100 dark:bg-primary-800">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" loading="lazy" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <form method="POST" action="{{ route('wishlist.destroy', $item['id']) }}" class="absolute right-3 top-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" aria-label="Remove from wishlist" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/90 text-red-500 shadow-sm dark:bg-primary-900/90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="currentColor" viewBox="0 0 24 24"><path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" /></svg>
                            </button>
                        </form>
                    </div>
                    <div class="p-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-primary-400">{{ $item['category'] }}</p>
                        <h3 class="mt-1 truncate text-sm font-medium text-primary-900 dark:text-white">{{ $item['name'] }}</h3>
                        <div class="mt-2"><x-price-display :regular-price="$item['regularPrice']" :sale-price="$item['salePrice']" size="sm" /></div>
                        <a href="{{ route('products.show', $item['slug']) }}" class="btn-primary mt-3 block w-full py-2! text-center text-xs">Select Options</a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="mt-16 flex flex-col items-center justify-center text-center">
            <div class="flex h-20 w-20 items-center justify-center rounded-full bg-primary-100 text-primary-400 dark:bg-primary-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" /></svg>
            </div>
            <h2 class="mt-6 text-xl font-semibold text-primary-900 dark:text-white">Your wishlist is empty</h2>
            <p class="mt-2 text-sm text-primary-500 dark:text-primary-400">Save items you love for later.</p>
            <a href="{{ route('products.index') }}" class="btn-primary mt-6">Browse Products</a>
        </div>
    @endif

</x-layouts.dashboard>
