<x-layouts.guest title="Two-Factor Challenge | Work Tracker">
        <section class="rounded-md border border-zinc-300 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <p class="text-sm font-medium text-teal-700 dark:text-teal-400">Two-factor authentication</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-normal text-zinc-950 dark:text-zinc-50">Enter your code</h1>
            <p class="mt-3 text-sm leading-6 text-zinc-600 dark:text-zinc-300">Open Google Authenticator and enter the current six-digit code.</p>

            <x-page-alerts class="mt-5" first-error-only />

            <form method="POST" action="{{ route('two-factor.login.store') }}" class="mt-6 flex flex-col gap-4">
                @csrf
                <label>
                    <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Authenticator code</span>
                    <input name="code" inputmode="numeric" autocomplete="one-time-code" autofocus class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                </label>
                <button class="rounded-md bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white hover:bg-zinc-800 dark:bg-teal-600 dark:text-zinc-950 dark:hover:bg-teal-500">
                    Verify
                </button>
            </form>
        </section>
</x-layouts.guest>
