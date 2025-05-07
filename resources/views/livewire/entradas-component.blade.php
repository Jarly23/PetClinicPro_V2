<div>
    <x-danger-button wire:click="openModal">Nueva entrada</x-danger-button>
    <x-secondary-button wire:click="exportarExcel">Exportar a Excel</x-secondary-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            {{ $entradaId ? 'Editar Entrada' : 'Registrar Nueva Entrada' }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="saveEntrada">
                <div class="mb-4">
                    <label class="block text-sm font-medium">Producto</label>
                    <select wire:model="id_product" class="w-full border p-2 rounded-md">
                        <option value="">Seleccione</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id_product }}">{{ $producto->name }}</option>
                        @endforeach
                    </select>
                    @error('id_product') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Cantidad</label>
                    <input wire:model="cantidad" type="number" class="w-full border p-2 rounded-md" min="1">
                    @error('cantidad') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Fecha</label>
                    <input wire:model="fecha" type="datetime-local" class="w-full border p-2 rounded-md">
                    @error('fecha') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium">Precio Unitario</label>
                    <input wire:model="precio_u" type="number" step="0.01" class="w-full border p-2 rounded-md">
                    @error('precio_u') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end space-x-2">
                <x-secondary-button wire:click="closeModal">Cancelar</x-secondary-button>
                <button wire:click="saveEntrada" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                    Guardar
                </button>
                
            </div>
        </x-slot>
    </x-dialog-modal>

    <div class="mt-6">
        <table class="w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Categoría</th>
                    <th class="border px-4 py-2">Producto</th>
                    <th class="border px-4 py-2">Proveedor</th>
                    <th class="border px-4 py-2">Fecha</th>
                    <th class="border px-4 py-2">Cantidad Actual</th>
                    <th class="border px-4 py-2">Precio de Compra</th>
                    <th class="border px-4 py-2">Precio de Venta</th>
                    <th class="border px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($entradas as $entrada)
                    <tr class="text-center">
                        <td class="border px-4 py-2">{{ $entrada->producto->category->name ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ $entrada->producto->name }}</td>
                        <td class="border px-4 py-2">{{ $entrada->producto->supplier->name ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($entrada->fecha)->format('d/m/Y H:i') }}</td>
                        <td class="border px-4 py-2">{{ $entrada->producto->current_stock }}</td>
                        <td class="border px-4 py-2">${{ number_format($entrada->producto->purchase_price, 2) }}</td>
                        <td class="border px-4 py-2">${{ number_format($entrada->producto->sale_price, 2) }}</td>
                        <td class="border px-4 py-2 space-x-2">
                            <button wire:click="editEntrada({{ $entrada->id_entrada }})" class="bg-blue-500 text-white px-3 py-1 rounded-md">Editar</button>
                            <button wire:click="deleteEntrada({{ $entrada->id_entrada }})" onclick="confirm('¿Eliminar entrada?') || event.stopImmediatePropagation()" class="bg-red-500 text-white px-3 py-1 rounded-md">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if (session()->has('message'))
            <div class="bg-green-500 text-white text-center py-2 mt-4">
                {{ session('message') }}
            </div>
        @endif
    </div>
</div>
