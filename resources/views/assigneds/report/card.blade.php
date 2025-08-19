<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carta de {{ $assigned->employee->name }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            color: #222;
            margin: 40px;
        }
        header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 25px;
        }
        header img {
            width: 140px;
            margin-right: 30px;
        }
        header h1 {
            font-size: 22px;
            color: #3498db;
            margin: 0;
            font-weight: bold;
        }
        .info {
            margin-bottom: 18px;
        }
        .info strong {
            color: #2c3e50;
        }
        .section-title {
            font-size: 16px;
            color: #1565c0;
            margin-top: 25px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }
        th, td {
            border: 1px solid #b0bec5;
            padding: 8px 6px;
            text-align: left;
        }
        th {
            background-color: #e3f2fd;
            color: #1565c0;
        }
        .terms {
            background: #f5faff;
            border-left: 4px solid #3498db;
            padding: 12px 18px;
            margin-bottom: 30px;
        }
        .firmas {
            margin-top: 40px;
            display: flex;
            flex-direction: row; /* Lado a lado */
            justify-content: space-between;
            gap: 40px;
        }
        .firma-block {
            width: 45%; /* Ocupa casi la mitad cada una */
            text-align: center;
        }
        .firma-line {
            margin-top: 50px;
            border-top: 1px solid #222;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }
        .firma-nombre {
            margin-top: 8px;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <header>
        <img src="./logo.png" alt="logo">
        <h1>ACTA DE ENTREGA DE EQUIPO DE CÓMPUTO</h1>
    </header>

    <div class="info">
        <strong>Lugar y fecha:</strong>
        Hermosillo, Sonora, México, {{ date('d/m/Y') }} &nbsp; &nbsp; <strong>Hora:</strong> {{ date('H:i') }}
    </div>

    <div class="info">
        Por medio de la presente, en la ciudad de Hermosillo, Sonora, México, el departamento de Sistemas y el departamento de Gerencia de la empresa <strong>SISA Sistemas Automatizados S.A. de C.V.</strong> otorgan al C. <strong>{{ $assigned->employee->name }}</strong> con el número de empleado <strong>{{ $assigned->employee->id ?? 'N/A' }}</strong>, quien desempeña el puesto de <strong>{{ $assigned->employee->position->name ?? 'N/A' }}</strong> en el departamento <strong>{{ $assigned->employee->position->department->name ?? 'N/A' }}</strong>, el siguiente equipo de cómputo:
    </div>

    <div class="section-title">Datos del equipo entregado</div>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Número de serie</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Descripción</th>
                <th>Especificaciones</th>
                <th>Sistema Operativo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $assigned->computer->name }}</td>
                <td>{{ $assigned->computer->serial_number }}</td>
                <td>{{ $assigned->computer->brand->name }}</td>
                <td>{{ $assigned->computer->model }}</td>
                <td>{{ $assigned->computer->description }}</td>
                <td>{{ $assigned->computer->specify }}</td>
                <td>{{ $assigned->computer->os }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">Términos y condiciones</div>
    <div class="terms">
        1. El equipo es propiedad de <strong>SISA Sistemas Automatizados S.A. de C.V.</strong> y debe ser utilizado exclusivamente para labores laborales.<br>
        2. El empleado se compromete a notificar cualquier daño o falla al Departamento de Sistemas.<br>
        3. No se permite la instalación de software no autorizado.<br>
        4. En caso de terminación laboral, el empleado debe devolver el equipo en buen estado.
    </div>

    <div class="section-title">Firmas de conformidad</div>
    <br>
    <br>
    <br>
    <br>
    <br>
        <table style="width:100%; margin-top:40px;border:none">
            <tr>
                <td style="width:50%; text-align:center;">
                    <div style="margin-top:50px; border-top:1px solid #222; width:80%; margin:auto;"></div>
                    <div style="margin-top:8px; font-size:13px;">Entregador<br>Nombre y firma</div>
                </td>
                <td style="width:50%; text-align:center;">
                    <div style="margin-top:50px; border-top:1px solid #222; width:80%; margin:auto;"></div>
                    <div style="margin-top:8px; font-size:13px;">Recibidor<br>Nombre y firma</div>
                </td>
            </tr>
        </table>
</body>
</html>
