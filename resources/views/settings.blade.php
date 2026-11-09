<x-layouts.app title="Settings | Work Tracker" max-width="max-w-4xl">
        <header class="flex flex-col gap-4 border-b border-zinc-300 pb-5 sm:flex-row sm:items-end sm:justify-between dark:border-zinc-800">
            <div>
                <p class="text-sm font-medium text-teal-700 dark:text-teal-400">{{ auth()->user()->email }}</p>
                <h1 class="text-3xl font-semibold tracking-normal text-zinc-950 dark:text-zinc-50">Settings</h1>
            </div>
            <div class="flex items-center gap-2">
                <x-theme-toggle />
                <a href="{{ route('dashboard') }}" class="rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm font-semibold text-zinc-700 hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800">Dashboard</a>
            </div>
        </header>

        <x-page-alerts format-status first-error-only />

        <section class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-zinc-950 dark:text-zinc-50">Two-factor authentication</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-zinc-600 dark:text-zinc-300">
                        Password remains the first login step. When two-factor authentication is enabled, login also requires a current Google Authenticator code.
                    </p>
                    <p class="mt-3 text-sm font-medium {{ $twoFactorEnabled ? 'text-teal-700 dark:text-teal-400' : 'text-zinc-600 dark:text-zinc-300' }}">
                        Status: {{ $twoFactorEnabled ? 'Enabled' : ($twoFactorPending ? 'Waiting for confirmation' : 'Disabled') }}
                    </p>
                </div>

                @if ($twoFactorEnabled || $twoFactorPending)
                    <form method="POST" action="{{ route('two-factor.disable') }}">
                        @csrf
                        @method('DELETE')
                        <button class="rounded-md border border-red-300 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50 dark:border-red-800 dark:text-red-300 dark:hover:bg-red-950">
                            Disable 2FA
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('two-factor.enable') }}">
                        @csrf
                        <button class="rounded-md bg-zinc-950 px-4 py-2 text-sm font-semibold text-white hover:bg-zinc-800 dark:bg-teal-600 dark:text-zinc-950 dark:hover:bg-teal-500">
                            Enable 2FA
                        </button>
                    </form>
                @endif
            </div>

            @if ($twoFactorPending)
                <div class="mt-6 grid gap-5 border-t border-zinc-200 pt-5 md:grid-cols-[auto_1fr] dark:border-zinc-800">
                    <div class="rounded-md border border-zinc-300 bg-white p-3 dark:border-zinc-700 dark:bg-white">
                        {!! $qrCodeSvg !!}
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-zinc-950 dark:text-zinc-50">Scan and confirm</h3>
                        <p class="mt-2 text-sm leading-6 text-zinc-600 dark:text-zinc-300">
                            Scan the QR code with Google Authenticator, then enter the generated code to finish enabling two-factor authentication.
                        </p>
                        <p class="mt-3 break-all rounded-md bg-zinc-100 px-3 py-2 font-mono text-xs text-zinc-700 dark:bg-zinc-950 dark:text-zinc-300">{{ $secretKey }}</p>

                        <form method="POST" action="{{ route('two-factor.confirm') }}" class="mt-4 flex flex-col gap-3 sm:flex-row">
                            @csrf
                            <input name="code" inputmode="numeric" autocomplete="one-time-code" class="min-w-0 flex-1 rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900" placeholder="123456">
                            <button class="rounded-md bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800 dark:bg-teal-600 dark:text-zinc-950 dark:hover:bg-teal-500">
                                Confirm
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </section>
</x-layouts.app>
