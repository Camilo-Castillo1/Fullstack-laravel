@extends('layouts.app')

@section('header', 'Ubicaciones de Almacenamiento')

@section('content')
<style>
    .ubicacion-card {
        border-radius: 1rem;
        transition: transform 0.3s ease;
    }
    .ubicacion-card:hover {
        transform: scale(1.01);
    }
</style>

<div class="container py-4">
    <div class="card shadow border-0 ubicacion-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0"><i class="bi bi-geo-alt-fill me-2"></i> Listado de Ubicaciones</h4>
                <a href="{{ route('admin.ubicaciones.create') }}" class="btn btn-primary shadow-sm rounded-pill">
                    <i class="bi bi-plus-circle me-1"></i> Nueva Ubicación
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="alertaExito">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($ubicaciones->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="bi bi-geo me-2 fs-3"></i> No hay ubicaciones registradas.
                </div>
            @else
                <div class="table-responsive rounded-4 overflow-hidden">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th>#</th>
                                <th>Almacén</th>
                                <th>Código</th>
                                <th>Tipo</th>
                                <th>Capacidad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ubicaciones as $ubicacion)
                                <tr>
                                    <td class="text-center">{{ $ubicacion->id }}</td>
                                    <td>{{ $ubicacion->almacen->nombre }}</td>
                                    <td>{{ $ubicacion->codigo_ubicacion }}</td>
                                    <td>{{ ucfirst($ubicacion->tipo_almacenamiento) }}</td>
                                    <td class="text-center">{{ $ubicacion->capacidad_maxima }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.ubicaciones.edit', $ubicacion->id) }}" class="btn btn-warning btn-sm me-1 shadow-sm">
                                            <i class="bi bi-pencil-square"></i> Editar
                                        </a>
                                        <form action="{{ route('admin.ubicaciones.destroy', $ubicacion->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta ubicación?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm shadow-sm">
                                                <i class="bi bi-trash-fill"></i> Eliminar
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

<script>
    // Oculta la alerta de éxito luego de 3 segundos
    setTimeout(() => {
        const alerta = document.getElementById('alertaExito');
        if (alerta) alerta.classList.remove('show');
    }, 3000);
</script>
@endsection
