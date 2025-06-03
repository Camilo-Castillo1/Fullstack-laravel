@extends('layouts.bodega')

@section('title', 'Registrar Entrada')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">
            <i class="bi bi-plus-circle me-2"></i> Nueva Entrada
        </h3>
        <a href="{{ route('bodega.entradas.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('bodega.entradas.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="lote_id" class="form-label">Lote</label>
                        <select name="lote_id" id="lote_id" class="form-select @error('lote_id') is-invalid @enderror" required>
                            <option value="">Seleccione un lote...</option>
                            @foreach ($lotes as $lote)
                                <option value="{{ $lote->id }}" {{ old('lote_id') == $lote->id ? 'selected' : '' }}>
                                    {{ $lote->codigo_lote }} - {{ $lote->producto->nombre ?? 'Sin producto' }}
                                </option>
                            @endforeach
                        </select>
                        @error('lote_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control @error('cantidad') is-invalid @enderror" value="{{ old('cantidad') }}" required min="1">
                        @error('cantidad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label for="motivo" class="form-label">Motivo (opcional)</label>
                        <textarea name="motivo" id="motivo" class="form-control @error('motivo') is-invalid @enderror" rows="3">{{ old('motivo') }}</textarea>
                        @error('motivo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i> Registrar Entrada
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
