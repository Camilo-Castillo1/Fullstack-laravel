@extends('layouts.bodega')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 text-success"><i class="bi bi-plus-circle me-2"></i>Nuevo Registro de Temperatura</h4>

    <form method="POST" action="{{ route('bodega.temperaturas.store') }}" class="card shadow-sm p-4">
        @csrf

        <div class="mb-3">
            <label class="form-label">Almacén</label>
            <select name="almacen_id" class="form-select" required>
                @foreach($almacenes as $almacen)
                <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Temperatura (°C)</label>
            <input type="number" name="temperatura" class="form-control" step="0.1" min="-50" max="100" required>
        </div>

        <div class="text-end">
            <a href="{{ route('bodega.temperaturas.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
        </div>
    </form>
</div>
@endsection
