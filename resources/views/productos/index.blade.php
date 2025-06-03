@extends('layouts.app')

@section('header', 'Gestión de Productos')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0"><i class="bi bi-box-seam me-2"></i> Listado de Productos</h4>
                <a href="{{ route('admin.productos.create') }}" class="btn btn-primary shadow-sm rounded-pill">
                    <i class="bi bi-plus-circle me-1"></i> Nuevo Producto
                </a>
            </div>

            {{-- Buscador --}}
            <form method="GET" action="{{ route('admin.productos.index') }}" class="mb-4">
                <div class="input-group shadow-sm">
                    <input type="text" name="buscar" class="form-control" placeholder="🔍 Buscar por nombre o código..." value="{{ $busqueda }}">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            {{-- Tabla --}}
            @if ($productos->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="bi bi-box me-2 fs-3"></i> No hay productos registrados.
                </div>
            @else
                <div class="table-responsive rounded-4 overflow-hidden">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th>#</th>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Stock Mínimo</th>
                                <th>Stock Actual</th>
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
                                        <span class="badge bg-{{ $producto->stock <= $producto->stock_minimo ? 'danger' : 'info' }}">
                                            {{ $producto->stock }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $producto->estado === 'activo' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($producto->estado) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.productos.edit', $producto->id) }}" class="btn btn-sm btn-warning me-1 shadow-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Eliminar este producto?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger shadow-sm">
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
