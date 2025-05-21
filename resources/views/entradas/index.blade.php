@extends('layouts.app')

@section('header', 'Entradas de Inventario')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 text-primary fw-bold">
            <i class="bi bi-box-seam me-2"></i> Entradas de Inventario
        </h4>
        <a href="{{ route('admin.entradas.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Nueva Entrada
        </a>
    </div>

    <div class="card shadow border-0 animate__animated animate__fadeIn">
        <div class="card-body">
            @if ($entradas->isEmpty())
                <div class="alert alert-info text-center" role="alert">
                    <i class="bi bi-info-circle me-2"></i> No hay entradas registradas aún.
                </div>
            @else
                <div class="table-responsive">
                    <table id="tabla-entradas" class="table table-striped table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Código Lote</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Usuario</th>
                                <th>Fecha</th>
                                <th>Motivo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entradas as $entrada)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $entrada->lote->codigo_lote }}</td>
                                    <td>{{ $entrada->lote->producto->nombre ?? 'N/A' }}</td>
                                    <td>{{ $entrada->cantidad }}</td>
                                    <td>{{ $entrada->usuario->nombre ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($entrada->fecha_movimiento)->format('Y-m-d H:i') }}</td>
                                    <td>{{ $entrada->motivo }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.entradas.edit', $entrada->id) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $entrada->id }})" title="Eliminar">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                            <form id="delete-form-{{ $entrada->id }}" action="{{ route('admin.entradas.destroy', $entrada->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- SweetAlert para confirmar eliminación -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar entrada?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#tabla-entradas').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            order: [[2, 'asc']], // Ordenar por producto
            columnDefs: [
                { targets: '_all', className: 'align-middle text-center' }
            ]
        });
    });
</script>

<!-- Animaciones -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection
