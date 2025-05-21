@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Crear Nuevo Rol</h2>

    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nombre del Rol:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <h5 class="mt-4">Asignar Permisos por Módulo:</h5>

        @foreach($grupos as $clave => $titulo)
            <div class="card mb-3">
                <div class="card-header fw-bold">{{ $titulo }}</div>
                <div class="card-body row">
                    @foreach ($permisos->filter(fn($p) => str_contains($p->name, $clave)) as $permiso)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input type="checkbox" name="permissions[]" value="{{ $permiso->name }}" class="form-check-input">
                                <label class="form-check-label">{{ $permiso->name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> Guardar Rol
        </button>
    </form>
</div>
@endsection
