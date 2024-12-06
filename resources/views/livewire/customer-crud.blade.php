<div>
    {{-- Botón para registrar cliente --}}
    <x-danger-button wire:click="$set('open',true)">
        Registrar Cliente
    </x-danger-button>

    @if (count($customers))
        <div class="overflow-hidden">
            <x-input class="md:float-right py-1 px-2 w-80 text-stone-700 mt-4"
            wire:model.defer="search" wire:keydown.enter="searchCustomers" placeholder="Buscar clientes..." />
        </div>
    @else
        <div class="flex items-center justify-center w-full h-full">
            <p class="text-2xl font-semibold text-gray-900">No hay clientes registrados</p>
        </div>
    @endif
    {{-- Modal de registro/edición de cliente --}}
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            <h2 class="text-base/7 font-semibold text-gray-900">Información del Cliente</h2>
            <p class="mt-1 text-sm/6 text-gray-600">{{ $customer_id ? 'Editar Cliente' : 'Registrar Nuevo Cliente' }}
            </p>
        </x-slot>
        <x-slot name="content">
            <form>
                <div class="space-y-12">
                    <div class="border-gray-900/10 pb-12">
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="first-name"
                                    class="block text-sm/6 font-medium text-gray-900">Nombres</label>
                                <div class="mt-2">
                                    <input wire :model="name" type="text" name="first-name" id="first-name"
                                        autocomplete="given-name"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                </div>
                                <x-input-error for="name" class="mb-2" />
                            </div>

                            <div class="sm:col-span-3">
                                <label for="last-name"
                                    class="block text-sm/6 font-medium text-gray-900">Apellidos</label>
                                <div class="mt-2">
                                    <input wire :model="lastname" type="text" name="last-name" id="last-name"
                                        autocomplete="family-name"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                </div>
                                <x-input-error for="lastname" class="mb-2" />
                            </div>

                            <div class="sm:col-span-4">
                                <label for="email" class="block text-sm/6 font-medium text-gray-900">Corre Electrónico</label>
                                <div class="mt-2">
                                    <input wire :model="email" id="email" name="email" type="email"
                                        autocomplete="email"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                </div>
                                <x-input-error for="email" class="mb-2" />
                            </div>
                            <div class="sm:col-span-2">
                                <label for="email" class="block text-sm/6 font-medium text-gray-900">Teléfono</label>
                                <div class="mt-2">
                                    <input wire :model="phone" id="phone" name="phone" type="tel"
                                        autocomplete="phone"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                </div>
                                <x-input-error for="phone" class="mb-2" />
                            </div>
                            <div class="col-span-full">
                                <label for="tipo-documento" class="block text-sm/6 font-medium text-gray-900">Tipo de Documento</label>
                                <div class="mt-2">
                                    <select wire :model="documentType" id="tipo-documento"
                                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                        <option value="">Seleccione</option>
                                        <option value="dni">DNI</option>
                                        <option value="ruc">RUC</option>
                                    </select>
                                </div>
                                <x-input-error for="documentType" class="mb-2" />
                            </div>

                            <div class="col-span-full">
                                <label for="dni-ruc" class="block text-sm/6 font-medium text-gray-900">
                                    {{ $documentType === 'dni' ? 'DNI' : ($documentType === 'ruc' ? 'RUC' : 'DNI / RUC') }}
                                </label>
                                <div class="mt-2">
                                    <input
                                        wire :model="dniruc"
                                        type="text"
                                        id="dni-ruc"
                                        maxlength="{{ $documentType === 'dni' ? 8 : ($documentType === 'ruc' ? 11 : '') }}"
                                        placeholder="{{ $documentType === 'dni' ? 'Ingrese su DNI' : ($documentType === 'ruc' ? 'Ingrese su RUC' : 'Ingrese DNI o RUC') }}"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                </div>
                                <x-input-error for="dniruc" class="mb-2" />
                            </div>

                            <div class="col-span-full">
                                <label for="street-address"
                                    class="block text-sm/6 font-medium text-gray-900">Dirección</label>
                                <div class="mt-2">
                                    <input wire :model="address" type="text" name="street-address" id="street-address"
                                        autocomplete="street-address"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                                </div>
                                <x-input-error for="address" class="mb-2" />
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </x-slot>
        <x-slot name="footer">
            <div class="flex items-center justify-end gap-x-6">
                <button type="button" class="text-sm/6 font-semibold text-gray-900"
                    wire :click="$set('open', false)">Cancelar</button>
                <button
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    wire :click="save" wire :loading.attr="disabled">
                    {{ $customer_id ? 'Actualizar' : 'Guardar' }}
                </button>
            </div>
            <span wire :loading>Guardando</span>
        </x-slot>
    </x-dialog-modal>

    <div
        class="relative flex flex-col w-full h-full text-gray-700 bg-white shadow-md bg-clip-border rounded-xl mt-4 overflow-auto">
        <table class="w-full text-left table-auto min-w-max dark:border-gray-700/60">
            <thead>
                <tr class="border-b border-blue-gray-100 bg-blue-gray-50">
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Nombres</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Apellidos</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Correo</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Teléfono</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Dirección</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            DNI / RUC</p>
                    </th>
                    <th class="p-4 border-b border-blue-gray-100 bg-blue-gray-50">
                        <p
                            class="block font-sans text-sm antialiased font-normal leading-none text-blue-gray-900 opacity-70">
                            Acción</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr class="even:bg-blue-gray-50/50">
                        <td class="p-4">{{ $customer->name }}</td>
                        <td class="p-4">{{ $customer->lastname }}</td>
                        <td class="p-4">{{ $customer->email }}</td>
                        <td class="p-4">{{ $customer->phone }}</td>
                        <td class="p-4 max-w-64">{{ $customer->address }}</td>
                        <td class="p-4 max-w-64">{{ $customer->dniruc }}</td>
                        <td class="p-4">
                            <button wire :click="edit({{ $customer->id }})"
                                class="font-bold rounded-lg text-base  w-24 h-8 bg-[#0d4dff] text-[#ffffff] justify-center">Editar</button>
                            <button wire :click="delete({{ $customer->id }})"
                                class="font-bold rounded-lg text-base  w-24 h-8 bg-[#f20e1e] text-[#ffffff] justify-center">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
