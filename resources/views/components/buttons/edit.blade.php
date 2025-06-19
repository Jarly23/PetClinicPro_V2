<button
    {{ $attributes->merge(['class' => 'px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 dark:bg-blue-400 dark:hover:bg-blue-500 transition']) }}>
    {{ $slot }}
</button>
