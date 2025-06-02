<div class="container mx-auto p-6">
    <!-- Título de la sección -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-blue-600">Gestión de Categorías</h2>
        <p class="text-lg text-blue-600 mt-2">Administra las categorías de productos en tu sistema</p>
    </div>

    <!-- Botón para crear nueva categoría -->
    <div class="flex justify-end mb-4">
        <x-danger-button wire:click="openModal">
            Crear Nueva Categoría
        </x-danger-button>
    </div>

    <!-- Modal para crear o editar categoría -->
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            {{ $categoryId ? 'Editar Categoría' : 'Crear Nueva Categoría' }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="save">
                <div class="mb-4">
                    <label for="category-name" class="block text-sm font-medium text-gray-700">
                        Nombre de la Categoría
                    </label>
                    <input wire:model="name" type="text" id="category-name" 
                        class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out" 
                        placeholder="Ingrese el nombre de la categoría">
                    @error('name') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-200">
                Cancelar
            </button>
            <button wire:click="save" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition duration-200" 
                wire:loading.attr="disabled">
                Guardar
            </button>
        </x-slot>
    </x-dialog-modal>

    <!-- Lista de categorías -->
    <div class="mt-6 bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full table-auto border-collapse border border-gray-200">
            <thead class="bg-indigo-100">
                <tr>
                    <th class="p-4 text-left text-sm font-medium text-gray-700 border border-gray-300">ID</th>
                    <th class="p-4 text-left text-sm font-medium text-gray-700 border border-gray-300">Nombre</th>
                    <th class="p-4 text-left text-sm font-medium text-gray-700 border border-gray-300">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="p-4 text-sm text-gray-700 border border-gray-300">{{ $category->id_category }}</td>
                        <td class="p-4 text-sm text-gray-700 border border-gray-300">{{ $category->name }}</td>
                        <td class="p-4 text-sm text-gray-700 border border-gray-300">
                            <button wire:click="edit({{ $category->id_category }})" 
                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">
                                Editar
                            </button>
                            <button wire:click="delete({{ $category->id_category }})" 
                                class="bg-red-500 text-white px-4 py-2 rounded-md ml-2 hover:bg-red-600 transition duration-200">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($categories->isEmpty())
            <p class="text-center text-gray-600 py-4">No hay categorías registradas.</p>
        @endif
    </div>
</div>
