<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte de {{$position->name}}</title>
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
            margin-bottom: 8px;
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
        .salary {
            font-weight: bold;
            color: #27ae60;
        }
        .description-box {
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header">
        <div class="logo">
            <!-- Puedes reemplazar con tu logo en base64 o URL -->
            <h2 style="color: #3498db; margin: 0;">
                <img src="./sisa-logo.png" alt="SISA" width="150">
            </h2>
        </div>
        <h1>Reporte de Puesto: {{ $position->name }}</h1>
        <div class="subtitle">Generado el {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <!-- Información principal -->
    <div class="info-section">
        <h2>Datos Básicos del Puesto</h2>
        <div class="info-grid">
            <div class="info-item">
                <strong>ID del Puesto:</strong> {{ $position->id }}
            </div>
            <div class="info-item">
                <strong>Nombre del Puesto:</strong> {{ $position->name }}
            </div>
            <div class="info-item">
                <strong>Salario:</strong>
                <span class="salary">${{ number_format($position->salary, 2) }}</span>
            </div>
            <div class="info-item">
                <strong>Estado Activo:</strong>
                <span class="status {{ $position->active === 'S' ? 'status-active' : 'status-inactive' }}">
                    {{ $position->active === 'S' ? 'ACTIVO' : 'INACTIVO' }}
                </span>
            </div>
            <div class="info-item">
                <strong>Estado del Sistema:</strong>
                <span class="status {{ $position->status ? 'status-enabled' : 'status-disabled' }}">
                    {{ $position->status ? 'HABILITADO' : 'DESHABILITADO' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Descripción -->
    <div class="info-section">
        <h2>Descripción del Puesto</h2>
        <div class="info-item">
            <div class="description-box">
                {{ $position->description ?? 'No se ha proporcionado una descripción.' }}
            </div>
        </div>
    </div>

    <!-- Fechas -->
    <div class="info-section">
        <h2>Información de Registro</h2>
        <div class="info-grid">
            <div class="info-item">
                <strong>Fecha de creación:</strong>
                {{ $position->created_at->format('d/m/Y H:i') }}
            </div>
            <div class="info-item">
                <strong>Última actualización:</strong>
                {{ $position->updated_at->format('d/m/Y H:i') }}
            </div>
        </div>
    </div>

    <!-- Pie de página -->
    <div class="footer">
        Reporte generado por SISA - Sistema Integrado de Administración<br>
        Página {PAGENO} de {nbpg}
    </div>
</body>
</html>
