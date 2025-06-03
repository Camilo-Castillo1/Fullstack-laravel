<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Productos</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #212529;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            color: #198754;
        }
        .meta {
            margin-bottom: 20px;
            font-size: 12px;
        }
        .meta strong {
            color: #198754;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #f0f0f0;
        }
        .badge-activo {
            background-color: #198754;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 11px;
        }
        .badge-inactivo {
            background-color: #6c757d;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 11px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Reporte de Productos</h2>
        <small>Sistema de Inventario - Administrador de Bodega</small>
    </div>

    <div class="meta">
        <p><strong>Generado por:</strong> {{ Auth::user()->nombre }} ({{ Auth::user()->correo }})</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock Mínimo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $producto->codigo_producto }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->categoria->nombre ?? 'N/A' }}</td>
                    <td>$ {{ number_format($producto->precio_unitario, 0, ',', '.') }}</td>
                    <td>{{ $producto->stock_minimo }}</td>
                    <td>
                        <span class="{{ $producto->estado === 'activo' ? 'badge-activo' : 'badge-inactivo' }}">
                            {{ ucfirst($producto->estado) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
