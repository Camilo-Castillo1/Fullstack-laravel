@extends('layouts.app')

@section('header', 'Gestión de Productos')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Listado de Productos</h5>
                <a href="{{ route('admin.productos.create') }}" class="btn btn-primary rounded-pill">
                    <i class="bi bi-plus-circle me-1"></i> Nuevo Producto
                </a>
            </div>

            {{-- Buscador --}}
            <form method="GET" action="{{ route('admin.productos.index') }}" class="mb-3 d-flex">
                <input type="text" name="buscar" class="form-control me-2" placeholder="Buscar por nombre..."
                    value="{{ $busqueda }}">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="bi bi-search"></i> Buscar
                </button>
            </form>

            {{-- Tabla --}}
            @if ($productos->isEmpty())
                <p class="text-center text-muted">No hay productos registrados.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-bordered">
                        <thead class="table-light text-center">
                            <tr>
                                <th>#</th>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Stock Mínimo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $producto)
                                <tr>
                                    <td class="text-center">{{ $producto->id }}</td>
                                    <td>{{ $producto->codigo_producto }}</td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->categoria->nombre }}</td>
                                    <td class="text-end">${{ number_format($producto->precio_unitario, 2) }}</td>
                                    <td class="text-center">{{ $producto->stock_minimo }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $producto->estado === 'activo' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($producto->estado) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.productos.edit', $producto->id) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Eliminar este producto?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
