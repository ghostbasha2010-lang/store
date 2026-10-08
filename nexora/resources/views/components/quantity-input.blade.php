@props(['value' => 1, 'max' => 99, 'name' => null])

<div x-data="{ qty: {{ $value }}, max: {{ $max }}, commit() { $el.closest('form')?.requestSubmit(); } }" class="inline-flex items-center rounded-full border border-primary-900/15 dark:border-white/15">
    @if ($name)
        <input type="hidden" name="{{ $name }}" :value="qty">
    @endif
    <button type="button" @click="qty = Math.max(1, qty - 1); commit()" class="flex h-10 w-10 items-center justify-center text-primary-600 transition-colors hover:text-accent-600 dark:text-primary-300" aria-label="Decrease quantity">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M5 12h14" /></svg>
    </button>
    <span x-text="qty" class="w-8 text-center text-sm font-medium text-primary-900 dark:text-white"></span>
    <button type="button" @click="qty = Math.min(max, qty + 1); commit()" class="flex h-10 w-10 items-center justify-center text-primary-600 transition-colors hover:text-accent-600 dark:text-primary-300" aria-label="Increase quantity">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M12 5v14M5 12h14" /></svg>
    </button>
</div>
