@extends('layouts.app')

@section('header', 'Editar Ubicación')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.ubicaciones.update', $ubicacion) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="almacen_id" class="form-label">Almacén</label>
                    <select name="almacen_id" id="almacen_id" class="form-select" required>
                        @foreach ($almacenes as $almacen)
                            <option value="{{ $almacen->id }}" {{ $ubicacion->almacen_id == $almacen->id ? 'selected' : '' }}>
                                {{ $almacen->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="codigo_ubicacion" class="form-label">Código de Ubicación</label>
                    <input type="text" name="codigo_ubicacion" class="form-control" value="{{ $ubicacion->codigo_ubicacion }}" required>
                </div>

                <div class="mb-3">
                    <label for="tipo_almacenamiento" class="form-label">Tipo de Almacenamiento</label>
                    <select name="tipo_almacenamiento" class="form-select" required>
                        @foreach (['refrigerado', 'seco', 'congelado'] as $tipo)
                            <option value="{{ $tipo }}" {{ $ubicacion->tipo_almacenamiento === $tipo ? 'selected' : '' }}>
                                {{ ucfirst($tipo) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="capacidad_maxima" class="form-label">Capacidad Máxima</label>
                    <input type="number" name="capacidad_maxima" class="form-control" value="{{ $ubicacion->capacidad_maxima }}" min="1" required>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.ubicaciones.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
