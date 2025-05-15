<div class="space-y-6">
    <!-- Botón para registrar mascota -->
    <div>
        <x-danger-button wire:click="create">Registrar Mascota</x-danger-button>
    </div>

    <!-- Mensaje si no hay mascotas -->
    @if ($pets->isEmpty())
        <div class="text-center text-2xl font-semibold text-gray-700 py-10">
            No hay mascotas registradas.
        </div>
    @else
        <!-- Barra de búsqueda -->
        <div class="flex justify-end items-center gap-2">
            <x-input class="w-80 text-stone-700" wire:model.defer="search" placeholder="Buscar mascotas..." />
            <button wire:click="searchPets"
                class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 transition">
                Buscar
            </button>
        </div>
    @endif

    <!-- Tabla de mascotas -->
    @if ($pets->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded shadow">
                <thead class="bg-gray-100">
                    <tr>
                        @foreach (['Nombre', 'Especie', 'Raza', 'Edad', 'Peso', 'Dueño', 'Acciones'] as $col)
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">{{ $col }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pets as $pet)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm">{{ $pet->name }}</td>
                            <td class="px-4 py-2 text-sm">{{ $pet->species }}</td>
                            <td class="px-4 py-2 text-sm">{{ $pet->breed }}</td>
                            <td class="px-4 py-2 text-sm">{{ $pet->age }}</td>
                            <td class="px-4 py-2 text-sm">{{ $pet->weight }} kg</td>
                            <td class="px-4 py-2 text-sm">{{ $pet->owner->name }}</td>
                            <td class="px-4 py-2 space-x-2 text-sm">
                                <x-secondary-button wire:click="edit({{ $pet->id }})">Editar</x-secondary-button>
                                <x-danger-button wire:click="delete({{ $pet->id }})">Eliminar</x-danger-button>
                                <a href="{{ route('pets.history', $pet->id) }}"
                                    class="text-indigo-600 hover:underline">Ver historial</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $pets->links() }}
            </div>
        </div>
    @endif

    <!-- Modal para gestión de mascotas -->
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            <h2 class="text-lg font-semibold text-gray-900">Registrar Mascota</h2>
        </x-slot>

        <x-slot name="content">
            <!-- Componente Livewire para buscar propietario -->
            <livewire:client-search/>

            <!-- Datos de la mascota -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                <x-form-group label="Nombre de la mascota">
                    <x-input wire:model="name" type="text" />
                    <x-input-error for="name" />
                </x-form-group>
                <x-form-group label="Especie">
                    <select id="animal_type_id" wire:model="animal_type_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                        <option value="">Selecciona un tipo de animal</option>
                        @foreach ($animalTypes as $animalType)
                            <option value="{{ $animalType->id }}">{{ $animalType->name }}</option>
                        @endforeach
                    </select>
                    @error('animal_type_id')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror

                    <x-input-error for="species" />
                </x-form-group>
                <x-form-group label="Raza">
                    <x-input wire:model="breed" type="text" />
                    <x-input-error for="breed" />
                </x-form-group>
                <x-form-group label="Edad">
                    <x-input wire:model="age" type="number" />
                    <x-input-error for="age" />
                </x-form-group>
  
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('open', false)">Cancelar</x-secondary-button>
            <x-button wire:click="savePet" type="button">Guardar Mascota</x-button> </x-slot>
    </x-dialog-modal>
</div>
