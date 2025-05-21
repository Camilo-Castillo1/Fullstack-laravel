@extends('layouts.app')

@section('header', 'Nueva Entrada de Inventario')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white fw-semibold">
                    <i class="bi bi-box-arrow-in-down me-1"></i> Registrar Nueva Entrada
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.entradas.store') }}">
                        @csrf

                        {{-- Lote --}}
                        <div class="mb-3">
                            <label for="lote_id" class="form-label">Lote</label>
                            <select name="lote_id" id="lote_id" class="form-select @error('lote_id') is-invalid @enderror" required>
                                <option value="">Seleccione un lote</option>
                                @foreach ($lotes as $lote)
                                    <option value="{{ $lote->id }}" {{ old('lote_id') == $lote->id ? 'selected' : '' }}>
                                        {{ $lote->codigo_lote }} - {{ $lote->producto->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lote_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Cantidad --}}
                        <div class="mb-3">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control @error('cantidad') is-invalid @enderror" min="1" value="{{ old('cantidad') }}" required>
                            @error('cantidad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Motivo --}}
                        <div class="mb-3">
                            <label for="motivo" class="form-label">Motivo (opcional)</label>
                            <textarea name="motivo" id="motivo" class="form-control @error('motivo') is-invalid @enderror" rows="3">{{ old('motivo') }}</textarea>
                            @error('motivo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Botones --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.entradas.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle me-1"></i> Guardar Entrada
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
