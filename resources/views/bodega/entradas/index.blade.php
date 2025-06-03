@extends('layouts.bodega')

@section('title', 'Entradas de Inventario')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">
            <i class="bi bi-box-arrow-in-down me-2"></i> Entradas de Inventario
        </h3>
        <a href="{{ route('bodega.entradas.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle-fill me-1"></i> Registrar Entrada
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tabla-entradas" class="table table-hover table-bordered align-middle w-100">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Lote</th>
                            <th>Cantidad</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entradas as $entrada)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start">{{ $entrada->lote->producto->nombre ?? 'N/A' }}</td>
                                <td>{{ $entrada->lote->codigo_lote }}</td>
                                <td>{{ $entrada->cantidad }}</td>
                                <td>{{ $entrada->fecha_movimiento }}</td>
                                <td>{{ $entrada->usuario->nombre ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('bodega.entradas.edit', $entrada->id) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    {{-- Puedes agregar botón de eliminar si lo deseas y si es permitido --}}
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
        $('#tabla-entradas').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            responsive: true,
            pageLength: 10,
            order: [[0, 'desc']]
        });
    });
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush
