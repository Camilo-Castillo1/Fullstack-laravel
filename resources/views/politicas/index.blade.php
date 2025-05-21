@extends('layouts.app')

@section('header', 'Políticas de Inventario')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold text-success">
            <i class="bi bi-clipboard-check me-2"></i> Políticas de Inventario
        </h4>
        <a href="{{ route('admin.politicas.create') }}" class="btn btn-success shadow-sm animate__animated animate__fadeIn">
            <i class="bi bi-plus-circle me-1"></i> Nueva Política
        </a>
    </div>

    <div class="card shadow border-0 animate__animated animate__fadeInUp">
        <div class="card-body">
            @if ($politicas->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle me-2"></i> No hay políticas registradas aún.
                </div>
            @else
                <div class="table-responsive">
                    <table id="tabla-politicas" class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Aplicable a</th>
                                <th>Tipo Producto</th>
                                <th>Valor</th>
                                <th>Código Ubicación</th>
                                <th>Almacén</th>
                                <th>Categoría</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($politicas as $politica)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $politica->nombre }}</td>
                                    <td>{{ $politica->tipo }}</td>
                                    <td>{{ $politica->aplicable_a }}</td>
                                    <td>{{ ucfirst($politica->tipo_producto ?? 'N/A') }}</td>
                                    <td>{{ number_format($politica->valor, 2) }}</td>
                                    <td>{{ $politica->ubicacion->codigo_ubicacion ?? 'N/A' }}</td>
                                    <td>{{ $politica->almacen->nombre ?? 'N/A' }}</td>
                                    <td>{{ $politica->categoria->nombre ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($politica->fecha_implementacion)->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.politicas.edit', $politica->id) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $politica->id }})">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                            <form id="delete-form-{{ $politica->id }}" action="{{ route('admin.politicas.destroy', $politica->id) }}" method="POST" style="display: none;">
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
        $('#tabla-politicas').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            order: [[1, 'asc']],
            columnDefs: [{ targets: '_all', className: 'align-middle text-center' }]
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar política?',
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
@endpush
