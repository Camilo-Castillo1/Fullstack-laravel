@extends('layouts.bodeguero')
@section('title', 'Lotes Registrados')

@section('content')

@push('styles')
<style>
    .lote-card {
        border: 1px solid #dee2e6;
        border-radius: 1rem;
        padding: 1.5rem;
        background-color: #ffffff;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }

    .lote-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
    }

    .lote-titulo {
        font-size: 1.15rem;
        font-weight: 600;
        color: #0d6efd;
        margin-bottom: 0.6rem;
    }

    .lote-label {
        font-size: 0.92rem;
        color: #495057;
        margin-bottom: 0.4rem;
    }

    .badge-estado {
        padding: 0.35rem 0.7rem;
        font-size: 0.8rem;
        border-radius: 0.6rem;
        font-weight: 600;
    }

    .bg-disponible {
        background-color: #198754;
        color: white;
    }

    .bg-agotado {
        background-color: #ffc107;
        color: #212529;
    }

    .bg-vencido {
        background-color: #dc3545;
        color: white;
    }

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
        <i class="bi bi-boxes me-2"></i>Lotes Registrados
    </h4>

    @if($lotes->isEmpty())
        <div class="alert alert-info text-center fade-in">
            <i class="bi bi-info-circle me-2"></i> No hay lotes registrados actualmente.
        </div>
    @else
        <div class="row g-4">
            @foreach ($lotes as $lote)
                <div class="col-md-6 col-lg-4 fade-in">
                    <div class="lote-card">
                        <div class="lote-titulo">
                            Lote: {{ $lote->codigo_lote }}
                        </div>

                        <div class="lote-label">
                            <i class="bi bi-tag me-1"></i>
                            Producto: <strong>{{ $lote->producto->nombre ?? 'Sin producto' }}</strong>
                        </div>

                        <div class="lote-label">
                            <i class="bi bi-calendar-plus me-1"></i>
                            Ingreso: {{ \Carbon\Carbon::parse($lote->fecha_ingreso)->format('d/m/Y') }}
                        </div>

                        <div class="lote-label">
                            <i class="bi bi-calendar-x me-1"></i>
                            Vencimiento:
                            {{ $lote->fecha_vencimiento ? \Carbon\Carbon::parse($lote->fecha_vencimiento)->format('d/m/Y') : 'N/A' }}
                        </div>

                        <div class="lote-label">
                            <i class="bi bi-box me-1"></i>
                            Cantidad: <strong>{{ $lote->cantidad }}</strong>
                        </div>

                        <div class="lote-label">
                            <i class="bi bi-info-circle me-1"></i>
                            Estado:
                            <span class="badge badge-estado
                                @if($lote->estado === 'disponible') bg-disponible
                                @elseif($lote->estado === 'agotado') bg-agotado
                                @else bg-vencido @endif">
                                {{ ucfirst($lote->estado) }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
