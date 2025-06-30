<div class="p-6 bg-white dark:bg-gray-800 rounded shadow-md" x-data="{ open: false }">
    @if (session()->has('success'))
        <div class="mb-4 p-3 text-green-700 dark:text-green-300 bg-green-100 dark:bg-green-900 rounded">
            {{ session('success') }}
        </div>
    @elseif (session()->has('error'))
        <div class="mb-4 p-3 text-red-700 dark:text-red-300 bg-red-100 dark:bg-red-900 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="applyVaccine" class="space-y-4">
        <div class="w-full flex flex-2">
            <div>
                <label for="vaccineId" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Vacuna</label>
                <select wire:model="vaccineId" id="vaccineId"
                    class="mt-1 block w-full rounded border-gray-300 dark:border-gray-600 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                    <option value="">-- Selecciona una vacuna --</option>
                    @foreach ($availableVaccines as $vaccine)
                        <option value="{{ $vaccine->id }}">{{ $vaccine->name }}</option>
                    @endforeach
                </select>
                @error('vaccineId')
                    <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="application_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de aplicación</label>
                <input type="date" wire:model="application_date" id="application_date"
                    class="mt-1 block w-full rounded border-gray-300 dark:border-gray-600 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" />
                @error('application_date')
                    <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div>
            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notas</label>
            <textarea wire:model="notes" id="notes" rows="3"
                class="mt-1 block w-full rounded border-gray-300 dark:border-gray-600 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"></textarea>
        </div>

        <div class="flex items-center">
            <input type="checkbox" wire:model="with_deworming" id="with_deworming"
                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700">
            <label for="with_deworming" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
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
    <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-gray-500 bg-opacity-50 dark:bg-gray-900 dark:bg-opacity-50"
        @keydown.escape.window="open = false">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full sm:w-96">
            <h3 class="text-xl font-semibold text-center mb-4 text-gray-900 dark:text-white">Confirmación de aplicación</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">¿Estás seguro de que deseas aplicar esta vacuna a {{ $pet->name }}?</p>
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

    <hr class="my-6 border-gray-200 dark:border-gray-700">

    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Historial de vacunación de <span
            class="text-indigo-600 dark:text-indigo-400">{{ $pet->name }}</span></h4>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border border-gray-200 dark:border-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr class="text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                    <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Vacuna</th>
                    <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Fecha aplicación</th>
                    <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Próxima dosis</th>
                    <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Desparasitación</th>
                    <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Veterinario</th>
                    <th class="px-4 py-2 border-b border-gray-200 dark:border-gray-600">Notas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse ($pet->vaccineApplications as $application)
                    <tr class="text-sm text-gray-800 dark:text-gray-200">
                        <td class="px-4 py-2">{{ $application->vaccine->name }}</td>
                        <td class="px-4 py-2">
                            {{ \Carbon\Carbon::parse($application->application_date)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">
                            {{ \Carbon\Carbon::parse($application->application_date)->addDays($application->vaccine->application_interval_days)->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-2">
                            <span
                                class="inline-block px-2 py-1 rounded text-xs font-medium {{ $application->with_deworming ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300' }}">
                                {{ $application->with_deworming ? 'Sí' : 'No' }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $application->user->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $application->notes ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">No hay vacunas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
```
 
