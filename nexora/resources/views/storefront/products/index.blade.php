<x-layouts.app title="Shop All Products — NEXORA">

    <div x-data="{ filtersOpen: false }">

        {{-- Page header --}}
        <div class="border-b border-primary-900/5 bg-white dark:border-white/10 dark:bg-primary-900/10">
            <div class="container-nexora py-10">
                <nav class="text-xs text-primary-400 dark:text-primary-400">
                    <a href="{{ route('home') }}" class="hover:text-accent-600">Home</a>
                    <span class="mx-1.5">/</span>
                    <span class="text-primary-700 dark:text-primary-200">All Products</span>
                </nav>
                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary-900 sm:text-4xl dark:text-white">All Products</h1>
                <p class="mt-2 text-sm text-primary-500 dark:text-primary-400">{{ $products->total() }} products found</p>
            </div>
        </div>

        <form method="GET" action="{{ route('products.index') }}" class="container-nexora grid grid-cols-1 gap-10 py-10 lg:grid-cols-[260px_1fr]">

            {{-- Filters sidebar (desktop) --}}
            <aside class="hidden lg:block">
                <x-storefront.product-filters />
            </aside>

            {{-- Mobile filter drawer --}}
            <div x-cloak x-show="filtersOpen" class="fixed inset-0 z-50 lg:hidden">
                <div @click="filtersOpen = false" class="fixed inset-0 bg-primary-900/40 backdrop-blur-sm"></div>
                <div class="fixed inset-y-0 left-0 w-full max-w-xs overflow-y-auto bg-white p-6 dark:bg-primary-900">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-primary-900 dark:text-white">Filters</h2>
                        <button type="button" @click="filtersOpen = false" class="rounded-lg p-2 text-primary-700 hover:bg-primary-900/5 dark:text-primary-200 dark:hover:bg-white/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    <div class="mt-6">
                        <x-storefront.product-filters />
                    </div>
                </div>
            </div>

            {{-- Product grid --}}
            <div>
                <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                    <button type="button" @click="filtersOpen = true" class="btn-outline inline-flex items-center gap-2 lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m9 12h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0M3.75 18H13.5m-9.75-6h9.75m9-6h-9m9-6H10.5" /></svg>
                        Filters
                    </button>

                    <div class="ml-auto flex items-center gap-2 text-sm">
                        <label for="sort" class="text-primary-500 dark:text-primary-400">Sort by</label>
                        <select id="sort" name="sort" onchange="this.form.submit()" class="rounded-full border border-primary-900/15 bg-transparent px-4 py-2 text-sm text-primary-900 focus:border-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-600/20 dark:border-white/15 dark:bg-primary-900 dark:text-white">
                            <option value="" {{ request('sort') ? '' : 'selected' }}>Newest</option>
                            <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Highest Rated</option>
                            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>
                </div>

                @if ($products->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <h2 class="text-xl font-semibold text-primary-900 dark:text-white">No products match your filters</h2>
                        <p class="mt-2 text-sm text-primary-500 dark:text-primary-400">Try adjusting or clearing your filters.</p>
                        <a href="{{ route('products.index') }}" class="btn-primary mt-6">Clear Filters</a>
                    </div>
                @else
                    <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 xl:grid-cols-4">
                        @foreach ($products as $product)
                            <x-product-card
                                :name="$product['name']"
                                :image="$product['image']"
                                :category="$product['category']"
                                :regular-price="$product['regularPrice']"
                                :sale-price="$product['salePrice']"
                                :rating="$product['rating']"
                                :rating-count="$product['ratingCount']"
                                :badge="$product['badge']"
                                :href="route('products.show', $product['slug'])"
                            />
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if ($products->lastPage() > 1)
                        <div class="mt-12 flex items-center justify-center gap-1">
                            <a href="{{ $products->previousPageUrl() ?? '#' }}" class="flex h-10 w-10 items-center justify-center rounded-full text-primary-400 hover:bg-primary-900/5 dark:hover:bg-white/10 {{ $products->onFirstPage() ? 'pointer-events-none opacity-40' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                            </a>
                            @for ($page = 1; $page <= $products->lastPage(); $page++)
                                <a href="{{ $products->url($page) }}" class="flex h-10 w-10 items-center justify-center rounded-full text-sm font-medium {{ $page === $products->currentPage() ? 'bg-primary-900 text-white dark:bg-white dark:text-primary-900' : 'text-primary-600 hover:bg-primary-900/5 dark:text-primary-300 dark:hover:bg-white/10' }}">
                                    {{ $page }}
                                </a>
                            @endfor
                            <a href="{{ $products->nextPageUrl() ?? '#' }}" class="flex h-10 w-10 items-center justify-center rounded-full text-primary-600 hover:bg-primary-900/5 dark:text-primary-300 dark:hover:bg-white/10 {{ $products->hasMorePages() ? '' : 'pointer-events-none opacity-40' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                            </a>
                        </div>
                    @endif
                @endif
            </div>
        </form>
    </div>

</x-layouts.app>
