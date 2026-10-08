<x-layouts.dashboard active="overview" title="My Account">

    <h1 class="text-2xl font-semibold tracking-tight text-primary-900 dark:text-white">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}</h1>
    <p class="mt-1 text-sm text-primary-500 dark:text-primary-400">Here's a quick summary of your account.</p>

    {{-- Stats --}}
    <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-4">
        @foreach ([
            ['label' => 'Total Orders', 'value' => $stats['totalOrders']],
            ['label' => 'In Progress', 'value' => $stats['inProgress']],
            ['label' => 'Wishlist Items', 'value' => $stats['wishlistItems']],
            ['label' => 'Saved Addresses', 'value' => $stats['savedAddresses']],
        ] as $stat)
            <div class="card-surface p-5">
                <p class="text-2xl font-semibold text-primary-900 dark:text-white">{{ $stat['value'] }}</p>
                <p class="mt-1 text-xs font-medium text-primary-400">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Recent orders --}}
    <div class="mt-8 card-surface p-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-primary-900 dark:text-white">Recent Orders</h2>
            <a href="{{ route('dashboard.orders') }}" class="text-sm font-medium text-accent-600 hover:underline">View all</a>
        </div>

        @if ($recentOrders->isEmpty())
            <p class="py-6 text-center text-sm text-primary-400">No orders yet.</p>
        @else
            <div class="mt-5 divide-y divide-primary-900/10 dark:divide-white/10">
                @foreach ($recentOrders as $order)
                    <a href="{{ route('dashboard.orders.show', $order['number']) }}" class="flex items-center justify-between gap-4 py-4 first:pt-0 last:pb-0">
                        <div>
                            <p class="text-sm font-semibold text-primary-900 dark:text-white">{{ $order['number'] }}</p>
                            <p class="mt-0.5 text-xs text-primary-400">{{ $order['date'] }} &middot; {{ $order['itemCount'] }} items</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-sm font-semibold text-primary-900 dark:text-white">${{ number_format($order['total'], 2) }}</span>
                            <x-badge-status :status="$order['status']" />
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

</x-layouts.dashboard>
