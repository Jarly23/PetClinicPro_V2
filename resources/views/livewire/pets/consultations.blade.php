<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto bg-gray-300 rounded-xl m-5">
    <h2 class="text-xl text-blue-700 font-black">Historial Médico de {{ $pet->name }}</h2>

    @if ($consultations->isEmpty())
        <div class="text-center text-gray-600 py-10">
            No hay consultas registradas para esta mascota.
        </div>
    @else
        <div class="relative flex flex-col w-full h-full text-gray-700 bg-white shadow-md rounded-xl mt-4 overflow-auto">
            <table class="w-full text-left table-auto min-w-max">
                <thead>
                    <tr class="bg-blue-gray-100">
                        <th class="p-4">Fecha</th>
                        <th class="p-4">Veterinario</th>
                        <th class="p-4">Servicio</th>
                        <th class="p-4">Diagnóstico</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($consultations as $consultation)
                        <tr class="even:bg-gray-50">
                            <td class="px-4 py-2">{{ $consultation->consultation_date }}</td>
                            <td class="px-4 py-2">{{ $consultation->user->name ?? '—' }}</td>
                            <td class="px-4 py-2">
                                @foreach ($consultation->services as $service)
                                    <span
                                        class="inline-block bg-gray-200 px-2 py-1 rounded text-sm">{{ $service->name ?? '--'}}</span>
                                @endforeach
                            </td>
                            <td class="px-4 py-2">{{ $consultation->diagnostico }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
