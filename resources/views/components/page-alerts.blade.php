@props([
    'formatStatus' => false,
    'firstErrorOnly' => false,
])

@if (session('status'))
    <div {{ $attributes->class('rounded-md border border-teal-300 bg-teal-50 px-4 py-3 text-sm font-medium text-teal-900 dark:border-teal-800 dark:bg-teal-950 dark:text-teal-100') }}>
        {{ $formatStatus ? str_replace('-', ' ', session('status')) : session('status') }}
    </div>
@endif

@if ($errors->any())
    <div {{ $attributes->class('rounded-md border border-red-300 bg-red-50 px-4 py-3 text-sm text-red-900 dark:border-red-800 dark:bg-red-950 dark:text-red-100') }}>
        @if ($firstErrorOnly)
            {{ $errors->first() }}
        @else
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>
@endif
