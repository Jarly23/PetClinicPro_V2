<button
    {{ $attributes->merge(['class' => 'px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 dark:bg-yellow-400 dark:hover:bg-yellow-500 transition']) }}>
    {{ $slot }}
</button>
