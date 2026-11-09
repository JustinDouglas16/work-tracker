@props([
    'title' => 'Work Tracker',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <x-theme-script />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-zinc-100 text-zinc-950 antialiased dark:bg-zinc-950 dark:text-zinc-100">
    <main {{ $attributes->merge(['class' => 'mx-auto flex min-h-screen w-full max-w-md flex-col justify-center px-4 py-8']) }}>
        {{ $slot }}
    </main>
</body>

</html>
