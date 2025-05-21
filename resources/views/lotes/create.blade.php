@extends('layouts.app')

@section('header', 'Registrar Lote')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.lotes.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Producto</label>
                    <select name="producto_id" class="form-select" required>
                        <option value="">Seleccione producto</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Código de Lote</label>
                    <input type="text" name="codigo_lote" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" class="form-control" min="1" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fecha de Ingreso</label>
                    <input type="date" name="fecha_ingreso" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fecha de Vencimiento</label>
                    <input type="date" name="fecha_vencimiento" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select" required>
                        <option value="disponible">Disponible</option>
                        <option value="agotado">Agotado</option>
                        <option value="vencido">Vencido</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.lotes.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
