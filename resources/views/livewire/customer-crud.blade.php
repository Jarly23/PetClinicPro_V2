<div>
    {{-- Botón para registrar cliente --}}
    @can('clientes.create')
        <x-danger-button wire:click="$set('open',true)">
            ➕ Registrar Cliente
        </x-danger-button>
    @endcan

    {{-- Barra de búsqueda --}}
    <div class="flex items-center space-x-2 mt-4 max-w-3xl relative">
        <div class="relative flex-1">
            <x-input class="py-2 px-2 w-full text-stone-700" wire:model.live.debounce.300ms="search"
                placeholder="Buscar clientes..." />
            
            {{-- Sugerencias en tiempo real --}}
            @if($showSuggestions && $suggestions->count() > 0)
                <div class="absolute bg-white border rounded-lg w-full mt-1 z-50 shadow-lg max-h-60 overflow-y-auto">
                    @foreach ($suggestions as $suggested)
                        <div wire:click="selectCustomer({{ $suggested->id }})" 
                             class="px-3 py-2 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0">
                            <div class="font-medium">{{ $suggested->name }} {{ $suggested->lastname }}</div>
                            <div class="text-sm text-gray-600">DNI: {{ $suggested->dniruc }} | Tel: {{ $suggested->phone }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        
        <x-buttons.search wire:click="searchCustomer">
            Buscar
        </x-buttons.search>
    </div>

    {{-- Vista de detalle del cliente --}}
    @if($showDetail && $selectedCustomer)
        <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    Detalle del Cliente
                </h2>
                <x-buttons.cancel wire:click="backToList">
                    ← Volver a la lista
                </x-buttons.cancel>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Información Personal</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombres:</span>
                            <p class="text-gray-900 dark:text-gray-100">{{ $selectedCustomer->name }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Apellidos:</span>
                            <p class="text-gray-900 dark:text-gray-100">{{ $selectedCustomer->lastname }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">DNI:</span>
                            <p class="text-gray-900 dark:text-gray-100">{{ $selectedCustomer->dniruc }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono:</span>
                            <p class="text-gray-900 dark:text-gray-100">{{ $selectedCustomer->phone }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Dirección:</span>
                            <p class="text-gray-900 dark:text-gray-100">{{ $selectedCustomer->address }}</p>
                        </div>
                        @if($selectedCustomer->email)
                        <div>
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Email:</span>
                            <p class="text-gray-900 dark:text-gray-100">{{ $selectedCustomer->email }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Acciones</h3>
                    <div class="space-y-3">
                        @can('clientes.edit')
                            <x-buttons.edit wire:click="edit({{ $selectedCustomer->id }})" class="w-full justify-center">
                                ✏️ Editar Cliente
                            </x-buttons.edit>
                        @endcan
                        @can('clientes.destroy')
                            <x-buttons.delete wire:click="delete({{ $selectedCustomer->id }})" class="w-full justify-center">
                                🗑️ Eliminar Cliente
                            </x-buttons.delete>
                        @endcan
                    </div>
                    
                    <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Información del Registro</h4>
                        <div class="text-xs text-gray-600 dark:text-gray-400">
                            <p>Creado: {{ $selectedCustomer->created_at->format('d/m/Y H:i') }}</p>
                            @if($selectedCustomer->updated_at != $selectedCustomer->created_at)
                                <p>Actualizado: {{ $selectedCustomer->updated_at->format('d/m/Y H:i') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

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

    {{-- Tabla de clientes (solo se muestra si no hay detalle seleccionado) --}}
    @if(!$showDetail)
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

                            @canany(['clientes.edit', 'clientes.destroy'])
                                <th class="px-4 py-3">Acción</th>
                            @endcanany
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($customers as $customer)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 cursor-pointer"
                                wire:click="selectCustomer({{ $customer->id }})">
                                <td class="px-4 py-2">{{ $customer->name }}</td>
                                <td class="px-4 py-2">{{ $customer->lastname }}</td>
                                <td class="px-4 py-2">{{ $customer->phone }}</td>
                                <td class="px-4 py-2">{{ $customer->address }}</td>
                                <td class="px-4 py-2">{{ $customer->dniruc }}</td>
                                @canany(['clientes.edit', 'clientes.destroy'])
                                    <td class="px-4 py-2 flex space-x-2" onclick="event.stopPropagation()">
                                        @can('clientes.edit')
                                            <x-buttons.edit wire:click="edit({{ $customer->id }})">Editar</x-buttons.edit>
                                        @endcan
                                        @can('clientes.destroy')
                                            <x-buttons.delete wire:click="delete({{ $customer->id }})">Eliminar</x-buttons.delete>
                                        @endcan
                                    </td>
                                @endcanany
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
                <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow cursor-pointer"
                     wire:click="selectCustomer({{ $customer->id }})">
                    <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Nombres:</strong> {{ $customer->name }}</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Apellidos:</strong>
                        {{ $customer->lastname }}</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Teléfono:</strong> {{ $customer->phone }}
                    </p>
                    <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Dirección:</strong>
                        {{ $customer->address }}</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300"><strong>DNI:</strong> {{ $customer->dniruc }}</p>
                    <div class="flex mt-2 space-x-2" onclick="event.stopPropagation()">
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
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cerrar sugerencias al hacer clic fuera del área de búsqueda
    document.addEventListener('click', function(event) {
        const searchContainer = document.querySelector('[wire\\:model\\.live\\.debounce\\.300ms="search"]')?.closest('.relative');
        const suggestions = document.querySelector('.absolute.bg-white.border.rounded-lg');
        
        if (suggestions && searchContainer && !searchContainer.contains(event.target)) {
            @this.set('showSuggestions', false);
        }
    });
});
</script>
