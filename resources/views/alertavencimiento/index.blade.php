@extends('layouts.app')

@section('header', 'Alertas de Vencimiento')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-header bg-warning text-dark fw-bold">
            Lotes próximos a vencer
        </div>
        <div class="card-body">
            @if($alertas->isEmpty())
                <div class="alert alert-success text-center">
                    <i class="bi bi-check-circle me-2"></i> No hay alertas pendientes.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Código Lote</th>
                                <th>Producto</th>
                                <th>Fecha Ingreso</th>
                                <th>Fecha Vencimiento</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alertas as $alerta)
                                <tr class="{{ $alerta->estado === 'pendiente' ? 'table-warning' : 'table-success' }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $alerta->lote->codigo_lote }}</td>
                                    <td>{{ $alerta->lote->producto->nombre ?? 'N/A' }}</td>
                                    <td>{{ $alerta->lote->fecha_ingreso }}</td>
                                    <td>{{ $alerta->fecha_vencimiento }}</td>
                                    <td>
                                        <span class="badge {{ $alerta->estado === 'pendiente' ? 'bg-danger' : 'bg-success' }}">
                                            {{ ucfirst($alerta->estado) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.alertas.show', $alerta->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye"></i> Ver
                                        </a>
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
