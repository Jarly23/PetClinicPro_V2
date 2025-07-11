<div class="space-y-6">

    <!-- ✅ Flash Messages -->
    @if (session()->has('message'))
        <div
            class="mb-4 rounded-md bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 p-4 text-sm text-green-800 dark:text-green-200 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500 dark:text-green-300" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div
            class="mb-4 rounded-md bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 p-4 text-sm text-red-800 dark:text-red-200 flex items-center gap-2">
            <svg class="w-5 h-5 text-red-500 dark:text-red-300" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- 📅 Botón para abrir Modal de Reserva -->
    <div class="text-right">
        <button wire:click="$set('open', true)"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 dark:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-700 dark:hover:bg-indigo-800 transition-all gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Registrar Reserva
        </button>
    </div>

    <!-- 🧾 Modal de Reserva -->
    <x-dialog-modal wire:model="open">
        <x-slot name="title"><span class="text-indigo-700 dark:text-indigo-300 font-bold">Nueva
                Reserva</span></x-slot>
        <x-slot name="content">
            <form wire:submit.prevent="save" class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium">Cliente</label>
                        <div
                            class="rounded-md border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-2">
                            <livewire:client-selector />
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Mascota</label>
                        <select wire:model="pet_id"
                            class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:border-indigo-400">
                            <option value="">Seleccione una mascota</option>
                            @foreach ($pets as $pet)
                                <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="pet_id" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Veterinario</label>
                        <select wire:model="user_id"
                            class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:border-indigo-400">
                            <option value="">Seleccione un veterinario</option>
                            @foreach ($veterinarians as $vet)
                                <option value="{{ $vet->id }}">{{ $vet->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="user_id" />
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium">Servicio</label>
                        <select wire:model="service_id"
                            class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:border-indigo-400">
                            <option value="">Seleccione un servicio</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="service_id" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Fecha de Reserva</label>
                        <input wire:model="reservation_date" type="date"
                            class="w-full mt-1 rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 dark:focus:border-indigo-400">
                        <x-input-error for="reservation_date" />
                    </div>
                </div>
            </form>
        </x-slot>
        <x-slot name="footer">
            <x-buttons.cancel wire:click="resetForm" type="button" class="mr-2"> Cancelar</x-buttons.cancel>
            <x-buttons.create wire:click.prevent="save"> Guardar</x-buttons.create>
        </x-slot>
    </x-dialog-modal>

    <!-- 📋 Tabla de Reservas -->
    <div
        class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-xl border border-gray-200 dark:border-gray-700 mt-6">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 dark:bg-gray-800">
                <tr>
                    @foreach (['Cliente', 'Mascota', 'Veterinario', 'Servicio', 'Fecha', 'Estado', 'Acciones'] as $th)
                        <th
                            class="px-4 py-3 font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                            {{ $th }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                    <tr
                        class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="px-4 py-2">{{ $reservation->customer->name }}</td>
                        <td class="px-4 py-2">{{ $reservation->pet->name }}</td>
                        <td class="px-4 py-2">{{ $reservation->user->name }}</td>
                        <td class="px-4 py-2">{{ $reservation->service->name }}</td>
                        <td class="px-4 py-2">
                            {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d/m/Y H:i') }}</td>

                        {{-- Estado --}}
                        <td class="px-4 py-2">
                            @php
                                switch ($reservation->status) {
                                    case 'Confirmed':
                                        $statusClass = 'bg-green-100 text-green-800';
                                        break;
                                    case 'Pending':
                                        $statusClass = 'bg-yellow-100 text-yellow-800';
                                        break;
                                    case 'Canceled':
                                        $statusClass = 'bg-red-100 text-red-800';
                                        break;
                                    case 'Completed':
                                        $statusClass = 'bg-blue-100 text-blue-800';
                                        break;
                                    default:
                                        $statusClass = 'bg-gray-100 text-gray-600';
                                        break;
                                }
                            @endphp

                            <span
                                class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                ● {{ ucfirst($reservation->status) }}
                            </span>
                        </td>


                        {{-- Acciones --}}
                        <td class="px-4 py-2 flex flex-wrap gap-2 items-center">
                            @can('reservas.edit')
                                <x-buttons.edit wire:click="edit({{ $reservation->id }})"
                                    class="!px-2 !py-1">Editar</x-buttons.edit>
                            @endcan
                            @can('reservas.destroy')
                                <x-buttons.delete wire:click="delete({{ $reservation->id }})"
                                    class="!px-2 !py-1">Eliminar</x-buttons.delete>
                            @endcan

                            {{-- Acciones según estado --}}
                            @if ($reservation->status === 'Pending')
                                <button wire:click="confirmReservation({{ $reservation->id }})"
                                    class="btn-yellow px-2 py-1 rounded text-xs font-semibold shadow hover:scale-105 transition">
                                    Confirmar
                                </button>
                            @elseif ($reservation->status === 'Confirmed')
                                <x-buttons.create wire:click="startConsultation({{ $reservation->id }})"
                                    class="btn-indigo px-2 py-1 rounded text-xs font-semibold shadow hover:scale-105 transition">
                                    Iniciar Consulta
                                </x-buttons.create>
                                <x-buttons.cancel wire:click="cancelReservation({{ $reservation->id }})"
                                    class="btn-red px-2 py-1 rounded text-xs font-semibold shadow hover:scale-105 transition">
                                    Cancelar
                                </x-buttons.cancel>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
        <div class="p-4">{{ $reservations->links() }}</div>
    </div>

    <!-- 🩺 Modal de Consulta -->
    <x-dialog-modal wire:model="openConsultationModal" class="bg-gray-900 text-gray-200">
        <x-slot name="title" class="text-gray-100 font-bold">Iniciar Consulta</x-slot>
        <x-slot name="content" class="bg-gray-900 text-gray-200 space-y-4">

            <!-- Campos con estilos oscuros -->

            <div class="grid grid-cols-2 gap-4 mb-2">
                <div>
                    <label class="block text-gray-300 text-sm font-semibold mb-1">Cliente</label>
                    <input type="text" disabled
                        value="{{ optional(App\Models\Customer::find($customer_id))->name }}"
                        class="w-full rounded-md bg-gray-800 text-gray-100 border border-gray-700 p-2" />
                </div>
                <div>
                    <label class="block text-gray-300 text-sm font-semibold mb-1">Mascota</label>
                    <input type="text" disabled value="{{ optional(App\Models\Pet::find($pet_id))->name }}"
                        class="w-full rounded-md bg-gray-800 text-gray-100 border border-gray-700 p-2" />
                </div>
            </div>
            <input type="text" disabled value="{{ optional(App\Models\Service::find($service_id))->name }}"
                class="w-full rounded-md bg-gray-800 text-gray-100 border border-gray-700 p-2 mb-2" />

            <textarea wire:model="motivo_consulta" placeholder="Motivo de Consulta *"
                class="w-full rounded-md bg-gray-800 text-gray-100 border border-gray-700 p-2 focus:ring-2 focus:ring-indigo-500"
                rows="3" required></textarea>
            <x-input-error for="motivo_consulta" class="text-red-400" />

            <textarea wire:model="tratamiento" placeholder="Tratamiento (opcional)"
                class="w-full rounded-md bg-gray-800 text-gray-100 border border-gray-700 p-2 focus:ring-2 focus:ring-indigo-500"
                rows="3"></textarea>
            <x-input-error for="tratamiento" class="text-red-400" />

            <div class="grid grid-cols-2 gap-4">
                <input type="number" wire:model="peso" placeholder="Peso (kg) (opcional)"
                    class="w-full rounded-md bg-gray-800 text-gray-100 border border-gray-700 p-2 focus:ring-2 focus:ring-indigo-500"
                    step="0.01" />
                <input type="number" wire:model="temperatura" placeholder="Temperatura (°C) (opcional)"
                    class="w-full rounded-md bg-gray-800 text-gray-100 border border-gray-700 p-2 focus:ring-2 focus:ring-indigo-500"
                    step="0.1" />
            </div>

            <textarea wire:model="observations" placeholder="Observaciones (opcional)"
                class="w-full rounded-md bg-gray-800 text-gray-100 border border-gray-700 p-2 focus:ring-2 focus:ring-indigo-500"
                rows="3"></textarea>

            <div class="grid grid-cols-2 gap-4">
                <input type="number" wire:model="frecuencia_cardiaca"
                    placeholder="Frecuencia cardíaca (lpm) (opcional)"
                    class="w-full rounded-md bg-gray-800 text-gray-100 border border-gray-700 p-2 focus:ring-2 focus:ring-indigo-500" />
                <input type="number" wire:model="frecuencia_respiratoria"
                    placeholder="Frecuencia respiratoria (rpm) (opcional)"
                    class="w-full rounded-md bg-gray-800 text-gray-100 border border-gray-700 p-2 focus:ring-2 focus:ring-indigo-500" />
            </div>

            <textarea wire:model="estado_general" placeholder="Estado General (opcional)"
                class="w-full rounded-md bg-gray-800 text-gray-100 border border-gray-700 p-2 focus:ring-2 focus:ring-indigo-500"
                rows="3"></textarea>

            <div class="flex gap-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" wire:model="desparasitacion"
                        class="rounded border-gray-600 bg-gray-800 text-indigo-600 focus:ring-2 focus:ring-indigo-500" />
                    Desparasitado
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" wire:model="vacunado"
                        class="rounded border-gray-600 bg-gray-800 text-indigo-600 focus:ring-2 focus:ring-indigo-500" />
                    Vacunado
                </label>
            </div>

            <textarea wire:model="diagnostico" placeholder="Diagnóstico (opcional)"
                class="w-full rounded-md bg-gray-800 text-gray-100 border border-gray-700 p-2 focus:ring-2 focus:ring-indigo-500"
                rows="3"></textarea>
            <x-input-error for="diagnostico" class="text-red-400" />

            <textarea wire:model="recomendaciones" placeholder="Recomendaciones (opcional)"
                class="w-full rounded-md bg-gray-800 text-gray-100 border border-gray-700 p-2 focus:ring-2 focus:ring-indigo-500"
                rows="3"></textarea>
            <x-input-error for="recomendaciones" class="text-red-400" />

            <fieldset class="border border-gray-700 rounded-md p-3">
                <legend class="text-sm font-semibold mb-2">Servicios Adicionales (opcional)</legend>
                <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto">
                    @foreach ($services as $service)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="selected_services" value="{{ $service->id }}"
                                class="rounded border-gray-600 bg-gray-800 text-indigo-600 focus:ring-2 focus:ring-indigo-500" />
                            {{ $service->name }}
                        </label>
                    @endforeach
                </div>
            </fieldset>

        </x-slot>
        <x-slot name="footer" class="bg-gray-900 text-gray-200 flex gap-2">
            <x-buttons.cancel wire:click="$set('openConsultationModal', false)" type="button"
                class="bg-red-700 hover:bg-red-600 mr-2"> Cancelar</x-buttons.cancel>
            <x-buttons.create wire:click.prevent="saveConsultation" class="bg-green-700 hover:bg-green-600"> Guardar
                Consulta</x-buttons.create>
        </x-slot>
    </x-dialog-modal>
</div>
