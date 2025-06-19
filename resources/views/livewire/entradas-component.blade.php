<div class="p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-3xl font-bold text-center text-blue-600 mb-6 flex items-center justify-center gap-3">
        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9 5 9-5M3 7v10l9 5 9-5V7M3 17l9 5 9-5" />
        </svg>
        Gestión de Entradas de Productos
    </h2>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
        <button wire:click="openModal"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition duration-200 shadow">
            + Registrar Entrada
        </button>
    </div>

    {{-- Mensaje flotante --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 1500)"
            class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded shadow transition">
            {{ session('message') }}
        </div>
    @endif

    {{-- Modal Confirmación de Precio --}}
    <x-dialog-modal wire:model="showUpdatePriceModal">
        <x-slot name="title"> Confirmación </x-slot>

        <x-slot name="content">
            <p class="text-gray-700">
                El precio de compra del producto difiere del precio actual (S/ {{ number_format($precio_actual, 2) }}).
                ¿Deseas actualizar el precio?
            </p>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="cancelUpdatePrice"
                class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md">
                No
            </button>
            <button wire:click="updatePrice" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md ml-2">
                Sí, actualizar
            </button>
        </x-slot>
    </x-dialog-modal>

    {{-- Modal de Entrada --}}
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            {{ $entradaId ? 'Editar Entrada' : 'Registrar Entrada' }}
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4 text-sm text-gray-700">
                <div>
                    <label class="block mb-1">Producto</label>
                    <select wire:model="id_product" class="w-full border rounded-md px-3 py-2 focus:ring-blue-500">
                        <option value="">Seleccione un producto</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id_product }}">{{ $producto->name }}</option>
                        @endforeach
                    </select>
                    @error('id_product')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1">Cantidad</label>
                    <input type="number" wire:model="cantidad" class="w-full border rounded-md px-3 py-2"
                        min="1">
                    @error('cantidad')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1">Fecha</label>
                    <input type="datetime-local" wire:model="fecha" class="w-full border rounded-md px-3 py-2">
                    @error('fecha')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block mb-1">Precio de compra</label>
                    <input type="number" wire:model="precio_u" step="0.01"
                        class="w-full border rounded-md px-3 py-2">
                    @error('precio_u')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block mb-1">Fecha de expiración</label>
                    <input type="date" wire:model="expiration_date" class="w-full border rounded-md px-3 py-2"
                        min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                    @error('expiration_date')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="closeModal" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md">
                Cancelar
            </button>
            <button wire:click="saveEntrada" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md ml-2">
                Guardar
            </button>
        </x-slot>
    </x-dialog-modal>

    {{-- Tabla --}}
    <div class="overflow-x-auto mt-6">
        <table class="min-w-full bg-white rounded-md shadow-sm border border-gray-200 text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">Categoría</th>
                    <th class="px-4 py-3 text-left">Producto</th>
                    <th class="px-4 py-3 text-left">Proveedor</th>
                    <th class="px-4 py-3 text-left">Fecha</th>
                    <th class="px-4 py-3 text-left">Cantidad</th>
                    <th class="px-4 py-3 text-left">Precio Unitario</th>
                    <th class="px-4 py-3 text-left">Fecha de Expiración</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($entradas as $entrada)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $entrada->product->category->name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $entrada->product->name }}</td>
                        <td class="px-4 py-3">{{ $entrada->product->supplier->name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($entrada->fecha)->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3">{{ $entrada->cantidad }}</td>
                        <td class="px-4 py-3">S/ {{ number_format($entrada->precio_u, 2) }}</td>
                        <td class="px-4 py-3">{{ $entrada->expiration_date_formatted ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            @can('entrada.edit')
                            <button wire:click="editEntrada({{ $entrada->id_entrada }})"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-sm shadow">
                                Editar
                            </button>                               
                            @endcan
                            @can('entrada.destroy')
                            <button wire:click="confirmDeleteEntrada({{ $entrada->id_entrada }})"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm shadow">
                                Eliminar
                            </button>                                
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-4 text-center text-gray-500">No hay entradas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- Modal de Confirmación de Eliminación --}}
    <x-confirmation-modal wire:model="confirmingDelete">
        <x-slot name="title">
            Eliminar Entrada
        </x-slot>

        <x-slot name="content">
            ¿Estás seguro de que deseas eliminar esta entrada? Esta acción no se puede deshacer.
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('confirmingDelete', false)" class="mr-2">
                Cancelar
            </x-secondary-button>

            <x-danger-button wire:click="deleteEntrada" class="bg-red-500 hover:bg-red-600 text-white ">
                Eliminar
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
