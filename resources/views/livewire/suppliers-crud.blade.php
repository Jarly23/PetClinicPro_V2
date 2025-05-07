<div>
    {{-- Botón para abrir el modal --}}
    <x-danger-button wire:click="openModal">
        Crear nuevo proveedor
    </x-danger-button>

    {{-- Modal de formulario --}}
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            {{ $supplierId ? 'Editar Proveedor' : 'Crear Nuevo Proveedor' }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="save">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input wire:model="name" type="text" 
                        class="w-full p-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Contacto</label>
                    <input wire:model="contact" type="text" 
                        class="w-full p-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                    @error('contact') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                    <input wire:model="phone" type="text" id="phone" 
    class="w-full p-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500" 
    placeholder="Ingrese el teléfono"
    onkeypress="return event.charCode >= 48 && event.charCode <= 57">

                    @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Dirección</label>
                    <textarea wire:model="address" 
                        class="w-full p-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-md">Cancelar</button>
            <button wire:click="save" class="bg-indigo-600 text-white px-4 py-2 rounded-md" 
                wire:loading.attr="disabled">
                Guardar
            </button>
        </x-slot>
    </x-dialog-modal>

    {{-- Tabla de proveedores --}}
    <div class="mt-6">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Nombre</th>
                    <th class="border border-gray-300 px-4 py-2">Contacto</th>
                    <th class="border border-gray-300 px-4 py-2">Teléfono</th>
                    <th class="border border-gray-300 px-4 py-2">Dirección</th>
                    <th class="border border-gray-300 px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $supplier->id_supplier }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $supplier->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $supplier->contact }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $supplier->phone }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $supplier->address }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <button wire:click="edit({{ $supplier->id_supplier }})" 
                                class="bg-blue-600 text-white px-4 py-1 rounded-md">Editar</button>
                            <button wire:click="delete({{ $supplier->id_supplier }})" 
                                class="bg-red-500 text-white px-2 py-1 rounded-md"
                                onclick="return confirm('¿Estás seguro de eliminar este proveedor?')">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Mensaje de sesión --}}
    @if (session()->has('message'))
        <div class="mt-4 p-2 bg-green-200 text-green-800 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>
