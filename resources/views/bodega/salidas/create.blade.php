@extends('layouts.bodega')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="bi bi-plus-circle text-success me-2"></i>Registrar nueva salida</h2>

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
    <form action="{{ route('bodega.salidas.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="lote_id" class="form-label">Lote / Producto</label>
            <select name="lote_id" id="lote_id" class="form-select" required>
                <option value="" disabled selected>Selecciona un lote</option>
                @foreach ($lotes as $lote)
                    <option value="{{ $lote->id }}">
                        {{ $lote->producto->nombre ?? 'Producto desconocido' }} - Lote #{{ $lote->id }} (Stock: {{ $lote->cantidad }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad a retirar</label>
            <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" required value="{{ old('cantidad') }}">
        </div>

        <div class="mb-3">
            <label for="motivo" class="form-label">Motivo de salida (opcional)</label>
            <textarea name="motivo" id="motivo" class="form-control" rows="3">{{ old('motivo') }}</textarea>
        </div>

        <div class="text-end">
            <a href="{{ route('bodega.salidas.index') }}" class="btn btn-secondary me-2">Cancelar</a>
            <button type="submit" class="btn btn-success">Registrar salida</button>
        </div>
    </form>
</div>
@endsection
