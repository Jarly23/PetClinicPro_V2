<div class="max-w-2xl mx-auto px-4">
    <h2 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-100">Vacunas</h2>

    <form wire:submit.prevent="save" class="mb-6 space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Nombre</label>
            <input type="text" wire:model="name" class="w-full input input-bordered dark:bg-gray-700" />
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Descripción</label>
            <textarea wire:model="description" class="w-full input input-bordered dark:bg-gray-700"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Intervalo de aplicación (días)</label>
            <input type="number" wire:model="application_interval_days" class="w-full input input-bordered dark:bg-gray-700" />
            @error('application_interval_days')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Enfermedades asociadas</label>
            <select wire:model="disease_ids" multiple class="w-full input input-bordered dark:bg-gray-700">
                @foreach ($diseases as $disease)
                    <option value="{{ $disease->id }}">{{ $disease->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col sm:flex-row gap-2">
            <x-buttons.create type="submit">
                {{ $editMode ? 'Actualizar' : 'Agregar' }}
            </x-buttons.create>

            @if ($editMode)
                <x-buttons.cancel type="button"  wire:click="resetForm">
                    Cancelar
                </x-buttons.cancel>
            @endif
        </div>
    </form>

    <div class="divide-y">
        @foreach ($vaccines as $vaccine)
            <div class="py-3">
                <div class="p-4 shadow-md rounded-md flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white dark:bg-gray-800">
                    <div>
                        <strong class="text-gray-800 dark:text-white">{{ $vaccine->name }}</strong>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Intervalo: {{ $vaccine->application_interval_days }} días</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Enfermedades:
                            {{ $vaccine->diseases->pluck('name')->join(', ') ?: 'Ninguna' }}
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <x-buttons.edit wire:click="edit({{ $vaccine->id }})" class="w-full sm:w-auto">Editar</x-buttons.edit>
                        <x-buttons.delete wire:click="delete({{ $vaccine->id }})" class="w-full sm:w-auto">Eliminar</x-buttons.delete>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
