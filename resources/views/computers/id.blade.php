<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte de {{ $computer->id }} - {{$computer->name}}</title>
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
            width: 140px;
        }
        .status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 12px;
        }
        .status-yes {
            background: #2ecc71;
            color: white;
        }
        .status-no {
            background: #e74c3c;
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
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header">
        <div class="logo">
            <!-- Puedes reemplazar con tu logo en base64 o URL -->
            <h2 style="color: #3498db; margin: 0;">
                <img src="./logo.png" alt="SISA" width="150">
            </h2>
        </div>
        <h1>Reporte de {{$computer->name}}</h1>
        <div class="subtitle">Generado el {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <!-- Información principal -->
    <div class="info-section">
        <h2>Datos del Equipo</h2>
        <div class="info-grid">
            <div class="info-item">
                <strong>Nombre:</strong> {{ $computer->name }}
            </div>
            <div class="info-item">
                <strong>Marca:</strong> {{ $computer->brand->name }}
            </div>
            <div class="info-item">
                <strong>Numero de serie:</strong> {{ $computer->serial_number }}
            </div>
            <div class="info-item">
                <strong>Modelo:</strong> {{ $computer->model }}
            </div>
            <div class="info-item">
                <strong>Sistema Operativo:</strong> {{ $computer->os }}
            </div>
        </div>
    </div>

    <!-- Especificaciones -->
    <div class="info-section">
        <h2>Especificaciones Técnicas</h2>
        <div class="info-item">
            <strong>Descripción:</strong><br>
            {{ $computer->description }}
        </div>
        <div class="info-item" style="margin-top: 10px;">
            <strong>Detalles:</strong><br>
            {{ $computer->specify }}
        </div>
        <div class="info-item" style="margin-top: 10px;">
            <strong>Sucursal:</strong><br>
            {{ $computer->branch_id }}
        </div>
    </div>

    <!-- Estado y fechas -->
    <div class="info-section">
        <div class="info-grid">
            <div class="info-item">
                <strong>Estado:</strong>
                <span class="status {{ $computer->active === 'S' ? 'status-yes' : 'status-no' }}">
                    {{ $computer->active === 'S' ? 'FUNCIONANDO' : 'NO FUNCIONA' }}
                </span>
            </div>
            <div class="info-item">
                <strong>Fecha de compra:</strong> {{ $computer->purchase_date }}
            </div>
            <div class="info-item">
                <strong>Última actualización:</strong> {{ $computer->warranty_until }}
            </div>
            <div class="info-item">
                <strong>Fecha creación:</strong> {{ $computer->created_at->format('d/m/Y H:i') }}
            </div>
            <div class="info-item">
                <strong>Última actualización:</strong> {{ $computer->updated_at->format('d/m/Y H:i') }}
            </div>
        </div>
    </div>

    <!-- Pie de página -->
    <div class="footer">Reporte generado por Sisas </div>
</body>
</html>
