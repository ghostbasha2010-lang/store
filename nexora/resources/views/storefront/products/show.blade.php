<x-layouts.app :title="$product['name'].' — NEXORA'">

    <div class="container-nexora py-10">
        <nav class="text-xs text-primary-400 dark:text-primary-400">
            <a href="{{ route('home') }}" class="hover:text-accent-600">Home</a>
            <span class="mx-1.5">/</span>
            <a href="{{ route('products.index') }}" class="hover:text-accent-600">{{ $product['category'] }}</a>
            <span class="mx-1.5">/</span>
            <span class="text-primary-700 dark:text-primary-200">{{ $product['name'] }}</span>
        </nav>

        <div
            x-data="{
                activeImage: 0,
                images: {{ Illuminate\Support\Js::from($product['images']) }},
                sizes: {{ Illuminate\Support\Js::from($product['sizes']) }},
                colors: {{ Illuminate\Support\Js::from($product['colors']) }},
                variants: {{ Illuminate\Support\Js::from($product['variants']) }},
                selectedSize: null,
                selectedColor: null,
                qty: 1,
                get selectedVariant() {
                    return this.variants.find(v => v.size === this.selectedSize && v.color === this.selectedColor?.name) ?? null;
                },
                get maxStock() {
                    return this.selectedVariant?.stock ?? 8;
                },
            }"
            class="mt-8 grid grid-cols-1 gap-12 lg:grid-cols-2"
        >
            {{-- Gallery --}}
            <div>
                <div class="aspect-[3/4] overflow-hidden rounded-2xl bg-primary-100 dark:bg-primary-800">
                    <template x-for="(img, i) in images" :key="i">
                        <img x-show="activeImage === i" :src="img" :alt="'{{ $product['name'] }}'" class="h-full w-full object-cover">
                    </template>
                </div>
                <div class="mt-4 grid grid-cols-5 gap-3">
                    <template x-for="(img, i) in images" :key="i">
                        <button @click="activeImage = i" class="aspect-square overflow-hidden rounded-xl ring-2 transition-all" :class="activeImage === i ? 'ring-accent-600' : 'ring-transparent hover:ring-primary-900/10'">
                            <img :src="img" class="h-full w-full object-cover" loading="lazy">
                        </button>
                    </template>
                </div>
            </div>

            {{-- Details --}}
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-accent-600">{{ $product['category'] }}</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-primary-900 sm:text-4xl dark:text-white">{{ $product['name'] }}</h1>

                <div class="mt-3 flex items-center gap-3">
                    <x-star-rating :rating="$product['rating']" :count="$product['ratingCount']" />
                </div>

                <div class="mt-5">
                    <x-price-display :regular-price="$product['regularPrice']" :sale-price="$product['salePrice']" size="lg" />
                </div>

                <p class="mt-6 max-w-lg text-sm leading-relaxed text-primary-500 dark:text-primary-300">
                    {{ $product['description'] }}
                </p>

                <div class="mt-8 h-px bg-primary-900/10 dark:bg-white/10"></div>

                {{-- Size --}}
                <div class="mt-8">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-primary-900 dark:text-white">Size</h3>
                        <button type="button" class="text-xs font-medium text-accent-600 hover:underline">Size Guide</button>
                    </div>
                    <div class="mt-3 grid grid-cols-4 gap-2 sm:w-72">
                        <template x-for="size in sizes" :key="size">
                            <button
                                type="button"
                                @click="selectedSize = size"
                                :class="selectedSize === size ? 'border-primary-900 bg-primary-900 text-white dark:border-white dark:bg-white dark:text-primary-900' : 'border-primary-900/15 text-primary-700 hover:border-accent-600 hover:text-accent-600 dark:border-white/15 dark:text-primary-200'"
                                class="rounded-lg border py-2.5 text-sm font-medium transition-colors"
                                x-text="size"
                            ></button>
                        </template>
                    </div>
                    <p x-show="!selectedSize" class="mt-2 text-xs text-primary-400">Please select a size</p>
                </div>

                {{-- Color --}}
                <div class="mt-6">
                    <h3 class="text-sm font-semibold text-primary-900 dark:text-white">
                        Color <span x-show="selectedColor" x-text="'— ' + selectedColor?.name"></span>
                    </h3>
                    <div class="mt-3 flex flex-wrap gap-3">
                        <template x-for="color in colors" :key="color.name">
                            <button
                                type="button"
                                @click="selectedColor = color"
                                :style="'background-color:' + color.hex"
                                :class="selectedColor?.name === color.name ? 'ring-2 ring-accent-600 ring-offset-2 dark:ring-offset-primary-900' : 'ring-1 ring-primary-900/10 dark:ring-white/20'"
                                class="h-9 w-9 rounded-full ring-offset-white transition-shadow dark:ring-offset-primary-900"
                            ></button>
                        </template>
                    </div>
                </div>

                {{-- Quantity + Actions --}}
                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <div class="inline-flex items-center rounded-full border border-primary-900/15 dark:border-white/15">
                        <button type="button" @click="qty = Math.max(1, qty - 1)" class="flex h-12 w-12 items-center justify-center text-primary-600 hover:text-accent-600 dark:text-primary-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M5 12h14" /></svg>
                        </button>
                        <span x-text="qty" class="w-10 text-center text-sm font-medium text-primary-900 dark:text-white"></span>
                        <button type="button" @click="qty = Math.min(maxStock, qty + 1)" class="flex h-12 w-12 items-center justify-center text-primary-600 hover:text-accent-600 dark:text-primary-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M12 5v14M5 12h14" /></svg>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('cart.store') }}" class="flex-1">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                        <input type="hidden" name="product_variant_id" :value="selectedVariant?.id">
                        <input type="hidden" name="quantity" :value="qty">
                        <button type="submit" :disabled="!selectedVariant" :class="!selectedVariant ? 'opacity-40 cursor-not-allowed' : ''" class="btn-accent w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.98-4.716 2.53-7.223.155-.71-.386-1.362-1.113-1.362H5.106M7.5 14.25 5.106 5.25" /></svg>
                            Add to Cart
                        </button>
                    </form>

                    <form method="POST" action="{{ route(($product['isWishlisted'] ?? false) ? 'wishlist.destroy' : 'wishlist.store', $product['id']) }}">
                        @csrf
                        @if ($product['isWishlisted'] ?? false) @method('DELETE') @endif
                        <button type="submit" aria-label="{{ ($product['isWishlisted'] ?? false) ? 'Remove from wishlist' : 'Add to wishlist' }}" class="flex h-12 w-12 items-center justify-center rounded-full border transition-colors {{ ($product['isWishlisted'] ?? false) ? 'border-red-400 text-red-500' : 'border-primary-900/15 text-primary-700 hover:border-red-400 hover:text-red-500 dark:border-white/15 dark:text-primary-200' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="{{ ($product['isWishlisted'] ?? false) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" /></svg>
                        </button>
                    </form>
                </div>

                <p class="mt-4 flex items-center gap-1.5 text-xs font-medium text-emerald-600 dark:text-emerald-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    In Stock — Ready to ship
                </p>
            </div>
        </div>

        {{-- Reviews --}}
        <div class="mt-20 border-t border-primary-900/10 pt-14 dark:border-white/10">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h2 class="section-heading">Customer Reviews</h2>
                <button class="btn-outline">Write a Review</button>
            </div>

            <div class="mt-8 grid gap-5 sm:grid-cols-2">
                @foreach ($product['reviews'] as $review)
                    <div class="card-surface p-5">
                        <div class="flex items-center justify-between">
                            <x-star-rating :rating="$review['rating']" size="xs" />
                            <span class="text-xs text-primary-400">{{ $review['date'] }}</span>
                        </div>
                        <p class="mt-3 text-sm leading-relaxed text-primary-600 dark:text-primary-300">{{ $review['comment'] }}</p>
                        <p class="mt-3 text-xs font-medium text-primary-900 dark:text-white">{{ $review['name'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Related products --}}
        <div class="mt-20 border-t border-primary-900/10 pt-14 dark:border-white/10">
            <h2 class="section-heading">You may also like</h2>
            <div class="mt-8 grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4">
                @foreach ($related as $item)
                    <x-product-card
                        :name="$item['name']"
                        :image="$item['image']"
                        :category="$item['category']"
                        :regular-price="$item['regularPrice']"
                        :sale-price="$item['salePrice']"
                        :rating="$item['rating']"
                        :rating-count="$item['ratingCount']"
                        :badge="$item['badge']"
                    />
                @endforeach
            </div>
        </div>
    </div>

</x-layouts.app>
