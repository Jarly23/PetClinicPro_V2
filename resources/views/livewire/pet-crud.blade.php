<div>
    <!-- Registrar Mascota Button -->
    <div class="mb-4">
        <x-danger-button wire:click="create">Registrar Mascota</x-danger-button>
    </div>

    <!-- Modal para la gestión de mascotas -->
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            <h2 class="text-lg font-semibold text-gray-900">Gestión de Mascotas</h2>
        </x-slot>

        <x-slot name="content">
            <form>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Nombre de la mascota -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-900">Nombre</label>
                        <input wire:model="name" type="text" class="w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <x-input-error for="name" />
                    </div>

                    <!-- Especie -->
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-900">Especie</label>
                        <input wire:model="species" type="text" class="w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <x-input-error for="species" />
                    </div>

                    <!-- Raza -->
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-900">Raza</label>
                        <input wire:model="breed" type="text" class="w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <x-input-error for="breed" />
                    </div>

                    <!-- Edad -->
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-900">Edad</label>
                        <input wire:model="age" type="number" class="w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <x-input-error for="age" />
                    </div>

                    <!-- Peso -->
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-900">Peso (kg)</label>
                        <input wire:model="weight" type="number" step="0.01" class="w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <x-input-error for="weight" />
                    </div>

                    <!-- Propietario -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-900">Dueño</label>
                        <select wire:model="owner_id" class="w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Seleccione un propietario</option>
                            @foreach ($owners as $owner)
                                <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="owner_id" />
                    </div>
                </div>
            </form>
        </x-slot>

        <!-- Footer del Modal -->
        <x-slot name="footer">
            <div class="flex justify-end space-x-4">
                <button wire:click="$set('open', false)" class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Cancelar
                </button>
                <button wire:click="{{ $pet_id ? 'update' : 'store' }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Guardar
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>

    <!-- Tabla de Mascotas -->
    <div class="mt-6">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Nombre</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Especie</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Raza</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Edad</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Peso</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Dueño</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pets as $pet)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $pet->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $pet->species }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $pet->breed }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $pet->age }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $pet->weight }} kg</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $pet->owner->name }}</td>
                        <td class="px-4 py-2 text-sm">
                            <button wire:click="edit({{ $pet->id }})" class="text-blue-600 hover:text-blue-800">Editar</button>
                            <button wire:click="delete({{ $pet->id }})" class="ml-2 text-red-600 hover:text-red-800">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $pets->links() }}
        </div>
    </div>
</div>
