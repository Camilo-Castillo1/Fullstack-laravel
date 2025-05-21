@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Panel - Administrador de Bodega</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-3">
        <div class="col-md-4">
            <a href="{{ route('productos.index') }}" class="btn btn-outline-primary w-100">
                <i class="bi bi-box-seam me-2"></i> Gestión de Productos
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('lotes.index') }}" class="btn btn-outline-primary w-100">
                <i class="bi bi-archive-fill me-2"></i> Gestión de Lotes
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('entradas.index') }}" class="btn btn-outline-success w-100">
                <i class="bi bi-box-arrow-in-down me-2"></i> Entradas de Inventario
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('salidas.index') }}" class="btn btn-outline-danger w-100">
                <i class="bi bi-box-arrow-up me-2"></i> Salidas de Inventario
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('alertas.index') }}" class="btn btn-outline-warning w-100">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> Alertas de Vencimiento
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('temperaturas.index') }}" class="btn btn-outline-info w-100">
                <i class="bi bi-thermometer-half me-2"></i> Control de Temperatura
            </a>
        </div>

        <div class="col-md-4">
            <a href="{{ route('ubicaciones.index') }}" class="btn btn-outline-secondary w-100">
                <i class="bi bi-pin-map-fill me-2"></i> Ubicaciones de Almacén
            </a>
        </div>
    </div>
</div>
@endsection
