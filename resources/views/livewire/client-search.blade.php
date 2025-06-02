<div>
    <!-- 🔍 Buscador de cliente -->
    <div class="flex items-end gap-4 mb-6 relative">
        <div class="w-full">
            <label class="block text-sm font-medium text-gray-700">Buscar cliente (nombre, email o DNI)</label>
            <input wire:model.debounce.300ms="owner_search" type="text"
                class="w-full mt-1 rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Ej. Juan Pérez, juan@mail.com, 12345678" />

            <!-- 🔽 Lista de resultados -->
            @if (!empty($owner_data) && is_null($owner_id))
                <ul class="absolute z-20 bg-white border border-gray-300 w-full mt-1 rounded-md shadow-md max-h-60 overflow-auto">
                    @foreach ($owner_data as $owner)
                        <li wire:click="selectOwner({{ $owner['id'] }})"
                            class="px-4 py-2 hover:bg-indigo-100 cursor-pointer text-sm">
                            {{ $owner['name'] }} {{ $owner['lastname'] }} - {{ $owner['dniruc'] }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div>
            <x-button wire:click="searchOwner">Buscar</x-button>
        </div>
    </div>

    <!-- 🧾 Datos del cliente (solo lectura si existe) -->
    @if (!empty($owner_data) && !is_null($owner_id))
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 p-4 border rounded bg-gray-50">
            <x-form-group label="Nombre">
                <x-input type="text" :value="$owner_data['name']" readonly />
            </x-form-group>
            <x-form-group label="Apellido">
                <x-input type="text" :value="$owner_data['lastname']" readonly />
            </x-form-group>
            <x-form-group label="DNI">
                <x-input type="text" :value="$owner_data['dniruc']" readonly />
            </x-form-group>
            <x-form-group label="Correo">
                <x-input type="email" :value="$owner_data['email']" readonly />
            </x-form-group>
            <x-form-group label="Teléfono">
                <x-input type="text" :value="$owner_data['phone']" readonly />
            </x-form-group>
            <x-form-group label="Dirección">
                <x-input type="text" :value="$owner_data['address']" readonly />
            </x-form-group>
        </div>
    @elseif ($owner_search && !$showNewOwnerForm)
        <div class="mb-4 text-sm text-gray-600">
            Cliente no encontrado.
            <button wire:click="showOwnerForm" class="text-indigo-600 underline">Registrar nuevo cliente</button>
        </div>
    @endif

    <!-- 🆕 Formulario para registrar nuevo cliente -->
    @if ($showNewOwnerForm)
        <div class="mb-6 p-4 border rounded bg-gray-50">
            <h3 class="text-md font-semibold text-gray-800 mb-4">Registrar nuevo cliente</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <x-form-group label="Nombre">
                    <x-input wire:model.defer="new_owner.name" type="text" />
                    <x-input-error for="new_owner.name" />
                </x-form-group>
                <x-form-group label="Apellido">
                    <x-input wire:model.defer="new_owner.lastname" type="text" />
                    <x-input-error for="new_owner.lastname" />
                </x-form-group>
                <x-form-group label="DNI">
                    <x-input wire:model.defer="new_owner.dniruc" type="text" />
                    <x-input-error for="new_owner.dniruc" />
                </x-form-group>
                <x-form-group label="Correo">
                    <x-input wire:model.defer="new_owner.email" type="email" />
                    <x-input-error for="new_owner.email" />
                </x-form-group>
                <x-form-group label="Teléfono">
                    <x-input wire:model.defer="new_owner.phone" type="text" />
                    <x-input-error for="new_owner.phone" />
                </x-form-group>
                <x-form-group label="Dirección">
                    <x-input wire:model.defer="new_owner.address" type="text" />
                    <x-input-error for="new_owner.address" />
                </x-form-group>
            </div>

            <div class="text-right mt-4">
                <x-button wire:click="createNewOwner">Guardar cliente</x-button>
            </div>
        </div>
    @endif
</div>
