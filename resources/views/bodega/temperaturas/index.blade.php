@extends('layouts.bodega')

@section('content')
<div class="container py-4">
    <h4 class="mb-4 text-primary">
        <i class="bi bi-thermometer-half me-2"></i>Registros de Temperatura
    </h4>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('bodega.temperaturas.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Nueva Temperatura
        </a>
    </div>

    <div class="table-responsive">
        <table id="tablaTemperaturas" class="table table-bordered table-hover">
            <thead class="table-light text-center align-middle">
                <tr>
                    <th>#</th>
                    <th>Almacén</th>
                    <th>Temperatura (°C)</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody class="text-center align-middle">
                @forelse($registros as $registro)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $registro->almacen->nombre }}</td>
                        <td>
                            @php
                                $temp = $registro->temperatura;
                                $clase = $temp < 0 ? 'bg-primary' : ($temp <= 25 ? 'bg-success' : ($temp <= 40 ? 'bg-warning text-dark' : 'bg-danger'));
                            @endphp
                            <span class="badge {{ $clase }}">{{ $temp }} °C</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($registro->fecha_registro)->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('bodega.temperaturas.edit', $registro->id) }}"
                               class="btn btn-outline-primary btn-sm" title="Editar">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted">No hay registros de temperatura aún.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#tablaTemperaturas').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            }
        });
    });
</script>
@endpush
@endsection
