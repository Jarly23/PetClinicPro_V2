<div>
    <x-danger-button wire:click="$set('open', true)">
        Registrar Veterinario
    </x-danger-button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            <h2 class="text-base/7 font-semibold text-gray-900">Información del Veterinario</h2>
            <p class="mt-1 text-sm/6 text-gray-600">
                {{ $veterinarian_id ? 'Editar Veterinario' : 'Registrar Nuevo Veterinario' }}</p>
        </x-slot>

        <x-slot name="content">
            <form>
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-12">
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="name" class="block text-sm/6 font-medium text-gray-900">Nombre</label>
                                <div class="mt-2">
                                    <input wire:model="name" type="text" name="name" id="name"
                                        autocomplete="given-name"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                </div>
                                <x-input-error for="name" class="mb-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <label for="phone" class="block text-sm/6 font-medium text-gray-900">Teléfono</label>
                                <div class="mt-2">
                                    <input wire:model="phone" type="text" name="phone" id="phone"
                                        autocomplete="phone"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                </div>
                                <x-input-error for="phone" class="mb-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <label for="email" class="block text-sm/6 font-medium text-gray-900">Correo
                                    Electrónico</label>
                                <div class="mt-2">
                                    <input wire:model="email" type="email" name="email" id="email"
                                        autocomplete="email"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                </div>
                                <x-input-error for="email" class="mb-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <label for="specialty"
                                    class="block text-sm/6 font-medium text-gray-900">Especialidad</label>
                                <div class="mt-2">
                                    <input wire:model="specialty" type="text" name="specialty" id="specialty"
                                        autocomplete="specialty"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                </div>
                                <x-input-error for="specialty" class="mb-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <label for="photo" class="block text-sm/6 font-medium text-gray-900">Foto</label>
                                <div class="mt-2">
                                    <input wire:model="photo" type="file" name="photo" id="photo"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                </div>
                                <x-input-error for="photo" class="mb-2" />
                            </div>

                            <!-- Mostrar la foto subida -->
                            @if ($photo)
                                <div class="sm:col-span-3 mt-4">
                                    <label class="block text-sm/6 font-medium text-gray-900">Foto Subida</label>
                                    <div class="mt-2">
                                        @if ($photo instanceof \Illuminate\Http\UploadedFile)
                                            <!-- Si es un archivo cargado, mostramos la vista previa con temporaryUrl() -->
                                            <img src="{{ $photo->temporaryUrl() }}" alt="Foto del Veterinario"
                                                class="w-32 h-32 object-cover rounded-lg border-2 border-gray-300">
                                        @else
                                            <!-- Si no es un archivo cargado (cuando estamos editando), usamos Storage::url() -->
                                            <img src="{{ Storage::url('photos/' . $photo) }}" alt="Foto del Veterinario"
                                                class="w-32 h-32 object-cover rounded-lg border-2 border-gray-300">
                                        @endif
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <div class="flex items-center justify-end gap-x-6">
                <button type="button" class="text-sm/6 font-semibold text-gray-900"
                    wire:click="$set('open', false)">Cancelar</button>
                <button
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    wire:click="save">Guardar</button>
            </div>
        </x-slot>
    </x-dialog-modal>

    <div class="mt-6">
        <table class="min-w-full table-auto bg-white">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-900">Nombre</th>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-900">Teléfono</th>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-900">Correo</th>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-900">Especialidad</th>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-900">Foto</th>
                    <th class="px-6 py-3 text-sm font-semibold text-left text-gray-900">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($veterinarians as $veterinarian)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $veterinarian->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $veterinarian->phone }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $veterinarian->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $veterinarian->specialty }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            @if ($veterinarian->photo)
                                <img src="{{ asset('storage/' . $veterinarian->photo) }}" alt="Foto del Veterinario"
                                    class="w-12 h-12 object-cover rounded-full">
                            @else
                                <span>No disponible</span>
                            @endif
                        </td>   
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <x-button class="text-xs" wire:click="edit({{ $veterinarian->id }})">Editar</x-button>
                            <x-button class="text-xs" wire:click="delete({{ $veterinarian->id }})">Eliminar</x-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
