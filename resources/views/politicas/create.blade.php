@extends('layouts.app')

@section('header', 'Registrar Nueva Política de Inventario')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0 animate__animated animate__fadeIn">
        <div class="card-body">
            <form action="{{ route('admin.politicas.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                </div>

                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select name="tipo" class="form-select" required>
                        <option value="">Seleccione...</option>
                        @foreach (['PEPS', 'UEPS', 'FIFO'] as $op)
                            <option value="{{ $op }}" {{ old('tipo') == $op ? 'selected' : '' }}>{{ $op }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="aplicable_a" class="form-label">Aplicable a</label>
                    <select name="aplicable_a" class="form-select" required>
                        <option value="">Seleccione...</option>
                        @foreach (['producto', 'lote', 'almacen'] as $op)
                            <option value="{{ $op }}" {{ old('aplicable_a') == $op ? 'selected' : '' }}>{{ ucfirst($op) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tipo_producto" class="form-label">Tipo de Producto</label>
                    <select name="tipo_producto" class="form-select">
                        <option value="">No aplica</option>
                        @foreach (['refrigerado', 'seco', 'congelado'] as $tp)
                            <option value="{{ $tp }}" {{ old('tipo_producto') == $tp ? 'selected' : '' }}>{{ ucfirst($tp) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="valor" class="form-label">Valor</label>
                    <input type="number" name="valor" step="0.01" class="form-control" value="{{ old('valor') }}" required>
                </div>

                <div class="mb-3">
                    <label for="fecha_implementacion" class="form-label">Fecha de Implementación</label>
                    <input type="date" name="fecha_implementacion" class="form-control" value="{{ old('fecha_implementacion', now()->format('Y-m-d')) }}" required>
                </div>

                <div class="mb-3">
                    <label for="ubicacion_id" class="form-label">Ubicación</label>

                    @if($ubicaciones->count() > 0)
                        <select name="ubicacion_id" class="form-select" required>
                            <option value="">Seleccione una ubicación</option>
                            @foreach ($ubicaciones as $ubicacion)
                                <option value="{{ $ubicacion->id }}" {{ old('ubicacion_id') == $ubicacion->id ? 'selected' : '' }}>
                                    {{ $ubicacion->codigo_ubicacion }} - {{ $ubicacion->almacen->nombre ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <div class="alert alert-warning d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            No hay ubicaciones disponibles. Por favor registre al menos una ubicación antes de continuar.
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="categoria_id" class="form-label">Categoría (opcional)</label>
                    <select name="categoria_id" class="form-select">
                        <option value="">Sin categoría</option>
                        @foreach ($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="almacen_id" class="form-label">Almacén (opcional)</label>
                    <select name="almacen_id" class="form-select">
                        <option value="">Sin almacén</option>
                        @foreach ($almacenes as $alm)
                            <option value="{{ $alm->id }}" {{ old('almacen_id') == $alm->id ? 'selected' : '' }}>
                                {{ $alm->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.politicas.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success" {{ $ubicaciones->count() === 0 ? 'disabled' : '' }}>
                        <i class="bi bi-save me-1"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
