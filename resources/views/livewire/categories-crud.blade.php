<div>
    <x-danger-button wire:click="$set('open',true)">
        Crear nueva categoría
    </x-danger-button>

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
                        class="w-full p-2 border rounded-md focus:ring-indigo-500 focus:border-indigo-500" 
                        placeholder="Ingrese el nombre de la categoría">
                    @error('name') 
                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                    @enderror
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

    {{-- Lista de categorías --}}
    <div class="mt-6 bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left border border-gray-300">ID</th>
                    <th class="p-3 text-left border border-gray-300">Nombre</th>
                    <th class="p-3 text-left border border-gray-300">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="border-b border-gray-200">
                        <td class="p-3 border border-gray-300">{{ $category->id_category }}</td>
                        <td class="p-3 border border-gray-300">{{ $category->name }}</td>
                        <td class="p-3 border border-gray-300">
                            <button wire:click="edit({{ $category->id_category }})" 
                                class="bg-blue-500 text-white px-3 py-1 rounded-md">
                                Editar
                            </button>
                            <button wire:click="delete({{ $category->id_category }})" 
                                class="bg-red-500 text-white px-3 py-1 rounded-md ml-2">
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
