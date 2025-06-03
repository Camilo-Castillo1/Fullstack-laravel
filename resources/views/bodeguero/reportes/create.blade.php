@extends('layouts.bodeguero')
@section('title', 'Reportar Novedad o Queja')

@section('content')
<div class="container">
    <h4 class="fw-bold text-primary mb-4">
        <i class="bi bi-clipboard-plus me-2"></i> Reportar Novedad o Queja
    </h4>

    <form method="POST" action="{{ route('bodeguero.reportes.store') }}">
        @csrf
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de Reporte</label>
            <select name="tipo" class="form-select" required>
                <option value="Novedad">Novedad</option>
                <option value="Queja">Queja</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" maxlength="100" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción detallada</label>
            <textarea name="descripcion" class="form-control" rows="5" maxlength="1000" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-send-fill me-1"></i> Enviar Reporte
        </button>
    </form>
</div>
@endsection
