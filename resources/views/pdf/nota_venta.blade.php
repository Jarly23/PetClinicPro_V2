<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Nota de Venta #{{ $venta->id_venta}}</title>
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
        .header p {
            margin: 2px 0;
        }

        h3 {
            color: #2c3e50;
            border-bottom: 1px solid #ccc;
            padding-bottom: 4px;
        }
        .info-cliente, .info-venta {
            margin-bottom: 20px;
        }
        .info-cliente p, .info-venta p {
            margin: 4px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
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
        {{-- Puedes reemplazar esta URL con una ruta local --}}
        <img src="https://www.google.com/url?sa=i&url=https%3A%2F%2Fes.vecteezy.com%2Fvectores-gratis%2Flogo-veterinaria&psig=AOvVaw0rqR4onIPnNPubHf-rvc46&ust=1748910543357000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCNjp6s690Y0DFQAAAAAdAAAAABAE">
        <h1>Elite Vets V&F</h1>
        <p>Nota de Venta N° {{ $venta->id_venta }}</p>
        <p><em>Fecha: {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y H:i') }}</em></p>
    </div>

    <div class="info-cliente">
        <h3>Datos del Cliente</h3>
        <p><strong>Nombre:</strong> {{ $venta->cliente->name }} {{ $venta->cliente->lastname }}</p>
        <p><strong>Email:</strong> {{ $venta->cliente->email ?? 'No especificado' }}</p>
        <p><strong>Teléfono:</strong> {{ $venta->cliente->phone ?? 'No especificado' }}</p>
        <p><strong>Dirección:</strong> {{ $venta->cliente->address ?? 'No especificado' }}</p>
        <p><strong>DNI/RUC:</strong> {{ $venta->cliente->dniruc ?? 'No especificado' }}</p>
    </div>

    <div class="info-venta">
        <h3>Detalles de la Venta</h3>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venta->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->product->name ?? 'Producto eliminado' }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>S/{{ number_format($detalle->p_unitario, 2) }}</td>
                        <td>S/{{ number_format($detalle->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;">TOTAL A PAGAR</td>
                    <td>S/{{ number_format($venta->total, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="footer">
        <p>Gracias por su preferencia. ¡Cuidamos a tus mejores amigos! 🐾</p>
    </div>
</body>
</html>
