@extends('layouts.bodega')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 text-success"><i class="bi bi-plus-circle me-2"></i>Nueva Ubicación</h4>

    <form action="{{ route('bodega.ubicaciones.store') }}" method="POST" class="card shadow-sm p-4">
        @csrf

        <div class="mb-3">
            <label class="form-label">Almacén</label>
            <select name="almacen_id" class="form-select" required>
                <option value="">Seleccione...</option>
                @foreach($almacenes as $almacen)
                    <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Código de Ubicación</label>
            <input type="text" name="codigo_ubicacion" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo de Almacenamiento</label>
            <select name="tipo_almacenamiento" class="form-select" required>
                <option value="seco">Seco</option>
                <option value="refrigerado">Refrigerado</option>
                <option value="congelado">Congelado</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Capacidad Máxima</label>
            <input type="number" name="capacidad_maxima" class="form-control" min="1" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Restricciones (opcional)</label>
            <textarea name="restricciones" class="form-control" rows="2"></textarea>
        </div>

        <div class="text-end">
            <a href="{{ route('bodega.ubicaciones.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
        </div>
    </form>
</div>
@endsection
