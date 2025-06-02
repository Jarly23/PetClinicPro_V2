<div>
    {{-- Botón para registrar cliente --}}
    <x-danger-button wire:click="$set('open',true)">
        ➕ Registrar Cliente
    </x-danger-button>

    {{-- Barra de búsqueda --}}
    <div class="flex items-center space-x-2 mt-4">
        <x-input
            class="py-1 px-2 w-80 text-stone-700"
            wire:model.defer="search"
            placeholder="Buscar clientes..."
        />
        <x-secondary-button wire:click="searchCustomer">
            Buscar
        </x-secondary-button>
    </div>
    {{-- Modal de registro/edición de cliente --}}
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            <h2 class="text-base font-semibold text-gray-900">Información del Cliente</h2>
            <p class="mt-1 text-sm text-gray-600">{{ $customer_id ? 'Editar Cliente' : 'Registrar Nuevo Cliente' }}</p>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-900">Nombres</label>
                        <input wire:model="name" id="name" type="text" autocomplete="given-name"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-600 focus:border-indigo-600">
                        <x-input-error for="name" />
                    </div>

                    <div>
                        <label for="lastname" class="block text-sm font-medium text-gray-900">Apellidos</label>
                        <input wire:model="lastname" id="lastname" type="text" autocomplete="family-name"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-600 focus:border-indigo-600">
                        <x-input-error for="lastname" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-900">Correo Electrónico</label>
                        <input wire:model="email" id="customer-email" type="email" autocomplete="email"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-600 focus:border-indigo-600">
                        <x-input-error for="email" />
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-900">Teléfono</label>
                        <input wire:model="phone" id="phone" type="tel" autocomplete="phone"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-600 focus:border-indigo-600">
                        <x-input-error for="phone" />
                    </div>

                    <div class="sm:col-span-2">
                        <label for="dni" class="block text-sm font-medium text-gray-900">DNI</label>
                        <input wire:model="dni" id="dni" maxlength="8" placeholder="Ingrese su DNI"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-600 focus:border-indigo-600">
                        <x-input-error for="dni" />
                    </div>

                    <div class="sm:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-900">Dirección</label>
                        <input wire:model="address" id="address" type="text" autocomplete="street-address"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-600 focus:border-indigo-600">
                        <x-input-error for="address" />
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button wire:click="cancel">Cancelar</x-button>
            <x-button wire:click="save" wire:loading.attr="disabled">
                {{ $customer_id ? 'Actualizar' : 'Guardar' }}
            </x-button>
            <span wire:loading class="text-sm text-gray-500 ml-2">Guardando...</span>
        </x-slot>
    </x-dialog-modal>

    {{-- Tabla de clientes --}}
    <div class="relative w-full overflow-x-auto mt-6 bg-white shadow-md rounded-lg">
        @if ($customers->count())
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-xs uppercase text-gray-700">
                    <tr>
                        <th class="px-4 py-3">Nombres</th>
                        <th class="px-4 py-3">Apellidos</th>
                        <th class="px-4 py-3">Correo</th>
                        <th class="px-4 py-3">Teléfono</th>
                        <th class="px-4 py-3">Dirección</th>
                        <th class="px-4 py-3">DNI</th>
                        <th class="px-4 py-3">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $customer->name }}</td>
                            <td class="px-4 py-2">{{ $customer->lastname }}</td>
                            <td class="px-4 py-2">{{ $customer->email }}</td>
                            <td class="px-4 py-2">{{ $customer->phone }}</td>
                            <td class="px-4 py-2">{{ $customer->address }}</td>
                            <td class="px-4 py-2">{{ $customer->dni }}</td>
                            <td class="px-4 py-2 flex space-x-2">
                                <x-button wire:click="edit({{ $customer->id }})">✏️</x-button>
                                <x-danger-button wire:click="delete({{ $customer->id }})">🗑️</x-danger-button>
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
</div>
