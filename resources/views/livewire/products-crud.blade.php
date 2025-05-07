<div>
    <!-- Botón para abrir modal -->
    <x-danger-button wire:click="openModal">
        Crear nuevo producto
    </x-danger-button>

    <!-- Modal -->
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            {{ $productId ? 'Editar Producto' : 'Crear Nuevo Producto' }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="save">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nombre del Producto</label>
                    <input wire:model="name" type="text" class="w-full p-2 border rounded-md">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea wire:model="description" class="w-full p-2 border rounded-md"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Categoría</label>
                        <select wire:model="id_category" class="w-full p-2 border rounded-md">
                            <option value="">Seleccione</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id_category }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('id_category') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Proveedor</label>
                        <select wire:model="id_supplier" class="w-full p-2 border rounded-md">
                            <option value="">Seleccione</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id_supplier }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                        @error('id_supplier') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Precio de Compra</label>
                        <input wire:model="purchase_price" type="number" step="0.01" class="w-full p-2 border rounded-md">
                        @error('purchase_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Precio de Venta</label>
                        <input wire:model="sale_price" type="number" step="0.01" class="w-full p-2 border rounded-md">
                        @error('sale_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-4 grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stock Actual</label>
                        <input wire:model="current_stock" type="number" class="w-full p-2 border rounded-md">
                        @error('current_stock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stock Mínimo</label>
                        <input wire:model="minimum_stock" type="number" class="w-full p-2 border rounded-md">
                        @error('minimum_stock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Fecha de Expiración</label>
                    <input wire:model="expiration_date" type="date" class="w-full p-2 border rounded-md">
                    @error('expiration_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancelar</button>
            <button wire:click="save" class="bg-indigo-600 text-white px-4 py-2 rounded-md">Guardar</button>
        </x-slot>
    </x-dialog-modal>

    <!-- Tabla de productos -->
    <div class="mt-4">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">Nombre</th>
                    <th class="border border-gray-300 px-4 py-2">Precio Venta</th>
                    <th class="border border-gray-300 px-4 py-2">Stock</th>
                    <th class="border border-gray-300 px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="text-center">
                        <td class="border border-gray-300 px-4 py-2">{{ $product->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ number_format($product->sale_price, 2) }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $product->current_stock }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <button wire:click="edit({{ $product->id_product }})" class="bg-blue-600 text-white px-4 py-1 rounded-md">Editar</button>
                            <button wire:click="delete({{ $product->id_product }})" onclick="confirm('¿Seguro que deseas eliminar este producto?') || event.stopImmediatePropagation()" class="bg-red-600 text-white px-3 py-1 rounded-md">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Mensajes de sesión -->
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="bg-green-500 text-white text-center py-2 mt-4">
                {{ session('message') }}
            </div>
        @endif
        <script>
            window.addEventListener('low-stock-alert', event => {
                alert(event.detail.message);
            });
        </script>
    </div>
</div>
