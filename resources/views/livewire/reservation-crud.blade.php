<div class="space-y-6">

    <!-- ✅ Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-4 rounded-md bg-green-50 border border-green-200 p-4 text-sm text-green-800">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 rounded-md bg-red-50 border border-red-200 p-4 text-sm text-red-800">
            {{ session('error') }}
        </div>
    @endif

    <!-- 📅 Botón para abrir Modal -->
    <div class="text-right">
        <button wire:click="$set('open', true)"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Registrar Reserva
        </button>
    </div>

    <!-- 🧾 Modal de Registro -->
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            <h2 class="text-lg font-semibold text-gray-900">Nueva Reserva</h2>
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="save" class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <!-- Cliente -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-900">Cliente</label>
                        <livewire:client-search />
                    </div>

                    <!-- Mascota -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Mascota</label>
                        <select wire:model="pet_id"
                            class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                        <select wire:model="user_id"
                            class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Seleccione un veterinario</option>
                            @foreach ($veterinarians as $vet)
                                <option value="{{ $vet->id }}">{{ $vet->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="user_id" />
                    </div>

                    <!-- Servicio -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-900">Servicio</label>
                        <select wire:model="service_id"
                            class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Seleccione un servicio</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="service_id" />
                    </div>

                    <!-- Fecha -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Fecha de Reserva</label>
                        <input wire:model="reservation_date" type="date"
                            class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <x-input-error for="reservation_date" />
                    </div>

                    <!-- Hora inicio -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Hora de Inicio</label>
                        <input wire:model="start_time" type="time"
                            class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <x-input-error for="start_time" />
                    </div>

                    <!-- Hora fin -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Hora de Fin</label>
                        <input wire:model="end_time" type="time"
                            class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <x-input-error for="end_time" />
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-end gap-3">
                <button wire:click="$set('open', false)" type="button"
                    class="text-sm font-semibold text-gray-600 hover:text-gray-800">
                    Cancelar
                </button>
                <button wire:click="save" type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">
                    Guardar
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>

    <!-- 📋 Tabla de Reservas -->

    <div class="overflow-x-auto bg-white shadow rounded-md">
        <table class="min-w-full text-sm text-left text-gray-900">
            <thead class="bg-gray-100">
                <tr>
                    @foreach (['Cliente', 'Mascota', 'Veterinario', 'Servicio', 'Fecha', 'Inicio', 'Fin', 'Estado', 'Acciones'] as $th)
                        <th class="px-4 py-2 font-semibold text-gray-700">{{ $th }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $reservation->customer->name }}</td>
                        <td class="px-4 py-2">{{ $reservation->pet->name }}</td>
                        <td class="px-4 py-2">{{ $reservation->user->name }}</td>
                        <td class="px-4 py-2">{{ $reservation->service->name }}</td>
                        <td class="px-4 py-2">{{ $reservation->reservation_date }}</td>
                        <td class="px-4 py-2">{{ $reservation->start_time }}</td>
                        <td class="px-4 py-2">{{ $reservation->end_time }}</td>
                        <td class="px-4 py-2">
                            <span
                                class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full
                            @switch($reservation->status)
                                @case('Confirmed') bg-green-100 text-green-800 @break
                                @case('Pending') bg-yellow-100 text-yellow-800 @break
                                @case('Canceled') bg-red-100 text-red-800 @break
                                @default bg-gray-100 text-gray-600
                            @endswitch">
                                ● {{ ucfirst($reservation->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 flex flex-wrap gap-2">
                            <button wire:click="edit({{ $reservation->id }})"
                                class="text-blue-600 hover:underline text-sm">
                                Editar
                            </button>
                            <button wire:click="delete({{ $reservation->id }})"
                                class="text-red-600 hover:underline text-sm">
                                Eliminar
                            </button>

                            @if ($reservation->status === 'Pending')
                                <button wire:click="confirmReservation({{ $reservation->id }})"
                                    class="text-sm px-3 py-1 rounded-md bg-yellow-600 text-white hover:bg-yellow-700 transition">
                                    Confirmar Reserva
                                </button>
                            @elseif ($reservation->status === 'Confirmed')
                                <button wire:click="startConsultation({{ $reservation->id }})"
                                    class="text-sm px-3 py-1 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 transition">
                                    Iniciar Consulta
                                </button>
                                <button wire:click="cancelReservation({{ $reservation->id }})"
                                    class="text-sm px-3 py-1 rounded-md bg-red-600 text-white hover:bg-red-700 transition">
                                    Cancelar Reserva
                                </button>
                            @elseif ($reservation->status === 'Completed')
                                <span class="text-gray-500 text-sm">Consulta Completada</span>
                            @elseif ($reservation->status === 'Canceled')
                                <span class="text-gray-500 text-sm">Reserva Cancelada</span>
                            @endif
                        </td>


                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="p-4">
            {{ $reservations->links() }}
        </div>
    </div>
    <x-dialog-modal wire:model="openConsultationModal">
        <x-slot name="title">
            Iniciar Consulta
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-900">Cliente</label>
                    <input type="text" disabled class="w-full rounded-md bg-gray-100"
                        value="{{ optional(App\Models\Customer::find($customer_id))->name }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900">Mascota</label>
                    <input type="text" disabled class="w-full rounded-md bg-gray-100"
                        value="{{ optional(App\Models\Pet::find($pet_id))->name }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900">Diagnóstico</label>
                    <textarea wire:model="diagnostico" class="w-full rounded-md border-gray-300 shadow-sm"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900">Recomendaciones</label>
                    <textarea wire:model="recomendaciones" class="w-full rounded-md border-gray-300 shadow-sm"></textarea>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="$set('openConsultationModal', false)" type="button"
                class="text-sm font-semibold text-gray-600 hover:text-gray-800">Cancelar</button>
            <button wire:click="saveConsultation" type="button"
                class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
                Guardar Consulta
            </button>
        </x-slot>
    </x-dialog-modal>
</div>
