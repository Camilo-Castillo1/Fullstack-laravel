<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Novedad o Queja</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 12px;
            margin: 40px;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            color: #0d6efd;
            margin-bottom: 30px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
        }

        .reporte {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .seccion {
            margin-bottom: 15px;
        }

        .seccion strong {
            display: block;
            color: #0d6efd;
            margin-bottom: 4px;
            font-size: 13px;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #6c757d;
        }
    </style>
</head>
<body>

    <h1>📄 Reporte de Novedad o Queja</h1>

    <div class="reporte">
        <div class="seccion">
            <strong>Título del reporte:</strong>
            {{ $reporte->titulo }}
        </div>

        <div class="seccion">
            <strong>Descripción:</strong>
            {{ $reporte->descripcion }}
        </div>

        <div class="seccion">
            <strong>Registrado por:</strong>
            {{ $reporte->usuario->nombre ?? 'Usuario desconocido' }}
        </div>

        <div class="seccion">
            <strong>Fecha de creación:</strong>
            {{ \Carbon\Carbon::parse($reporte->created_at)->format('d/m/Y H:i') }}
        </div>
    </div>

    <div class="footer">
        Sistema de Inventario · Generado automáticamente · {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>
