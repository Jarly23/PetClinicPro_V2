<div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-md space-y-6 dark:bg-gray-800">
    <h1 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-100">Configuración de Tipos de Animales</h1>

    @if (session()->has('message'))
        <div class="text-green-600 text-center font-medium dark:text-green-400">{{ session('message') }}</div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del Tipo</label>
            <input wire:model="name" id="name" type="text"
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
            <x-input-error for="name" />
        </div>

        <div class="flex items-end justify-center sm:justify-start">
            @if ($editing)
                <x-buttons.create wire:click="update">Actualizar</x-buttons.create>
            @else
                <x-buttons.create wire:click="save">Guardar</x-buttons.create>
            @endif
            <span wire:loading class="ml-2 text-sm text-gray-500 dark:text-gray-400">Guardando...</span>
        </div>
    </div>

    <hr class="my-4 border-gray-200 dark:border-gray-700">

    <h2 class="text-lg font-semibold text-center text-gray-700 dark:text-gray-300">Listado de Tipos de Animales</h2>
    <ul class="space-y-2">
        @foreach ($types as $type)
            <li class="flex justify-between items-center border-b pb-1 border-gray-200 dark:border-gray-700">
                <span class="text-gray-800 dark:text-gray-200">{{ $type->name }}</span>
                <div class="space-x-2">
                    <x-buttons.edit wire:click="edit({{ $type->id }})">Editar</x-buttons.edit>
                    <x-buttons.delete wire:click="delete({{ $type->id }})">Eliminar</x-buttons.delete>
                </div> 
            </li>
        @endforeach
    </ul>
</div>
