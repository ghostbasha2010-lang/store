<x-layouts.dashboard active="orders" :title="'Order '.$order['number']">

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <a href="{{ route('dashboard.orders') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-primary-400 hover:text-accent-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" /></svg>
                Back to orders
            </a>
            <h1 class="mt-2 text-2xl font-semibold tracking-tight text-primary-900 dark:text-white">Order {{ $order['number'] }}</h1>
            <p class="mt-1 text-sm text-primary-500 dark:text-primary-400">Placed on {{ $order['date'] }}</p>
        </div>
        <x-badge-status :status="$order['status']" class="px-4! py-1.5! text-sm!" />
    </div>

    {{-- Status timeline --}}
    @if ($order['status'] !== 'cancelled')
        <div class="mt-8 card-surface p-6">
            <div class="flex items-center">
                @foreach (['pending', 'confirmed', 'preparing', 'shipped', 'delivered'] as $i => $step)
                    @php
                        $steps = ['pending', 'confirmed', 'preparing', 'shipped', 'delivered'];
                        $currentIndex = array_search($order['status'], $steps);
                        $done = $i <= $currentIndex;
                    @endphp
                    <div class="flex flex-1 flex-col items-center last:flex-none">
                        <div class="flex w-full items-center">
                            <div class="h-0.5 flex-1 {{ $i === 0 ? 'bg-transparent' : ($done ? 'bg-accent-600' : 'bg-primary-900/10 dark:bg-white/10') }}"></div>
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full {{ $done ? 'bg-accent-600 text-white' : 'bg-primary-100 text-primary-400 dark:bg-primary-800' }}">
                                @if ($done)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>
                                @else
                                    <span class="h-2 w-2 rounded-full bg-current"></span>
                                @endif
                            </div>
                            <div class="h-0.5 flex-1 {{ $i === 4 ? 'bg-transparent' : ($i < $currentIndex ? 'bg-accent-600' : 'bg-primary-900/10 dark:bg-white/10') }}"></div>
                        </div>
                        <span class="mt-2 text-center text-xs font-medium capitalize {{ $done ? 'text-primary-900 dark:text-white' : 'text-primary-400' }}">{{ $step }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-[1fr_320px]">

        {{-- Items --}}
        <div class="card-surface p-6">
            <h2 class="text-lg font-semibold text-primary-900 dark:text-white">Items</h2>
            <div class="mt-4 divide-y divide-primary-900/10 dark:divide-white/10">
                @foreach ($order['items'] as $item)
                    <div class="flex gap-4 py-4 first:pt-0 last:pb-0">
                        <div class="h-20 w-16 shrink-0 overflow-hidden rounded-lg bg-primary-100 dark:bg-primary-800">
                            <img src="{{ $item['image'] }}" class="h-full w-full object-cover" loading="lazy">
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-primary-900 dark:text-white">{{ $item['name'] }}</p>
                            <p class="mt-1 text-xs text-primary-400">{{ $item['size'] }} / {{ $item['color'] }} &times; {{ $item['quantity'] }}</p>
                        </div>
                        <p class="text-sm font-semibold text-primary-900 dark:text-white">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                    </div>
                @endforeach
            </div>

            @if (in_array($order['status'], ['pending', 'confirmed']))
                <div class="mt-6 border-t border-primary-900/10 pt-6 dark:border-white/10">
                    <form method="POST" action="{{ route('dashboard.orders.cancel', $order['number']) }}" onsubmit="return confirm('Cancel this order?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-sm font-medium text-red-500 hover:underline">Cancel this order</button>
                    </form>
                </div>
            @endif
        </div>

        {{-- Summary + shipping --}}
        <div class="space-y-6">
            <div class="card-surface p-6">
                <h2 class="text-lg font-semibold text-primary-900 dark:text-white">Summary</h2>
                <div class="mt-4 space-y-2.5 text-sm">
                    <div class="flex justify-between text-primary-600 dark:text-primary-300"><span>Subtotal</span><span class="font-medium text-primary-900 dark:text-white">${{ number_format($order['subtotal'], 2) }}</span></div>
                    <div class="flex justify-between text-primary-600 dark:text-primary-300"><span>Shipping</span><span class="font-medium text-primary-900 dark:text-white">{{ $order['shipping'] > 0 ? '$'.number_format($order['shipping'], 2) : 'Free' }}</span></div>
                </div>
                <div class="mt-4 flex justify-between border-t border-primary-900/10 pt-4 text-base font-semibold text-primary-900 dark:border-white/10 dark:text-white">
                    <span>Total</span>
                    <span>${{ number_format($order['total'], 2) }}</span>
                </div>
            </div>

            <div class="card-surface p-6">
                <h2 class="text-lg font-semibold text-primary-900 dark:text-white">Shipping Address</h2>
                <p class="mt-3 text-sm leading-relaxed text-primary-600 dark:text-primary-300">
                    {{ $order['shippingAddress']['name'] }}<br>
                    {{ $order['shippingAddress']['line1'] }}<br>
                    {{ $order['shippingAddress']['city'] }}<br>
                    {{ $order['shippingAddress']['phone'] }}
                </p>
            </div>
        </div>
    </div>

</x-layouts.dashboard>
