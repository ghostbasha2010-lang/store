@php
    $columns = [
        'Shop' => ['Men', 'Women', 'Kids', 'Shoes', 'Accessories', 'New Arrivals'],
        'Help' => ['Track Order', 'Shipping & Returns', 'Size Guide', 'FAQs', 'Contact Us'],
        'Company' => ['About NEXORA', 'Careers', 'Sustainability', 'Press'],
    ];
@endphp

<footer class="border-t border-primary-900/5 bg-white dark:border-white/10 dark:bg-primary-900/20">

    <!-- Newsletter -->
    <div class="border-b border-primary-900/5 dark:border-white/10">
        <div class="container-nexora flex flex-col items-center justify-between gap-6 py-12 lg:flex-row">
            <div class="text-center lg:text-left">
                <h3 class="text-xl font-semibold text-primary-900 dark:text-white">Join the NEXORA list</h3>
                <p class="mt-1 text-sm text-primary-500 dark:text-primary-300">Get early access to new drops and exclusive offers.</p>
            </div>
            <form class="flex w-full max-w-md gap-2">
                <input type="email" placeholder="Enter your email" class="w-full rounded-full border border-primary-900/15 bg-transparent px-5 py-3 text-sm text-primary-900 placeholder:text-primary-400 focus:border-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-600/20 dark:border-white/15 dark:text-white" />
                <button type="submit" class="btn-primary shrink-0">Subscribe</button>
            </form>
        </div>
    </div>

    <div class="container-nexora grid grid-cols-2 gap-10 py-14 sm:grid-cols-2 lg:grid-cols-5">
        <div class="col-span-2">
            <span class="text-2xl font-extrabold tracking-tight text-primary-900 dark:text-white">NEXORA</span>
            <p class="mt-4 max-w-xs text-sm leading-relaxed text-primary-500 dark:text-primary-300">
                Modern, premium clothing designed for everyday confidence. Crafted with care, made to last.
            </p>
            <div class="mt-6 flex gap-3">
                @foreach (['M 4 4 h16 v16 h-16 z', 'M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Z'] as $icon)
                    <a href="#" class="flex h-9 w-9 items-center justify-center rounded-full border border-primary-900/10 text-primary-500 transition-colors hover:border-accent-600 hover:text-accent-600 dark:border-white/15 dark:text-primary-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" /></svg>
                    </a>
                @endforeach
            </div>
        </div>

        @foreach ($columns as $heading => $items)
            <div>
                <h4 class="text-sm font-semibold uppercase tracking-wide text-primary-900 dark:text-white">{{ $heading }}</h4>
                <ul class="mt-4 space-y-3">
                    @foreach ($items as $item)
                        <li>
                            <a href="#" class="text-sm text-primary-500 transition-colors hover:text-accent-600 dark:text-primary-300 dark:hover:text-accent-400">{{ $item }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <div class="border-t border-primary-900/5 py-6 dark:border-white/10">
        <div class="container-nexora flex flex-col items-center justify-between gap-3 text-xs text-primary-400 sm:flex-row dark:text-primary-500">
            <p>&copy; {{ date('Y') }} NEXORA. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#" class="hover:text-accent-600">Privacy Policy</a>
                <a href="#" class="hover:text-accent-600">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
