@extends('layouts.app')

@section('header', 'Salidas de Inventario')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 text-danger fw-bold">
            <i class="bi bi-box-arrow-up me-2"></i> Salidas de Inventario
        </h4>
        <a href="{{ route('admin.salidas.create') }}" class="btn btn-danger shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Nueva Salida
        </a>
    </div>

    <div class="card shadow border-0 animate__animated animate__fadeIn">
        <div class="card-body">
            @if ($salidas->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle me-2"></i> No hay salidas registradas aún.
                </div>
            @else
                <div class="table-responsive">
                    <table id="tabla-salidas" class="table table-bordered table-hover align-middle text-center">
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
                            @foreach ($salidas as $salida)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $salida->lote->codigo_lote }}</td>
                                    <td>{{ $salida->lote->producto->nombre ?? 'N/A' }}</td>
                                    <td>{{ $salida->cantidad }}</td>
                                    <td>{{ $salida->usuario->nombre ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($salida->fecha_movimiento)->format('Y-m-d H:i') }}</td>
                                    <td>{{ $salida->motivo }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.salidas.edit', $salida->id) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $salida->id }})" title="Eliminar">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                            <form id="delete-form-{{ $salida->id }}" action="{{ route('admin.salidas.destroy', $salida->id) }}" method="POST" style="display: none;">
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
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#tabla-salidas').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            order: [[2, 'asc']],
            columnDefs: [
                { targets: '_all', className: 'align-middle text-center' }
            ]
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar salida?',
            text: "Esto devolverá el stock al lote.",
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
@endpush
