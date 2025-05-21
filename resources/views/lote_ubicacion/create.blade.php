@extends('layouts.app')

@section('header', 'Nueva Asignación de Lote a Ubicación')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-body">
            <form action="{{ route('admin.lote-ubicacion.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="id_lote" class="form-label">Lote</label>
                    <select name="id_lote" class="form-select" required>
                        <option value="">Seleccione un lote</option>
                        @foreach($lotes as $lote)
                            <option value="{{ $lote->id }}">{{ $lote->codigo_lote }} - {{ $lote->producto->nombre ?? 'N/A' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_ubicacion" class="form-label">Ubicación</label>
                    @if ($ubicaciones->count() > 0)
                        <select name="id_ubicacion" class="form-select" required>
                            <option value="">Seleccione una ubicación</option>
                            @foreach($ubicaciones as $ubicacion)
                                <option value="{{ $ubicacion->id }}">{{ $ubicacion->codigo_ubicacion }} - {{ $ubicacion->almacen->nombre ?? '' }}</option>
                            @endforeach
                        </select>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> Por favor asigne una <strong>ubicación</strong> primero.
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" class="form-control" min="1" required>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.lote-ubicacion.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary" {{ $ubicaciones->count() === 0 ? 'disabled' : '' }}>
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
