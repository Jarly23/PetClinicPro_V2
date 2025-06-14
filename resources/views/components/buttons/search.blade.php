<button
    {{ $attributes->merge(['class' => 'px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 transition']) }}>
    {{ $slot }}
</button>
