<div>
    <x-danger-button wire:click="$set('open',true)"> Registrar Mascota</x-danger-button> 
    <x-dialog-modal wire:model="open">
        <x-slot name="title">Registrar / Editar Mascota</x-slot>

        <x-slot name="content">
            <livewire:client-search/>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Nombre -->
                <x-form-group label="Nombre">
                    <x-input wire:model="name" type="text" />
                    <x-input-error for="name" />
                </x-form-group>

                <!-- Tipo de animal -->
                <x-form-group label="Tipo de animal">
                    <select wire:model="animal_type_id" class="w-full border-gray-300 rounded">
                        <option value="">Selecciona un tipo</option>
                        @foreach ($animalTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="animal_type_id" />
                </x-form-group>

                <!-- Raza -->
                <x-form-group label="Raza">
                    <x-input wire:model="breed" type="text" />
                    <x-input-error for="breed" />
                </x-form-group>

                <!-- Fecha de nacimiento -->
                <x-form-group label="Fecha de nacimiento">
                    <x-input wire:model="birth_date" type="date" />
                    <x-input-error for="birth_date" />
                </x-form-group>

                <!-- Sexo -->
                <x-form-group label="Sexo">
                    <select wire:model="sex" class="w-full border-gray-300 rounded">
                        <option value="">Selecciona el sexo</option>
                        <option value="Macho">Macho</option>
                        <option value="Hembra">Hembra</option>
                    </select>
                    <x-input-error for="sex" />
                </x-form-group>

                <!-- Color -->
                <x-form-group label="Color">
                    <x-input wire:model="color" type="text" />
                    <x-input-error for="color" />
                </x-form-group>

                <!-- Esterilizado -->
                <x-form-group label="Esterilizado">
                    <div class="flex items-center">
                        <input wire:model="sterilized" type="checkbox" class="mr-2" />
                        <span>Sí</span>
                    </div>
                    <x-input-error for="sterilized" />
                </x-form-group>

            </div>

        </x-slot>

        <x-slot name="footer">
            <x-secondary-button  wire:click="resetForm">Cancelar</x-secondary-button>
            <x-button wire:click="store">Guardar</x-button>
        </x-slot>
    </x-dialog-modal>
</div>
