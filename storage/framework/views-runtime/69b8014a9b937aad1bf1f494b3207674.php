<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Work Tracker</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="min-h-screen bg-zinc-100 text-zinc-950 antialiased">
    <main class="mx-auto flex min-h-screen w-full max-w-md flex-col justify-center px-4 py-8">
        <section class="rounded-md border border-zinc-300 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-teal-700"><?php echo e(now()->format('F j, Y')); ?></p>
            <h1 class="mt-2 text-3xl font-semibold tracking-normal text-zinc-950">Work Tracker</h1>
            <p class="mt-3 text-sm leading-6 text-zinc-600">Sign in to manage leave, overtime, and earnings.</p>

            <?php if(session('status')): ?>
                <div class="mt-5 rounded-md border border-teal-300 bg-teal-50 px-4 py-3 text-sm font-medium text-teal-900">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="mt-5 rounded-md border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-900">
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login.store')); ?>" class="mt-6 flex flex-col gap-4">
                <?php echo csrf_field(); ?>
                <label>
                    <span class="mb-1 block text-sm font-medium text-zinc-700">Username or work email</span>
                    <input name="login" value="<?php echo e(old('login')); ?>" autocomplete="username" autofocus
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100">
                </label>
                <label>
                    <span class="mb-1 block text-sm font-medium text-zinc-700">Password</span>
                    <input name="password" type="password" autocomplete="current-password"
                        class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100">
                </label>
                <button class="rounded-md bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white hover:bg-zinc-800">
                    Log in
                </button>
            </form>
        </section>
    </main>
</body>

</html>
<?php /**PATH C:\wamp64\www\work-tracker\resources\views\login.blade.php ENDPATH**/ ?>