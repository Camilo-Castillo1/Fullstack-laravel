@extends('layouts.app')

@section('header', 'Categorías')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0" id="categoriaCard">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Listado de Categorías</h5>
                <a href="{{ route('categorias.create') }}" class="btn btn-primary rounded-pill">
                    <i class="bi bi-plus-circle me-1"></i> Nueva Categoría
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($categorias->isEmpty())
                <p class="text-muted text-center">No hay categorías registradas.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categorias as $categoria)
                                <tr>
                                    <td class="text-center">{{ $categoria->id }}</td>
                                    <td>{{ $categoria->nombre }}</td>
                                    <td>{{ $categoria->descripcion }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-warning btn-sm me-1">
                                            <i class="bi bi-pencil-square"></i> Editar
                                        </a>
                                        <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Eliminar esta categoría?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
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
