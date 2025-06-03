@extends('layouts.bodega')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 text-info"><i class="bi bi-thermometer-half me-2"></i>Control de Temperatura</h4>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('bodega.temperaturas.create') }}" class="btn btn-info shadow-sm">
            <i class="bi bi-plus-circle me-1"></i>Nuevo Registro
        </a>
    </div>

    <div class="table-responsive shadow-sm">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th>Almacén</th>
                    <th>Temperatura (°C)</th>
                    <th>Fecha de Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @forelse($registros as $registro)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $registro->almacen->nombre }}</td>
                        <td class="{{ $registro->temperatura > 30 ? 'text-danger fw-bold' : 'text-success' }}">
                            {{ $registro->temperatura }}
                        </td>
                        <td>{{ \Carbon\Carbon::parse($registro->fecha_registro)->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('bodega.temperaturas.edit', $registro->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No hay registros disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
