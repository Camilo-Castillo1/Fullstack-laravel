@extends('layouts.app')

@section('header', 'Editar Rol')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0" id="rolesCard">
        <div class="card-body">
            <h5 class="mb-4">Editar Rol</h5>

            <form method="POST" action="{{ route('admin.roles.update', $rol->id) }}">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Rol</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $rol->nombre) }}" required>
                    @error('nombre')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $rol->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
