<x-layouts.dashboard active="orders" title="Order History">

    <h1 class="text-2xl font-semibold tracking-tight text-primary-900 dark:text-white">Order History</h1>
    <p class="mt-1 text-sm text-primary-500 dark:text-primary-400">Track and review all your past orders.</p>

    @if ($orders->isEmpty())
        <div class="mt-16 flex flex-col items-center justify-center text-center">
            <h2 class="text-xl font-semibold text-primary-900 dark:text-white">No orders yet</h2>
            <p class="mt-2 text-sm text-primary-500 dark:text-primary-400">When you place an order, it will show up here.</p>
            <a href="{{ route('products.index') }}" class="btn-primary mt-6">Start Shopping</a>
        </div>
    @else
        <div class="mt-6 card-surface overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-primary-900/10 text-xs uppercase tracking-wide text-primary-400 dark:border-white/10">
                        <tr>
                            <th class="px-6 py-4 font-medium">Order</th>
                            <th class="px-6 py-4 font-medium">Date</th>
                            <th class="px-6 py-4 font-medium">Items</th>
                            <th class="px-6 py-4 font-medium">Total</th>
                            <th class="px-6 py-4 font-medium">Status</th>
                            <th class="px-6 py-4 font-medium"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-primary-900/10 dark:divide-white/10">
                        @foreach ($orders as $order)
                            <tr class="transition-colors hover:bg-primary-900/[0.02] dark:hover:bg-white/[0.02]">
                                <td class="px-6 py-4 font-semibold text-primary-900 dark:text-white">{{ $order['number'] }}</td>
                                <td class="px-6 py-4 text-primary-500 dark:text-primary-400">{{ $order['date'] }}</td>
                                <td class="px-6 py-4 text-primary-500 dark:text-primary-400">{{ $order['itemCount'] }}</td>
                                <td class="px-6 py-4 font-medium text-primary-900 dark:text-white">${{ number_format($order['total'], 2) }}</td>
                                <td class="px-6 py-4"><x-badge-status :status="$order['status']" /></td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('dashboard.orders.show', $order['number']) }}" class="text-sm font-medium text-accent-600 hover:underline">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</x-layouts.dashboard>
