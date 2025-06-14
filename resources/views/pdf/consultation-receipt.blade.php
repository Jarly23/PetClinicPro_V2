<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Boleta de Consulta #{{ $consultation->id }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #2980b9;
            padding-bottom: 10px;
        }

        .header img {
            max-width: 80px;
            display: block;
            margin: 0 auto 10px auto;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #2980b9;
        }

        h3 {
            color: #2c3e50;
            border-bottom: 1px solid #ccc;
            padding-bottom: 4px;
        }

        .info-cliente,
        .info-consulta {
            margin-bottom: 20px;
        }

        .info-cliente p,
        .info-consulta p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #bbb;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background-color: #2980b9;
            color: white;
        }

        tfoot td {
            font-weight: bold;
            background-color: #f4f6f7;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <div class="header">

        
        <h1>Elite Vets V&F</h1>
        <p>Boleta de Consulta N° {{ $consultation->id }}</p>
        <p><em>Fecha: {{ \Carbon\Carbon::parse($consultation->consultation_date)->format('d/m/Y H:i') }}</em></p>
    </div>

    <div class="info-cliente">
        <h3>Datos del Cliente</h3>
        <p><strong>Nombre:</strong> {{ $consultation->customer->name }}</p>
        <p><strong>Teléfono:</strong> {{ $consultation->customer->phone ?? 'No especificado' }}</p>
        <p><strong>Mascota:</strong> {{ $consultation->pet->name }}</p>
    </div>

    <div class="info-consulta">
        <h3>Detalles de la Consulta</h3>

        <p><strong>Veterinario:</strong> {{ $consultation->user->name }}</p>

        @if (!empty($consultation->motivo_consulta))
            <p><strong>Motivo:</strong> {{ $consultation->motivo_consulta }}</p>
        @endif

        @if (!empty($consultation->peso))
            <p><strong>Peso:</strong> {{ $consultation->peso }} kg</p>
        @endif

        @if (!empty($consultation->temperatura))
            <p><strong>Temperatura:</strong> {{ $consultation->temperatura }} °C</p>
        @endif

        @if (!empty($consultation->frecuencia_cardiaca))
            <p><strong>F. Cardíaca:</strong> {{ $consultation->frecuencia_cardiaca }}</p>
        @endif

        @if (!empty($consultation->frecuencia_respiratoria))
            <p><strong>F. Respiratoria:</strong> {{ $consultation->frecuencia_respiratoria }}</p>
        @endif

        @if (!empty($consultation->estado_general))
            <p><strong>Estado General:</strong> {{ $consultation->estado_general }}</p>
        @endif

        <p><strong>Vacunado:</strong> {{ $consultation->vacunado ? 'Sí' : 'No' }}</p>
        <p><strong>Desparasitado:</strong> {{ $consultation->desparasitacion ? 'Sí' : 'No' }}</p>

        @if (!empty($consultation->tratamiento))
            <p><strong>Tratamiento:</strong> {{ $consultation->tratamiento }}</p>
        @endif

        @if (!empty($consultation->diagnostico))
            <p><strong>Diagnóstico:</strong> {{ $consultation->diagnostico }}</p>
        @endif

        @if (!empty($consultation->recomendaciones))
            <p><strong>Recomendaciones:</strong> {{ $consultation->recomendaciones }}</p>
        @endif
    </div>

    <h3>Servicios Realizados</h3>
    <table>
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($consultation->services as $service)
                <tr>
                    <td>{{ $service->name }}</td>
                    <td>S/ {{ number_format($service->price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>Total a pagar</td>
                <td>S/ {{ number_format($total, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Gracias por confiar en Elite Vets V&F. ¡Cuidamos a tus mejores amigos! 🐾</p>
    </div>
</body>

</html>
