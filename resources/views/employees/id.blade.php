<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte de {{$employee->name}}</title>
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
            width: 160px;
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
        .status-enabled {
            background: #3498db;
            color: white;
        }
        .status-disabled {
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
        .contact-box {
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            margin-top: 5px;
        }
        .photo-placeholder {
            width: 100px;
            height: 120px;
            background: #eee;
            border: 1px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: #999;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header">
        <div class="logo">
            <h2 style="color: #3498db; margin: 0;">
                <img src="./sisa-logo.png" alt="SISA" width="150">
            </h2>
        </div>
        <h1>Ficha del Empleado: {{ $employee->name }}</h1>
        <div class="subtitle">Generado el {{ now()->format('d/m/Y H:i') }}</div>
    </div>
    @if(asset('storage/employees/' .  $employee->id . '.png'))
        <div class="photo-placeholder">
            <img src="{{ public_path('storage/employees/' .  $employee->id . '.png') }}" alt="Foto del Empleado" width="100" height="120" style="object-fit: cover; border-radius: 5px;">
        </div>
    @else
        <div class="photo-placeholder">
            No hay foto disponible
        </div>
    @endif

    <!-- Información principal -->
    <div class="info-section">
        <h2>Datos Personales</h2>
        <div class="info-grid">
            <div class="info-item">
                <strong>ID del Empleado:</strong> {{ $employee->id }}
            </div>
            <div class="info-item">
                <strong>Nombre Completo:</strong> {{ $employee->name }}
            </div>
            <div class="info-item">
                <strong>Dirección:</strong> {{ $employee->address }}
            </div>
            <div class="info-item">
                <strong>Estado:</strong>
                <span class="status {{ $employee->active === 'S' ? 'status-active' : 'status-inactive' }}">
                    {{ $employee->active === 'S' ? 'ACTIVO' : 'INACTIVO' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Información de contacto -->
    <div class="info-section">
        <h2>Información de Contacto</h2>
        <div class="info-grid">
            <div class="info-item">
                <strong>Correo Electrónico:</strong>
                <div class="contact-box">{{ $employee->email }}</div>
            </div>
            <div class="info-item">
                <strong>Teléfono:</strong>
                <div class="contact-box">{{ $employee->phone ?? 'No registrado' }}</div>
            </div>
        </div>
    </div>

    <!-- Información laboral -->
    <div class="info-section">
        <h2>Información Laboral</h2>
        <div class="info-grid">
            <div class="info-item">
                <strong>Puesto:</strong> {{ $employee->position->name }}
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
