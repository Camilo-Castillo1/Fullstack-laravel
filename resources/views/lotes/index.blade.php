@extends('layouts.app')

@section('header', 'Gestión de Lotes')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Listado de Lotes</h5>
                <a href="{{ route('admin.lotes.create') }}" class="btn btn-primary rounded-pill">
                    <i class="bi bi-plus-circle me-1"></i> Nuevo Lote
                </a>
            </div>

            {{-- Filtros --}}
            <form method="GET" action="{{ route('admin.lotes.index') }}" class="row g-2 mb-3">
                <div class="col-md-3">
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar por código..."
                        value="{{ $busqueda }}">
                </div>
                <div class="col-md-3">
                    <select name="producto_id" class="form-select">
                        <option value="">Todos los productos</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}" {{ $producto_id == $producto->id ? 'selected' : '' }}>
                                {{ $producto->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="estado" class="form-select">
                        <option value="">Todos los estados</option>
                        <option value="disponible" {{ $estado == 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="agotado" {{ $estado == 'agotado' ? 'selected' : '' }}>Agotado</option>
                        <option value="vencido" {{ $estado == 'vencido' ? 'selected' : '' }}>Vencido</option>
                    </select>
                </div>
                <div class="col-md-3 d-grid">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-search me-1"></i> Filtrar
                    </button>
                </div>
            </form>

            {{-- Tabla --}}
            @if ($lotes->isEmpty())
                <p class="text-center text-muted">No hay lotes registrados.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-bordered">
                        <thead class="table-light text-center">
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Código</th>
                                <th>Cantidad</th>
                                <th>Ingreso</th>
                                <th>Vencimiento</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lotes as $lote)
                                <tr>
                                    <td class="text-center">{{ $lote->id }}</td>
                                    <td>{{ $lote->producto->nombre }}</td>
                                    <td>{{ $lote->codigo_lote }}</td>
                                    <td class="text-end">{{ $lote->cantidad }}</td>
                                    <td>{{ $lote->fecha_ingreso }}</td>
                                    <td>{{ $lote->fecha_vencimiento ?? '—' }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $lote->estado == 'disponible' ? 'success' : ($lote->estado == 'agotado' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($lote->estado) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.lotes.edit', $lote->id) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.lotes.destroy', $lote->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Eliminar este lote?');">
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
