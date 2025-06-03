@extends('layouts.app')

@section('header', 'Editar Rol')

@section('content')
<div class="container py-4">
    <div class="card shadow rounded-4 border-0 bg-body text-body">
        <div class="card-body p-4">

            <h4 class="fw-bold mb-3">
                <i class="bi bi-pencil-square me-2"></i> Editar Rol: <span class="text-primary">{{ $role->name }}</span>
            </h4>

            <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                @csrf @method('PUT')

                <div class="mb-4">
                    <label for="name" class="form-label fw-semibold">Nombre del Rol</label>
                    <input type="text" name="name" id="name" class="form-control shadow-sm" value="{{ $role->name }}" required>
                </div>

                <h5 class="fw-bold mb-3">Permisos Asignados</h5>

                @foreach($grupos as $clave => $titulo)
                    <div class="mb-4 border rounded-3 p-3 bg-light-subtle dark-mode-card">
                        <h6 class="fw-semibold mb-3">
                            <i class="bi bi-folder2-open me-1"></i> {{ $titulo }}
                        </h6>
                        <div class="row">
                            @foreach ($permisos->filter(fn($p) => str_contains($p->name, $clave)) as $permiso)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[]" value="{{ $permiso->name }}"
                                            class="form-check-input"
                                            {{ in_array($permiso->name, $rolePermissions) ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $permiso->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="bi bi-save me-1"></i> Guardar Cambios
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
