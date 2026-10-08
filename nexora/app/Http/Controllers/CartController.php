<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        [$items, $subtotal, $discount, $shipping] = self::summary();

        return view('storefront.cart.index', compact('items', 'subtotal', 'discount', 'shipping'));
    }

    public static function summary(): array
    {
        $cart = (new self)->currentCart();

        $items = $cart->items->map(function (CartItem $item) {
            return [
                'id' => $item->id,
                'productId' => $item->product_id,
                'name' => $item->product->name,
                'category' => $item->product->category?->name,
                'image' => $item->product->image,
                'size' => $item->variant?->size,
                'color' => $item->variant?->color,
                'quantity' => $item->quantity,
                'maxStock' => $item->variant?->stock ?? 0,
                'regularPrice' => (float) $item->product->regular_price,
                'salePrice' => $item->product->sale_price !== null ? (float) $item->product->sale_price : null,
            ];
        });

        $subtotal = $items->sum(fn ($item) => ($item['salePrice'] ?? $item['regularPrice']) * $item['quantity']);
        $discount = $items->sum(fn ($item) => $item['salePrice'] ? ($item['regularPrice'] - $item['salePrice']) * $item['quantity'] : 0);
        $shipping = $subtotal >= 100 || $subtotal == 0 ? 0 : 9.99;

        return [$items, $subtotal, $discount, $shipping];
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'product_variant_id' => ['required', 'exists:product_variants,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $variant = ProductVariant::findOrFail($validated['product_variant_id']);
        $cart = $this->currentCart();

        $item = $cart->items()
            ->where('product_id', $validated['product_id'])
            ->where('product_variant_id', $validated['product_variant_id'])
            ->first();

        $quantity = min(($item?->quantity ?? 0) + $validated['quantity'], $variant->stock);

        $cart->items()->updateOrCreate(
            ['product_id' => $validated['product_id'], 'product_variant_id' => $validated['product_variant_id']],
            ['quantity' => max($quantity, 1)],
        );

        return redirect()->route('cart.index');
    }

    public function update(Request $request, CartItem $item): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $this->authorizeCartItem($item);

        $item->update(['quantity' => min($validated['quantity'], $item->variant?->stock ?? $validated['quantity'])]);

        return redirect()->route('cart.index');
    }

    public function destroy(CartItem $item): RedirectResponse
    {
        $this->authorizeCartItem($item);

        $item->delete();

        return redirect()->route('cart.index');
    }

    private function currentCart(): Cart
    {
        return Cart::with('items.product.category', 'items.variant')
            ->firstOrCreate(['session_id' => session()->getId()]);
    }

    private function authorizeCartItem(CartItem $item): void
    {
        abort_unless($item->cart->session_id === session()->getId(), 403);
    }
}
