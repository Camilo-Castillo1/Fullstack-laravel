@extends('layouts.app')

@section('header', 'Registrar Temperatura')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.temperaturas.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="almacen_id" class="form-label">Almacén</label>
                    <select name="almacen_id" class="form-select" required>
                        <option value="">Seleccione un almacén</option>
                        @foreach ($almacenes as $almacen)
                            <option value="{{ $almacen->id }}" {{ old('almacen_id') == $almacen->id ? 'selected' : '' }}>
                                {{ $almacen->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('almacen_id') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="temperatura" class="form-label">Temperatura (°C)</label>
                    <input type="number" step="0.01" name="temperatura" value="{{ old('temperatura') }}" class="form-control" required>
                    @error('temperatura') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.temperaturas.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
