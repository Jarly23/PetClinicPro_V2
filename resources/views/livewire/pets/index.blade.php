<div class="space-y-6">

    <!-- Botón para abrir el modal de registro -->
    @livewire('pets.form')

    <!-- Barra de búsqueda -->
    <div class="flex justify-end items-center gap-2">
        <x-input class="w-80 text-stone-700" wire:model.defer="search" placeholder="Buscar mascotas..." />
        <button wire:click="$refresh"
            class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 transition">
            Buscar
        </button>
    </div>

    <!-- Tabla de mascotas -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded shadow">
            <thead class="bg-gray-100">
                <tr>
                    @foreach (['Nombre', 'Especie', 'Raza', 'Edad', 'Dueño', 'Acciones'] as $col)
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">{{ $col }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($pets as $pet)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm">{{ $pet->name }}</td>
                        <td class="px-4 py-2 text-sm">{{ $pet->animaltype->name ?? '-' }}</td>
                        <td class="px-4 py-2 text-sm">{{ $pet->breed }}</td>
                        <td class="px-4 py-2 text-sm">{{ $pet->age }}</td>
                        <td class="px-4 py-2 text-sm">{{ $pet->owner->name }}</td>
                        <td class="px-4 py-2 space-x-2 text-sm">
                            <!-- Botones de acciones -->
                            <x-secondary-button wire:click="edit({{ $pet->id }})">Editar</x-secondary-button>
                            <x-danger-button wire:click="delete({{ $pet->id }})">Eliminar</x-danger-button>

                            <!-- Enlace para ver detalles -->
                            <a href="{{ route('pets.detail', $pet->id) }}" class="text-indigo-600 hover:underline">Ver más</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $pets->links() }}
        </div>
    </div>

</div>
