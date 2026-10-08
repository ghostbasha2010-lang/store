@php
    $categories = \App\Models\Category::orderBy('name')->pluck('name');
    $sizes = ['S', 'M', 'L', 'XL'];
    $colors = [
        'Black' => '#111827',
        'Navy' => '#1e3a8a',
        'Beige' => '#d6c7ae',
    ];

    $activeCategories = (array) request()->query('category', []);
    $activeSizes = (array) request()->query('size', []);
    $activeColors = (array) request()->query('color', []);
@endphp

<div class="space-y-8">

    {{-- Category --}}
    <div>
        <h3 class="text-sm font-semibold text-primary-900 dark:text-white">Category</h3>
        <div class="mt-3 space-y-2.5">
            @foreach ($categories as $category)
                <label class="flex items-center gap-2.5 text-sm text-primary-600 dark:text-primary-300">
                    <input type="checkbox" name="category[]" value="{{ $category }}" {{ in_array($category, $activeCategories) ? 'checked' : '' }} class="h-4 w-4 rounded border-primary-300 text-accent-600 focus:ring-accent-600/30 dark:border-primary-600 dark:bg-primary-800">
                    {{ $category }}
                </label>
            @endforeach
        </div>
    </div>

    {{-- Price range --}}
    <div>
        <h3 class="text-sm font-semibold text-primary-900 dark:text-white">Price Range</h3>
        <div class="mt-3 flex items-center gap-3">
            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="$0" class="w-full rounded-lg border border-primary-900/15 bg-transparent px-3 py-2 text-sm text-primary-900 placeholder:text-primary-400 focus:border-accent-600 focus:outline-none dark:border-white/15 dark:text-white">
            <span class="text-primary-400">&mdash;</span>
            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="$500" class="w-full rounded-lg border border-primary-900/15 bg-transparent px-3 py-2 text-sm text-primary-900 placeholder:text-primary-400 focus:border-accent-600 focus:outline-none dark:border-white/15 dark:text-white">
        </div>
    </div>

    {{-- Size --}}
    <div>
        <h3 class="text-sm font-semibold text-primary-900 dark:text-white">Size</h3>
        <div class="mt-3 grid grid-cols-4 gap-2">
            @foreach ($sizes as $size)
                <label class="relative">
                    <input type="checkbox" name="size[]" value="{{ $size }}" {{ in_array($size, $activeSizes) ? 'checked' : '' }} class="peer sr-only">
                    <span class="block cursor-pointer rounded-lg border border-primary-900/15 py-2 text-center text-sm font-medium text-primary-700 transition-colors hover:border-accent-600 hover:text-accent-600 peer-checked:border-accent-600 peer-checked:bg-accent-600 peer-checked:text-white dark:border-white/15 dark:text-primary-200">
                        {{ $size }}
                    </span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Color --}}
    <div>
        <h3 class="text-sm font-semibold text-primary-900 dark:text-white">Color</h3>
        <div class="mt-3 flex flex-wrap gap-2.5">
            @foreach ($colors as $name => $hex)
                <label class="relative" title="{{ $name }}">
                    <input type="checkbox" name="color[]" value="{{ $name }}" {{ in_array($name, $activeColors) ? 'checked' : '' }} class="peer sr-only">
                    <span class="block h-7 w-7 cursor-pointer rounded-full ring-1 ring-primary-900/10 ring-offset-2 ring-offset-white transition-shadow hover:ring-2 hover:ring-accent-600 peer-checked:ring-2 peer-checked:ring-accent-600 dark:ring-offset-primary-900" style="background-color: {{ $hex }}"></span>
                </label>
            @endforeach
        </div>
    </div>

    <button type="submit" class="btn-primary w-full">Apply Filters</button>
    <a href="{{ route('products.index') }}" class="block w-full text-center text-sm font-medium text-primary-400 hover:text-accent-600">Clear all</a>
</div>
