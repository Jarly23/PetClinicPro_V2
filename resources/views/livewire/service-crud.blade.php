<div>
    <x-danger-button wire:click="$set('open',true)">
        Crear un nuevo servicio
    </x-danger-button>
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            <h2 class="text-base/7 font-semibold text-gray-900">Detalle del Servicio</h2>
            <p class="mt-1 text-sm/6 text-gray-600">{{ $service_id ? 'Editar Servicio' : 'Registrar Nuevo Servicio' }}
            </p>
        </x-slot>
        <x-slot name="content">
            <form>
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-12">

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="service-name" class="block text-sm/6 font-medium text-gray-900">Nombre del
                                    servicio</label>
                                <div class="mt-2">
                                    <input wire:model="name" type="text" name="service-name" id="service-name"
                                        autocomplete="service-name"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="price-service" class="block text-sm/6 font-medium text-gray-900">Precio del
                                    Servicio</label>
                                <div class="mt-2">
                                    <input wire:model="price" type="number" name="price-service" id="price-service"
                                        autocomplete="price-service"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                </div>
                            </div>
                        </div>
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="col-span-full">
                                <label for="detail-service" class="block text-sm/6 font-medium text-gray-900">Detalle
                                    del Servicio</label>
                                <div class="mt-2">
                                    <textarea wire:model="description" id="detail-service" name="detail-service" rows="3"
                                        placeholder="Ingrese la descripcion del servicio"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6"></textarea>
                                </div>
                            </div>
                            <div class="col-span-full">
                                <label for="cover-photo" class="block text-sm/6 font-medium text-gray-900">Imagen del
                                    servicio</label>
                                <div
                                    class="mt-2 flex justify-center items-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10 relative overflow-hidden h-60">

                                    @if ($image)
                                        <img src="{{ $image instanceof \Illuminate\Http\UploadedFile ? $image->temporaryUrl() : Storage::url('images/' . $image) }}"
                                            alt="Imagen del Servicio"
                                            class="absolute inset-0 w-full h-full object-cover rounded-lg" />
                                    @else
                                        <div class="text-center">
                                            <svg class="mx-auto size-12 text-gray-300" viewBox="0 0 24 24"
                                                fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                    d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <div class="mt-4 flex text-sm text-gray-600">
                                                <label for="file-upload"
                                                    class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 hover:text-indigo-500">
                                                    <span>Subir archivo</span>
                                                    <input wire:model="image" id="file-upload" name="file-upload"
                                                        type="file" accept="image/*" class="sr-only">
                                                </label>
                                                <p class="pl-1">o arrastra aquí</p>
                                            </div>
                                            <p class="text-xs text-gray-600">PNG, JPG, GIF hasta 10MB</p>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </x-slot>
        <x-slot name="footer">
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button wire:click="$set('open',false)" type="button"
                    class="text-sm/6 font-semibold text-gray-900">Cancelar</button>
                <button wire:click="save" type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Guardar</button>
            </div>
        </x-slot>

    </x-dialog-modal>

    <div class="relative flex flex-col w-full h-full text-gray-700 bg-white shadow-md bg-clip-border rounded-xl mt-4">
        <table class="w-full text-left table-auto min-w-max">
            <thead>
                <tr>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Servicio</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Descrpcion</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Precio</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Imagen</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Acción</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr class="even:bg-blue-gray-50/50">
                        <td class="p-4">{{ $service->name }}</td>
                        <td class="p-4">{{ $service->description }}</td>
                        <td class="p-4">{{ $service->price }}</td>
                        <td class="p-4">
                            @if ($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" alt="Foto del Veterinario"
                                    class="w-full h-12 object-cover ">
                            @else
                                <span>No disponible</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <a href="#" wire:click="edit({{ $service->id }})"
                                class="block text-blue-600">Editar</a>
                        </td>
                        <td class="p-4">
                            <a href="#" wire:click="delete({{ $service->id }})"
                                class="block text-red-600">Eliminar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
