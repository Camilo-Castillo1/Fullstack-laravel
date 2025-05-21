@extends('layouts.app')

@section('header', 'Editar Producto')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.productos.update', $producto) }}">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Código</label>
                    <input type="text" name="codigo_producto" class="form-control" value="{{ $producto->codigo_producto }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ $producto->nombre }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="2">{{ $producto->descripcion }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Categoría</label>
                    <select name="categoria_id" class="form-select" required>
                        @foreach ($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ $producto->categoria_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Precio Unitario</label>
                    <input type="number" name="precio_unitario" class="form-control"
                        value="{{ $producto->precio_unitario }}" step="0.01" min="0" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stock Mínimo</label>
                    <input type="number" name="stock_minimo" class="form-control"
                        value="{{ $producto->stock_minimo }}" min="0" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select" required>
                        <option value="activo" {{ $producto->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ $producto->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
