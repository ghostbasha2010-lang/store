<x-layouts.guest title="Create Account — NEXORA">

    <h1 class="text-2xl font-semibold tracking-tight text-primary-900 dark:text-white">Create your account</h1>
    <p class="mt-2 text-sm text-primary-500 dark:text-primary-400">Join NEXORA for a faster checkout and order tracking.</p>

    @if ($errors->any())
        <div class="mt-6 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-600 dark:bg-red-500/10 dark:text-red-400">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
        @csrf
        <div>
            <label class="text-xs font-medium text-primary-600 dark:text-primary-300">Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Jane Doe" class="mt-1.5 w-full rounded-lg border border-primary-900/15 bg-transparent px-4 py-2.5 text-sm text-primary-900 placeholder:text-primary-400 focus:border-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-600/20 dark:border-white/15 dark:text-white">
        </div>

        <div>
            <label class="text-xs font-medium text-primary-600 dark:text-primary-300">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="you@example.com" class="mt-1.5 w-full rounded-lg border border-primary-900/15 bg-transparent px-4 py-2.5 text-sm text-primary-900 placeholder:text-primary-400 focus:border-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-600/20 dark:border-white/15 dark:text-white">
        </div>

        <div>
            <label class="text-xs font-medium text-primary-600 dark:text-primary-300">Password</label>
            <input type="password" name="password" required placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" class="mt-1.5 w-full rounded-lg border border-primary-900/15 bg-transparent px-4 py-2.5 text-sm text-primary-900 placeholder:text-primary-400 focus:border-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-600/20 dark:border-white/15 dark:text-white">
        </div>

        <div>
            <label class="text-xs font-medium text-primary-600 dark:text-primary-300">Confirm Password</label>
            <input type="password" name="password_confirmation" required placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" class="mt-1.5 w-full rounded-lg border border-primary-900/15 bg-transparent px-4 py-2.5 text-sm text-primary-900 placeholder:text-primary-400 focus:border-accent-600 focus:outline-none focus:ring-2 focus:ring-accent-600/20 dark:border-white/15 dark:text-white">
        </div>

        <button type="submit" class="btn-accent w-full">Create Account</button>
    </form>

    <p class="mt-8 text-center text-sm text-primary-500 dark:text-primary-400">
        Already have an account?
        <a href="{{ route('login') }}" class="font-medium text-accent-600 hover:underline">Sign in</a>
    </p>

</x-layouts.guest>
