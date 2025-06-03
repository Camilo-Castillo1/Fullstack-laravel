@extends('layouts.bodega')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="bi bi-pencil-square text-primary me-2"></i>Editar salida</h2>

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Corrige los siguientes errores:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario --}}
    <form action="{{ route('bodega.salidas.update', $salida->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="lote_id" class="form-label">Lote / Producto</label>
            <select name="lote_id" id="lote_id" class="form-select" required>
                @foreach ($lotes as $lote)
                    <option value="{{ $lote->id }}" {{ $salida->lote_id == $lote->id ? 'selected' : '' }}>
                        {{ $lote->producto->nombre ?? 'Producto desconocido' }} - Lote #{{ $lote->id }} (Stock: {{ $lote->cantidad }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" required value="{{ old('cantidad', $salida->cantidad) }}">
        </div>

        <div class="mb-3">
            <label for="motivo" class="form-label">Motivo</label>
            <textarea name="motivo" id="motivo" class="form-control" rows="3">{{ old('motivo', $salida->motivo) }}</textarea>
        </div>

        <div class="text-end">
            <a href="{{ route('bodega.salidas.index') }}" class="btn btn-secondary me-2">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar salida</button>
        </div>
    </form>
</div>
@endsection
