<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->where('is_active', true)->get();

        $featured = $products->where('badge', 'Featured')->take(8)->map(fn (Product $product) => ProductController::toCard($product));
        $newArrivals = $products->where('badge', 'New')->take(8)->map(fn (Product $product) => ProductController::toCard($product));
        $offers = $products->filter(fn (Product $product) => ! is_null($product->sale_price))->take(8)->map(fn (Product $product) => ProductController::toCard($product));

        $categories = Category::all()->map(fn (Category $category) => [
            'name' => $category->name,
            'image' => $category->image,
        ]);

        $reviews = [
            ['name' => 'Sarah Mitchell', 'initials' => 'SM', 'rating' => 5, 'comment' => 'The quality is unreal for the price. My overcoat looks and feels like it costs three times as much.'],
            ['name' => 'James Okafor', 'initials' => 'JO', 'rating' => 5, 'comment' => 'Fast shipping, perfect fit, and the packaging felt genuinely premium. Already ordered twice more.'],
            ['name' => 'Layla Haddad', 'initials' => 'LH', 'rating' => 4, 'comment' => 'Beautiful pieces and true to size. NEXORA is now my go-to for basics and statement pieces alike.'],
        ];

        return view('storefront.home', compact('featured', 'newArrivals', 'offers', 'categories', 'reviews'));
    }
}
