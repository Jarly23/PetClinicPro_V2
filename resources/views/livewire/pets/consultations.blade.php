<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto bg-gray-300 rounded-xl m-5">
    <h2 class="text-xl text-blue-700 font-black">Historial Médico de {{ $pet->name }}</h2>

    @if ($consultations->isEmpty())
        <div class="text-center text-gray-600 py-10">
            No hay consultas registradas para esta mascota.
        </div>
    @else
        <div class="relative flex flex-col w-full h-full text-gray-700 bg-white shadow-md rounded-xl mt-4 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left table-auto">
                    <thead>
                        <tr class="bg-blue-gray-100">
                            <th class="p-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Fecha</th>
                            <th class="p-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Motivo</th>
                            <th class="p-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Veterinario</th>
                            <th class="p-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Servicios</th>
                            <th class="p-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Diagnóstico</th>
                            <th class="p-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Tratamiento</th>
                            <th class="p-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Obs.</th>
                            <th class="p-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($consultations as $consultation)
                            <tr class="even:bg-gray-50 hover:bg-gray-100">
                                <td class="px-3 py-2 text-xs whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('d/m/Y') }}
                                </td>
                                <td class="px-3 py-2 text-xs">
                                    <span class="inline-block max-w-24 truncate" title="{{ $consultation->motivo_consulta }}">
                                        {{ $consultation->motivo_consulta }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-xs">
                                    <span class="inline-block max-w-20 truncate" title="{{ $consultation->user->name ?? '—' }}">
                                        {{ $consultation->user->name ?? '—' }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-xs">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($consultation->services as $service)
                                            <span class="inline-block bg-gray-200 px-1 py-0.5 rounded text-xs max-w-16 truncate" title="{{ $service->name ?? '--' }}">
                                                {{ $service->name ?? '--' }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-3 py-2 text-xs">
                                    <span class="inline-block max-w-24 truncate" title="{{ $consultation->diagnostico }}">
                                        {{ $consultation->diagnostico }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-xs">
                                    <span class="inline-block max-w-24 truncate" title="{{ $consultation->tratamiento }}">
                                        {{ $consultation->tratamiento }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-xs">
                                    <span class="inline-block max-w-20 truncate" title="{{ $consultation->observaciones }}">
                                        {{ $consultation->observaciones }}
                                    </span>
                                </td>
                                <td class="px-3 py-2 text-xs">
                                    <span class="inline-block max-w-16 truncate" title="{{ $consultation->estado }}">
                                        {{ $consultation->estado }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
