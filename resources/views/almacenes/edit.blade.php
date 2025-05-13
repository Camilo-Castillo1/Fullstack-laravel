@extends('layouts.app')

@section('header', 'Editar Almacén')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0" id="almacenCard">
        <div class="card-body">
            <h5 class="mb-4">Editar Almacén</h5>

            <form method="POST" action="{{ route('almacenes.update', ['almacen' => $almacen->id]) }}">

                @csrf @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre"
                        value="{{ old('nombre', $almacen->nombre) }}" required>
                    @error('nombre') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="ubicacion" class="form-label">Ubicación</label>
                    <textarea class="form-control" id="ubicacion" name="ubicacion" rows="3" required>{{ old('ubicacion', $almacen->ubicacion) }}</textarea>
                    @error('ubicacion') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="capacidad_maxima" class="form-label">Capacidad Máxima</label>
                    <input type="number" class="form-control" id="capacidad_maxima" name="capacidad_maxima"
                        value="{{ old('capacidad_maxima', $almacen->capacidad_maxima) }}" min="1" required>
                    @error('capacidad_maxima') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('almacenes.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
