@extends('layouts.app')

@section('header', 'Gestión de Roles')

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="bi bi-shield-lock me-2"></i> Gestión de Roles</h4>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Crear nuevo rol
        </a>
    </div>

    <div class="bg-white dark-mode-card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-borderless align-middle mb-0">
                <thead class="bg-light dark-mode-header">
                    <tr>
                        <th class="py-3 ps-4 text-secondary">Rol</th>
                        <th class="py-3 text-secondary">Permisos</th>
                        <th class="py-3 pe-4 text-end text-secondary">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $rol)
                        <tr class="border-top">
                            <td class="ps-4 text-capitalize fw-semibold text-muted">{{ $rol->name }}</td>
                            <td>
                                @forelse($rol->permissions as $permiso)
                                    <span class="badge bg-dark-subtle text-dark-emphasis dark-mode-badge me-1 mb-1">{{ $permiso->name }}</span>
                                @empty
                                    <span class="badge bg-secondary-subtle text-muted">Sin permisos</span>
                                @endforelse
                            </td>
                            <td class="pe-4 text-end">
                                <a href="{{ route('admin.roles.edit', $rol) }}" class="btn btn-sm btn-outline-warning me-1">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.roles.destroy', $rol) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('¿Eliminar este rol?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">No hay roles registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
