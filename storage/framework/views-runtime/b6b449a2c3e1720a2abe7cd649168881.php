<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'formatStatus' => false,
    'firstErrorOnly' => false,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'formatStatus' => false,
    'firstErrorOnly' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php if(session('status')): ?>
    <div <?php echo e($attributes->class('rounded-md border border-teal-300 bg-teal-50 px-4 py-3 text-sm font-medium text-teal-900 dark:border-teal-800 dark:bg-teal-950 dark:text-teal-100')); ?>>
        <?php echo e($formatStatus ? str_replace('-', ' ', session('status')) : session('status')); ?>

    </div>
<?php endif; ?>

<?php if($errors->any()): ?>
    <div <?php echo e($attributes->class('rounded-md border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-900 dark:border-red-800 dark:bg-red-950 dark:text-red-100')); ?>>
        <?php if($firstErrorOnly): ?>
            <?php echo e($errors->first()); ?>

        <?php else: ?>
            <ul class="list-inside list-disc">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php /**PATH C:\wamp64\www\work-tracker\resources\views/components/page-alerts.blade.php ENDPATH**/ ?>