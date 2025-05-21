@extends('layouts.app')

@section('header', 'Panel de Control')

@section('content')
<div class="container py-4">
    {{-- Bienvenida --}}
    <div class="mb-4">
        <div class="card border-0 shadow-lg bg-primary text-white">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-1">Bienvenido, {{ Auth::user()->nombre }}</h4>
                    <p class="card-text mb-0">Tienes acceso completo al sistema como administrador.</p>
                </div>
                <i class="bi bi-person-check-fill fs-1"></i>
            </div>
        </div>
    </div>

    {{-- Acciones rápidas --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('admin.usuarios.index') }}" class="text-decoration-none">
                <div class="card bg-dark text-white shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-people-fill fs-2 me-3"></i>
                        <div>
                            <h6 class="mb-1">Gestión de Usuarios</h6>
                            <small>Ver, editar o eliminar usuarios</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('admin.productos.index') }}" class="text-decoration-none">
                <div class="card bg-dark text-white shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-box-seam fs-2 me-3"></i>
                        <div>
                            <h6 class="mb-1">Gestión de Productos</h6>
                            <small>Agregar o revisar productos</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-4">
            <a href="{{ route('admin.lotes.index') }}" class="text-decoration-none">
                <div class="card bg-dark text-white shadow h-100">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-layers-fill fs-2 me-3"></i>
                        <div>
                            <h6 class="mb-1">Gestión de Lotes</h6>
                            <small>Control de stock y vencimiento</small>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Panel de alertas urgentes --}}
    <div class="card shadow border-0 mb-4">
        <div class="card-header bg-warning text-dark fw-bold">
            <i class="bi bi-exclamation-triangle-fill me-1"></i> Alertas Urgentes de Vencimiento
        </div>
        <div class="card-body">
            @php
                $alertas = \App\Models\AlertaVencimiento::with('lote.producto')
                    ->where('estado', 'pendiente')
                    ->orderBy('fecha_alerta_generada', 'desc')
                    ->take(5)
                    ->get();
            @endphp

            @if($alertas->isEmpty())
                <div class="alert alert-success text-center">
                    <i class="bi bi-check-circle-fill me-1"></i> No hay alertas urgentes por el momento.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Vencimiento</th>
                                <th>Estado</th>
                                <th>Ver</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alertas as $alerta)
                                <tr class="table-warning">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $alerta->lote->codigo_lote }}</td>
                                    <td>{{ $alerta->lote->producto->nombre ?? 'N/A' }}</td>
                                    <td>{{ $alerta->fecha_vencimiento }}</td>
                                    <td>
                                        <span class="badge bg-danger">{{ ucfirst($alerta->estado) }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.alertas.show', $alerta->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-end mt-3">
                    <a href="{{ route('admin.alertas.index') }}" class="btn btn-outline-secondary">
                        Ver todas las alertas
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
