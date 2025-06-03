@extends('layouts.bodeguero')
@section('title', 'Entradas')

@section('content')

@push('styles')
<style>
    .entrada-card {
        border: 1px solid #dee2e6;
        border-radius: 1rem;
        padding: 1.5rem;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .entrada-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
    }

    .entrada-title {
        font-weight: 600;
        font-size: 1.1rem;
        color: #0d6efd;
        margin-bottom: 0.5rem;
    }

    .entrada-label {
        font-size: 0.92rem;
        color: #495057;
        margin-bottom: 0.4rem;
    }

    .entrada-icon {
        font-size: 1.2rem;
        margin-right: 0.4rem;
        color: #6c757d;
    }

    .badge-cantidad {
        background-color: #0d6efd;
        color: white;
        padding: 0.35rem 0.7rem;
        border-radius: 0.5rem;
        font-size: 0.8rem;
        font-weight: 500;
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

@php
    $entradas = $entradas ?? collect();
@endphp

<div class="container-fluid fade-in">
    <div class="d-flex justify-content-between flex-wrap align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="bi bi-box-arrow-in-down me-2"></i>Entradas de Inventario
        </h2>
    </div>

    @if($entradas->isEmpty())
        <div class="alert alert-warning text-center fade-in">
            <i class="bi bi-exclamation-triangle me-2"></i> No se han registrado entradas aún.
        </div>
    @else
        <div class="row g-4">
            @foreach ($entradas as $entrada)
                <div class="col-md-6 col-lg-4 fade-in">
                    <div class="entrada-card">
                        <div class="entrada-title">
                            <i class="bi bi-box"></i> Producto: <span>{{ $entrada->lote->producto->nombre ?? '—' }}</span>
                        </div>

                        <div class="entrada-label">
                            <i class="bi bi-upc entrada-icon"></i>
                            Código Lote: {{ $entrada->lote->codigo_lote ?? '—' }}
                        </div>

                        <div class="entrada-label">
                            <i class="bi bi-cash-coin entrada-icon"></i>
                            Cantidad: <span class="badge-cantidad">{{ $entrada->cantidad }}</span>
                        </div>

                        <div class="entrada-label">
                            <i class="bi bi-calendar-event entrada-icon"></i>
                            Fecha: {{ \Carbon\Carbon::parse($entrada->fecha_movimiento)->format('d/m/Y H:i') }}
                        </div>

                        <div class="entrada-label">
                            <i class="bi bi-person-circle entrada-icon"></i>
                            Usuario: {{ $entrada->usuario->nombre ?? '—' }}
                        </div>

                        <div class="entrada-label">
                            <i class="bi bi-chat-left-text entrada-icon"></i>
                            Motivo: {{ $entrada->motivo ?? '—' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
