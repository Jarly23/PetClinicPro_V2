<div>
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Enfermedades</h2>

    <form wire:submit.prevent="save" class="mb-4 space-y-3">
        <div>
            <label class="block text-sm font-medium text-gray-600">Nombre</label>
            <input type="text" wire:model="name" class="w-full input input-bordered" />
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex space-x-2">
            <button class="bg-blue-700 p-3 text-white rounded-xl" type="submit">{{ $editMode ? 'Actualizar' : 'Agregar' }}</button>
            @if($editMode)
                <button type="button" class="bg-red-700 p-3 text-white rounded-xl" wire:click="resetForm">Cancelar</button>
            @endif
        </div>
    </form>

    <div class="divide-y">
        @foreach ($diseases as $disease)
            <div class="py-2 flex justify-between items-center">
                <div class="text-gray-800">{{ $disease->name }}</div>
                <div class="space-x-2">
                    <button class="text-blue-500 hover:underline text-sm" wire:click="edit({{ $disease->id }})">Editar</button>
                    <button class="text-red-500 hover:underline text-sm" wire:click="delete({{ $disease->id }})">Eliminar</button>
                </div>
            </div>
        @endforeach
    </div>
</div>
