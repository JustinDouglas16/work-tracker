<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Work Tracker']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Work Tracker']); ?>
        <header class="flex flex-col gap-4 border-b border-zinc-300 pb-5 sm:flex-row sm:items-end sm:justify-between dark:border-zinc-800">
            <div>
                <p class="text-sm font-medium text-teal-700 dark:text-teal-400"><?php echo e(now()->format('F j, Y')); ?></p>
                <h1 class="text-3xl font-semibold tracking-normal text-zinc-950 dark:text-zinc-50">Work Tracker</h1>
            </div>
            <div class="flex flex-wrap items-center gap-2 text-sm text-zinc-600 dark:text-zinc-300">
                <?php if (isset($component)) { $__componentOriginal2090438866f3dcdb76cd8b070bcc302d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2090438866f3dcdb76cd8b070bcc302d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.theme-toggle','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('theme-toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2090438866f3dcdb76cd8b070bcc302d)): ?>
<?php $attributes = $__attributesOriginal2090438866f3dcdb76cd8b070bcc302d; ?>
<?php unset($__attributesOriginal2090438866f3dcdb76cd8b070bcc302d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2090438866f3dcdb76cd8b070bcc302d)): ?>
<?php $component = $__componentOriginal2090438866f3dcdb76cd8b070bcc302d; ?>
<?php unset($__componentOriginal2090438866f3dcdb76cd8b070bcc302d); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal279b9df2be2d916f4fc9962bfd966981 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal279b9df2be2d916f4fc9962bfd966981 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.privacy-toggle','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('privacy-toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal279b9df2be2d916f4fc9962bfd966981)): ?>
<?php $attributes = $__attributesOriginal279b9df2be2d916f4fc9962bfd966981; ?>
<?php unset($__attributesOriginal279b9df2be2d916f4fc9962bfd966981); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal279b9df2be2d916f4fc9962bfd966981)): ?>
<?php $component = $__componentOriginal279b9df2be2d916f4fc9962bfd966981; ?>
<?php unset($__componentOriginal279b9df2be2d916f4fc9962bfd966981); ?>
<?php endif; ?>
                <span data-private class="rounded-md border border-zinc-300 bg-white px-3 py-2 transition duration-200 dark:border-zinc-700 dark:bg-zinc-900"><?php echo e(auth()->user()->email); ?></span>
                <a href="<?php echo e(route('settings.edit')); ?>" class="rounded-md border border-zinc-300 bg-white px-3 py-2 font-semibold text-zinc-700 hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800">Settings</a>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button class="rounded-md border border-zinc-300 bg-white px-3 py-2 font-semibold text-zinc-700 hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800">
                        Log out
                    </button>
                </form>
            </div>
        </header>

        <?php if (isset($component)) { $__componentOriginalcbb98ebbc7cbab738c49c1b78f3af3fa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcbb98ebbc7cbab738c49c1b78f3af3fa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-alerts','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-alerts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
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

        <section class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm font-medium text-zinc-600 dark:text-zinc-300">Paid leave balance</p>
                <p class="mt-2 text-4xl font-semibold text-zinc-950 dark:text-zinc-50"><?php echo e(number_format((float) $leaveSetting->paid_leave_balance, 2)); ?></p>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">Last accrued <?php echo e($leaveSetting->last_accrued_month); ?>/<?php echo e($leaveSetting->last_accrued_year); ?></p>
            </div>
            <div class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm font-medium text-zinc-600 dark:text-zinc-300">Overtime hours</p>
                <p class="mt-2 text-4xl font-semibold text-zinc-950 dark:text-zinc-50"><?php echo e(number_format((float) $overtimeHours, 2)); ?></p>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400"><?php echo e($overtimeEntries->count()); ?> entries</p>
            </div>
            <div class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <p class="text-sm font-medium text-zinc-600 dark:text-zinc-300">Earnings total</p>
                <p data-private class="mt-2 text-4xl font-semibold text-zinc-950 transition duration-200 dark:text-zinc-50">$<?php echo e(number_format((float) $earningsTotal, 2)); ?></p>
                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400"><?php echo e($earnings->count()); ?> records</p>
            </div>
        </section>

        <section class="grid grid-cols-1 gap-6 xl:grid-cols-[1fr_1.4fr]">
            <div class="flex flex-col gap-6">
                <form method="POST" action="<?php echo e(route('leave-settings.update')); ?>" class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <h2 class="text-lg font-semibold text-zinc-950 dark:text-zinc-50">Balance</h2>
                    <div class="mt-4 flex gap-3">
                        <label class="min-w-0 flex-1">
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Paid days</span>
                            <input name="paid_leave_balance" type="number" min="0" step="0.25" value="<?php echo e(old('paid_leave_balance', $leaveSetting->paid_leave_balance)); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                        <button class="mt-6 rounded-md bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800 dark:bg-teal-600 dark:text-zinc-950 dark:hover:bg-teal-500">Save</button>
                    </div>
                </form>

                <form method="POST" action="<?php echo e(route('leaves.store')); ?>" class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <?php echo csrf_field(); ?>
                    <h2 class="text-lg font-semibold text-zinc-950 dark:text-zinc-50">Leave</h2>
                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Type</span>
                            <select name="leave_type_id" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                                <?php $__currentLoopData = $leaveTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leaveType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($leaveType->id); ?>" <?php if(old('leave_type_id') == $leaveType->id): echo 'selected'; endif; ?>><?php echo e(str_replace('_', ' ', $leaveType->name)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Start</span>
                            <input name="start_date" type="date" value="<?php echo e(old('start_date', now()->toDateString())); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">End</span>
                            <input name="end_date" type="date" value="<?php echo e(old('end_date', now()->toDateString())); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Reason</span>
                            <input name="reason" value="<?php echo e(old('reason')); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                    </div>
                    <button class="mt-4 rounded-md bg-zinc-950 px-4 py-2 text-sm font-semibold text-white hover:bg-zinc-800 dark:bg-teal-600 dark:text-zinc-950 dark:hover:bg-teal-500">Add leave</button>
                </form>

                <form method="POST" action="<?php echo e(route('overtime-entries.store')); ?>" class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <?php echo csrf_field(); ?>
                    <h2 class="text-lg font-semibold text-zinc-950 dark:text-zinc-50">Overtime</h2>
                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Date</span>
                            <input name="work_date" type="date" value="<?php echo e(old('work_date', now()->toDateString())); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Start</span>
                            <input name="start_time" type="time" value="<?php echo e(old('start_time', '17:00')); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">End</span>
                            <input name="end_time" type="time" value="<?php echo e(old('end_time', '19:00')); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                    </div>
                    <label class="mt-3 block">
                        <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Notes</span>
                        <input name="notes" value="<?php echo e(old('notes')); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                    </label>
                    <button class="mt-4 rounded-md bg-zinc-950 px-4 py-2 text-sm font-semibold text-white hover:bg-zinc-800 dark:bg-teal-600 dark:text-zinc-950 dark:hover:bg-teal-500">Add overtime</button>
                </form>

                <form method="POST" action="<?php echo e(route('earnings.store')); ?>" class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <?php echo csrf_field(); ?>
                    <h2 class="text-lg font-semibold text-zinc-950 dark:text-zinc-50">Earnings</h2>
                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Pay date</span>
                            <input name="pay_date" type="date" value="<?php echo e(old('pay_date', now()->toDateString())); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Currency</span>
                            <input name="currency" maxlength="3" value="<?php echo e(old('currency', 'USD')); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm uppercase outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Base</span>
                            <input name="base_amount" type="number" min="0" step="0.01" value="<?php echo e(old('base_amount', 0)); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Bonus</span>
                            <input name="bonus_amount" type="number" min="0" step="0.01" value="<?php echo e(old('bonus_amount', 0)); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                        <label class="sm:col-span-2">
                            <span class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Overtime pay</span>
                            <input name="overtime_pay_amount" type="number" min="0" step="0.01" value="<?php echo e(old('overtime_pay_amount', 0)); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100 dark:focus:border-teal-500 dark:focus:ring-teal-900">
                        </label>
                    </div>
                    <button class="mt-4 rounded-md bg-zinc-950 px-4 py-2 text-sm font-semibold text-white hover:bg-zinc-800 dark:bg-teal-600 dark:text-zinc-950 dark:hover:bg-teal-500">Add earnings</button>
                </form>
            </div>

            <div class="flex flex-col gap-6">
                <section class="rounded-md border border-zinc-300 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <div class="border-b border-zinc-200 px-5 py-4 dark:border-zinc-800">
                        <h2 class="text-lg font-semibold text-zinc-950 dark:text-zinc-50">Leave history</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-170 text-left text-sm">
                            <thead class="bg-zinc-50 text-xs uppercase text-zinc-500 dark:bg-zinc-950 dark:text-zinc-400">
                                <tr>
                                    <th class="px-5 py-3">Type</th>
                                    <th class="px-5 py-3">Dates</th>
                                    <th class="px-5 py-3">Days</th>
                                    <th class="px-5 py-3">Reason</th>
                                    <th class="px-5 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                <?php $__empty_1 = true; $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="px-5 py-3 font-medium"><?php echo e(str_replace('_', ' ', $leave->leaveType->name)); ?></td>
                                        <td class="px-5 py-3 text-zinc-600 dark:text-zinc-300"><?php echo e($leave->start_date->toDateString()); ?> to <?php echo e($leave->end_date->toDateString()); ?></td>
                                        <td class="px-5 py-3"><?php echo e($leave->days_used); ?></td>
                                        <td class="max-w-55 truncate px-5 py-3 text-zinc-600 dark:text-zinc-300"><?php echo e($leave->reason ?: 'None'); ?></td>
                                        <td class="px-5 py-3 text-right">
                                            <form method="POST" action="<?php echo e(route('leaves.destroy', $leave)); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button class="rounded-md border border-red-300 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50 dark:border-red-800 dark:text-red-300 dark:hover:bg-red-950">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="px-5 py-8 text-center text-zinc-500 dark:text-zinc-400">No leave entries</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <div class="rounded-md border border-zinc-300 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                        <div class="border-b border-zinc-200 px-5 py-4 dark:border-zinc-800">
                            <h2 class="text-lg font-semibold text-zinc-950 dark:text-zinc-50">Overtime</h2>
                        </div>
                        <div class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            <?php $__empty_1 = true; $__currentLoopData = $overtimeEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="px-5 py-4">
                                    <div class="flex items-center justify-between gap-3">
                                        <p class="font-medium"><?php echo e($entry->work_date->toDateString()); ?></p>
                                        <p class="text-sm font-semibold text-teal-700 dark:text-teal-400"><?php echo e(number_format((float) $entry->hours_worked, 2)); ?>h</p>
                                    </div>
                                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300"><?php echo e(substr($entry->start_time, 0, 5)); ?> to <?php echo e(substr($entry->end_time, 0, 5)); ?></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="px-5 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">No overtime entries</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="rounded-md border border-zinc-300 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                        <div class="border-b border-zinc-200 px-5 py-4 dark:border-zinc-800">
                            <h2 class="text-lg font-semibold text-zinc-950 dark:text-zinc-50">Earnings</h2>
                        </div>
                        <div class="divide-y divide-zinc-200 dark:divide-zinc-800">
                            <?php $__empty_1 = true; $__currentLoopData = $earnings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $earning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="px-5 py-4">
                                    <div class="flex items-center justify-between gap-3">
                                        <p class="font-medium"><?php echo e($earning->pay_date->toDateString()); ?></p>
                                        <p data-private class="text-sm font-semibold text-teal-700 transition duration-200 dark:text-teal-400"><?php echo e($earning->currency); ?> <?php echo e(number_format((float) $earning->base_amount + (float) $earning->bonus_amount + (float) $earning->overtime_pay_amount, 2)); ?></p>
                                    </div>
                                    <p data-private class="mt-1 text-sm text-zinc-600 transition duration-200 dark:text-zinc-300">Base <?php echo e(number_format((float) $earning->base_amount, 2)); ?> · Bonus <?php echo e(number_format((float) $earning->bonus_amount, 2)); ?> · OT <?php echo e(number_format((float) $earning->overtime_pay_amount, 2)); ?></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="px-5 py-8 text-center text-sm text-zinc-500 dark:text-zinc-400">No earnings records</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
            </div>
        </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>


<?php /**PATH C:\wamp64\www\work-tracker\resources\views/dashboard.blade.php ENDPATH**/ ?>