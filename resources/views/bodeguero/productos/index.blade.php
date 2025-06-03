@extends('layouts.bodeguero')

@section('title', 'Productos')

@section('content')
<style>
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-6px);
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.15);
    }

    .fade-in {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .search-bar input:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        transition: box-shadow 0.3s ease;
    }
</style>

<div class="container py-4 fade-in">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <h2 class="fw-bold text-primary mb-3">📦 Productos en Inventario</h2>
        <form method="GET" action="{{ route('bodega.productos.index') }}" class="d-flex flex-wrap search-bar">
            <input type="text" name="buscar" class="form-control me-2 mb-2" placeholder="🔍 Buscar por nombre o código..." value="{{ request('buscar') }}">
            <button class="btn btn-outline-primary mb-2" type="submit">
                <i class="bi bi-search"></i> Buscar
            </button>
        </form>
    </div>

    @if ($productos->isEmpty())
        <div class="alert alert-warning text-center shadow-sm fade-in">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> No se encontraron productos registrados.
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($productos as $producto)
                <div class="col fade-in">
                    <div class="card card-hover h-100 border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary fw-bold mb-1">
                                {{ $producto->nombre }}
                            </h5>
                            <p class="card-subtitle text-muted small mb-2">
                                <i class="bi bi-tag"></i> Código: <strong>{{ $producto->codigo_producto }}</strong>
                            </p>
                            <p class="mb-1"><i class="bi bi-box"></i> Categoría: {{ $producto->categoria->nombre ?? 'Sin categoría' }}</p>
                            <p class="mb-1"><i class="bi bi-currency-dollar"></i> Precio: <strong>${{ number_format($producto->precio_unitario, 2) }}</strong></p>
                            <p class="mb-1"><i class="bi bi-layers"></i> Stock actual:
                                <span class="badge bg-secondary">{{ $producto->stock }}</span>
                            </p>
                            <p class="mb-0">
                                <i class="bi bi-circle-fill {{ $producto->estado === 'activo' ? 'text-success' : 'text-secondary' }}"></i>
                                <strong>{{ ucfirst($producto->estado) }}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center fade-in">
            {{ $productos->links() }}
        </div>
    @endif
</div>
@endsection
