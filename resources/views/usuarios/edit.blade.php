@extends('layouts.app')

@section('header', 'Editar Usuario')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card bg-dark text-white shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nombre --}}
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre', $usuario->nombre) }}" required>
                            @error('nombre')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Apellido --}}
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" id="apellido" name="apellido" class="form-control" value="{{ old('apellido', $usuario->apellido) }}" required>
                            @error('apellido')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Correo --}}
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" id="correo" name="correo" class="form-control" value="{{ old('correo', $usuario->correo) }}" required>
                            @error('correo')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Contraseña (opcional) --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña (opcional)</label>
                            <input type="password" id="password" name="password" class="form-control">
                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Teléfono --}}
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" class="form-control" value="{{ old('telefono', $usuario->telefono) }}">
                            @error('telefono')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Roles --}}
                        <div class="mb-3">
                            <label for="roles" class="form-label">Rol(es)</label>
                            <select name="roles[]" id="roles" class="form-select" multiple required>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->name }}" {{ $usuario->roles->pluck('name')->contains($rol->name) ? 'selected' : '' }}>
                                        {{ $rol->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('roles')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Botones --}}
                        <div class="d-flex align-items-center mt-4">
                            <button type="submit" class="btn btn-success me-3">
                                <i class="bi bi-save me-1"></i> Actualizar Usuario
                            </button>
                            <a href="{{ route('admin.usuarios.index') }}" class="text-decoration-none text-secondary">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
