<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Settings | Work Tracker</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="min-h-screen bg-zinc-100 text-zinc-950 antialiased">
    <main class="mx-auto flex w-full max-w-4xl flex-col gap-6 px-4 py-6 sm:px-6 lg:px-8">
        <header class="flex flex-col gap-4 border-b border-zinc-300 pb-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium text-teal-700"><?php echo e(auth()->user()->email); ?></p>
                <h1 class="text-3xl font-semibold tracking-normal text-zinc-950">Settings</h1>
            </div>
            <a href="<?php echo e(route('dashboard')); ?>" class="rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm font-semibold text-zinc-700 hover:bg-zinc-50">Dashboard</a>
        </header>

        <?php if(session('status')): ?>
            <div class="rounded-md border border-teal-300 bg-teal-50 px-4 py-3 text-sm font-medium text-teal-900">
                <?php echo e(str_replace('-', ' ', session('status'))); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="rounded-md border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-900">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <section class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-zinc-950">Two-factor authentication</h2>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-zinc-600">
                        Password remains the first login step. When two-factor authentication is enabled, login also requires a current Google Authenticator code.
                    </p>
                    <p class="mt-3 text-sm font-medium <?php echo e($twoFactorEnabled ? 'text-teal-700' : 'text-zinc-600'); ?>">
                        Status: <?php echo e($twoFactorEnabled ? 'Enabled' : ($twoFactorPending ? 'Waiting for confirmation' : 'Disabled')); ?>

                    </p>
                </div>

                <?php if($twoFactorEnabled || $twoFactorPending): ?>
                    <form method="POST" action="<?php echo e(route('two-factor.disable')); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="rounded-md border border-red-300 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">
                            Disable 2FA
                        </button>
                    </form>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('two-factor.enable')); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="rounded-md bg-zinc-950 px-4 py-2 text-sm font-semibold text-white hover:bg-zinc-800">
                            Enable 2FA
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <?php if($twoFactorPending): ?>
                <div class="mt-6 grid gap-5 border-t border-zinc-200 pt-5 md:grid-cols-[auto_1fr]">
                    <div class="rounded-md border border-zinc-300 bg-white p-3">
                        <?php echo $qrCodeSvg; ?>

                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-zinc-950">Scan and confirm</h3>
                        <p class="mt-2 text-sm leading-6 text-zinc-600">
                            Scan the QR code with Google Authenticator, then enter the generated code to finish enabling two-factor authentication.
                        </p>
                        <p class="mt-3 break-all rounded-md bg-zinc-100 px-3 py-2 font-mono text-xs text-zinc-700"><?php echo e($secretKey); ?></p>

                        <form method="POST" action="<?php echo e(route('two-factor.confirm')); ?>" class="mt-4 flex flex-col gap-3 sm:flex-row">
                            <?php echo csrf_field(); ?>
                            <input name="code" inputmode="numeric" autocomplete="one-time-code" class="min-w-0 flex-1 rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100" placeholder="123456">
                            <button class="rounded-md bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800">
                                Confirm
                            </button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>

</html>
<?php /**PATH C:\wamp64\www\work-tracker\resources\views\settings.blade.php ENDPATH**/ ?>