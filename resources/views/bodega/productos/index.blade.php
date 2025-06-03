@extends('layouts.bodega')

@section('title', 'Productos - Administrador de Bodega')

@section('content')
<div class="container py-4">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success mb-0">
            <i class="bi bi-box-seam-fill me-2"></i>Gestión de Productos
        </h3>
        <div class="d-flex gap-2">

            <a href="{{ route('bodega.productos.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle-fill"></i> Agregar Producto
            </a>
        </div>
    </div>

    {{-- Tabla de productos --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table id="tabla-productos" class="table table-hover table-bordered align-middle w-100">
                    <thead class="table-success text-center">
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Descripción</th>
                            <th style="min-width: 100px;">Stock Mínimo</th>
                            <th style="min-width: 120px;">Precio</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                            <tr class="align-middle text-center">
                                <td>{{ $loop->iteration }}</td>

                                <td style="white-space: normal; overflow-wrap: break-word; word-break: break-word;">
                                    {{ $producto->codigo_producto }}
                                </td>

                                <td class="text-start" style="white-space: normal; overflow-wrap: break-word; word-break: break-word;">
                                    {{ $producto->nombre }}
                                </td>

                                <td style="white-space: normal; overflow-wrap: break-word; word-break: break-word;">
                                    {{ $producto->categoria->nombre ?? 'N/A' }}
                                </td>

                                <td class="text-start" style="white-space: normal; overflow-wrap: break-word; word-break: break-word;">
                                    {{ $producto->descripcion }}
                                </td>

                                <td>{{ $producto->stock_minimo }}</td>

                                <td>$ {{ number_format($producto->precio_unitario, 0, ',', '.') }}</td>

                                <td>
                                    <span class="badge {{ $producto->estado === 'activo' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ ucfirst($producto->estado) }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('bodega.productos.edit', $producto->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#tabla-productos').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                pageLength: 10,
                responsive: true,
                order: [[0, 'asc']],
            });
        });
    </script>
@endpush
