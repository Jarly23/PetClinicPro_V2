@props(['type' => 'info'])

@php
    $base = match($type) {
        'success' => 'bg-green-100 text-green-800 border-green-300 dark:bg-green-900 dark:text-green-200',
        'error'   => 'bg-red-100 text-red-800 border-red-300 dark:bg-red-900 dark:text-red-200',
        'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-300 dark:bg-yellow-900 dark:text-yellow-200',
        'info'    => 'bg-blue-100 text-blue-800 border-blue-300 dark:bg-blue-900 dark:text-blue-200',
        default   => 'bg-gray-100 text-gray-800 border-gray-300 dark:bg-gray-900 dark:text-gray-200',
    };
@endphp

<div class="p-4 border rounded mb-4 {{ $base }}">
    {{ $slot }}
</div>