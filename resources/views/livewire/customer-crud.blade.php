<div>
    {{-- Botón para registrar cliente --}}
    @can('clientes.create')
        <x-danger-button wire:click="$set('open',true)">
            ➕ Registrar Cliente
        </x-danger-button>
    @endcan

    {{-- Barra de búsqueda --}}
    <div class="flex items-center space-x-2 mt-4 max-w-3xl">
        <x-input class="py-2 px-2 w-80 text-stone-700" wire:model.defer="search" placeholder="Buscar clientes..." />
        <x-buttons.search wire:click="searchCustomer">
            Buscar
        </x-buttons.search>
    </div>
    {{-- Modal de registro/edición de cliente --}}
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100">Información del Cliente</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ $customer_id ? 'Editar Cliente' : 'Registrar Nuevo Cliente' }}</p>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="name"
                            class="block text-sm font-medium text-gray-900 dark:text-gray-400">Nombres</label>
                        <input wire:model="name" id="name" type="text" autocomplete="given-name"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-600 focus:border-indigo-600 dark:bg-gray-700">
                        <x-input-error for="name" />
                    </div>

                    <div>
                        <label for="lastname"
                            class="block text-sm font-medium text-gray-900 dark:text-gray-400">Apellidos</label>
                        <input wire:model="lastname" id="lastname" type="text" autocomplete="family-name"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-600 focus:border-indigo-600 dark:bg-gray-700">
                        <x-input-error for="lastname" />
                    </div>


                    <div>
                        <label for="phone"
                            class="block text-sm font-medium text-gray-900 dark:text-gray-400">Teléfono</label>
                        <input wire:model="phone" id="phone" type="tel" autocomplete="phone"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-600 focus:border-indigo-600 dark:bg-gray-700">
                        <x-input-error for="phone" />
                    </div>

                    <div>
                        <label for="dni"
                            class="block text-sm font-medium text-gray-900 dark:text-gray-400">DNI</label>
                        <input wire:model="dniruc" id="dniruc" maxlength="8" placeholder="Ingrese su DNI"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-600 focus:border-indigo-600 dark:bg-gray-700">
                        <x-input-error for="dniruc" />
                    </div>

                    <div class="sm:col-span-2">
                        <label for="address"
                            class="block text-sm font-medium text-gray-900 dark:text-gray-400">Dirección</label>
                        <input wire:model="address" id="address" type="text" autocomplete="street-address"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-600 focus:border-indigo-600 dark:bg-gray-700">
                        <x-input-error for="address" />
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-buttons.cancel class="mr-2" wire:click="cancel">Cancelar</x-buttons.cancel>
            <x-buttons.create wire:click="save" wire:loading.attr="disabled">
                {{ $customer_id ? 'Actualizar' : 'Guardar' }}
            </x-buttons.create>
            <span wire:loading class="text-sm text-gray-500 ml-2">Guardando...</span>
        </x-slot>
    </x-dialog-modal>

    {{-- Tabla de clientes --}}
    <div
        class="hidden md:block relative w-full overflow-x-auto mt-6 bg-white dark:bg-gray-800 shadow-md rounded-lg transition-colors duration-300">
        @if ($customers->count())
            <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                <thead class="bg-gray-100 dark:bg-gray-900 text-xs uppercase text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-3">Nombres</th>
                        <th class="px-4 py-3">Apellidos</th>
                        <th class="px-4 py-3">Teléfono</th>
                        <th class="px-4 py-3">Dirección</th>
                        <th class="px-4 py-3">DNI</th>
                        <th class="px-4 py-3">Acción</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($customers as $customer)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-4 py-2">{{ $customer->name }}</td>
                            <td class="px-4 py-2">{{ $customer->lastname }}</td>
                            <td class="px-4 py-2">{{ $customer->phone }}</td>
                            <td class="px-4 py-2">{{ $customer->address }}</td>
                            <td class="px-4 py-2">{{ $customer->dniruc }}</td>
                            <td class="px-4 py-2 flex space-x-2">
                                @can('clientes.edit')
                                    <x-buttons.edit wire:click="edit({{ $customer->id }})">Editar</x-buttons.edit>
                                @endcan
                                @can('clientes.destroy')
                                    <x-buttons.delete wire:click="delete({{ $customer->id }})">Eliminar</x-buttons.delete>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Paginación --}}
            <div class="mt-4 px-4">
                {{ $customers->links() }}
            </div>
        @else
            <div class="flex items-center justify-center w-full h-32 text-center text-lg text-gray-600">
                No hay clientes registrados.
            </div>
        @endif
    </div>
    <!-- Mostrar tarjetas solo en móviles -->
    <div class="md:hidden space-y-4 mt-4">
        @foreach ($customers as $customer)
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Nombres:</strong> {{ $customer->name }}</p>
                <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Apellidos:</strong>
                    {{ $customer->lastname }}</p>
                <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Teléfono:</strong> {{ $customer->phone }}
                </p>
                <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Dirección:</strong>
                    {{ $customer->address }}</p>
                <p class="text-sm text-gray-700 dark:text-gray-300"><strong>DNI:</strong> {{ $customer->dniruc }}</p>
                <div class="flex mt-2 space-x-2">
                    @can('clientes.edit')
                        <x-buttons.edit wire:click="edit({{ $customer->id }})">Editar</x-buttons.edit>
                    @endcan
                    @can('clientes.destroy')
                        <x-buttons.delete wire:click="delete({{ $customer->id }})">Eliminar</x-buttons.delete>
                    @endcan
                </div>
            </div>
        @endforeach
    </div>
</div>
