<div class="flex flex-col col-span-full sm:col-span-6  bg-white  dark:bg-gray-800 shadow-sm rounded-xl p-6">
    <div class="flex justify-between">
        <h5 class="text-xl text-gray-400">{{ $title }}</h5>
        <img src="{{ asset($icon) }}" alt="Ícono" class="w-6 h-6 mr-2">
    </div>

    <p class="text-2xl text-black dark:text-white font-bold">S/ {{ number_format($value, 2) }}</p>
    <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">
        Total generado por servicios prestados
    </p>
</div>
