<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de usuarios</title>
</head>
<body>
    <div class="header">
        <div class="logo">
            <h2 style="color: #3498db; margin: 0;">
                <img src="./sisa-logo.png" alt="SISA" width="150">
            </h2>
        </div>
        <h1>Reporte de usuarios</h1>
        <div class="subtitle">Generado el {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <div class="info-section">
        <h2>Lista de Usuarios</h2>
        <table border="1" cellpadding="1" cellspacing="0" style="width: 10px; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Idioma</th>
                    <th>Activo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role == 1 ? 'administrador' : 'operador' }}</td>
                    <td>{{ $user->languaje == 1 ? 'Español' : 'Inglés'  }}</td>
                    <td>{{ $user->active == 'S' ? 'Si' : 'No' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
