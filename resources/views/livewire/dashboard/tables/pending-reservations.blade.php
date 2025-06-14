<div wire:poll.10s class="flex flex-col col-span-full sm:col-span-6 p-6 bg-white dark:bg-gray-800 shadow-lg rounded-xl transition">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">
            Reservas pendientes
        </h2>
        <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full">
            {{ $total }} en total
        </span>
    </div>

    @if ($pendingReservations->isEmpty())
        <p class="text-gray-500 dark:text-gray-400 text-sm">No hay reservas pendientes.</p>
    @else
        <div class="overflow-x-auto rounded-xl shadow-md">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Cliente</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Mascota</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Veterinario</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Fecha</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($pendingReservations as $res)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $res->customer->name ?? 'Sin cliente' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $res->pet->name ?? 'Sin mascota' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $res->user->name ?? 'Sin asignar' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($res->reservation_date)->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
