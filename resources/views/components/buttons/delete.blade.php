<button
    {{ $attributes->merge(['class' => 'px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 transition']) }}>
    {{ $slot }}
</button>
