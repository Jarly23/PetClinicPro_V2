<div>
    <!-- Botón para Registrar Consulta -->
    <div class="mb-4">
        <x-buttons.create wire:click="$set('open',true)">Registrar Consulta</x-buttons.create>
    </div>
    @if (count($consultations))
        <div class="overflow-hidden my-3">
            <div class="flex justify-end items-center gap-2">
                <!-- Campo de entrada -->
                <x-input class="py-2 px-2 w-80 text-gary-400" wire:model.defer="search"
                    wire:keydown.enter="searchConsultations" placeholder="Buscar consulta..." />
                <!-- Botón de búsqueda -->
                <x-buttons.search wire:click="searchConsultations"
                    class="py-1 px-4 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 transition">
                    Buscar
                </x-buttons.search>
            </div>
        </div>
    @else
        <div class="flex items-center justify-center w-full h-full">
            <p class="text-2xl font-semibold text-gray-900">No hay consulta registrada</p>
        </div>
    @endif
    <!-- Modal para la Gestión de Consultas -->
    <x-dialog-modal wire:model="open" class="w-full">
        <x-slot name="title">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                {{ $isEdit ? 'Editar Consulta' : 'Registrar Consulta' }}
            </h2>
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                    <!-- Cliente -->
                    <div class="sm:col-span-2">
                        <livewire:client-selector />
                    </div>

                    <!-- Mascota -->
                    <div>
                        <label for="pet_id"
                            class="block text-sm font-medium text-gray-900 dark:text-gray-100">Mascota</label>
                        <select id="pet_id" wire:model="pet_id"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100">
                            <option value="">Seleccione una mascota</option>
                            @foreach ($pets as $pet)
                                <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="pet_id" />
                    </div>

                    <!-- Veterinario -->
                    <div>
                        <label for="user_id"
                            class="block text-sm font-medium text-gray-900 dark:text-gray-100">Veterinario</label>
                        <select id="user_id" wire:model="user_id"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100">
                            <option value="">Seleccione un veterinario</option>
                            @foreach ($veterinarians as $vet)
                                <option value="{{ $vet->id }}">{{ $vet->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="user_id" />
                    </div>

                    <!-- Servicios -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-900 mb-1 dark:text-gray-100">Servicios</label>
                        <div
                            class="flex flex-wrap gap-4 max-h-40 overflow-y-auto border rounded-md p-2 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100">
                            @foreach ($services as $service)
                                <label class="inline-flex items-center">
                                    <input type="checkbox" wire:model="service_ids" value="{{ $service->id }}"
                                        class="form-checkbox">
                                    <span class="ml-2">{{ $service->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error for="service_ids" />
                    </div>

                    <!-- Motivo de Consulta -->
                    <div class="sm:col-span-2">
                        <label for="motivo_consulta"
                            class="block text-sm font-medium text-gray-900 dark:text-gray-100">Motivo de la
                            Consulta</label>
                        <input id="motivo_consulta" wire:model="motivo_consulta" type="text"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100">
                        <x-input-error for="motivo_consulta" />
                    </div>

                    <!-- Campos numéricos agrupados en dos columnas -->
                    <div class="grid grid-cols-3 gap-4 sm:col-span-2">
                        <!-- Fecha de Consulta -->
                        <div>
                            <label for="consultation_date"
                                class="block text-sm font-medium text-gray-900 dark:text-gray-100">Fecha de
                                Consulta</label>
                            <input id="consultation_date" wire:model="consultation_date" type="datetime-local"
                                class="w-full rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100">
                            @error('consultation_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Peso -->
                        <div>
                            <label for="peso"
                                class="block text-sm font-medium text-gray-900 dark:text-gray-100">Peso (kg)</label>
                            <input id="peso" wire:model="peso" type="number" step="0.01"
                                class="w-full rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100">
                            <x-input-error for="peso" />
                        </div>

                        <!-- Temperatura -->
                        <div>
                            <label for="temperatura"
                                class="block text-sm font-medium text-gray-900 dark:text-gray-100">Temperatura
                                (°C)</label>
                            <input id="temperatura" wire:model="temperatura" type="number" step="0.1"
                                class="w-full rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100">
                            <x-input-error for="temperatura" />
                        </div>

                        <!-- Frecuencia Cardíaca -->
                        <div>
                            <label for="frecuencia_cardiaca"
                                class="block text-sm font-medium text-gray-900 dark:text-gray-100">Frecuencia
                                Cardíaca</label>
                            <input id="frecuencia_cardiaca" wire:model="frecuencia_cardiaca" type="text"
                                class="w-full rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100">
                            <x-input-error for="frecuencia_cardiaca" />
                        </div>

                        <!-- Frecuencia Respiratoria -->
                        <div>
                            <label for="frecuencia_respiratoria"
                                class="block text-sm font-medium text-gray-900 dark:text-gray-100">Frecuencia
                                Respiratoria</label>
                            <input id="frecuencia_respiratoria" wire:model="frecuencia_respiratoria" type="text"
                                class="w-full rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100">
                            <x-input-error for="frecuencia_respiratoria" />
                        </div>

                    </div>

                    <!-- Estado General -->
                    <div class="sm:col-span-2">
                        <label for="estado_general"
                            class="block text-sm font-medium text-gray-900 dark:text-gray-100">Estado
                            General</label>
                        <input id="estado_general" wire:model="estado_general" type="text"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100">
                        <x-input-error for="estado_general" />
                    </div>

                    <!-- Desparasitado -->
                    <div>
                        <label class="inline-flex items-center" for="desparasitacion">
                            <input id="desparasitacion" type="checkbox" wire:model="desparasitacion"
                                class="form-checkbox">
                            <span class="ml-2 text-gray-700 dark:text-gray-100">Desparasitado</span>
                        </label>
                        <x-input-error for="desparasitacion" />
                    </div>

                    <!-- Vacunado -->
                    <div>
                        <label class="inline-flex items-center" for="vacunado">
                            <input id="vacunado" type="checkbox" wire:model="vacunado" class="form-checkbox">
                            <span class="ml-2 text-gray-700 dark:text-gray-100">Vacunado</span>
                        </label>
                        <x-input-error for="vacunado" />
                    </div>

                    <!-- Diagnóstico -->
                    <div class="sm:col-span-2">
                        <label for="diagnostico"
                            class="block text-sm font-medium text-gray-900 dark:text-gray-100">Diagnóstico</label>
                        <textarea id="diagnostico" wire:model="diagnostico" rows="2"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100"></textarea>
                        <x-input-error for="diagnostico" />
                    </div>

                    <!-- Tratamiento -->
                    <div class="sm:col-span-2">
                        <label for="tratamiento"
                            class="block text-sm font-medium text-gray-900 dark:text-gray-100">Tratamiento</label>
                        <textarea id="tratamiento" wire:model="tratamiento" rows="2"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100"></textarea>
                        <x-input-error for="tratamiento" />
                    </div>

                    <!-- Recomendaciones -->
                    <div class="sm:col-span-2">
                        <label for="recomendaciones"
                            class="block text-sm font-medium text-gray-900 dark:text-gray-100">Recomendaciones</label>
                        <textarea id="recomendaciones" wire:model="recomendaciones" rows="2"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100"></textarea>
                        <x-input-error for="recomendaciones" />
                    </div>

                    <!-- Observaciones -->
                    <div class="sm:col-span-2">
                        <label for="observations"
                            class="block text-sm font-medium text-gray-900 dark:text-gray-100">Observaciones</label>
                        <textarea id="observations" wire:model="observations" rows="2"
                            class="w-full rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100"></textarea>
                        <x-input-error for="observations" />
                    </div>

                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end space-x-4">
                <x-buttons.cancel wire:click="closeModal">Cancelar</x-buttons.cancel>
                <x-buttons.create type="submit" wire:click="save"
                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                    Guardar
                </x-buttons.create>
            </div>
        </x-slot>
    </x-dialog-modal>


    <!-- Tabla de Consultas -->
    <div class="overflow-x-auto bg-white shadow rounded-md dark:bg-gray-700">
        <table class="min-w-full bg-white border-collapse dark:bg-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-100">
                <tr class="border-b dark:border-gray-600">
                    <th class="px-4 py-2 text-left text-sm font-semibold">Cliente</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Mascota</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Veterinario</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Motivo de la consulta</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Fecha</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($consultations as $consultation)
                    <tr class="border-b text-gray-700 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-4 py-2">{{ $consultation->customer->name ?? 'No asignado' }}</td>
                        <td class="px-4 py-2">{{ $consultation->pet->name ?? 'No asignada' }}</td>
                        <td class="px-4 py-2">{{ $consultation->user->name ?? 'No asignado' }}</td>
                        <td class="px-4 py-2">{{ $consultation->motivo_consulta ?? 'No hay un motivo' }}</td>
                        <td class="px-4 py-2">
                            {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-2">
                            @can('consultas.index')
                                <x-buttons.view wire:click="viewDetails({{ $consultation->id }})">Ver</x-buttons.view>
                            @endcan
                            @can('consultas.edit')
                                <x-buttons.edit wire:click="edit({{ $consultation->id }})">Editar</x-buttons.edit>
                            @endcan
                            @can('consultas.destroy')
                                <x-buttons.delete wire:click="delete({{ $consultation->id }})">Eliminar</x-buttons.delete>
                            @endcan
                            <button wire:click="exportPDF({{ $consultation->id }})"
                                class="text-sm text-blue-600 hover:underline dark:text-blue-400">Boleta PDF</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Modal de Detalles de la Consulta -->
        <x-dialog-modal wire:model="showDetails">
            <x-slot name="title">
                Detalles de la Consulta
            </x-slot>

            <x-slot name="content">
                @if ($consultation_details)
                    <div class="space-y-2">
                        <p><strong>Cliente:</strong> {{ $consultation_details->customer->name }}</p>
                        <p><strong>Mascota:</strong> {{ $consultation_details->pet->name }}</p>
                        <p><strong>Veterinario:</strong> {{ $consultation_details->user->name }}</p>
                        <p><strong>Fecha:</strong>
                            {{ \Carbon\Carbon::parse($consultation_details->consultation_date)->format('d/m/Y H:i') }}
                        </p>
                        <p><strong>Motivo:</strong> {{ $consultation_details->motivo_consulta ?? '-' }}</p>
                        <p><strong>Peso:</strong> {{ $consultation_details->peso ?? '-' }} kg</p>
                        <p><strong>Temperatura:</strong> {{ $consultation_details->temperatura ?? '-' }} °C</p>
                        <p><strong>F. Cardíaca:</strong> {{ $consultation_details->frecuencia_cardiaca ?? '-' }}</p>
                        <p><strong>F. Respiratoria:</strong>
                            {{ $consultation_details->frecuencia_respiratoria ?? '-' }}</p>
                        <p><strong>Estado General:</strong> {{ $consultation_details->estado_general ?? '-' }}</p>
                        <p><strong>Desparasitado:</strong> {{ $consultation_details->desparasitacion ? 'Sí' : 'No' }}
                        </p>
                        <p><strong>Vacunado:</strong> {{ $consultation_details->vacunado ? 'Sí' : 'No' }}</p>
                        <p><strong>Tratamiento:</strong> {{ $consultation_details->tratamiento ?? '-' }}</p>
                        <p><strong>Diagnóstico:</strong> {{ $consultation_details->diagnostico ?? '-' }}</p>
                        <p><strong>Recomendaciones:</strong> {{ $consultation_details->recomendaciones ?? '-' }}</p>
                        <p><strong>Observaciones:</strong> {{ $consultation_details->observations ?? '-' }}</p>
                        <p><strong>Servicios:</strong>
                            {{ $consultation_details->services->pluck('name')->implode(', ') }}
                        </p>
                    </div>
                @endif
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$set('showDetails', false)">Cerrar</x-secondary-button>
            </x-slot>
        </x-dialog-modal>

        <!-- Paginación -->
        <div class="px-4 py-2">
            {{ $consultations->links() }}
        </div>
    </div>
</div>
