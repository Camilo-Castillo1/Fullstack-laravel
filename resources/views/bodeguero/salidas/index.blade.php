@extends('layouts.bodeguero')
@section('title', 'Salidas')

@section('content')

@push('styles')
<style>
    .salida-card {
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.5rem;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .salida-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    }

    .salida-title {
        font-weight: 600;
        font-size: 1.1rem;
        color: #0d6efd;
        margin-bottom: 0.4rem;
    }

    .salida-label {
        font-size: 0.92rem;
        color: #495057;
        margin-bottom: 0.35rem;
    }

    .badge-cantidad {
        background-color: #dc3545;
        color: white;
        padding: 0.35rem 0.7rem;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        font-weight: 500;
    }

    /* Animación */
    .fade-in {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

<div class="container-fluid py-4 fade-in">
    <h4 class="fw-bold text-primary mb-4">
        <i class="bi bi-box-arrow-up me-2"></i>Salidas de Inventario
    </h4>

    @if($salidas->isEmpty())
        <div class="alert alert-warning text-center fade-in">
            <i class="bi bi-exclamation-circle me-2"></i> No hay salidas registradas.
        </div>
    @else
        <div class="row g-4">
            @foreach ($salidas as $salida)
                <div class="col-md-6 col-lg-4 fade-in">
                    <div class="salida-card">
                        <div class="salida-title">
                            <i class="bi bi-box"></i>
                            {{ optional($salida->lote->producto)->nombre ?? 'Producto no encontrado' }}
                        </div>

                        <div class="salida-label">
                            <i class="bi bi-upc"></i>
                            Lote: <strong>{{ $salida->lote->codigo_lote ?? '—' }}</strong>
                        </div>

                        <div class="salida-label">
                            <i class="bi bi-dash-circle"></i>
                            Cantidad: <span class="badge-cantidad">{{ $salida->cantidad }}</span>
                        </div>

                        <div class="salida-label">
                            <i class="bi bi-calendar3"></i>
                            Fecha: {{ \Carbon\Carbon::parse($salida->fecha_movimiento)->format('d/m/Y H:i') }}
                        </div>

                        <div class="salida-label">
                            <i class="bi bi-person-circle"></i>
                            Usuario: {{ $salida->usuario->nombre ?? 'Desconocido' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
