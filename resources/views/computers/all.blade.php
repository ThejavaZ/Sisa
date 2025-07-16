<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de computadoras</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .logo img {
            width: 120px;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 13px;
            color: #888;
            margin-bottom: 10px;
        }
        h1 {
            color: #3498db;
            margin-bottom: 5px;
        }
        h2 {
            color: #2c3e50;
            font-size: 18px;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            table-layout: auto;
            word-break: break-word;
        }
        th, td {
            border: 1px solid #b0bec5;
            padding: 10px 6px;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #e3f2fd;
            color: #1565c0;
            font-size: 13px;
        }
        tr:nth-child(even) {
            background-color: #f5faff;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('sisa-logo.png') }}" alt="SISA">
        </div>
        <h1>Reporte de computadoras</h1>
        <div class="subtitle">Generado el {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <div class="info-section">
        <h2>Lista de Computadoras</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Número de serie</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Descripción</th>
                    <th>Especificaciones</th>
                    <th>Sistema Operativo</th>
                    <th>Fecha de compra</th>
                    <th>Garantía hasta</th>
                    <th>Sucursal</th>
                    <th>Activo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($computers as $computer)
                <tr>
                    <td>{{ $computer->id }}</td>
                    <td>{{ $computer->name }}</td>
                    <td>{{ $computer->serial_number }}</td>
                    <td>{{ $computer->brand_id }}</td>
                    <td>{{ $computer->model }}</td>
                    <td>{{ $computer->description }}</td>
                    <td>{{ $computer->specify }}</td>
                    <td>{{ $computer->os }}</td>
                    <td>{{ $computer->purchase_date }}</td>
                    <td>{{ $computer->warranty_until }}</td>
                    <td>{{ $computer->branch_id }}</td>
                    <td>{{ $computer->active == 'S' ? 'Sí' : 'No' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
