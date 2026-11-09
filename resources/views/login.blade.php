<x-layouts.guest title="Login | Work Tracker">
        <section class="rounded-md border border-zinc-300 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-medium text-teal-700 dark:text-teal-400">{{ now()->format('F j, Y') }}</p>
                    <h1 class="mt-2 text-3xl font-semibold tracking-normal text-zinc-950 dark:text-zinc-50">Work Tracker</h1>
                </div>
                <x-theme-toggle />
            </div>
            <p class="mt-3 text-sm leading-6 text-zinc-600 dark:text-zinc-300">Sign in to manage leave, overtime, and earnings.</p>

            <x-page-alerts class="mt-5" first-error-only />

            <form method="POST" action="{{ route('login.store') }}" class="mt-6 flex flex-col gap-4">
                @csrf
                <label>
                    <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Username or work email</span>
                    <input name="login" value="{{ old('login') }}" autocomplete="username" autofocus
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                </label>
                <label>
                    <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Password</span>
                    <input name="password" type="password" autocomplete="current-password"
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                </label>
                <button class="rounded-md bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white hover:bg-zinc-800 dark:bg-teal-600 dark:text-zinc-950 dark:hover:bg-teal-500">
                    Log in
                </button>
            </form>
        </section>
</x-layouts.guest>
