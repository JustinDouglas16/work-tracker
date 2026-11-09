<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Two-Factor Challenge | Work Tracker</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="min-h-screen bg-zinc-100 text-zinc-950 antialiased">
    <main class="mx-auto flex min-h-screen w-full max-w-md flex-col justify-center px-4 py-8">
        <section class="rounded-md border border-zinc-300 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-teal-700">Two-factor authentication</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-normal text-zinc-950">Enter your code</h1>
            <p class="mt-3 text-sm leading-6 text-zinc-600">Open Google Authenticator and enter the current six-digit code.</p>

            <?php if($errors->any()): ?>
                <div class="mt-5 rounded-md border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-900">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('two-factor.login.store')); ?>" class="mt-6 flex flex-col gap-4">
                <?php echo csrf_field(); ?>
                <label>
                    <span class="mb-1 block text-sm font-medium text-zinc-700">Authenticator code</span>
                    <input name="code" inputmode="numeric" autocomplete="one-time-code" autofocus class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100">
                </label>
                <button class="rounded-md bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white hover:bg-zinc-800">
                    Verify
                </button>
            </form>
        </section>
    </main>
</body>

</html>
<?php /**PATH C:\wamp64\www\work-tracker\resources\views\two-factor-challenge.blade.php ENDPATH**/ ?>