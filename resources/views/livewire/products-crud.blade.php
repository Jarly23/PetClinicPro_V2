<div class="p-4">
    {{-- Título --}}
    <h2 class="text-3xl font-bold text-blue-800 mb-6 border-b pb-3">📦 Gestión de Productos</h2>
    {{-- Botón de crear --}}
    <div class="mb-6">
        <x-danger-button wire:click="openModal">
            Crear nuevo producto
        </x-danger-button>
    </div>
    {{-- Mensaje de sesión --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 1500)"
            class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded shadow transition">
            {{ session('message') }}
        </div>
    @endif
    {{-- Filtros de búsqueda --}}
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6 flex-wrap">
        <div class="w-full md:flex-1">
            <input type="text" wire:model.debounce.500ms="search" placeholder="Buscar producto..."
                class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 shadow-sm" />
        </div>

        <div class="w-full md:w-1/3">
            <select wire:model="categoryFilter"
                class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 shadow-sm">
                <option value="">Todas las categorías</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id_category }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="w-full md:w-1/3">
            <select wire:model="supplierFilter"
                class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 shadow-sm">
                <option value="">Todos los proveedores</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id_supplier }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="w-full md:w-auto">
            <button type="button" wire:click="$refresh"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                Buscar/Filtrar
            </button>
        </div>
    </div>
  


    {{-- Modal --}}
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            {{ $productId ? 'Editar Producto' : 'Crear Nuevo Producto' }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre del Producto</label>
                    <input wire:model="name" type="text"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300" />
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea wire:model="description" class="w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300"></textarea>
                    @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Categoría</label>
                        <select wire:model="id_category"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300">
                            <option value="">Seleccione</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id_category }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('id_category')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Proveedor</label>
                        <select wire:model="id_supplier"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300">
                            <option value="">Seleccione</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id_supplier }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                        @error('id_supplier')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Precio de Compra</label>
                        <input wire:model="purchase_price" type="number" step="0.01"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300" />
                        @error('purchase_price')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Precio de Venta</label>
                        <input wire:model="sale_price" type="number" step="0.01"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300" />
                        @error('sale_price')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stock Actual</label>
                        <input wire:model="current_stock" type="number"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300" />
                        @error('current_stock')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stock Mínimo</label>
                        <input wire:model="minimum_stock" type="number"
                            class="w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300" />
                        @error('minimum_stock')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="closeModal" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md mr-2">
                Cancelar
            </button>
            <button wire:click="save" class="bg-blue-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
                Guardar
            </button>
        </x-slot>
    </x-dialog-modal>

    {{-- Tabla de productos --}}
    <div class="mt-6 overflow-x-auto">
        <table class="table-auto w-full border border-gray-300 shadow-sm text-sm">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border">Nombre</th>
                    <th class="px-4 py-2 border">Categoría</th>
                    <th class="px-4 py-2 border">Proveedor</th>
                    <th class="px-4 py-2 border">P. Compra</th>
                    <th class="px-4 py-2 border">P. Venta</th>
                    <th class="px-4 py-2 border">Ganancia</th>
                    <th class="px-4 py-2 border">Stock</th>
                    <th class="px-4 py-2 border">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $product->name }}</td>
                        <td class="px-4 py-2 border">{{ $product->category->name ?? '—' }}</td>
                        <td class="px-4 py-2 border">{{ $product->supplier->name ?? '—' }}</td>
                        <td class="px-4 py-2 border text-center text-yellow-600 font-semibold">
                            S/. {{ number_format($product->purchase_price, 2) }}
                        </td>
                        <td class="px-4 py-2 border text-center text-green-600 font-semibold">
                            S/. {{ number_format($product->sale_price, 2) }}
                        </td>
                        <td class="px-4 py-2 border text-center text-indigo-600 font-semibold">
                            S/. {{ number_format($product->sale_price - $product->purchase_price, 2) }}
                            ({{ number_format((($product->sale_price - $product->purchase_price) / $product->purchase_price) * 100, 1) }}%)
                        </td>

                        <td class="px-4 py-2 border text-center font-bold {{ $product->current_stock <= $product->minimum_stock ? 'text-red-600' : 'text-gray-700' }}">
                            {{ $product->current_stock }}
                        </td>
                        <td class="px-4 py-2 border text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2 flex-wrap">
                                <button wire:click="edit({{ $product->id_product }})"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-md shadow-md transition">
                                    Editar
                                </button>
                                <button wire:click="confirmDelete({{ $product->id_product }})"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md shadow-md transition">
                                    Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">No se encontraron productos.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{-- nodal para confirmacion --}}
    <x-confirmation-modal wire:model="confirmingDelete">
        <x-slot name="title">
            Confirmar Eliminación
        </x-slot>

        <x-slot name="content">
            ¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.
        </x-slot>

        <x-slot name="footer">
            <button wire:click="cancelDelete"
                class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-200 mr-2">
                Cancelar
            </button>
            <button wire:click="deleteConfirmed"
                class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-200">
                Eliminar
            </button>
        </x-slot>
    </x-confirmation-modal>

    <script>
        window.addEventListener('low-stock-alert', event => {
            alert(event.detail.message);
        });
    </script>
</div>
