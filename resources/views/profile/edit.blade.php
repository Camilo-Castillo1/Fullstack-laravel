@extends('layouts.app')

@section('header', 'Editar Perfil')

@section('content')
<div class="container py-4">
    <div class="mx-auto" style="max-width: 700px;">
        <div class="card border-0 shadow rounded-4 px-4 py-3 bg-body text-body">
            <div class="card-header bg-transparent border-0 pb-0">
                <h5 class="fw-bold mb-1">
                    <i class="bi bi-person-circle me-2"></i>
                    Mi Información Personal
                </h5>
                <p class="text-muted small mb-0">Actualiza tu nombre, correo y otros datos de perfil.</p>
            </div>

            <div class="card-body pt-3">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        {{-- Nombre --}}
                        <div class="col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" value="{{ old('nombre', Auth::user()->nombre) }}"
                                   class="form-control shadow-sm" required>
                        </div>

                        {{-- Apellido --}}
                        <div class="col-md-6">
                            <label class="form-label">Apellido</label>
                            <input type="text" name="apellido" value="{{ old('apellido', Auth::user()->apellido) }}"
                                   class="form-control shadow-sm" required>
                        </div>

                        {{-- Correo --}}
                        <div class="col-md-12">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" name="correo" value="{{ old('correo', Auth::user()->correo) }}"
                                   class="form-control shadow-sm" required>
                        </div>

                        {{-- Teléfono --}}
                        <div class="col-md-12">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" value="{{ old('telefono', Auth::user()->telefono) }}"
                                   class="form-control shadow-sm">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">
                            <i class="bi bi-check-circle me-1"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
