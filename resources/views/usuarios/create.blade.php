@extends('layouts.app')

@section('header')
    Crear Usuario
@endsection

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('usuarios.store') }}" method="POST">
                            @csrf

                            {{-- Nombre --}}
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre') }}" required autofocus>
                                @error('nombre')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Apellido --}}
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" id="apellido" name="apellido" class="form-control" value="{{ old('apellido') }}" required>
                                @error('apellido')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Correo --}}
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" id="correo" name="correo" class="form-control" value="{{ old('correo') }}" required>
                                @error('correo')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Contraseña --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Teléfono --}}
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" id="telefono" name="telefono" class="form-control" value="{{ old('telefono') }}">
                                @error('telefono')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Roles --}}
                            <div class="mb-3">
                                <label for="roles" class="form-label">Rol(es)</label>
                                <select name="roles[]" id="roles" class="form-select" multiple required>
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol->name }}" {{ collect(old('roles'))->contains($rol->name) ? 'selected' : '' }}>
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
                                    <i class="bi bi-save me-1"></i> Guardar Usuario
                                </button>
                                <a href="{{ route('usuarios.index') }}" class="text-decoration-none text-secondary">
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
