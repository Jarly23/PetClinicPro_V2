<div class="p-6 bg-white rounded shadow-md" x-data="{ open: false }">
    @if (session()->has('success'))
        <div class="mb-4 p-3 text-green-700 bg-green-100 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="applyVaccine" class="space-y-4">
        <div class="w-full flex flex-2">
            <div>
                <label for="vaccineId" class="block text-sm font-medium text-gray-700">Vacuna</label>
                <select wire:model="vaccineId" id="vaccineId"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Selecciona una vacuna --</option>
                    @foreach ($availableVaccines as $vaccine)
                        <option value="{{ $vaccine->id }}">{{ $vaccine->name }}</option>
                    @endforeach
                </select>
                @error('vaccineId')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="application_date" class="block text-sm font-medium text-gray-700">Fecha de aplicación</label>
                <input type="date" wire:model="application_date" id="application_date"
                    class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                @error('application_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div>
            <label for="notes" class="block text-sm font-medium text-gray-700">Notas</label>
            <textarea wire:model="notes" id="notes" rows="3"
                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
        </div>

        <div class="flex items-center">
            <input type="checkbox" wire:model="with_deworming" id="with_deworming"
                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
            <label for="with_deworming" class="ml-2 block text-sm text-gray-700">
                Incluye desparasitación
            </label>
        </div>

        <!-- Botón para abrir el modal -->
        <button type="button" @click="open = true"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            Aplicar vacuna
        </button>
    </form>

    <!-- Modal de confirmación -->
    <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-gray-500 bg-opacity-50"
        @keydown.escape.window="open = false">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full sm:w-96">
            <h3 class="text-xl font-semibold text-center mb-4">Confirmación de aplicación</h3>
            <p class="text-sm text-gray-600 mb-4">¿Estás seguro de que deseas aplicar esta vacuna a {{ $pet->name }}?</p>
            <div class="flex justify-between">
                <button @click="open = false"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none">
                    Cancelar
                </button>
                <button @click="open = false; $wire.applyVaccine()"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none">
                    Confirmar
                </button>
            </div>
        </div>
    </div>

    <hr class="my-6">

    <h4 class="text-lg font-semibold text-gray-800 mb-4">Historial de vacunación de <span
            class="text-indigo-600">{{ $pet->name }}</span></h4>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border border-gray-200">
            <thead class="bg-gray-100">
                <tr class="text-left text-sm font-medium text-gray-700">
                    <th class="px-4 py-2 border-b">Vacuna</th>
                    <th class="px-4 py-2 border-b">Fecha aplicación</th>
                    <th class="px-4 py-2 border-b">Próxima dosis</th>
                    <th class="px-4 py-2 border-b">Desparasitación</th>
                    <th class="px-4 py-2 border-b">Veterinario</th>
                    <th class="px-4 py-2 border-b">Notas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($pet->vaccineApplications as $application)
                    <tr class="text-sm text-gray-800">
                        <td class="px-4 py-2">{{ $application->vaccine->name }}</td>
                        <td class="px-4 py-2">
                            {{Carbon::parse($application->application_date)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">
                            {{Carbon::parse($application->application_date)->addDays($application->vaccine->application_interval_days)->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-2">
                            <span
                                class="inline-block px-2 py-1 rounded text-xs font-medium {{ $application->with_deworming ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $application->with_deworming ? 'Sí' : 'No' }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $application->user->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $application->notes ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">No hay vacunas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
