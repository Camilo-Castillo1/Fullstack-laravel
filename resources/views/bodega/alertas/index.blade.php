@extends('layouts.bodega')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Alertas de Vencimiento</h4>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-danger">
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Lote</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Días Restantes</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($alertas as $alerta)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $alerta->lote->producto->nombre ?? 'Producto no encontrado' }}</td>
                        <td>{{ $alerta->lote->id }}</td>
                        <td>{{ $alerta->fecha_vencimiento }}</td>
                        <td>{{ \Carbon\Carbon::now()->diffInDays($alerta->fecha_vencimiento, false) }}</td>
                        <td>
                            <a href="{{ route('bodega.alertas.atender', $alerta->id) }}" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-wrench-adjustable-circle"></i> Atender
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-muted">No hay alertas pendientes.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
