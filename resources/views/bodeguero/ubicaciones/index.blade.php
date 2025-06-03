@extends('layouts.bodeguero')
@section('title', 'Ubicaciones de Almacén')

@section('content')

@push('styles')
<style>
    html, body {
        height: 100%;
        overflow-x: hidden;
    }

    .ubicacion-card {
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.25rem;
        background-color: #fff;
        box-shadow: 0 6px 16px rgba(0,0,0,0.05);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .ubicacion-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    }

    .ubicacion-title {
        font-weight: 600;
        font-size: 1.1rem;
        color: #0d6efd;
        margin-bottom: 0.4rem;
    }

    .ubicacion-label {
        font-size: 0.92rem;
        color: #495057;
        margin-bottom: 0.3rem;
    }

    .badge-lotes {
        background-color: #0d6efd;
        color: white;
        padding: 0.35rem 0.7rem;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .badge-tipo {
        padding: 0.35rem 0.7rem;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        font-weight: 500;
        color: white;
    }

    .bg-seco { background-color: #6c757d; }
    .bg-refrigerado { background-color: #0dcaf0; }
    .bg-congelado { background-color: #0d6efd; }

    .fade-in {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

<div class="container-fluid py-4 fade-in">
    <h4 class="fw-bold text-primary mb-4">
        <i class="bi bi-map me-2"></i>Ubicaciones de Almacén
    </h4>

    @if($ubicaciones->isEmpty())
        <div class="alert alert-info text-center fade-in">
            No hay ubicaciones registradas actualmente.
        </div>
    @else
        <div class="row g-4">
            @foreach ($ubicaciones as $ubicacion)
                <div class="col-md-6 col-lg-4 fade-in">
                    <div class="ubicacion-card">
                        <div class="ubicacion-title">
                            Código: {{ $ubicacion->codigo_ubicacion }}
                        </div>

                        <div class="ubicacion-label">
                            <i class="bi bi-building"></i>
                            Almacén: {{ $ubicacion->almacen->nombre ?? 'No definido' }}
                        </div>

                        <div class="ubicacion-label">
                            <i class="bi bi-thermometer-half"></i>
                            Tipo:
                            <span class="badge-tipo
                                {{ $ubicacion->tipo_almacenamiento == 'seco' ? 'bg-seco' : '' }}
                                {{ $ubicacion->tipo_almacenamiento == 'refrigerado' ? 'bg-refrigerado' : '' }}
                                {{ $ubicacion->tipo_almacenamiento == 'congelado' ? 'bg-congelado' : '' }}">
                                {{ ucfirst($ubicacion->tipo_almacenamiento) }}
                            </span>
                        </div>

                        <div class="ubicacion-label">
                            <i class="bi bi-box-seam"></i>
                            Capacidad máxima: {{ $ubicacion->capacidad_maxima }}
                        </div>

                        <div class="ubicacion-label">
                            <i class="bi bi-exclamation-circle"></i>
                            Restricciones: {{ $ubicacion->restricciones ?? 'Ninguna' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
