<div>
    <!-- Mensajes Flash -->
    @if (session()->has('message'))
        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-800">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-800">
            {{ session('error') }}
        </div>
    @endif

    <!-- Botón para Registrar Reserva -->
    <button wire:click="$set('open', true)" 
            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75">
        Registrar Reserva
    </button>

    <!-- Modal para la Gestión de Reservas -->
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            <h2 class="text-lg font-semibold text-gray-900">Gestión de Reservas</h2>
        </x-slot>

        <x-slot name="content">
            <form>
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

                    <!-- Fecha de Reserva -->
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-900">Fecha de Reserva</label>
                        <input wire:model="reservation_date" type="date"
                               class="w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <x-input-error for="reservation_date" />
                    </div>

                    <!-- Hora de Inicio -->
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-900">Hora de Inicio</label>
                        <input wire:model="start_time" type="time"
                               class="w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <x-input-error for="start_time" />
                    </div>

                    <!-- Hora de Fin -->
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-900">Hora de Fin</label>
                        <input wire:model="end_time" type="time"
                               class="w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <x-input-error for="end_time" />
                    </div>

                    <!-- Estado -->
                    <div class="sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-900">Estado</label>
                        <select wire:model="status"
                                class="w-full rounded-md shadow-sm border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="Pending">Pendiente</option>
                            <option value="Confirmed">Confirmada</option>
                            <option value="Canceled">Cancelada</option>
                        </select>
                        <x-input-error for="status" />
                    </div>
                </div>
            </form>
        </x-slot>

        <!-- Footer del Modal -->
        <x-slot name="footer">
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button wire:click="$set('open', false)" type="button"
                        class="text-sm font-semibold text-gray-900">Cancelar</button>
                <button wire:click="save" type="submit"
                        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Guardar</button>
            </div>
        </x-slot>
    </x-dialog-modal>

    <!-- Tabla de Reservas -->
    <div class="mt-6">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Cliente</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Mascota</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Veterinario</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Servicio</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Fecha de Reserva</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Hora de Inicio</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Hora de Fin</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Estado</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                    <tr>
                        <td class="px-4 py-2">{{ $reservation->customer->name }}</td>
                        <td class="px-4 py-2">{{ $reservation->pet->name }}</td>
                        <td class="px-4 py-2">{{ $reservation->veterinarian->name }}</td>
                        <td class="px-4 py-2">{{ $reservation->service->name }}</td>
                        <td class="px-4 py-2">{{ $reservation->reservation_date }}</td>
                        <td class="px-4 py-2">{{ $reservation->start_time }}</td>
                        <td class="px-4 py-2">{{ $reservation->end_time }}</td>
                        <td class="px-4 py-2">
                            <select wire:change="updateStatus({{ $reservation->id }}, $event.target.value)" 
                                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Pending" {{ $reservation->status === 'Pending' ? 'selected' : '' }}>Pendiente</option>
                                <option value="Confirmed" {{ $reservation->status === 'Confirmed' ? 'selected' : '' }}>Confirmada</option>
                                <option value="Canceled" {{ $reservation->status === 'Canceled' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                        </td>
                        <td class="px-4 py-2">
                            <button wire:click="edit({{ $reservation->id }})"
                                class="text-blue-600 hover:text-blue-800">Editar</button>
                            <button wire:click="delete({{ $reservation->id }})"
                                class="ml-2 text-red-600 hover:text-red-800">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $reservations->links() }}
        </div>
    </div>
</div>
