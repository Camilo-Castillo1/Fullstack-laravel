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

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0"><i class="bi bi-people me-2"></i> Gestión de Usuarios</h4>
            <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Crear Usuario
            </a>
        </div>

        <div class="card border-0 shadow rounded-4 bg-white">
            <div class="card-body p-0">
                @if ($usuarios->isEmpty())
                    <div class="p-4 text-center text-muted">No hay usuarios registrados.</div>
                @else
                    <div class="table-responsive rounded-4 overflow-hidden">
                        <table class="table table-bordered align-middle table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Rol</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td>{{ $usuario->id }}</td>
                                        <td>{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
                                        <td>{{ $usuario->correo }}</td>
                                        <td>
                                            @forelse ($usuario->roles as $rol)
                                                <span class="badge bg-secondary me-1">{{ $rol->name }}</span>
                                            @empty
                                                <span class="badge bg-light text-muted">Sin rol</span>
                                            @endforelse
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.usuarios.edit', $usuario->id) }}" class="btn btn-warning btn-sm me-1 shadow-sm">
                                                <i class="bi bi-pencil-square"></i> Editar
                                            </a>
                                            <form action="{{ route('admin.usuarios.destroy', $usuario->id) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                                @csrf
                                                @method('DELETE')
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
