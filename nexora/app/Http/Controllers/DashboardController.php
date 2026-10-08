<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = $user->orders()->withCount('items')->latest()->take(3)->get();
        $recentOrders = $orders->map(fn (Order $order) => self::toSummary($order));

        $stats = [
            'totalOrders' => $user->orders()->count(),
            'inProgress' => $user->orders()->whereIn('status', ['pending', 'confirmed', 'shipped'])->count(),
            'wishlistItems' => $user->wishlist()->count(),
            'savedAddresses' => $user->addresses()->count(),
        ];

        return view('storefront.dashboard.index', compact('recentOrders', 'stats'));
    }

    public function orders()
    {
        $orders = Auth::user()->orders()->withCount('items')->latest()->get()->map(fn (Order $order) => self::toSummary($order));

        return view('storefront.dashboard.orders.index', compact('orders'));
    }

    public function orderShow(string $number)
    {
        $order = Auth::user()->orders()->with(['items', 'address'])->where('number', $number)->firstOrFail();

        $orderData = self::toSummary($order) + [
            'items' => $order->items->map(fn ($item) => [
                'name' => $item->name,
                'image' => $item->image,
                'size' => $item->size,
                'color' => $item->color,
                'quantity' => $item->quantity,
                'price' => (float) $item->price,
            ])->all(),
            'subtotal' => (float) $order->subtotal,
            'shipping' => (float) $order->shipping,
            'shippingAddress' => $order->address ? [
                'name' => $order->address->name,
                'line1' => $order->address->line1,
                'city' => $order->address->city,
                'phone' => $order->address->phone,
            ] : null,
        ];

        return view('storefront.dashboard.orders.show', ['order' => $orderData]);
    }

    public function cancelOrder(string $number): RedirectResponse
    {
        $order = Auth::user()->orders()->where('number', $number)->firstOrFail();

        abort_unless(in_array($order->status, ['pending', 'confirmed']), 400);

        $order->update(['status' => 'cancelled']);

        return redirect()->route('dashboard.orders.show', $number);
    }

    public function addresses()
    {
        $addresses = Auth::user()->addresses()->orderByDesc('is_default')->get()->map(fn (Address $address) => [
            'id' => $address->id,
            'label' => $address->label,
            'name' => $address->name,
            'line1' => $address->line1,
            'city' => $address->city,
            'country' => $address->country,
            'phone' => $address->phone,
            'isDefault' => $address->is_default,
        ]);

        return view('storefront.dashboard.addresses', compact('addresses'));
    }

    public function storeAddress(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'line1' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
        ]);

        $user = Auth::user();
        $isFirst = $user->addresses()->count() === 0;

        $user->addresses()->create($validated + ['is_default' => $isFirst]);

        return redirect()->route('dashboard.addresses');
    }

    public function updateAddress(Request $request, Address $address): RedirectResponse
    {
        abort_unless($address->user_id === Auth::id(), 403);

        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'line1' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
        ]);

        $address->update($validated);

        return redirect()->route('dashboard.addresses');
    }

    public function destroyAddress(Address $address): RedirectResponse
    {
        abort_unless($address->user_id === Auth::id(), 403);

        $address->delete();

        return redirect()->route('dashboard.addresses');
    }

    public function setDefaultAddress(Address $address): RedirectResponse
    {
        abort_unless($address->user_id === Auth::id(), 403);

        Auth::user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return redirect()->route('dashboard.addresses');
    }

    public function wishlist()
    {
        $items = Auth::user()->wishlist()->with('category')->get()->map(fn ($product) => [
            'id' => $product->id,
            'slug' => $product->slug,
            'name' => $product->name,
            'category' => $product->category?->name,
            'image' => $product->image,
            'regularPrice' => (float) $product->regular_price,
            'salePrice' => $product->sale_price !== null ? (float) $product->sale_price : null,
        ]);

        return view('storefront.dashboard.wishlist', compact('items'));
    }

    private static function toSummary(Order $order): array
    {
        return [
            'number' => $order->number,
            'date' => $order->created_at->format('M j, Y'),
            'itemCount' => $order->items_count ?? $order->items()->count(),
            'total' => (float) $order->total,
            'status' => $order->status,
        ];
    }
}
