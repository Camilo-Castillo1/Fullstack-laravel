@extends('layouts.app')

@section('header', 'Editar Asignación de Lote a Ubicación')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.lote-ubicacion.update', [$asignacion->id_lote, $asignacion->id_ubicacion]) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="id_lote" class="form-label">Lote</label>
                    <select name="id_lote" class="form-select" required>
                        @foreach($lotes as $lote)
                            <option value="{{ $lote->id }}" {{ $lote->id == $asignacion->id_lote ? 'selected' : '' }}>
                                {{ $lote->codigo_lote }} - {{ $lote->producto->nombre ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_ubicacion" class="form-label">Ubicación</label>
                    <select name="id_ubicacion" class="form-select" required>
                        @foreach($ubicaciones as $ubicacion)
                            <option value="{{ $ubicacion->id }}" {{ $ubicacion->id == $asignacion->id_ubicacion ? 'selected' : '' }}>
                                {{ $ubicacion->codigo_ubicacion }} - {{ $ubicacion->almacen->nombre ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" value="{{ old('cantidad', $asignacion->cantidad) }}" class="form-control" min="0" required>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.lote-ubicacion.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
