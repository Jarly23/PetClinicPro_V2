<div>
    <div>
        {{-- Título principal --}}
        <div class="mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-blue-700 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-500" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path
                        d="M16 14c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-8 0c2.21 0 4-1.79 4-4S10.21 6 8 6 4 7.79 4 10s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 2.06 1.97 3.45v1.5h6v-1.5c0-2.66-5.33-4-8-4z" />
                </svg>
                Gestión de Proveedores
            </h2>
            <p class="text-sm text-gray-600 mt-1">Aquí puedes registrar, editar y buscar proveedores de tu inventario.
            </p>
        </div>
        {{-- Barra superior con buscador y botón --}}
        <div class="flex justify-between items-center mb-4">
            @can('proveedor.create')
            <x-danger-button wire:click="openModal">
                Crear nuevo proveedor
            </x-danger-button>
                
            @endcan

            <form wire:submit.prevent="$refresh" class="flex gap-2 w-1/3">
                <input type="text" wire:model.debounce.500ms="search"
                    placeholder="Buscar por nombre de la empresa o contacto"
                    class="border border-gray-300 px-3 py-1 rounded-md w-full focus:outline-none focus:ring focus:ring-indigo-300" />
                <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded-md">
                    Buscar
                </button>
            </form>
        </div>

        {{-- Mensaje flotante --}}
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 1500)"
                class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded shadow transition">
                {{ session('message') }}
            </div>
        @endif

        {{-- Tabla de proveedores --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="border px-4 py-2 border-gray-300">Nombre de la Empresa</th>
                        <th class="border px-4 py-2 border-gray-300">Contacto de la Empresa</th>
                        <th class="border px-4 py-2 border-gray-300">Documento</th>
                        <th class="border px-4 py-2 border-gray-300">Teléfono</th>
                        <th class="border px-4 py-2 border-gray-300">Dirección</th>
                        <th class="border px-4 py-2 border-gray-300">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $supplier)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $supplier->name }}</td>
                            <td class="border px-4 py-2">{{ $supplier->contact }}</td>
                            <td class="border px-4 py-2">
                                @if ($supplier->document_type && $supplier->document_number)
                                    {{ $supplier->document_type }} - {{ $supplier->document_number }}
                                @else
                                    <span class="text-gray-400 italic">No definido</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2">{{ $supplier->phone }}</td>
                            <td class="border px-4 py-2">{{ $supplier->address }}</td>
                            <td class="border px-4 py-2">
                                @can('proveedor.edit')
                                <button wire:click="edit({{ $supplier->id_supplier }})"
                                    class="bg-blue-600 text-white px-4 py-1 rounded-md">Editar</button> 
                                @endcan
                                @can('proveedor.destroy')
                                 <button wire:click="confirmDelete({{ $supplier->id_supplier }})"
                                    class="bg-red-500 text-white px-3 py-1 rounded-md">
                                    Eliminar
                                </button>                                   
                                @endcan

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-4">No se encontraron proveedores.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Modal --}}
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                {{ $supplierId ? 'Editar Proveedor' : 'Crear Nuevo Proveedor' }}
            </x-slot>

            <x-slot name="content">
                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Nombre de la Empresa</label>
                        <input wire:model="name" type="text" class="w-full p-2 border rounded-md" />
                        @error('name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium">Contacto de la Empresa</label>
                            <input wire:model="contact" type="text" class="w-full p-2 border rounded-md" />
                            @error('contact')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium">Tipo de Documento</label>
                            <select wire:model="document_type" class="w-full p-2 border rounded-md">
                                <option value="">Seleccionar</option>
                                <option value="DNI">DNI</option>
                                <option value="RUC">RUC</option>
                            </select>
                            @error('document_type')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Número de Documento</label>
                        <input wire:model="document_number" type="text" class="w-full p-2 border rounded-md"
                            placeholder="Según el tipo (8 o 11 dígitos)"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                        @error('document_number')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Teléfono</label>
                        <input wire:model="phone" type="text" class="w-full p-2 border rounded-md"
                            placeholder="Solo números"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" />
                        @error('phone')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Dirección</label>
                        <textarea wire:model="address" class="w-full p-2 border rounded-md"></textarea>
                        @error('address')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </x-slot>

            <x-slot name="footer">
                <div class="flex justify-end gap-4">
                    <button wire:click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-md">
                        Cancelar
                    </button>
                    <button wire:click="save" class="bg-blue-600 text-white px-4 py-2 rounded-md"
                        wire:loading.attr="disabled">
                        Guardar
                    </button>
                </div>
            </x-slot>
        </x-dialog-modal>
        <x-dialog-modal wire:model="confirmingDelete">
            <x-slot name="title">
                Confirmar Eliminación
            </x-slot>

            <x-slot name="content">
                <p>¿Estás seguro de eliminar este proveedor? Esta acción no se puede deshacer.</p>
            </x-slot>

            <x-slot name="footer">
                <div class="flex justify-end gap-4">
                    <button wire:click="$set('confirmingDelete', false)"
                        class="bg-gray-500 text-white px-4 py-2 rounded-md">
                        Cancelar
                    </button>
                    <button wire:click="delete" class="bg-red-600 text-white px-4 py-2 rounded-md"
                        wire:loading.attr="disabled">
                        Eliminar
                    </button>
                </div>
            </x-slot>
        </x-dialog-modal>
    </div>
