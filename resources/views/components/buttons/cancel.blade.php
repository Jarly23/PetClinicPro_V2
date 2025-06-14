<button
    {{ $attributes->merge(['class' => 'px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 dark:bg-gray-600 dark:hover:bg-gray-500 transition']) }}>
    {{ $slot }}
</button>
