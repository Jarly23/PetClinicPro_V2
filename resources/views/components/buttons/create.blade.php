<button
    {{ $attributes->merge(['class' => 'px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition']) }}>
    {{ $slot }}
</button>
