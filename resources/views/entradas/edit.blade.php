@extends('layouts.app')

@section('header', 'Editar Entrada de Inventario')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.entradas.update', $entrada->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="lote_id" class="form-label">Lote</label>
                    <select name="lote_id" class="form-select" required>
                        @foreach($lotes as $lote)
                            <option value="{{ $lote->id }}" {{ $entrada->lote_id == $lote->id ? 'selected' : '' }}>
                                {{ $lote->producto->nombre ?? 'Producto sin nombre' }} (Lote #{{ $lote->id }})
                            </option>
                        @endforeach
                    </select>
                    @error('lote_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" value="{{ old('cantidad', $entrada->cantidad) }}" class="form-control" min="1" required>
                    @error('cantidad') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="motivo" class="form-label">Motivo</label>
                    <textarea name="motivo" rows="3" class="form-control">{{ old('motivo', $entrada->motivo) }}</textarea>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.entradas.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
