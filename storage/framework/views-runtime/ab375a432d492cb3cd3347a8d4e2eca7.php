<?php if (isset($component)) { $__componentOriginal1e6834b7596effc838ab3adb1475b477 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1e6834b7596effc838ab3adb1475b477 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.guest','data' => ['title' => 'Two-Factor Challenge | Work Tracker']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.guest'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Two-Factor Challenge | Work Tracker']); ?>
        <section class="rounded-md border border-zinc-300 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <p class="text-sm font-medium text-teal-700 dark:text-teal-400">Two-factor authentication</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-normal text-zinc-950 dark:text-zinc-50">Enter your code</h1>
            <p class="mt-3 text-sm leading-6 text-zinc-600 dark:text-zinc-300">Open Google Authenticator and enter the current six-digit code.</p>

            <?php if (isset($component)) { $__componentOriginalcbb98ebbc7cbab738c49c1b78f3af3fa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcbb98ebbc7cbab738c49c1b78f3af3fa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-alerts','data' => ['class' => 'mt-5','firstErrorOnly' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-alerts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-5','first-error-only' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcbb98ebbc7cbab738c49c1b78f3af3fa)): ?>
<?php $attributes = $__attributesOriginalcbb98ebbc7cbab738c49c1b78f3af3fa; ?>
<?php unset($__attributesOriginalcbb98ebbc7cbab738c49c1b78f3af3fa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcbb98ebbc7cbab738c49c1b78f3af3fa)): ?>
<?php $component = $__componentOriginalcbb98ebbc7cbab738c49c1b78f3af3fa; ?>
<?php unset($__componentOriginalcbb98ebbc7cbab738c49c1b78f3af3fa); ?>
<?php endif; ?>

            <form method="POST" action="<?php echo e(route('two-factor.login.store')); ?>" class="mt-6 flex flex-col gap-4">
                <?php echo csrf_field(); ?>
                <label>
                    <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Authenticator code</span>
                    <input name="code" inputmode="numeric" autocomplete="one-time-code" autofocus class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                </label>
                <button class="rounded-md bg-zinc-950 px-4 py-2.5 text-sm font-semibold text-white hover:bg-zinc-800 dark:bg-teal-600 dark:text-zinc-950 dark:hover:bg-teal-500">
                    Verify
                </button>
            </form>
        </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1e6834b7596effc838ab3adb1475b477)): ?>
<?php $attributes = $__attributesOriginal1e6834b7596effc838ab3adb1475b477; ?>
<?php unset($__attributesOriginal1e6834b7596effc838ab3adb1475b477); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1e6834b7596effc838ab3adb1475b477)): ?>
<?php $component = $__componentOriginal1e6834b7596effc838ab3adb1475b477; ?>
<?php unset($__componentOriginal1e6834b7596effc838ab3adb1475b477); ?>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\work-tracker\resources\views/two-factor-challenge.blade.php ENDPATH**/ ?>