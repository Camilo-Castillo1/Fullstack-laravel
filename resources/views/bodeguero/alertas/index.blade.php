@extends('layouts.bodeguero')
@section('title', 'Alertas de Vencimiento')

@section('content')

@push('styles')
<style>
    .alerta-card {
        border: 1px solid #f8d7da;
        border-radius: 1rem;
        padding: 1.5rem;
        background-color: #fff;
        box-shadow: 0 4px 16px rgba(0,0,0,0.05);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .alerta-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.08);
    }

    .alerta-title {
        font-weight: 700;
        font-size: 1.1rem;
        color: #dc3545;
        margin-bottom: 0.5rem;
    }

    .alerta-info {
        font-size: 0.93rem;
        color: #495057;
        margin-bottom: 0.35rem;
    }

    .badge-vencida {
        background-color: #dc3545;
        color: white;
        padding: 0.35rem 0.7rem;
        border-radius: 0.6rem;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-proxima {
        background-color: #ffc107;
        color: #212529;
        padding: 0.35rem 0.7rem;
        border-radius: 0.6rem;
        font-size: 0.8rem;
        font-weight: 600;
    }

    /* Animación tipo productos */
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
    <h4 class="fw-bold text-danger mb-4">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>Alertas de Vencimiento
    </h4>

    @if($alertas->isEmpty())
        <div class="alert alert-success text-center fade-in">
            No hay productos próximos a vencer ni vencidos.
        </div>
    @else
        <div class="row g-4">
            @foreach ($alertas as $alerta)
                @php
                    $fechaVencimiento = \Carbon\Carbon::parse($alerta->fecha_vencimiento);
                    $diasRestantes = now()->diffInDays($fechaVencimiento, false);
                @endphp

                <div class="col-md-6 col-lg-4 fade-in">
                    <div class="alerta-card">
                        <div class="alerta-title">
                            {{ $alerta->lote->producto->nombre ?? 'Producto no encontrado' }}
                        </div>

                        <div class="alerta-info">
                            <i class="bi bi-upc-scan me-1"></i>
                            Lote: <strong>{{ $alerta->lote->id }}</strong>
                        </div>

                        <div class="alerta-info">
                            <i class="bi bi-calendar-event me-1"></i>
                            Fecha de vencimiento: {{ $fechaVencimiento->format('d/m/Y') }}
                        </div>

                        <div class="alerta-info">
                            <i class="bi bi-hourglass-bottom me-1"></i>
                            @if ($diasRestantes < 0)
                                <span class="badge badge-vencida">Vencido hace {{ abs($diasRestantes) }} día(s)</span>
                            @elseif ($diasRestantes === 0)
                                <span class="badge badge-vencida">Vence hoy</span>
                            @else
                                <span class="badge badge-proxima">Vence en {{ $diasRestantes }} día(s)</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
