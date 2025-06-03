@extends('layouts.bodega')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 text-primary"><i class="bi bi-box-arrow-up me-2"></i>Salidas de Inventario</h4>
        <a href="{{ route('bodega.salidas.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Registrar Salida
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-primary">
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
                @forelse ($salidas as $salida)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ optional($salida->lote->producto)->nombre ?? 'Producto no encontrado' }}</td>
                        <td>{{ $salida->lote->id ?? '-' }}</td>
                        <td>{{ $salida->cantidad }}</td>
                        <td>{{ \Carbon\Carbon::parse($salida->fecha_movimiento)->format('Y-m-d H:i:s') }}</td>
                        <td>{{ $salida->usuario->nombre ?? 'Desconocido' }}</td>
                        <td>
                            <a href="{{ route('bodega.salidas.edit', $salida->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-muted">No hay salidas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
