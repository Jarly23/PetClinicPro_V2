<div class="space-y-6">
    <h1 class="text-xl font-semibold">Configuración de Tipos de Animales</h1>

    @if (session()->has('message'))
        <div class="text-green-600">{{ session('message') }}</div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-900">Nombre del Tipo</label>
            <input wire:model="name" id="name" type="text"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-600 focus:border-indigo-600">
            <x-input-error for="name" />
        </div>

        <div class="flex items-end">
            @if ($editing)
                <x-button wire:click="update">Actualizar</x-button>
            @else
                <x-button wire:click="save">Guardar</x-button>
            @endif
            <span wire:loading class="ml-2 text-sm text-gray-500">Guardando...</span>
        </div>
    </div>

    <hr class="my-4">

    <h2 class="text-lg font-semibold">Listado</h2>
    <ul class="space-y-2">
        @foreach ($types as $type)
            <li class="flex justify-between items-center border-b pb-1">
                <span>{{ $type->name }}</span>
                <div class="space-x-2">
                    <button wire:click="edit({{ $type->id }})" class="text-blue-600 text-sm">Editar</button>
                    <button wire:click="delete({{ $type->id }})" class="text-red-600 text-sm">Eliminar</button>
                </div>
            </li>
        @endforeach
    </ul>
</div>
