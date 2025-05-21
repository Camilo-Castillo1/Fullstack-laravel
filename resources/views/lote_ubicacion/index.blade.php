@extends('layouts.app')

@section('header', 'Ubicación de Lotes')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between mb-3">
        <h4 class="text-primary fw-bold">
            <i class="bi bi-pin-map-fill me-2"></i> Asignación de Lotes por Ubicación
        </h4>
        <a href="{{ route('admin.lote-ubicacion.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Nuevo
        </a>
    </div>

    <div class="card shadow border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tabla-lotes" class="table table-hover align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Código Lote</th>
                            <th>Producto</th>
                            <th>Ubicación</th>
                            <th>Almacén</th>
                            <th>Cantidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($asignaciones as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->lote->codigo_lote }}</td>
                                <td>{{ $item->lote->producto->nombre ?? 'N/A' }}</td>
                                <td>{{ $item->ubicacion->codigo_ubicacion }}</td>
                                <td>{{ $item->ubicacion->almacen->nombre ?? 'N/A' }}</td>
                                <td>{{ $item->cantidad }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.lote-ubicacion.edit', [$item->id_lote, $item->id_ubicacion]) }}"
                                           class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.lote-ubicacion.destroy', [$item->id_lote, $item->id_ubicacion]) }}"
                                              onsubmit="return confirm('¿Eliminar esta asignación?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
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

@push('scripts')
<script>
    $(document).ready(function () {
        $('#tabla-lotes').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            }
        });
    });
</script>
@endpush
