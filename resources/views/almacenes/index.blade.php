@extends('layouts.app')

@section('header', 'Almacenes')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0"><i class="bi bi-box-seam me-2"></i> Listado de Almacenes</h4>
                <a href="{{ route('admin.almacenes.create') }}" class="btn btn-primary shadow-sm rounded-pill">
                    <i class="bi bi-plus-circle me-1"></i> Nuevo Almacén
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($almacenes->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="bi bi-inboxes display-5 d-block mb-3"></i>
                    No hay almacenes registrados.
                </div>
            @else
                <div class="table-responsive rounded-4 overflow-hidden">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Ubicación</th>
                                <th>Capacidad Máxima</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($almacenes as $almacen)
                                <tr>
                                    <td class="text-center">{{ $almacen->id }}</td>
                                    <td class="text-capitalize">{{ $almacen->nombre }}</td>
                                    <td>{{ $almacen->ubicacion }}</td>
                                    <td class="text-center">{{ $almacen->capacidad_maxima }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.almacenes.edit', $almacen->id) }}" class="btn btn-warning btn-sm me-1 shadow-sm">
                                            <i class="bi bi-pencil-square"></i> Editar
                                        </a>
                                        <form action="{{ route('admin.almacenes.destroy', $almacen->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Eliminar este almacén?');">
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
@endsection
