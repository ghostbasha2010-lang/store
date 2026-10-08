@props(['regularPrice', 'salePrice' => null, 'size' => 'md'])

@php
    $onSale = !is_null($salePrice) && (float) $salePrice < (float) $regularPrice;
    $discount = $onSale ? round((($regularPrice - $salePrice) / $regularPrice) * 100) : 0;
    $priceClass = match ($size) {
        'lg' => 'text-2xl',
        'sm' => 'text-sm',
        default => 'text-base',
    };
@endphp

<div class="flex items-center gap-2">
    <span class="{{ $priceClass }} font-semibold text-primary-900 dark:text-white">
        ${{ number_format($onSale ? $salePrice : $regularPrice, 2) }}
    </span>

    @if ($onSale)
        <span class="text-sm text-primary-400 line-through dark:text-primary-500">
            ${{ number_format($regularPrice, 2) }}
        </span>
        <span class="rounded-full bg-red-50 px-2 py-0.5 text-xs font-semibold text-red-600 dark:bg-red-500/10 dark:text-red-400">
            -{{ $discount }}%
        </span>
    @endif
</div>
