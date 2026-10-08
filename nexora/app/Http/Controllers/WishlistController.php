<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function store(Product $product): RedirectResponse
    {
        Auth::user()->wishlist()->syncWithoutDetaching([$product->id]);

        return back();
    }

    public function destroy(Product $product): RedirectResponse
    {
        Auth::user()->wishlist()->detach($product->id);

        return back();
    }
}
