<x-layouts.guest title="Sign In — NEXORA">

    <h1 class="text-2xl font-semibold tracking-tight text-primary-900 dark:text-white">Welcome back</h1>
    <p class="mt-2 text-sm text-primary-500 dark:text-primary-400">Sign in to continue to your account.</p>

    @if ($errors->any())
        <div class="mt-6 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-600 dark:bg-red-500/10 dark:text-red-400">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
        @csrf
        <div>
            <label class="text-xs font-medium text-primary-600 dark:text-primary-300">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="you@example.com" class="mt-1.5 w-full rounded-lg border border-primary-900/15 bg-transparent px-4 py-2.5 text-sm text-primary-900 placeholder:text-primary-400 focus:border-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-600/20 dark:border-white/15 dark:text-white">
        </div>

        <div>
            <div class="flex items-center justify-between">
                <label class="text-xs font-medium text-primary-600 dark:text-primary-300">Password</label>
            </div>
            <input type="password" name="password" required placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" class="mt-1.5 w-full rounded-lg border border-primary-900/15 bg-transparent px-4 py-2.5 text-sm text-primary-900 placeholder:text-primary-400 focus:border-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-600/20 dark:border-white/15 dark:text-white">
        </div>

        <label class="flex items-center gap-2.5 text-sm text-primary-600 dark:text-primary-300">
            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-primary-300 text-accent-600 focus:ring-accent-600/30 dark:border-primary-600 dark:bg-primary-800">
            Remember me
        </label>

        <button type="submit" class="btn-accent w-full">Sign In</button>
    </form>

    <p class="mt-8 text-center text-sm text-primary-500 dark:text-primary-400">
        Don't have an account?
        <a href="{{ route('register') }}" class="font-medium text-accent-600 hover:underline">Create one</a>
    </p>

</x-layouts.guest>
