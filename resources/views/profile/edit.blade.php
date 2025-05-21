@extends('layouts.app')

@section('header', 'Editar Perfil')

@section('content')
<style>
    #perfilCard {
        transition: transform 0.3s ease, background-color 0.3s ease;
    }

    #perfilCard:hover {
        transform: scale(1.02);
    }

    .dark-mode #perfilCard {
        background-color: #2a3b5c !important;
        color: #e2e8f0;
    }

    body:not(.dark-mode) #perfilCard {
        background-color: #f8f9fa !important;
        color: #212529;
    }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0" id="perfilCard">
                <div class="card-body">
                    <h4 class="mb-4">
                        <i class="bi bi-person-circle me-2"></i>Información del Perfil
                    </h4>

                    @if (session('status') === 'profile-updated')
                        <div class="alert alert-success alert-dismissible fade show" role="alert" id="statusMessage">
                            Guardado correctamente.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        {{-- Nombre --}}
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control"
                                   value="{{ old('nombre', $user->nombre) }}" required autofocus>
                            @error('nombre') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        {{-- Apellido --}}
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" id="apellido" name="apellido" class="form-control"
                                   value="{{ old('apellido', $user->apellido) }}" required>
                            @error('apellido') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        {{-- Correo --}}
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" id="correo" name="correo" class="form-control"
                                   value="{{ old('correo', $user->correo) }}" required>
                            @error('correo') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        {{-- Teléfono --}}
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" id="telefono" name="telefono" class="form-control"
                                   value="{{ old('telefono', $user->telefono) }}">
                            @error('telefono') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-1"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Animación con JavaScript para el mensaje de éxito --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusMsg = document.getElementById('statusMessage');
        if (statusMsg) {
            setTimeout(() => {
                statusMsg.classList.add('fade');
                statusMsg.classList.remove('show');
            }, 3000);
        }
    });
</script>
@endsection
