@extends('layouts.app')

@section('header', 'Registrar Producto')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.productos.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Código</label>
                    <input type="text" name="codigo_producto" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="2"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Categoría</label>
                    <select name="categoria_id" class="form-select" required>
                        <option value="">Seleccione una categoría</option>
                        @foreach ($categorias as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Precio Unitario</label>
                    <input type="number" name="precio_unitario" class="form-control" min="0" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stock Mínimo</label>
                    <input type="number" name="stock_minimo" class="form-control" min="0" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select" required>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
