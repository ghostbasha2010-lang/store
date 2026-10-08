@props(['rating' => 0, 'count' => null, 'size' => 'sm'])

@php
    $sizeClass = match ($size) {
        'xs' => 'h-3.5 w-3.5',
        'lg' => 'h-5 w-5',
        default => 'h-4 w-4',
    };
@endphp

<div class="flex items-center gap-1.5">
    <div class="flex items-center gap-0.5">
        @for ($i = 1; $i <= 5; $i++)
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="{{ $sizeClass }} {{ $i <= round($rating) ? 'text-amber-400' : 'text-primary-200 dark:text-primary-700' }}">
                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.454 1.405 1.02L10 15.591l4.069 2.485c.713.435 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
            </svg>
        @endfor
    </div>
    @if ($count !== null)
        <span class="text-xs text-primary-400 dark:text-primary-400">({{ $count }})</span>
    @endif
</div>
