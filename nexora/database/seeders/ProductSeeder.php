<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    private const SIZES = ['S', 'M', 'L', 'XL'];

    private const COLORS = [
        ['name' => 'Black', 'hex' => '#111827'],
        ['name' => 'Navy', 'hex' => '#1e3a8a'],
        ['name' => 'Beige', 'hex' => '#d6c7ae'],
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Men', 'image' => 'https://images.unsplash.com/photo-1516257984-b1b4d707412e?q=80&w=800&auto=format&fit=crop'],
            ['name' => 'Women', 'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=800&auto=format&fit=crop'],
            ['name' => 'Kids', 'image' => 'https://images.unsplash.com/photo-1519238263530-99bdd11df2ea?q=80&w=800&auto=format&fit=crop'],
            ['name' => 'Shoes', 'image' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?q=80&w=800&auto=format&fit=crop'],
            ['name' => 'Accessories', 'image' => 'https://images.unsplash.com/photo-1611923134239-b9be5816e23c?q=80&w=800&auto=format&fit=crop'],
        ];

        $categoryModels = collect($categories)->mapWithKeys(function (array $category) {
            $model = Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                ['name' => $category['name'], 'image' => $category['image']],
            );

            return [$category['name'] => $model];
        });

        $products = [
            ['slug' => 'tailored-wool-overcoat', 'name' => 'Tailored Wool Overcoat', 'category' => 'Men', 'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=800&auto=format&fit=crop', 'regularPrice' => 249.00, 'salePrice' => null, 'rating' => 4.8, 'ratingCount' => 132, 'badge' => 'Featured'],
            ['slug' => 'silk-blend-midi-dress', 'name' => 'Silk Blend Midi Dress', 'category' => 'Women', 'image' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=800&auto=format&fit=crop', 'regularPrice' => 189.00, 'salePrice' => 149.00, 'rating' => 4.9, 'ratingCount' => 87, 'badge' => null],
            ['slug' => 'essential-cotton-tee', 'name' => 'Essential Cotton Tee', 'category' => 'Men', 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=800&auto=format&fit=crop', 'regularPrice' => 39.00, 'salePrice' => null, 'rating' => 4.6, 'ratingCount' => 305, 'badge' => null],
            ['slug' => 'kids-denim-jacket', 'name' => 'Kids Denim Jacket', 'category' => 'Kids', 'image' => 'https://images.unsplash.com/photo-1519238263530-99bdd11df2ea?q=80&w=800&auto=format&fit=crop', 'regularPrice' => 79.00, 'salePrice' => null, 'rating' => 4.7, 'ratingCount' => 54, 'badge' => 'New'],
            ['slug' => 'leather-chelsea-boots', 'name' => 'Leather Chelsea Boots', 'category' => 'Shoes', 'image' => 'https://images.unsplash.com/photo-1638247025967-b4e38f787b76?q=80&w=800&auto=format&fit=crop', 'regularPrice' => 219.00, 'salePrice' => null, 'rating' => 4.9, 'ratingCount' => 211, 'badge' => null],
            ['slug' => 'structured-leather-bag', 'name' => 'Structured Leather Bag', 'category' => 'Accessories', 'image' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?q=80&w=800&auto=format&fit=crop', 'regularPrice' => 159.00, 'salePrice' => null, 'rating' => 4.7, 'ratingCount' => 76, 'badge' => null],
            ['slug' => 'relaxed-linen-shirt', 'name' => 'Relaxed Linen Shirt', 'category' => 'Men', 'image' => 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?q=80&w=800&auto=format&fit=crop', 'regularPrice' => 69.00, 'salePrice' => null, 'rating' => 4.5, 'ratingCount' => 98, 'badge' => null],
            ['slug' => 'high-waist-tailored-trousers', 'name' => 'High-Waist Tailored Trousers', 'category' => 'Women', 'image' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?q=80&w=800&auto=format&fit=crop', 'regularPrice' => 99.00, 'salePrice' => null, 'rating' => 4.8, 'ratingCount' => 63, 'badge' => 'Featured'],
            ['slug' => 'cropped-puffer-jacket', 'name' => 'Cropped Puffer Jacket', 'category' => 'Women', 'image' => 'https://images.unsplash.com/photo-1544923246-77307dd654cb?q=80&w=800&auto=format&fit=crop', 'regularPrice' => 179.00, 'salePrice' => 99.00, 'rating' => 4.6, 'ratingCount' => 45, 'badge' => '-45%'],
            ['slug' => 'slim-fit-chinos', 'name' => 'Slim Fit Chinos', 'category' => 'Men', 'image' => 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?q=80&w=800&auto=format&fit=crop', 'regularPrice' => 79.00, 'salePrice' => 49.00, 'rating' => 4.5, 'ratingCount' => 88, 'badge' => '-38%'],
            ['slug' => 'running-sneakers', 'name' => 'Running Sneakers', 'category' => 'Shoes', 'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=800&auto=format&fit=crop', 'regularPrice' => 129.00, 'salePrice' => 89.00, 'rating' => 4.7, 'ratingCount' => 156, 'badge' => '-31%'],
            ['slug' => 'wool-blend-scarf', 'name' => 'Wool Blend Scarf', 'category' => 'Accessories', 'image' => 'https://images.unsplash.com/photo-1520903920243-00d872a2d1c9?q=80&w=800&auto=format&fit=crop', 'regularPrice' => 45.00, 'salePrice' => 29.00, 'rating' => 4.4, 'ratingCount' => 34, 'badge' => '-36%'],
        ];

        $galleryPool = [
            'https://images.unsplash.com/photo-1516257984-b1b4d707412e?q=80&w=800&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1520975954732-35dd22299614?q=80&w=800&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1487222477894-8943e31ef7b2?q=80&w=800&auto=format&fit=crop',
        ];

        $reviewPool = [
            ['name' => 'Amira K.', 'rating' => 5, 'comment' => 'Fits perfectly and the fabric feels premium. Exactly as pictured.'],
            ['name' => 'David R.', 'rating' => 4, 'comment' => 'Great quality, shipping was fast. Would size up slightly.'],
        ];

        foreach ($products as $data) {
            $product = Product::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'category_id' => $categoryModels[$data['category']]->id,
                    'name' => $data['name'],
                    'image' => $data['image'],
                    'description' => 'Crafted from premium materials with meticulous attention to detail, this piece blends timeless design with modern comfort. Designed to layer effortlessly and built to last well beyond a single season.',
                    'regular_price' => $data['regularPrice'],
                    'sale_price' => $data['salePrice'],
                    'rating' => $data['rating'],
                    'rating_count' => $data['ratingCount'],
                    'badge' => $data['badge'],
                ],
            );

            foreach ($galleryPool as $index => $url) {
                $product->images()->updateOrCreate(
                    ['url' => $url],
                    ['sort_order' => $index],
                );
            }

            foreach (self::SIZES as $size) {
                foreach (self::COLORS as $color) {
                    $product->variants()->updateOrCreate(
                        ['size' => $size, 'color' => $color['name']],
                        ['color_hex' => $color['hex'], 'stock' => rand(0, 20)],
                    );
                }
            }

            if ($product->reviews()->count() === 0) {
                foreach ($reviewPool as $review) {
                    $product->reviews()->create($review);
                }
            }
        }
    }
}
