@extends('layouts.app')

@section('header', 'Registrar Salida de Inventario')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.salidas.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="lote_id" class="form-label">Lote</label>
                    <select name="lote_id" class="form-select" required>
                        <option value="">Seleccione un lote</option>
                        @foreach ($lotes as $lote)
                            <option value="{{ $lote->id }}" {{ old('lote_id') == $lote->id ? 'selected' : '' }}>
                                {{ $lote->producto->nombre ?? 'Producto' }} - Lote #{{ $lote->codigo_lote }} (Stock: {{ $lote->cantidad }})
                            </option>
                        @endforeach
                    </select>
                    @error('lote_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" value="{{ old('cantidad') }}" class="form-control" min="1" required>
                    @error('cantidad') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="motivo" class="form-label">Motivo</label>
                    <textarea name="motivo" rows="3" class="form-control">{{ old('motivo') }}</textarea>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.salidas.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-save me-1"></i> Registrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
