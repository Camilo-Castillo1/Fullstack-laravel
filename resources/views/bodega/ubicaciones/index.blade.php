@extends('layouts.bodega')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 text-primary"><i class="bi bi-geo-alt-fill me-2"></i>Ubicaciones de Almacenamiento</h4>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="text-end mb-3">
        <a href="{{ route('bodega.ubicaciones.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nueva Ubicación
        </a>
    </div>

    <div class="table-responsive">
        <table id="tabla-ubicaciones" class="table table-striped table-bordered text-center align-middle">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Código</th>
                    <th>Tipo</th>
                    <th>Capacidad</th>
                    <th>Almacén</th>
                    <th>Restricciones</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ubicaciones as $ubicacion)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $ubicacion->codigo_ubicacion }}</td>
                        <td>
                            <span class="badge
                                @if($ubicacion->tipo_almacenamiento == 'seco') bg-secondary
                                @elseif($ubicacion->tipo_almacenamiento == 'refrigerado') bg-info
                                @elseif($ubicacion->tipo_almacenamiento == 'congelado') bg-primary
                                @endif">
                                {{ ucfirst($ubicacion->tipo_almacenamiento) }}
                            </span>
                        </td>
                        <td>{{ $ubicacion->capacidad_maxima }}</td>
                        <td>{{ $ubicacion->almacen->nombre ?? 'No definido' }}</td>
                        <td>{{ $ubicacion->restricciones ?? '-' }}</td>
                        <td>
                            <a href="{{ route('bodega.ubicaciones.edit', $ubicacion->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- DataTables --}}
@push('styles')
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#tabla-ubicaciones').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                },
                responsive: true,
                pageLength: 10
            });
        });
    </script>
@endpush
@endsection
