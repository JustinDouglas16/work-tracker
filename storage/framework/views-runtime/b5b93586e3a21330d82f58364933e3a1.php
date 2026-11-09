<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => 'Work Tracker',
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
    'title' => 'Work Tracker',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($title); ?></title>
    <?php if (isset($component)) { $__componentOriginald165ea9fefcd025b5d835007adfd5466 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald165ea9fefcd025b5d835007adfd5466 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.theme-script','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('theme-script'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald165ea9fefcd025b5d835007adfd5466)): ?>
<?php $attributes = $__attributesOriginald165ea9fefcd025b5d835007adfd5466; ?>
<?php unset($__attributesOriginald165ea9fefcd025b5d835007adfd5466); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald165ea9fefcd025b5d835007adfd5466)): ?>
<?php $component = $__componentOriginald165ea9fefcd025b5d835007adfd5466; ?>
<?php unset($__componentOriginald165ea9fefcd025b5d835007adfd5466); ?>
<?php endif; ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="min-h-screen bg-zinc-100 text-zinc-950 antialiased dark:bg-zinc-950 dark:text-zinc-100">
    <main <?php echo e($attributes->merge(['class' => 'mx-auto flex min-h-screen w-full max-w-md flex-col justify-center px-4 py-8'])); ?>>
        <?php echo e($slot); ?>

    </main>
</body>

</html>
<?php /**PATH C:\wamp64\www\work-tracker\resources\views/components/layouts/guest.blade.php ENDPATH**/ ?>