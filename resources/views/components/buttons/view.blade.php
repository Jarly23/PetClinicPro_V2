<button
    {{ $attributes->merge(['class' => 'px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 transition']) }}>
    {{ $slot }}
</button>
