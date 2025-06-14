<div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-md space-y-6">
    <h1 class="text-2xl font-bold text-center text-gray-800">Configuración de Tipos de Animales</h1>

    @if (session()->has('message'))
        <div class="text-green-600 text-center font-medium">{{ session('message') }}</div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Tipo</label>
            <input wire:model="name" id="name" type="text"
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            <x-input-error for="name" />
        </div>

        <div class="flex items-end justify-center sm:justify-start">
            @if ($editing)
                <x-button wire:click="update">Actualizar</x-button>
            @else
                <x-button wire:click="save">Guardar</x-button>
            @endif
            <span wire:loading class="ml-2 text-sm text-gray-500">Guardando...</span>
        </div>
    </div>

    <hr class="my-4">

    <h2 class="text-lg font-semibold text-center text-gray-700">Listado de Tipos de Animales</h2>
    <ul class="space-y-2">
        @foreach ($types as $type)
            <li class="flex justify-between items-center border-b pb-1">
                <span class="text-gray-800">{{ $type->name }}</span>
                <div class="space-x-2">
                    <button wire:click="edit({{ $type->id }})" class="text-blue-600 text-sm hover:underline">Editar</button>
                    <button wire:click="delete({{ $type->id }})" class="text-red-600 text-sm hover:underline">Eliminar</button>
                </div>
            </li>
        @endforeach
    </ul>
</div>
