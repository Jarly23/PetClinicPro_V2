<div>
    <!-- Botón para Registrar Consulta -->
    <div class="mb-4">
        <x-danger-button wire:click="$set('open',true)">Registrar Consulta</x-danger-button>
    </div>
    @if (count($consultations))
        <div class="overflow-hidden">
            <div class="flex justify-end items-center gap-2">
                <!-- Campo de entrada -->
                <x-input class="py-1 px-2 w-80 text-stone-700" wire:model.defer="search"
                    wire:keydown.enter="searchConsultations" placeholder="Buscar consulta..." />
                <!-- Botón de búsqueda -->
                <button wire:click="searchConsultations"
                    class="py-1 px-4 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 transition">
                    Buscar
                </button>
            </div>
        </div>
    @else
        <div class="flex items-center justify-center w-full h-full">
            <p class="text-2xl font-semibold text-gray-900">No hay consulta registrada</p>
        </div>
    @endif
    <!-- Modal para la Gestión de Consultas -->
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            <h2 class="text-lg font-semibold text-gray-900">Gestión de Consultas</h2>
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

                    <!-- Cliente -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-900">Cliente</label>
                        <select wire:model="customer_id" class="w-full rounded-md border-gray-300">
                            <option value="">Seleccione un cliente</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="customer_id" />
                    </div>

                    <!-- Mascota -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Mascota</label>
                        <select wire:model="pet_id" class="w-full rounded-md border-gray-300">
                            <option value="">Seleccione una mascota</option>
                            @foreach ($pets as $pet)
                                <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="pet_id" />
                    </div>

                    <!-- Veterinario -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Veterinario</label>
                        <select wire:model="user_id" class="w-full rounded-md border-gray-300">
                            <option value="">Seleccione un veterinario</option>
                            @foreach ($veterinarians as $vet)
                                <option value="{{ $vet->id }}">{{ $vet->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="user_id" />
                    </div>

                    <!-- Servicios -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-900">Servicios</label>
                        <select wire:model="service_ids" multiple class="w-full rounded-md border-gray-300">
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="service_ids" />
                    </div>

                    <!-- Fecha de Consulta -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Fecha de Consulta</label>
                        <input wire:model="consultation_date" type="datetime-local"
                            class="w-full rounded-md border-gray-300">
                        <x-input-error for="consultation_date" />
                    </div>

                    <!-- Motivo de Consulta -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Motivo de la Consulta</label>
                        <input wire:model="motivo_consulta" type="text" class="w-full rounded-md border-gray-300">
                        <x-input-error for="motivo_consulta" />
                    </div>

                    <!-- Peso -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Peso (kg)</label>
                        <input wire:model="peso" type="number" step="0.01"
                            class="w-full rounded-md border-gray-300">
                        <x-input-error for="peso" />
                    </div>

                    <!-- Temperatura -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Temperatura (°C)</label>
                        <input wire:model="temperatura" type="number" step="0.1"
                            class="w-full rounded-md border-gray-300">
                        <x-input-error for="temperatura" />
                    </div>

                    <!-- Frecuencia Cardíaca -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Frecuencia Cardíaca</label>
                        <input wire:model="frecuencia_cardiaca" type="text"
                            class="w-full rounded-md border-gray-300">
                        <x-input-error for="frecuencia_cardiaca" />
                    </div>

                    <!-- Frecuencia Respiratoria -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Frecuencia Respiratoria</label>
                        <input wire:model="frecuencia_respiratoria" type="text"
                            class="w-full rounded-md border-gray-300">
                        <x-input-error for="frecuencia_respiratoria" />
                    </div>

                    <!-- Estado General -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-900">Estado General</label>
                        <input wire:model="estado_general" type="text" class="w-full rounded-md border-gray-300">
                        <x-input-error for="estado_general" />
                    </div>

                    <!-- Desparasitado -->
                    <div>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="desparasitacion" class="form-checkbox">
                            <span class="ml-2 text-gray-700">Desparasitado</span>
                        </label>
                        <x-input-error for="desparasitacion" />
                    </div>

                    <!-- Vacunado -->
                    <div>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="vacunado" class="form-checkbox">
                            <span class="ml-2 text-gray-700">Vacunado</span>
                        </label>
                        <x-input-error for="vacunado" />
                    </div>

                    <!-- Diagnóstico -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-900">Diagnóstico</label>
                        <textarea wire:model="diagnostico" rows="2" class="w-full rounded-md border-gray-300"></textarea>
                        <x-input-error for="diagnostico" />
                    </div>

                    <!-- Tratamiento -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-900">Tratamiento</label>
                        <textarea wire:model="tratamiento" rows="2" class="w-full rounded-md border-gray-300"></textarea>
                        <x-input-error for="tratamiento" />
                    </div>

                    <!-- Recomendaciones -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-900">Recomendaciones</label>
                        <textarea wire:model="recomendaciones" rows="2" class="w-full rounded-md border-gray-300"></textarea>
                        <x-input-error for="recomendaciones" />
                    </div>

                    <!-- Observaciones -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-900">Observaciones</label>
                        <textarea wire:model="observations" rows="2" class="w-full rounded-md border-gray-300"></textarea>
                        <x-input-error for="observations" />
                    </div>

                </div>
            </form>
        </x-slot>
        <!-- Footer del Modal -->
        <x-slot name="footer">
            <div class="flex justify-end space-x-4">
                <!-- Botón Cancelar -->
                <button wire:click="$set('open', false)"
                    class="px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Cancelar
                </button>
                <button wire:click="save"
                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Guardar
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>

    <!-- Tabla de Consultas -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-900">Cliente</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-900">Mascota</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-900">Veterinario</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-900">Fecha</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-900">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($consultations as $consultation)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $consultation->customer->name ?? 'No asignado' }}</td>
                        <td class="px-4 py-2">{{ $consultation->pet->name ?? 'No asignada' }}</td>
                        <td class="px-4 py-2">{{ $consultation->user->name ?? 'No asignado' }}</td>
                        <td class="px-4 py-2">
                            {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-4 py-2">
                            <button wire:click="viewDetails({{ $consultation->id }})"
                                class="px-2 py-1 text-xs text-white bg-green-600 rounded hover:bg-green-700">Ver</button>
                            <button wire:click="edit({{ $consultation->id }})"
                                class="px-2 py-1 text-xs text-white bg-blue-500 rounded hover:bg-blue-600">Editar</button>
                            <button wire:click="delete({{ $consultation->id }})"
                                class="px-2 py-1 text-xs text-white bg-red-500 rounded hover:bg-red-600">Eliminar</button>
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
