@extends('layouts.bodega')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <h4 class="card-title">Bienvenido, {{ Auth::user()->nombre }}</h4>
        <p class="card-text">Vista exclusiva para el Administrador de Bodega.</p>
        <hr>
        <div class="row g-3">
            <div class="col-md-4">
                <a href="{{ route('bodega.productos.index') }}" class="btn btn-outline-primary w-100">
                    <i class="bi bi-box-seam"></i> Productos
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('bodega.salidas.index') }}" class="btn btn-outline-warning w-100">
                    <i class="bi bi-truck"></i> Salidas
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('bodega.alertas.index') }}" class="btn btn-outline-danger w-100">
                    <i class="bi bi-exclamation-triangle"></i> Alertas
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
