<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Work Tracker</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="min-h-screen bg-zinc-100 text-zinc-950 antialiased">
    <main class="mx-auto flex w-full max-w-7xl flex-col gap-6 px-4 py-6 sm:px-6 lg:px-8">
        <header class="flex flex-col gap-4 border-b border-zinc-300 pb-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium text-teal-700"><?php echo e(now()->format('F j, Y')); ?></p>
                <h1 class="text-3xl font-semibold tracking-normal text-zinc-950">Work Tracker</h1>
            </div>
            <div class="flex flex-wrap items-center gap-2 text-sm text-zinc-600">
                <span class="rounded-md border border-zinc-300 bg-white px-3 py-2"><?php echo e(auth()->user()->email); ?></span>
                <a href="<?php echo e(route('settings.edit')); ?>" class="rounded-md border border-zinc-300 bg-white px-3 py-2 font-semibold text-zinc-700 hover:bg-zinc-50">Settings</a>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button class="rounded-md border border-zinc-300 bg-white px-3 py-2 font-semibold text-zinc-700 hover:bg-zinc-50">
                        Log out
                    </button>
                </form>
            </div>
        </header>

        <?php if(session('status')): ?>
            <div class="rounded-md border border-teal-300 bg-teal-50 px-4 py-3 text-sm font-medium text-teal-900">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="rounded-md border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-900">
                <ul class="list-inside list-disc">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <section class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-zinc-600">Paid leave balance</p>
                <p class="mt-2 text-4xl font-semibold text-zinc-950"><?php echo e(number_format((float) $leaveSetting->paid_leave_balance, 2)); ?></p>
                <p class="mt-1 text-sm text-zinc-500">Last accrued <?php echo e($leaveSetting->last_accrued_month); ?>/<?php echo e($leaveSetting->last_accrued_year); ?></p>
            </div>
            <div class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-zinc-600">Overtime hours</p>
                <p class="mt-2 text-4xl font-semibold text-zinc-950"><?php echo e(number_format((float) $overtimeHours, 2)); ?></p>
                <p class="mt-1 text-sm text-zinc-500"><?php echo e($overtimeEntries->count()); ?> entries</p>
            </div>
            <div class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-zinc-600">Earnings total</p>
                <p class="mt-2 text-4xl font-semibold text-zinc-950">$<?php echo e(number_format((float) $earningsTotal, 2)); ?></p>
                <p class="mt-1 text-sm text-zinc-500"><?php echo e($earnings->count()); ?> records</p>
            </div>
        </section>

        <section class="grid grid-cols-1 gap-6 xl:grid-cols-[1fr_1.4fr]">
            <div class="flex flex-col gap-6">
                <form method="POST" action="<?php echo e(route('leave-settings.update')); ?>" class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <h2 class="text-lg font-semibold text-zinc-950">Balance</h2>
                    <div class="mt-4 flex gap-3">
                        <label class="min-w-0 flex-1">
                            <span class="mb-1 block text-sm font-medium text-zinc-700">Paid days</span>
                            <input name="paid_leave_balance" type="number" min="0" step="0.25" value="<?php echo e(old('paid_leave_balance', $leaveSetting->paid_leave_balance)); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100">
                        </label>
                        <button class="mt-6 rounded-md bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800">Save</button>
                    </div>
                </form>

                <form method="POST" action="<?php echo e(route('leaves.store')); ?>" class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm">
                    <?php echo csrf_field(); ?>
                    <h2 class="text-lg font-semibold text-zinc-950">Leave</h2>
                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700">Type</span>
                            <select name="leave_type_id" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100">
                                <?php $__currentLoopData = $leaveTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leaveType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($leaveType->id); ?>" <?php if(old('leave_type_id') == $leaveType->id): echo 'selected'; endif; ?>><?php echo e(str_replace('_', ' ', $leaveType->name)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700">Start</span>
                            <input name="start_date" type="date" value="<?php echo e(old('start_date', now()->toDateString())); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700">End</span>
                            <input name="end_date" type="date" value="<?php echo e(old('end_date', now()->toDateString())); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700">Reason</span>
                            <input name="reason" value="<?php echo e(old('reason')); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100">
                        </label>
                    </div>
                    <button class="mt-4 rounded-md bg-zinc-950 px-4 py-2 text-sm font-semibold text-white hover:bg-zinc-800">Add leave</button>
                </form>

                <form method="POST" action="<?php echo e(route('overtime-entries.store')); ?>" class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm">
                    <?php echo csrf_field(); ?>
                    <h2 class="text-lg font-semibold text-zinc-950">Overtime</h2>
                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-3">
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700">Date</span>
                            <input name="work_date" type="date" value="<?php echo e(old('work_date', now()->toDateString())); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700">Start</span>
                            <input name="start_time" type="time" value="<?php echo e(old('start_time', '17:00')); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700">End</span>
                            <input name="end_time" type="time" value="<?php echo e(old('end_time', '19:00')); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100">
                        </label>
                    </div>
                    <label class="mt-3 block">
                        <span class="mb-1 block text-sm font-medium text-zinc-700">Notes</span>
                        <input name="notes" value="<?php echo e(old('notes')); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100">
                    </label>
                    <button class="mt-4 rounded-md bg-zinc-950 px-4 py-2 text-sm font-semibold text-white hover:bg-zinc-800">Add overtime</button>
                </form>

                <form method="POST" action="<?php echo e(route('earnings.store')); ?>" class="rounded-md border border-zinc-300 bg-white p-5 shadow-sm">
                    <?php echo csrf_field(); ?>
                    <h2 class="text-lg font-semibold text-zinc-950">Earnings</h2>
                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700">Pay date</span>
                            <input name="pay_date" type="date" value="<?php echo e(old('pay_date', now()->toDateString())); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700">Currency</span>
                            <input name="currency" maxlength="3" value="<?php echo e(old('currency', 'USD')); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm uppercase outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700">Base</span>
                            <input name="base_amount" type="number" min="0" step="0.01" value="<?php echo e(old('base_amount', 0)); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100">
                        </label>
                        <label>
                            <span class="mb-1 block text-sm font-medium text-zinc-700">Bonus</span>
                            <input name="bonus_amount" type="number" min="0" step="0.01" value="<?php echo e(old('bonus_amount', 0)); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100">
                        </label>
                        <label class="sm:col-span-2">
                            <span class="mb-1 block text-sm font-medium text-zinc-700">Overtime pay</span>
                            <input name="overtime_pay_amount" type="number" min="0" step="0.01" value="<?php echo e(old('overtime_pay_amount', 0)); ?>" class="w-full rounded-md border border-zinc-300 bg-white px-3 py-2 text-sm outline-none focus:border-teal-600 focus:ring-2 focus:ring-teal-100">
                        </label>
                    </div>
                    <button class="mt-4 rounded-md bg-zinc-950 px-4 py-2 text-sm font-semibold text-white hover:bg-zinc-800">Add earnings</button>
                </form>
            </div>

            <div class="flex flex-col gap-6">
                <section class="rounded-md border border-zinc-300 bg-white shadow-sm">
                    <div class="border-b border-zinc-200 px-5 py-4">
                        <h2 class="text-lg font-semibold text-zinc-950">Leave history</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-170 text-left text-sm">
                            <thead class="bg-zinc-50 text-xs uppercase text-zinc-500">
                                <tr>
                                    <th class="px-5 py-3">Type</th>
                                    <th class="px-5 py-3">Dates</th>
                                    <th class="px-5 py-3">Days</th>
                                    <th class="px-5 py-3">Reason</th>
                                    <th class="px-5 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200">
                                <?php $__empty_1 = true; $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="px-5 py-3 font-medium"><?php echo e(str_replace('_', ' ', $leave->leaveType->name)); ?></td>
                                        <td class="px-5 py-3 text-zinc-600"><?php echo e($leave->start_date->toDateString()); ?> to <?php echo e($leave->end_date->toDateString()); ?></td>
                                        <td class="px-5 py-3"><?php echo e($leave->days_used); ?></td>
                                        <td class="max-w-55 truncate px-5 py-3 text-zinc-600"><?php echo e($leave->reason ?: 'None'); ?></td>
                                        <td class="px-5 py-3 text-right">
                                            <form method="POST" action="<?php echo e(route('leaves.destroy', $leave)); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button class="rounded-md border border-red-300 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-50">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="px-5 py-8 text-center text-zinc-500">No leave entries</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <div class="rounded-md border border-zinc-300 bg-white shadow-sm">
                        <div class="border-b border-zinc-200 px-5 py-4">
                            <h2 class="text-lg font-semibold text-zinc-950">Overtime</h2>
                        </div>
                        <div class="divide-y divide-zinc-200">
                            <?php $__empty_1 = true; $__currentLoopData = $overtimeEntries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="px-5 py-4">
                                    <div class="flex items-center justify-between gap-3">
                                        <p class="font-medium"><?php echo e($entry->work_date->toDateString()); ?></p>
                                        <p class="text-sm font-semibold text-teal-700"><?php echo e(number_format((float) $entry->hours_worked, 2)); ?>h</p>
                                    </div>
                                    <p class="mt-1 text-sm text-zinc-600"><?php echo e(substr($entry->start_time, 0, 5)); ?> to <?php echo e(substr($entry->end_time, 0, 5)); ?></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="px-5 py-8 text-center text-sm text-zinc-500">No overtime entries</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="rounded-md border border-zinc-300 bg-white shadow-sm">
                        <div class="border-b border-zinc-200 px-5 py-4">
                            <h2 class="text-lg font-semibold text-zinc-950">Earnings</h2>
                        </div>
                        <div class="divide-y divide-zinc-200">
                            <?php $__empty_1 = true; $__currentLoopData = $earnings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $earning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="px-5 py-4">
                                    <div class="flex items-center justify-between gap-3">
                                        <p class="font-medium"><?php echo e($earning->pay_date->toDateString()); ?></p>
                                        <p class="text-sm font-semibold text-teal-700"><?php echo e($earning->currency); ?> <?php echo e(number_format((float) $earning->base_amount + (float) $earning->bonus_amount + (float) $earning->overtime_pay_amount, 2)); ?></p>
                                    </div>
                                    <p class="mt-1 text-sm text-zinc-600">Base <?php echo e(number_format((float) $earning->base_amount, 2)); ?> · Bonus <?php echo e(number_format((float) $earning->bonus_amount, 2)); ?> · OT <?php echo e(number_format((float) $earning->overtime_pay_amount, 2)); ?></p>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <p class="px-5 py-8 text-center text-sm text-zinc-500">No earnings records</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </main>
</body>

</html>
<?php /**PATH C:\wamp64\www\work-tracker\resources\views\dashboard.blade.php ENDPATH**/ ?>