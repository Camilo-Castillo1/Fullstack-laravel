@extends('layouts.app')

@section('header', 'Control de Temperatura')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 text-primary fw-bold">
            <i class="bi bi-thermometer-half me-2"></i> Registros de Temperatura
        </h4>
        <a href="{{ route('admin.temperaturas.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Nuevo Registro
        </a>
    </div>

    <div class="card shadow border-0 animate__animated animate__fadeIn">
        <div class="card-body">
            @if ($registros->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle me-2"></i> No hay registros de temperatura.
                </div>
            @else
                <div class="table-responsive">
                    <table id="tabla-temperaturas" class="table table-bordered table-hover text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Almacén</th>
                                <th>Temperatura (°C)</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registros as $registro)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $registro->almacen->nombre ?? 'N/A' }}</td>
                                    <td>{{ number_format($registro->temperatura, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($registro->fecha_registro)->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.temperaturas.edit', $registro->id) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $registro->id }})" title="Eliminar">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                            <form id="delete-form-{{ $registro->id }}" action="{{ route('admin.temperaturas.destroy', $registro->id) }}" method="POST" style="display: none;">
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
        $('#tabla-temperaturas').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            order: [[3, 'desc']],
            columnDefs: [{ targets: '_all', className: 'align-middle text-center' }]
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar registro?',
            text: "Esto eliminará el registro de temperatura.",
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
