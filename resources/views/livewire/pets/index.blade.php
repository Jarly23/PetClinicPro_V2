<div class="space-y-6">

    @livewire('pets.form')

    <!-- Filtros y búsqueda -->
    <div class="flex justify-end items-center gap-2">
        <div x-data="{ open: true }" class="relative w-80">
            <x-input wire:model="search" placeholder="Buscar mascotas..." class="w-full text-stone-700" @click="open = true"
                @click.away="open = false" />

            @if (strlen($search) > 1 && count($results) > 0)
                <ul x-show="open"
                    class="absolute z-10 bg-white border rounded shadow w-full max-h-60 overflow-y-auto mt-1">
                    @foreach ($results as $result)
                        <li wire:click="selectSuggestion('{{ $result->name }}')"
                            class="px-4 py-2 hover:bg-gray-100 cursor-pointer dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100 dark:hover:bg-gray-700">
                            {{ $result->name }} - {{ $result->owner->name }} {{ $result->owner->lastname }}
                        </li>
                    @endforeach
                </ul>
            @elseif(strlen($search) > 1)
                <div x-show="open"
                    class="absolute z-10 bg-white border rounded shadow w-full mt-1 px-4 py-2 text-sm text-gray-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100">
                    Sin resultados
                </div>
            @endif
        </div>

        <!-- Filtro por tipo -->
        <select wire:model="typeFilter" class="text-sm border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100">
            <option value="">Todas las especies</option>
            @foreach ($animalTypes as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>

        <!-- Filtro por dueño -->
        <select wire:model="ownerFilter" class="text-sm border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100">
            <option value="">Todos los dueños</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }} {{ $customer->lastname }}</option>
            @endforeach
        </select>

        <x-buttons.search wire:click="$refresh">Buscar</x-buttons.search>
    </div>

    <!-- Tabla -->
    <div class="overflow-x-auto bg-white shadow rounded-md dark:bg-gray-700 borrder-4">
        <table class="min-w-full bg-white  rounded shadow dark:bg-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-800">
                <tr>
                    @foreach (['Fecha de registro','Id','Nombre', 'Especie', 'Raza', 'Edad', 'Dueño', 'Acciones'] as $col)
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-100">{{ $col }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($pets as $pet)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-2 text-sm">{{ $pet->created_at }}</td>
                        <td class="px-4 py-2 text-sm">{{$pet->id}}</td>
                        <td class="px-4 py-2 text-sm">{{ $pet->name }}</td>
                        <td class="px-4 py-2 text-sm">{{ $pet->animaltype->name ?? '-' }}</td>
                        <td class="px-4 py-2 text-sm">{{ $pet->breed }}</td>
                        <td class="px-4 py-2 text-sm">{{ $pet->age }}</td>
                        <td class="px-4 py-2 text-sm">{{ $pet->owner->name }} {{ $pet->owner->lastname }}</td>
                        <td class="px-4 py-2 space-x-2 text-sm">
                            @can('mascotas.edit')
                                <x-buttons.edit wire:click="edit({{ $pet->id }})">Editar</x-buttons.edit>
                            @endcan
                            @can('mascotas.destroy')
                                <x-buttons.delete wire:click="delete({{ $pet->id }})">Eliminar</x-buttons.delete>
                            @endcan
                            <x-buttons.view>
                                <a href="{{ route('pets.detail', $pet->id) }}">Ver más</a>
                            </x-buttons.view>
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
