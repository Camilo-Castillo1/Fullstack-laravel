@extends('layouts.app')

@section('header', 'Gestión de Usuarios')

@section('content')
    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus-fill me-1"></i> Crear Usuario
            </a>
        </div>

        <div class="card bg-dark text-white shadow-sm border-0">
            <div class="card-body">
                @if ($usuarios->isEmpty())
                    <p class="text-center text-muted">No hay usuarios registrados.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-dark table-striped table-hover align-middle mb-0">
                            <thead>
                                <tr class="text-white">
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td>{{ $usuario->id }}</td>
                                        <td>{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
                                        <td>{{ $usuario->correo }}</td>
                                        <td>
                                            @foreach ($usuario->roles as $rol)
                                                <span class="badge bg-secondary">{{ $rol->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="btn btn-warning btn-sm me-1">
                                                <i class="bi bi-pencil-square"></i> Editar
                                            </a>
                                            <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                                @csrf
                                                @method('DELETE')
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
