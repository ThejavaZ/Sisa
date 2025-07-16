<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de puestos</title>
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
            <h2 style="color: #3498db; margin: 0;">
                <img src="./sisa-logo.png" alt="SISA" width="150">
            </h2>
        </div>
        <h1>Reporte de puestos</h1>
        <div class="subtitle">Generado el {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <div class="info-section">
        <h2>Lista de Puestos</h2>
        <table border="1" cellpadding="1" cellspacing="0" style="width: 10px; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Nivel</th>
                    <th>Departamento</th>
                    <th>Descripcion</th>
                    <th>Salario</th>
                    <th>Activo</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($positions as $position)
                <tr>
                    <td>{{ $position->id }}</td>
                    <td>{{ $position->name }}</td>
                    <td>
                        @if ($position->level == 1)
                            Administrativo
                        @elseif ($position->level == 2)
                            Operativo
                        @elseif ($position->level == 3)
                            Supervicion/Cordinacion
                        @elseif ($position->level == 4)
                            Direccion/Gerencia
                        @else
                            desconocido
                        @endif
                    </td>
                    <td>{{ $position->department_id }}</td>
                    <td>{{ $position->description }}</td>
                    <td>${{ $position->salary }}</td>
                    <td>{{ $position->funct == 'S' ? 'Si' : 'No' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
