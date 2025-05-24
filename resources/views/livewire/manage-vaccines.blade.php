<div>
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Vacunas</h2>

    <form wire:submit.prevent="save" class="mb-4 space-y-3">
        <div>
            <label class="block text-sm font-medium text-gray-600">Nombre</label>
            <input type="text" wire:model="name" class="w-full input input-bordered" />
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Descripción</label>
            <textarea wire:model="description" class="w-full input input-bordered"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600">Intervalo de aplicación (días)</label>
            <input type="number" wire:model="application_interval_days" class="w-full input input-bordered" />
            @error('application_interval_days') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Enfermedades asociadas</label>
            <select wire:model="disease_ids" multiple class="w-full input input-bordered">
                @foreach ($diseases as $disease)
                    <option value="{{ $disease->id }}">{{ $disease->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex space-x-2">
            <button class="bg-blue-700 p-3 text-white rounded-xl" type="submit">{{ $editMode ? 'Actualizar' : 'Agregar' }}</button>
            @if($editMode)
                <button type="button" class="bg-red-700 p-3 text-white rounded-xl" wire:click="resetForm">Cancelar</button>
            @endif
        </div>
    </form>

    <div class="divide-y">
        @foreach ($vaccines as $vaccine)
            <div class="py-2">
                <div class="flex justify-between p-4 items-center  shadow-md">
                    <div>
                        <strong class="text-gray-800">{{ $vaccine->name }}</strong>
                        <p class="text-sm text-gray-600">Intervalo: {{ $vaccine->application_interval_days }} días</p>
                        <p class="text-sm text-gray-600">Enfermedades: {{ $vaccine->diseases->pluck('name')->join(', ') ?: 'Ninguna' }}</p>
                    </div>
                    <div class="space-x-2">
                        <button class="text-blue-500 hover:underline text-sm" wire:click="edit({{ $vaccine->id }})">Editar</button>
                        <button class="text-red-500 hover:underline text-sm" wire:click="delete({{ $vaccine->id }})">Eliminar</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
