<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial Médico de {{ $pet->name }}</title>
</head>
<body>

    <h1>Historial Médico de {{ $pet->name }}</h1>

    <table class="min-w-full table-auto bg-white rounded-lg">
        <thead>
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Fecha de Consulta</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Veterinario</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Servicio</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-gray-900">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($consultations as $consultation)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $consultation->consultation_date }}</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $consultation->veterinarian->name }}</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $consultation->service->name }}</td>
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $consultation->observations }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
