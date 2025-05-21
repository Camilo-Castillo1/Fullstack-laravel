@extends('layouts.app')

@section('header', 'Editar Lote')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="mb-4">Editar Lote</h5>

            <form method="POST" action="{{ route('admin.lotes.update', $lote) }}">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label for="codigo_lote" class="form-label">Código de Lote</label>
                    <input type="text" class="form-control" name="codigo_lote" id="codigo_lote"
                           value="{{ old('codigo_lote', $lote->codigo_lote) }}" required>
                </div>

                <div class="mb-3">
                    <label for="producto_id" class="form-label">Producto</label>
                    <select name="producto_id" id="producto_id" class="form-select" required>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}" {{ $lote->producto_id == $producto->id ? 'selected' : '' }}>{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="cantidad" class="form-label">Cantidad</label>
                    <input type="number" class="form-control" name="cantidad" id="cantidad"
                           value="{{ old('cantidad', $lote->cantidad) }}" required>
                </div>

                <div class="mb-3">
                    <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                    <input type="date" class="form-control" name="fecha_ingreso" id="fecha_ingreso"
                           value="{{ old('fecha_ingreso', $lote->fecha_ingreso) }}" required>
                </div>

                <div class="mb-3">
                    <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
                    <input type="date" class="form-control" name="fecha_vencimiento" id="fecha_vencimiento"
                           value="{{ old('fecha_vencimiento', $lote->fecha_vencimiento) }}">
                </div>

                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select name="estado" class="form-select" required>
                        <option value="disponible" {{ $lote->estado == 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="agotado" {{ $lote->estado == 'agotado' ? 'selected' : '' }}>Agotado</option>
                        <option value="vencido" {{ $lote->estado == 'vencido' ? 'selected' : '' }}>Vencido</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.lotes.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-1"></i> Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
