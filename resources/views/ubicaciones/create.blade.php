@extends('layouts.app')

@section('header', 'Nueva Ubicación de Almacenamiento')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.ubicaciones.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="almacen_id" class="form-label">Almacén</label>
                    <select name="almacen_id" id="almacen_id" class="form-select" required>
                        <option value="">Seleccione un almacén</option>
                        @foreach ($almacenes as $almacen)
                            <option value="{{ $almacen->id }}" {{ old('almacen_id') == $almacen->id ? 'selected' : '' }}>
                                {{ $almacen->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="codigo_ubicacion" class="form-label">Código de Ubicación</label>
                    <input type="text" class="form-control" name="codigo_ubicacion" value="{{ old('codigo_ubicacion') }}" required>
                </div>

                <div class="mb-3">
                    <label for="tipo_almacenamiento" class="form-label">Tipo de Almacenamiento</label>
                    <select name="tipo_almacenamiento" class="form-select" required>
                        <option value="">Seleccione tipo</option>
                        <option value="refrigerado">Refrigerado</option>
                        <option value="congelado">Congelado</option>
                        <option value="seco">Seco</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="capacidad_maxima" class="form-label">Capacidad Máxima</label>
                    <input type="number" class="form-control" name="capacidad_maxima" min="1" value="{{ old('capacidad_maxima') }}" required>
                </div>

                <div class="mb-3">
                    <label for="restricciones" class="form-label">Restricciones</label>
                    <textarea class="form-control" name="restricciones" rows="3">{{ old('restricciones') }}</textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.ubicaciones.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
