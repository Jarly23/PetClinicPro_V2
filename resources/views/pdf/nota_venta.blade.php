<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota de Venta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Nota de Venta #{{ $venta->id_venta }}</h1>
    <p><strong>Cliente:</strong> 
        {{ $venta->cliente->name }} 
        {{ $venta->cliente->lastname }}
    </p>
    <p><strong>Fecha:</strong> {{ $venta->fecha }}</p>
    <p><strong>Total:</strong> ${{ number_format($venta->total, 2) }}</p>

    <h3>Detalles de la Venta</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detalleVentas as $detalle)
                <tr>
                    <td>{{ $detalle->producto->name ?? 'Producto eliminado' }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>${{ number_format($detalle->p_unitario, 2) }}</td>
                    <td>${{ number_format($detalle->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
