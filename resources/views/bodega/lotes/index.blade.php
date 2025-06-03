@extends('layouts.bodega')

@section('title', 'Lotes')

@section('content')
<div class="container py-4">

    {{-- Encabezado --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success mb-0">
            <i class="bi bi-layers me-2"></i> Gestión de Lotes
        </h3>

        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('administrador de bodega'))
            <a href="{{ route(auth()->user()->hasRole('admin') ? 'admin.lotes.create' : 'bodega.lotes.create') }}"
               class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle-fill me-1"></i> Nuevo Lote
            </a>
        @endif
    </div>

    {{-- Tabla --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tabla-lotes" class="table table-hover table-bordered align-middle w-100">
                    <thead class="table-success text-center">
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Fecha Ingreso</th>
                            <th>Fecha Vencimiento</th>
                            <th>Cantidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lotes as $lote)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start">{{ $lote->codigo_lote }}</td>
                                <td class="text-start">{{ $lote->producto->nombre ?? 'Sin producto' }}</td>
                                <td>{{ $lote->fecha_ingreso }}</td>
                                <td>{{ $lote->fecha_vencimiento ?? 'N/A' }}</td>
                                <td>{{ $lote->cantidad }}</td>
                                <td>
                                    <span class="badge
                                        @if($lote->estado === 'disponible') bg-success
                                        @elseif($lote->estado === 'agotado') bg-warning text-dark
                                        @else bg-danger @endif">
                                        {{ ucfirst($lote->estado) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route(auth()->user()->hasRole('admin') ? 'admin.lotes.edit' : 'bodega.lotes.edit', $lote->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    {{-- Solo admin puede eliminar --}}
                                    @if(auth()->user()->hasRole('admin'))
                                        <form action="{{ route('admin.lotes.destroy', $lote->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este lote?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
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
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#tabla-lotes').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                responsive: true,
                pageLength: 10,
                order: [[0, 'asc']]
            });
        });
    </script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush
