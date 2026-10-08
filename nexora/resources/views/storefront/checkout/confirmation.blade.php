<x-layouts.app title="Order Confirmed — NEXORA">

    <div class="container-nexora flex flex-col items-center py-20 text-center">
        <div class="flex h-20 w-20 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
        </div>

        <h1 class="mt-8 text-3xl font-semibold tracking-tight text-primary-900 sm:text-4xl dark:text-white">Order Confirmed!</h1>
        <p class="mt-3 max-w-md text-sm leading-relaxed text-primary-500 dark:text-primary-400">
            Thank you for shopping with NEXORA. Your order <span class="font-semibold text-primary-900 dark:text-white">{{ $order['number'] }}</span> has been placed and will be paid via Cash on Delivery.
        </p>

        <div class="mt-10 w-full max-w-md card-surface p-6 text-left">
            <div class="flex justify-between text-sm">
                <span class="text-primary-500 dark:text-primary-400">Order Number</span>
                <span class="font-semibold text-primary-900 dark:text-white">{{ $order['number'] }}</span>
            </div>
            <div class="mt-3 flex justify-between text-sm">
                <span class="text-primary-500 dark:text-primary-400">Total</span>
                <span class="font-semibold text-primary-900 dark:text-white">${{ number_format($order['total'], 2) }}</span>
            </div>
            <div class="mt-3 flex justify-between text-sm">
                <span class="text-primary-500 dark:text-primary-400">Payment</span>
                <span class="font-semibold text-primary-900 dark:text-white">Cash on Delivery</span>
            </div>
            <div class="mt-3 flex justify-between text-sm">
                <span class="text-primary-500 dark:text-primary-400">Estimated Delivery</span>
                <span class="font-semibold text-primary-900 dark:text-white">{{ $order['estimatedDelivery'] }}</span>
            </div>
        </div>

        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ route('dashboard.orders.show', $order['number']) }}" class="btn-primary">Track Order</a>
            <a href="{{ route('products.index') }}" class="btn-outline">Continue Shopping</a>
        </div>
    </div>

</x-layouts.app>
