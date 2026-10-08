<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        [$items, $subtotal, $discount, $shipping] = CartController::summary();

        return view('storefront.checkout.index', compact('items', 'subtotal', 'discount', 'shipping'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'line1' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
        ]);

        [$items, $subtotal, $discount, $shipping] = CartController::summary();

        abort_if($items->isEmpty(), 400, 'Your cart is empty.');

        $user = Auth::user();
        $cart = Cart::with('items.variant')->where('session_id', session()->getId())->first();

        $order = DB::transaction(function () use ($user, $validated, $items, $subtotal, $discount, $shipping, $cart) {
            $address = $user->addresses()->create([
                'label' => 'Checkout',
                'name' => $validated['name'],
                'line1' => $validated['line1'],
                'city' => $validated['city'],
                'country' => 'Egypt',
                'phone' => $validated['phone'],
                'is_default' => $user->addresses()->count() === 0,
            ]);

            $order = $user->orders()->create([
                'address_id' => $address->id,
                'number' => 'NXR-'.now()->format('Ymd').'-'.strtoupper(Str::random(5)),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping' => $shipping,
                'total' => $subtotal - $discount + $shipping,
                'estimated_delivery' => now()->addDays(2)->format('M j').' - '.now()->addDays(4)->format('M j, Y'),
            ]);

            foreach ($items as $item) {
                $order->items()->create([
                    'product_id' => $item['productId'],
                    'name' => $item['name'],
                    'image' => $item['image'],
                    'size' => $item['size'],
                    'color' => $item['color'],
                    'quantity' => $item['quantity'],
                    'price' => $item['salePrice'] ?? $item['regularPrice'],
                ]);
            }

            $cart?->items->each(function ($cartItem) {
                $cartItem->variant?->decrement('stock', $cartItem->quantity);
            });
            $cart?->items()->delete();

            return $order;
        });

        return redirect()->route('checkout.confirmation', $order->number);
    }

    public function confirmation(string $order)
    {
        $order = Auth::user()->orders()->where('number', $order)->firstOrFail();

        return view('storefront.checkout.confirmation', ['order' => [
            'number' => $order->number,
            'total' => (float) $order->total,
            'estimatedDelivery' => $order->estimated_delivery,
        ]]);
    }
}
