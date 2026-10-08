<x-layouts.app>

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-primary-900">
        <img
            src="https://images.unsplash.com/photo-1490114538077-0a7f8cb49891?q=80&w=1800&auto=format&fit=crop"
            alt="NEXORA new season collection"
            class="absolute inset-0 h-full w-full object-cover opacity-60"
        >
        <div class="absolute inset-0 bg-gradient-to-r from-primary-900 via-primary-900/70 to-transparent"></div>

        <div class="container-nexora relative flex min-h-[560px] items-center py-24 sm:min-h-[640px]">
            <div class="max-w-xl">
                <span class="inline-block rounded-full border border-white/20 px-4 py-1.5 text-xs font-medium uppercase tracking-widest text-white/80">
                    Fall / Winter Collection
                </span>
                <h1 class="mt-6 text-4xl font-extrabold leading-tight tracking-tight text-white sm:text-6xl">
                    Wear confidence,<br> every single day.
                </h1>
                <p class="mt-6 max-w-md text-base leading-relaxed text-white/70">
                    Premium essentials and statement pieces, designed with intention and made to move with you.
                </p>
                <div class="mt-10 flex flex-wrap gap-4">
                    <a href="{{ route('products.index') }}" class="btn-accent">Shop Collection</a>
                    <a href="#categories" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/30 px-6 py-3 text-sm font-medium tracking-wide text-white transition-all duration-300 ease-out hover:border-white hover:bg-white/10">Explore Categories</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Trust strip --}}
    <section class="border-b border-primary-900/5 bg-white dark:border-white/10 dark:bg-primary-900/10">
        <div class="container-nexora grid grid-cols-2 gap-6 py-8 text-center sm:grid-cols-4">
            @foreach ([
                ['label' => 'Free Shipping', 'sub' => 'On orders over $100'],
                ['label' => '30-Day Returns', 'sub' => 'No questions asked'],
                ['label' => 'Secure Checkout', 'sub' => '100% protected payments'],
                ['label' => '24/7 Support', 'sub' => 'Always here to help'],
            ] as $item)
                <div>
                    <p class="text-sm font-semibold text-primary-900 dark:text-white">{{ $item['label'] }}</p>
                    <p class="mt-1 text-xs text-primary-400 dark:text-primary-400">{{ $item['sub'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Featured Products --}}
    <section id="featured" class="container-nexora py-20">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-widest text-accent-600">Handpicked</p>
                <h2 class="section-heading mt-2">Featured Products</h2>
            </div>
            <a href="#" class="text-sm font-medium text-primary-700 hover:text-accent-600 dark:text-primary-200">View all &rarr;</a>
        </div>

        <div class="mt-10 grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4">
            @foreach ($featured as $product)
                <x-product-card
                    :name="$product['name']"
                    :image="$product['image']"
                    :category="$product['category']"
                    :regular-price="$product['regularPrice']"
                    :sale-price="$product['salePrice']"
                    :rating="$product['rating']"
                    :rating-count="$product['ratingCount']"
                    :badge="$product['badge']"
                />
            @endforeach
        </div>
    </section>

    {{-- Special Offers --}}
    <section class="bg-primary-900 py-20 dark:bg-black/40">
        <div class="container-nexora">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-widest text-accent-400">Limited Time</p>
                    <h2 class="mt-2 text-3xl font-semibold tracking-tight text-white sm:text-4xl">Special Offers &amp; Discounts</h2>
                </div>
                <a href="#" class="text-sm font-medium text-white/80 hover:text-white">Shop all deals &rarr;</a>
            </div>

            <div class="mt-10 grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4">
                @foreach ($offers as $product)
                    <x-product-card
                        :name="$product['name']"
                        :image="$product['image']"
                        :category="$product['category']"
                        :regular-price="$product['regularPrice']"
                        :sale-price="$product['salePrice']"
                        :rating="$product['rating']"
                        :rating-count="$product['ratingCount']"
                        :badge="$product['badge']"
                    />
                @endforeach
            </div>
        </div>
    </section>

    {{-- New Arrivals --}}
    <section class="container-nexora py-20">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-widest text-accent-600">Just Dropped</p>
                <h2 class="section-heading mt-2">New Arrivals</h2>
            </div>
            <a href="#" class="text-sm font-medium text-primary-700 hover:text-accent-600 dark:text-primary-200">View all &rarr;</a>
        </div>

        <div class="mt-10 grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-4">
            @foreach ($newArrivals as $product)
                <x-product-card
                    :name="$product['name']"
                    :image="$product['image']"
                    :category="$product['category']"
                    :regular-price="$product['regularPrice']"
                    :sale-price="$product['salePrice']"
                    :rating="$product['rating']"
                    :rating-count="$product['ratingCount']"
                    :badge="$product['badge']"
                />
            @endforeach
        </div>
    </section>

    {{-- Categories --}}
    <section id="categories" class="bg-white py-20 dark:bg-primary-900/10">
        <div class="container-nexora">
            <div class="text-center">
                <p class="text-sm font-semibold uppercase tracking-widest text-accent-600">Shop by Category</p>
                <h2 class="section-heading mt-2">Find your style</h2>
            </div>

            <div class="mt-10 grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-5">
                @foreach ($categories as $category)
                    <x-category-tile :name="$category['name']" :image="$category['image']" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- Customer Reviews --}}
    <section class="container-nexora py-20">
        <div class="text-center">
            <p class="text-sm font-semibold uppercase tracking-widest text-accent-600">Testimonials</p>
            <h2 class="section-heading mt-2">Loved by our customers</h2>
        </div>

        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($reviews as $review)
                <div class="card-surface p-6">
                    <x-star-rating :rating="$review['rating']" size="sm" />
                    <p class="mt-4 text-sm leading-relaxed text-primary-600 dark:text-primary-300">
                        &ldquo;{{ $review['comment'] }}&rdquo;
                    </p>
                    <div class="mt-6 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-accent-600/10 text-sm font-semibold text-accent-600">
                            {{ $review['initials'] }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-primary-900 dark:text-white">{{ $review['name'] }}</p>
                            <p class="text-xs text-primary-400 dark:text-primary-400">Verified Buyer</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

</x-layouts.app>
