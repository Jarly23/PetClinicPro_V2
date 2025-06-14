<div wire:poll.10s
    class="flex flex-col col-span-full sm:col-span-6 p-6 bg-white dark:bg-gray-800 shadow-lg rounded-xl transition">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">
            Vacunas pendientes
        </h2>
        <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full">
            {{ $total }} en total
        </span>
    </div>

    @if ($pendingVaccinations->isEmpty())
        <p class="text-gray-500 dark:text-gray-400 text-sm">No hay vacunas pendientes próximas.</p>
    @else
        <div class="overflow-x-auto rounded-xl shadow-md">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Cliente
                        </th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Mascota
                        </th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Próxima
                            vacunación</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Veterinario</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($pendingVaccinations as $pet)
                        @php
                            // Tomar la próxima vacuna pendiente
                            $nextVaccineApplication = $pet->vaccineApplications
                                ->filter(function ($app) {
                                    $nextDate = \Carbon\Carbon::parse($app->application_date)->addDays(
                                        $app->vaccine->application_interval_days,
                                    );
                                    return $nextDate->between(
                                        \Carbon\Carbon::today(),
                                        \Carbon\Carbon::today()->addDays(7),
                                    );
                                })
                                ->sortBy('application_date')
                                ->first();

                            $nextVaccinationDate = $nextVaccineApplication
                                ? \Carbon\Carbon::parse($nextVaccineApplication->application_date)->addDays(
                                    $nextVaccineApplication->vaccine->application_interval_days,
                                )
                                : null;
                        @endphp
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">
                                {{ $pet->owner->name ?? 'Sin cliente' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">
                                {{ $pet->name ?? 'Sin mascota' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">
                                @if ($nextVaccineApplication)
                                    {{ $nextVaccinationDate->format('d/m/Y') }}
                                @else
                                    <span class="text-gray-400 italic">Sin próxima vacuna</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">
                                {{ $nextVaccineApplication->user->name ?? 'Sin asignar' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
