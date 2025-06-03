@extends('layouts.bodega')

@section('title', 'Nuevo Lote')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success">
            <i class="bi bi-plus-circle me-2"></i> Registrar nuevo lote
        </h3>
        <a href="{{ route('bodega.lotes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('bodega.lotes.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="codigo_lote" class="form-label">Código de Lote</label>
                        <input type="text" name="codigo_lote" id="codigo_lote"
                               class="form-control @error('codigo_lote') is-invalid @enderror"
                               value="{{ old('codigo_lote') }}" required>
                        @error('codigo_lote') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="producto_id" class="form-label">Producto</label>
                        <select name="producto_id" id="producto_id"
                                class="form-select @error('producto_id') is-invalid @enderror" required>
                            <option value="">Seleccione...</option>
                            @foreach ($productos as $producto)
                                <option value="{{ $producto->id }}" {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                                    {{ $producto->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('producto_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" name="cantidad" id="cantidad"
                               class="form-control @error('cantidad') is-invalid @enderror"
                               value="{{ old('cantidad') }}" min="1" required>
                        @error('cantidad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                        <input type="date" name="fecha_ingreso" id="fecha_ingreso"
                               class="form-control @error('fecha_ingreso') is-invalid @enderror"
                               value="{{ old('fecha_ingreso') }}" required>
                        @error('fecha_ingreso') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
                        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento"
                               class="form-control @error('fecha_vencimiento') is-invalid @enderror"
                               value="{{ old('fecha_vencimiento') }}">
                        @error('fecha_vencimiento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado"
                                class="form-select @error('estado') is-invalid @enderror" required>
                            <option value="disponible" {{ old('estado') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="agotado" {{ old('estado') == 'agotado' ? 'selected' : '' }}>Agotado</option>
                            <option value="vencido" {{ old('estado') == 'vencido' ? 'selected' : '' }}>Vencido</option>
                        </select>
                        @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i> Guardar Lote
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
