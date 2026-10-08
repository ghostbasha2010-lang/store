<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);

        if ($categories = $request->query('category')) {
            $query->whereHas('category', fn ($q) => $q->whereIn('name', $categories));
        }

        if ($request->filled('min_price')) {
            $query->whereRaw('COALESCE(sale_price, regular_price) >= ?', [$request->float('min_price')]);
        }

        if ($request->filled('max_price')) {
            $query->whereRaw('COALESCE(sale_price, regular_price) <= ?', [$request->float('max_price')]);
        }

        if ($sizes = $request->query('size')) {
            $query->whereHas('variants', fn ($q) => $q->whereIn('size', $sizes));
        }

        if ($colors = $request->query('color')) {
            $query->whereHas('variants', fn ($q) => $q->whereIn('color', $colors));
        }

        match ($request->query('sort')) {
            'rating' => $query->orderByDesc('rating'),
            'price_asc' => $query->orderByRaw('COALESCE(sale_price, regular_price) asc'),
            'price_desc' => $query->orderByRaw('COALESCE(sale_price, regular_price) desc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();
        $products->through(fn (Product $product) => self::toCard($product));

        return view('storefront.products.index', compact('products'));
    }

    public function show(string $slug)
    {
        $product = Product::with(['category', 'images', 'variants', 'reviews'])
            ->where('slug', $slug)
            ->firstOrFail();

        $images = $product->images->pluck('url')->prepend($product->image)->unique()->values()->all();

        $sizes = $product->variants->pluck('size')->unique()->values()->all();

        $colors = $product->variants
            ->unique('color')
            ->map(fn ($variant) => ['name' => $variant->color, 'hex' => $variant->color_hex])
            ->values()
            ->all();

        $variants = $product->variants->map(fn ($variant) => [
            'id' => $variant->id,
            'size' => $variant->size,
            'color' => $variant->color,
            'stock' => $variant->stock,
        ])->values()->all();

        $productData = [
            'id' => $product->id,
            'slug' => $product->slug,
            'name' => $product->name,
            'category' => $product->category?->name,
            'image' => $product->image,
            'images' => $images,
            'sizes' => $sizes,
            'colors' => $colors,
            'variants' => $variants,
            'regularPrice' => (float) $product->regular_price,
            'salePrice' => $product->sale_price !== null ? (float) $product->sale_price : null,
            'rating' => (float) $product->rating,
            'ratingCount' => $product->rating_count,
            'badge' => $product->badge,
            'isWishlisted' => Auth::check() && Auth::user()->wishlist()->where('product_id', $product->id)->exists(),
            'description' => $product->description,
            'reviews' => $product->reviews->map(fn ($review) => [
                'name' => $review->name,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'date' => $review->created_at->diffForHumans(),
            ])->all(),
        ];

        $related = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get()
            ->map(fn (Product $item) => self::toCard($item))
            ->all();

        return view('storefront.products.show', ['product' => $productData, 'related' => $related]);
    }

    public static function toCard(Product $product): array
    {
        return [
            'slug' => $product->slug,
            'name' => $product->name,
            'category' => $product->category?->name,
            'image' => $product->image,
            'regularPrice' => (float) $product->regular_price,
            'salePrice' => $product->sale_price !== null ? (float) $product->sale_price : null,
            'rating' => (float) $product->rating,
            'ratingCount' => $product->rating_count,
            'badge' => $product->badge,
        ];
    }
}
