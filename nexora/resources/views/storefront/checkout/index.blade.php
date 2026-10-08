<x-layouts.app title="Checkout — NEXORA">

    <div class="container-nexora py-10">
        <h1 class="text-3xl font-semibold tracking-tight text-primary-900 sm:text-4xl dark:text-white">Checkout</h1>

        @if ($items->isEmpty())
            <div class="mt-16 flex flex-col items-center justify-center text-center">
                <h2 class="text-xl font-semibold text-primary-900 dark:text-white">Your cart is empty</h2>
                <p class="mt-2 text-sm text-primary-500 dark:text-primary-400">Add items to your cart before checking out.</p>
                <a href="{{ route('products.index') }}" class="btn-primary mt-6">Start Shopping</a>
            </div>
        @else
        <form method="POST" action="{{ route('checkout.store') }}" class="mt-8 grid grid-cols-1 gap-10 lg:grid-cols-[1fr_360px]">
            @csrf

            <div class="space-y-8">

                {{-- Shipping address --}}
                <div class="card-surface p-6">
                    <h2 class="text-lg font-semibold text-primary-900 dark:text-white">Shipping Address</h2>

                    <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label class="text-xs font-medium text-primary-600 dark:text-primary-300">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required placeholder="Full name" class="mt-1.5 w-full rounded-lg border border-primary-900/15 bg-transparent px-4 py-2.5 text-sm text-primary-900 placeholder:text-primary-400 focus:border-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-600/20 dark:border-white/15 dark:text-white">
                            @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-xs font-medium text-primary-600 dark:text-primary-300">Phone Number</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="+20 100 000 0000" class="mt-1.5 w-full rounded-lg border border-primary-900/15 bg-transparent px-4 py-2.5 text-sm text-primary-900 placeholder:text-primary-400 focus:border-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-600/20 dark:border-white/15 dark:text-white">
                            @error('phone') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="text-xs font-medium text-primary-600 dark:text-primary-300">Address</label>
                            <input type="text" name="line1" value="{{ old('line1') }}" required placeholder="Street address" class="mt-1.5 w-full rounded-lg border border-primary-900/15 bg-transparent px-4 py-2.5 text-sm text-primary-900 placeholder:text-primary-400 focus:border-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-600/20 dark:border-white/15 dark:text-white">
                            @error('line1') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-xs font-medium text-primary-600 dark:text-primary-300">City</label>
                            <input type="text" name="city" value="{{ old('city') }}" required placeholder="City" class="mt-1.5 w-full rounded-lg border border-primary-900/15 bg-transparent px-4 py-2.5 text-sm text-primary-900 placeholder:text-primary-400 focus:border-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-600/20 dark:border-white/15 dark:text-white">
                            @error('city') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Payment method --}}
                <div class="card-surface p-6">
                    <h2 class="text-lg font-semibold text-primary-900 dark:text-white">Payment Method</h2>
                    <label class="mt-5 flex cursor-pointer items-center gap-3 rounded-xl border border-accent-600 bg-accent-50 p-4 dark:bg-accent-500/10">
                        <input type="radio" checked class="h-4 w-4 text-accent-600 focus:ring-accent-600/30">
                        <div>
                            <p class="text-sm font-medium text-primary-900 dark:text-white">Cash on Delivery</p>
                            <p class="text-xs text-primary-500 dark:text-primary-400">Pay with cash when your order arrives</p>
                        </div>
                    </label>
                </div>

                <div>
                    <label class="text-xs font-medium text-primary-600 dark:text-primary-300">Order Notes (optional)</label>
                    <textarea rows="3" placeholder="Any special instructions for your order" class="mt-1.5 w-full rounded-lg border border-primary-900/15 bg-transparent px-4 py-2.5 text-sm text-primary-900 placeholder:text-primary-400 focus:border-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-600/20 dark:border-white/15 dark:text-white"></textarea>
                </div>
            </div>

            {{-- Summary --}}
            <div class="card-surface h-fit p-6">
                <h2 class="text-lg font-semibold text-primary-900 dark:text-white">Order Summary</h2>

                <div class="mt-5 space-y-4">
                    @foreach ($items as $item)
                        <div class="flex gap-3">
                            <div class="h-16 w-14 shrink-0 overflow-hidden rounded-lg bg-primary-100 dark:bg-primary-800">
                                <img src="{{ $item['image'] }}" class="h-full w-full object-cover">
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-primary-900 dark:text-white">{{ $item['name'] }}</p>
                                <p class="text-xs text-primary-400">{{ $item['size'] }} / {{ $item['color'] }} &times; {{ $item['quantity'] }}</p>
                            </div>
                            <p class="text-sm font-medium text-primary-900 dark:text-white">${{ number_format(($item['salePrice'] ?? $item['regularPrice']) * $item['quantity'], 2) }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-5 space-y-3 border-t border-primary-900/10 pt-5 text-sm dark:border-white/10">
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

                <button type="submit" class="btn-accent mt-6 block w-full text-center">Place Order</button>
            </div>
        </form>
        @endif
    </div>

</x-layouts.app>
