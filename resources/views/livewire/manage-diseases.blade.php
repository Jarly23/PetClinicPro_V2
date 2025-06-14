<div>
    <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-100">Enfermedades</h2>

    <form wire:submit.prevent="save" class="mb-4 space-y-3">
        <div>
            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Nombre</label>
            <input type="text" wire:model="name" class="w-full input input-bordered dark:bg-gray-700" />
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex space-x-2">
            <x-buttons.create class="bg-blue-700 p-3 text-white rounded-xl" type="submit">{{ $editMode ? 'Actualizar' : 'Agregar' }}</x-buttons.create>
            @if($editMode)
                <x-buttons.cancel type="button" class="bg-red-700 p-3 text-white rounded-xl" wire:click="resetForm">Cancelar</x-buttons.cancel>
            @endif
        </div>
    </form>

    <div class="divide-y">
        @foreach ($diseases as $disease)
            <div class="py-2 flex justify-between items-center">
                <div class="text-gray-800 dark:text-gray-400">{{ $disease->name }}</div>
                <div class="space-x-2">
                    <x-buttons.edit  wire:click="edit({{ $disease->id }})">Editar</x-buttons.edit>
                    <x-buttons.delete  wire:click="delete({{ $disease->id }})">Eliminar</x-buttons.delete>
                </div>
            </div>
        @endforeach
    </div>
</div>
