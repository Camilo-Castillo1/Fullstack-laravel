@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Crear Nuevo Rol</h3>

    <form action="{{ route('admin.roles.store') }}" method="POST" class="mt-3">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Rol</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
            <small class="form-text text-muted">Ejemplo: Administrador, Técnico, Auditor</small>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Guardar Rol</button>
    </form>
</div>

<script>
    document.getElementById('nombre').addEventListener('input', function () {
        this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ ]/g, '');
    });
</script>
@endsection
