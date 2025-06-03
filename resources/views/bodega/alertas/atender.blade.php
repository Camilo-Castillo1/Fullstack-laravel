@extends('layouts.bodega')

@section('content')
<div class="container py-4">
    <h4 class="mb-4"><i class="bi bi-wrench-adjustable-circle me-2"></i>Atender alerta de vencimiento</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>Producto:</strong> {{ $alerta->lote->producto->nombre ?? 'Producto desconocido' }}</p>
            <p><strong>Lote:</strong> #{{ $alerta->lote->id }}</p>
            <p><strong>Fecha de vencimiento:</strong> {{ $alerta->fecha_vencimiento }}</p>
        </div>
    </div>

    <form action="{{ route('bodega.alertas.resolver', $alerta->id) }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-3">
            <label for="observacion" class="form-label">Observaciones (opcional)</label>
            <textarea name="observacion" id="observacion" class="form-control" rows="3"></textarea>
        </div>

        <div class="text-end">
            <a href="{{ route('bodega.alertas.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-danger">Marcar como atendida</button>
        </div>
    </form>
</div>
@endsection
