<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de empleados</title>
</head>
<body>
    <div class="header">
        <div class="logo">
            <h2 style="color: #3498db; margin: 0;">
                <img src="./sisa-logo.png" alt="SISA" width="150">
            </h2>
        </div>
        <h1>Reporte de empleados</h1>
        <div class="subtitle">Generado el {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <div class="info-section">
        <h2>Lista de empleados</h2>
        <table border="1" cellpadding="1" cellspacing="0" style="width: 10px; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirrección</th>
                    <th>Correo</th>
                    <th>Celular</th>
                    <th>Puesto</th>
                    <th>Activo</th>
                </tr>
            </thead>
            <tbody style="text-align: center; font-size: 12px;">
                @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->name }} {{ $employee->name }} {{ $employee->name }}</td>
                    <td>{{ $employee->address }} {{ $employee->address }} {{ $employee->address }} {{ $employee->address }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $employee->position->name }}</td>
                    <td>
                        @if ($employee->active == "S")
                            Si
                        @else
                            No
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
