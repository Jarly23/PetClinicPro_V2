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
                        <select wire:model="customer_id"
                            class="w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Seleccione un cliente</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="customer_id" />
                    </div>

                    <!-- Mascota -->
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-900">Mascota</label>
                        <select wire:model="pet_id"
                            class="w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Seleccione una mascota</option>
                            @foreach ($pets as $pet)
                                <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="pet_id" />
                    </div>

                    <!-- Veterinario -->
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-900">Veterinario</label>
                        <select wire:model="veterinarian_id"
                            class="w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Seleccione un veterinario</option>
                            @foreach ($veterinarians as $vet)
                                <option value="{{ $vet->id }}">{{ $vet->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="veterinarian_id" />
                    </div>

                    <!-- Servicio -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-900">Servicio</label>
                        <select wire:model="service_id"
                            class="w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Seleccione un servicio</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="service_id" />
                    </div>

                    <!-- Fecha de Consulta -->
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-900">Fecha de Consulta</label>
                        <input wire:model="consultation_date" type="datetime-local"
                            class="w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <x-input-error for="consultation_date" />
                    </div>

                    <!-- Recomendaciones -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-900">Recomendaciones</label>
                        <textarea wire:model="recomendaciones"
                            class="w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        <x-input-error for="recomendaciones" />
                    </div>

                    <!-- Diagnóstico -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-900">Diagnóstico</label>
                        <textarea wire:model="diagnostico"
                            class="w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        <x-input-error for="diagnostico" />
                    </div>

                    <!-- Observaciones -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-900">Observaciones</label>
                        <textarea wire:model="observations"
                            class="w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
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
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-900">Observaciones</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-900">Diagnóstico</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-900">Recomendaciones</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-900">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($consultations as $consultation)
                    <tr class="border-b">
                        <!-- Cliente -->
                        <td class="px-4 py-2">{{ $consultation->customer->name ?? 'No asignado' }}</td>

                        <!-- Mascota -->
                        <td class="px-4 py-2">{{ $consultation->pet->name ?? 'No asignada' }}</td>

                        <!-- Veterinario -->
                        <td class="px-4 py-2">{{ $consultation->veterinarian->name ?? 'No asignado' }}</td>

                        <!-- Fecha de Consulta -->
                        <td class="px-4 py-2">
                            {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('d/m/Y H:i') }}</td>

                        <!-- Observaciones -->
                        <td class="px-4 py-2">{{ $consultation->observations ?? 'Sin observaciones' }}</td>

                        <!-- Diagnóstico -->
                        <td class="px-4 py-2">{{ $consultation->diagnostico ?? 'No disponible' }}</td>

                        <!-- Recomendaciones -->
                        <td class="px-4 py-2">{{ $consultation->recomendaciones ?? 'No disponibles' }}</td>

                        <!-- Acciones -->
                        <td class="px-4 py-2">
                            <button wire:click="edit({{ $consultation->id }})"
                                class="px-2 py-1 text-xs text-white bg-blue-500 rounded">Editar</button>
                            <button wire:click="delete({{ $consultation->id }})"
                                class="px-2 py-1 text-xs text-white bg-red-500 rounded">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="px-4 py-2">
            {{ $consultations->links() }}
        </div>
    </div>
</div>
