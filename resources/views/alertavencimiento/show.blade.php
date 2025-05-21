@extends('layouts.app')

@section('header', 'Detalle de Alerta de Vencimiento')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-info text-white fw-bold">
            Información del Lote
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <strong>Código Lote:</strong> {{ $alerta->lote->codigo_lote }}
                </li>
                <li class="list-group-item">
                    <strong>Producto:</strong> {{ $alerta->lote->producto->nombre ?? 'N/A' }}
                </li>
                <li class="list-group-item">
                    <strong>Fecha Ingreso:</strong> {{ $alerta->lote->fecha_ingreso }}
                </li>
                <li class="list-group-item">
                    <strong>Fecha Vencimiento:</strong> {{ $alerta->fecha_vencimiento }}
                </li>
                <li class="list-group-item">
                    <strong>Estado Alerta:</strong>
                    <span class="badge {{ $alerta->estado === 'pendiente' ? 'bg-danger' : 'bg-success' }}">
                        {{ ucfirst($alerta->estado) }}
                    </span>
                </li>
            </ul>
            <div class="mt-4 text-end">
                <a href="{{ route('admin.alertas.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Volver
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
