<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte de Usuario: {{$user->name}}</title>
    <style>
        @page { margin: 20px; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #2c3e50;
            margin-bottom: 5px;
            font-size: 24px;
        }
        .header .subtitle {
            color: #7f8c8d;
            font-size: 14px;
        }
        .info-section {
            margin-bottom: 20px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #3498db;
        }
        .info-section h2 {
            color: #2c3e50;
            font-size: 18px;
            margin-top: 0;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .info-item {
            margin-bottom: 12px;
        }
        .info-item strong {
            color: #2c3e50;
            display: inline-block;
            width: 180px;
        }
        .status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 12px;
        }
        .status-active {
            background: #2ecc71;
            color: white;
        }
        .status-inactive {
            background: #e74c3c;
            color: white;
        }
        .status-verified {
            background: #3498db;
            color: white;
        }
        .status-unverified {
            background: #f39c12;
            color: white;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .logo {
            text-align: center;
            margin-bottom: 15px;
        }
        .logo img {
            max-height: 60px;
        }
        .user-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #3498db;
            margin: 0 auto 15px;
            display: block;
        }
        .photo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .role-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 15px;
            font-weight: bold;
            font-size: 12px;
            background: #9b59b6;
            color: white;
        }
        .language-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 15px;
            font-weight: bold;
            font-size: 12px;
            background: #1abc9c;
            color: white;
        }
        .verified-info {
            font-size: 12px;
            color: #7f8c8d;
            font-style: italic;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header">
        <div class="logo">
            <img src="./sisa-logo.png" alt="SISA" width="150">
        </div>
        <h1>Reporte de Usuario</h1>
        <div class="subtitle">Generado el {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <!-- Foto del usuario -->
    <div class="photo-container">
        @if(file_exists(public_path('storage/users/img/'.$user->id.'.png')))
            <img src="{{ public_path('storage/users/img/'.$user->id.'.png') }}" class="user-photo" alt="Foto de perfil">
        @else
            <div style="width: 120px; height: 120px; border-radius: 50%; background: #eee; border: 3px solid #ccc; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                Sin foto
            </div>
        @endif
        <h3>{{ $user->name }}</h3>
    </div>

    <!-- Información básica -->
    <div class="info-section">
        <h2>Información Básica</h2>
        <div class="info-grid">
            <div class="info-item">
                <strong>Nombre:</strong> {{ $user->name }}
            </div>
            <div class="info-item">
                <strong>Correo Electrónico:</strong> {{ $user->email }}
            </div>
            <div class="info-item">
                <strong>Estado:</strong>
                <span class="status {{ $user->active === 'S' ? 'status-active' : 'status-inactive' }}">
                    {{ $user->active === 'S' ? 'ACTIVO' : 'INACTIVO' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Configuraciones -->
    <div class="info-section">
        <h2>Configuraciones del Usuario</h2>
        <div class="info-grid">
            <div class="info-item">
                <strong>Rol:</strong>
                <span class="role-badge">
                    @switch($user->role)
                        @case(1) Administrador @break
                        @case(2) Gerente @break
                        @case(3) Operador @break
                        @case(4) Contador @break
                        @case(5) Cliente @break
                        @case(6) Proveedor @break
                        @default Rol desconocido ({{ $user->role }})
                    @endswitch
                </span>
            </div>
            <div class="info-item">
                <strong>Idioma:</strong>
                <span class="language-badge">
                    @switch($user->language)
                        @case(1) Español @break
                        @case(2) Inglés @break
                        @case(3) Francés @break
                        @default Idioma desconocido ({{ $user->languaje }})
                    @endswitch
                </span>
            </div>
            <div class="info-item">
                <strong>Estado en Sistema:</strong>
                <span class="status {{ $user->status ? 'status-active' : 'status-inactive' }}">
                    {{ $user->status ? 'HABILITADO' : 'DESHABILITADO' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Fechas -->
    <div class="info-section">
        <h2>Historial del Registro</h2>
        <div class="info-grid">
            <div class="info-item">
                <strong>Fecha de creación:</strong>
                {{ $user->created_at->format('d/m/Y H:i') }}
            </div>
            <div class="info-item">
                <strong>Última actualización:</strong>
                {{ $user->updated_at->format('d/m/Y H:i') }}
            </div>
        </div>
    </div>

    <!-- Pie de página -->
    <div class="footer">
        Reporte generado por SISA - Sistema Integrado de Administración<br>
        Página {PAGENO} de {nbpg} | Documento confidencial
    </div>
</body>
</html>
