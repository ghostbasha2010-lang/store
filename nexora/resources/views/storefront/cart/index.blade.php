<x-layouts.app title="Shopping Cart — NEXORA">

    <div class="container-nexora py-10">
        <h1 class="text-3xl font-semibold tracking-tight text-primary-900 sm:text-4xl dark:text-white">Shopping Cart</h1>

        @if (count($items) > 0)
            <div class="mt-8 grid grid-cols-1 gap-10 lg:grid-cols-[1fr_360px]">

                {{-- Line items --}}
                <div class="space-y-4">
                    @foreach ($items as $item)
                        <div class="card-surface flex gap-4 p-4">
                            <div class="h-28 w-24 shrink-0 overflow-hidden rounded-xl bg-primary-100 dark:bg-primary-800">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="h-full w-full object-cover" loading="lazy">
                            </div>

                            <div class="flex flex-1 flex-col justify-between">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-medium uppercase tracking-wide text-primary-400">{{ $item['category'] }}</p>
                                        <h3 class="mt-0.5 text-sm font-semibold text-primary-900 dark:text-white">{{ $item['name'] }}</h3>
                                        <p class="mt-1 text-xs text-primary-500 dark:text-primary-400">Size: {{ $item['size'] }} &middot; Color: {{ $item['color'] }}</p>
                                    </div>
                                    <form method="POST" action="{{ route('cart.destroy', $item['id']) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" aria-label="Remove item" class="text-primary-400 transition-colors hover:text-red-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9M19.228 5.79A2.25 2.25 0 0 0 16.98 4h-1.51a2.25 2.25 0 0 0-2.248 1.79m5.996 0L19.5 21H4.5L3.796 5.79m15.432 0L19.5 5.79M3.796 5.79 3 5.79m.796 0h16.408" /></svg>
                                        </button>
                                    </form>
                                </div>

                                <div class="mt-3 flex items-end justify-between">
                                    <form method="POST" action="{{ route('cart.update', $item['id']) }}">
                                        @csrf
                                        @method('PATCH')
                                        <x-quantity-input :value="$item['quantity']" :max="$item['maxStock']" name="quantity" />
                                    </form>
                                    <x-price-display :regular-price="$item['regularPrice']" :sale-price="$item['salePrice']" />
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-600 hover:text-accent-600 dark:text-primary-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
                        Continue shopping
                    </a>
                </div>

                {{-- Summary --}}
                <div class="card-surface h-fit p-6">
                    <h2 class="text-lg font-semibold text-primary-900 dark:text-white">Order Summary</h2>

                    <div class="mt-5 space-y-3 text-sm">
                        <div class="flex justify-between text-primary-600 dark:text-primary-300">
                            <span>Subtotal</span>
                            <span class="font-medium text-primary-900 dark:text-white">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-primary-600 dark:text-primary-300">
                            <span>Discount</span>
                            <span class="font-medium text-emerald-600">-${{ number_format($discount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-primary-600 dark:text-primary-300">
                            <span>Shipping</span>
                            <span class="font-medium text-primary-900 dark:text-white">{{ $shipping > 0 ? '$'.number_format($shipping, 2) : 'Free' }}</span>
                        </div>
                    </div>

                    <div class="mt-5 flex justify-between border-t border-primary-900/10 pt-5 text-base font-semibold text-primary-900 dark:border-white/10 dark:text-white">
                        <span>Total</span>
                        <span>${{ number_format($subtotal - $discount + $shipping, 2) }}</span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn-accent mt-6 w-full">Proceed to Checkout</a>

                    <p class="mt-4 text-center text-xs text-primary-400">Cash on Delivery available at checkout</p>
                </div>
            </div>
        @else
            <div class="mt-16 flex flex-col items-center justify-center text-center">
                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-primary-100 text-primary-400 dark:bg-primary-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.98-4.716 2.53-7.223.155-.71-.386-1.362-1.113-1.362H5.106M7.5 14.25 5.106 5.25" /></svg>
                </div>
                <h2 class="mt-6 text-xl font-semibold text-primary-900 dark:text-white">Your cart is empty</h2>
                <p class="mt-2 text-sm text-primary-500 dark:text-primary-400">Looks like you haven't added anything yet.</p>
                <a href="{{ route('products.index') }}" class="btn-primary mt-6">Start Shopping</a>
            </div>
        @endif
    </div>

</x-layouts.app>
