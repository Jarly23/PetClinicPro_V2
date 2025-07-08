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

    <!-- Mensaje de éxito que desaparece en 2 segundos -->
    @if (session()->has('message'))
        <div 
            x-data="{ show: true }" 
            x-init="setTimeout(() => show = false, 2000)" 
            x-show="show"
            x-transition 
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mt-4"
        >
            {{ session('message') }}
        </div>
    @endif

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
                        class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-indigo-500 transition duration-150 ease-in-out" 
                        placeholder="Ingrese el nombre de la categoría">
                    @error('name') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-200 mr-2">
                Cancelar
            </button>
            <button wire:click="save" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200" 
                wire:loading.attr="disabled">
                Guardar
            </button>
        </x-slot>
    </x-dialog-modal>

    <!-- Modal de confirmación para eliminar -->
    <x-dialog-modal wire:model="confirmingDelete">
        <x-slot name="title">
            Confirmar eliminación
        </x-slot>

        <x-slot name="content">
            <p class="text-red-600">
                ¿Estás seguro de eliminar esta categoría? <br>
                También se eliminarán los productos registrados con esta categoría.
            </p>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="$set('confirmingDelete', false)" 
                class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-200 mr-2">
                Cancelar
            </button>
            <button wire:click="delete" 
                class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-200" 
                wire:loading.attr="disabled">
                Eliminar
            </button>

        </x-slot>
    </x-dialog-modal>

    <!-- Lista de categorías -->
    <div class="mt-6 bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full table-auto border-collapse border border-gray-200">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-4 text-left text-sm font-medium text-gray-700 border border-gray-400">ID</th>
                    <th class="p-4 text-left text-sm font-medium text-gray-700 border border-gray-400">Nombre</th>
                    <th class="p-4 text-left text-sm font-medium text-gray-700 border border-gray-400">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="p-4 text-sm text-gray-700 border border-gray-300">{{ $category->id_category }}</td>
                        <td class="p-4 text-sm text-gray-700 border border-gray-300">{{ $category->name }}</td>
                        <td class="p-4 text-sm text-gray-700 border border-gray-300">
                            @can('categorias.edit')
                            <button wire:click="edit({{ $category->id_category }})" 
                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">
                                Editar
                            </button>
                            @endcan
                            @can('categorias.destroy')
                            <button wire:click="confirmDelete({{ $category->id_category }})" 
                                class="bg-red-500 text-white px-4 py-2 rounded-md ml-2 hover:bg-red-600 transition duration-200">
                                Eliminar
                            </button>                               
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($categories->isEmpty())
            <p class="text-center text-gray-600 py-4">No hay categorías registradas.</p>
        @endif
    </div>
    <script src="//unpkg.com/alpinejs" defer></script>
</div>
