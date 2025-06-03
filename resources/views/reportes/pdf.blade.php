@extends('layouts.app')

@section('title', 'Reportes de Novedades o Quejas')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold text-primary mb-4">
        <i class="bi bi-file-earmark-text me-2"></i> Reportes de Novedades o Quejas
    </h4>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if($reportes->isEmpty())
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle me-1"></i> No hay reportes registrados.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reportes as $reporte)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $reporte->titulo }}</td>
                            <td>{{ Str::limit($reporte->descripcion, 50) }}</td>
                            <td>{{ $reporte->usuario->nombre ?? 'Desconocido' }}</td>
                            <td>{{ $reporte->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('reportes.ver-pdf', $reporte->id) }}" class="btn btn-sm btn-outline-danger" target="_blank">
                                    <i class="bi bi-file-earmark-pdf-fill"></i> Ver PDF
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
