@extends('layouts.bodega')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 text-warning"><i class="bi bi-pencil-square me-2"></i>Editar Ubicación</h4>

    <form action="{{ route('bodega.ubicaciones.update', $ubicacion) }}" method="POST" class="card shadow-sm p-4">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Almacén</label>
            <select name="almacen_id" class="form-select" required>
                @foreach($almacenes as $almacen)
                    <option value="{{ $almacen->id }}" {{ $almacen->id == $ubicacion->almacen_id ? 'selected' : '' }}>
                        {{ $almacen->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Código de Ubicación</label>
            <input type="text" name="codigo_ubicacion" class="form-control" value="{{ $ubicacion->codigo_ubicacion }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo de Almacenamiento</label>
            <select name="tipo_almacenamiento" class="form-select" required>
                @foreach(['seco', 'refrigerado', 'congelado'] as $tipo)
                    <option value="{{ $tipo }}" {{ $tipo == $ubicacion->tipo_almacenamiento ? 'selected' : '' }}>
                        {{ ucfirst($tipo) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Capacidad Máxima</label>
            <input type="number" name="capacidad_maxima" class="form-control" value="{{ $ubicacion->capacidad_maxima }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Restricciones</label>
            <textarea name="restricciones" class="form-control" rows="2">{{ $ubicacion->restricciones }}</textarea>
        </div>

        <div class="text-end">
            <a href="{{ route('bodega.ubicaciones.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-warning">Actualizar</button>
        </div>
    </form>
</div>
@endsection
