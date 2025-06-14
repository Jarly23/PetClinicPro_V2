<!-- resources/views/pdf/report.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Cliente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
        }
        h2 {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }
        p {
            font-size: 14px;
            margin: 5px 0;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }
        th {
            background-color: #f8f8f8;
            color: #333;
        }
        .total {
            font-weight: bold;
            font-size: 16px;
            color: #333;
            border-top: 2px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>NOTA DE SERVICIOS</h1>

    <h2>Información del Cliente</h2>
    <table>
        <tr>
            <th>Nombre</th>
            <td>{{ $customer->name }}</td>
        </tr>
        <tr>
            <th>DNI/RUC</th>
            <td>{{ $customer->dniruc }}</td>
        </tr>
        <tr>
            <th>Correo</th>
            <td>{{ $customer->email }}</td>
        </tr>
        <tr>
            <th>Teléfono</th>
            <td>{{ $customer->phone }}</td>
        </tr>
    </table>

    <h2>Detalles de la Consulta</h2>
    <table>
        <tr>
            <th>Fecha de Consulta</th>
            <td>{{ $consultation->consultation_date }}</td>
        </tr>
        <tr>
            <th>Servicio</th>
            <td>{{ $consultation->services->name }}</td>
        </tr>
        <tr>
            <th>Detalles del Servicio</th>
            <td>{{ $consultation->service->description }}</td>
        </tr>
        <tr>
            <th>Precio</th>
            <td>${{ $consultation->service->price }}</td>
        </tr>
    </table>

    <div class="total">
        <p><strong>Total a Pagar:</strong> ${{ $consultation->service->price }}</p>
    </div>
</div>
</body>
</html>
