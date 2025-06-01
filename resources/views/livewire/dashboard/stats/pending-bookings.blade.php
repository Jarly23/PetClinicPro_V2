<div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-3  bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6">
    <div class="flex justify-between">
        <h5 class="text-xl text-gray-400">{{ $title }}</h5>
        <img src="{{ asset($icon) }}" alt="Ícono personalizado" class="w-6 h-6 mr-2">
    </div>
    <p class="text-2xl text-black dark:text-white font-bold">{{ $value }}</p>
    <p class="flex items-center mt-2 text-gray-500 dark:text-gray-300">
        <img src="{{ asset($secondIcon) }}" alt="Ícono adicional" class="w-6 h-6 mr-2">
        {{ $additionalData }}
    </p>
</div>
