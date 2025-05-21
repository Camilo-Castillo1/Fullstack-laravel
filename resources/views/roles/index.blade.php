@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Gestión de Roles</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Crear nuevo rol
    </a>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Nombre del Rol</th>
                <th>Permisos Asignados</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $rol)
                <tr>
                    <td>{{ $rol->name }}</td>
                    <td>
                        @foreach($rol->permissions as $permiso)
                            <span class="badge bg-secondary">{{ $permiso->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('admin.roles.edit', $rol) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        <form action="{{ route('admin.roles.destroy', $rol) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este rol?')">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
