@extends('layouts.bodega')

@section('title', 'Agregar Producto')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success mb-0">
            <i class="bi bi-plus-circle me-2"></i>Nuevo Producto
        </h3>
        <a href="{{ route('bodega.productos.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left"></i> Volver al listado
        </a>
    </div>

    <div class="card shadow border-0">
        <div class="card-body">
            <form action="{{ route('bodega.productos.store') }}" method="POST" autocomplete="off">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="codigo_producto" class="form-label fw-semibold">Código del Producto</label>
                        <input type="text" name="codigo_producto" id="codigo_producto" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="nombre" class="form-label fw-semibold">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="categoria_id" class="form-label fw-semibold">Categoría</label>
                        <select name="categoria_id" id="categoria_id" class="form-select" required>
                            <option value="" disabled selected>Selecciona una categoría</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="precio_unitario" class="form-label fw-semibold">Precio Unitario ($)</label>
                        <input type="number" name="precio_unitario" id="precio_unitario" step="0.01" min="0" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="stock_minimo" class="form-label fw-semibold">Stock Mínimo</label>
                        <input type="number" name="stock_minimo" id="stock_minimo" min="0" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="estado" class="form-label fw-semibold">Estado</label>
                        <select name="estado" id="estado" class="form-select" required>
                            <option value="activo" selected>Activo</option>
                            <option value="inactivo">Inactivo</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="3" placeholder="Descripción detallada del producto"></textarea>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success shadow-sm">
                        <i class="bi bi-check-circle"></i> Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
