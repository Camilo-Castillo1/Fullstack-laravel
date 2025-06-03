@extends('layouts.bodeguero')

@section('title', 'Resumen')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    .status-card {
        border-left: 5px solid #0d6efd;
        background: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 0.1rem 0.5rem rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, background-color 0.3s ease, border-color 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .status-card:hover {
        transform: translateY(-5px);
        border-left-color: #198754;
        background-color: #f8f9fa;
    }
    .status-icon {
        font-size: 2rem;
        opacity: 0.9;
        animation: bounce 1.5s infinite;
    }
    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-5px);
        }
    }
    .status-title {
        font-size: 1rem;
        font-weight: 600;
    }
    .status-value {
        font-size: 1.3rem;
        font-weight: bold;
        color: #212529;
    }
    .status-card a.stretched-link {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        z-index: 1;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="mb-4 text-center" data-aos="fade-down">
        <h2 class="fw-bold text-success">Panel de Bodega</h2>
        <p class="text-muted">Consulta el estado general del inventario y accede rápidamente a los módulos.</p>
    </div>

    {{-- Tarjetas con enlaces --}}
    <div class="row g-4 text-center">
        @php
            $items = [
                ['id' => 'stockTotal', 'icon' => 'box-seam', 'text' => 'Productos en stock', 'color' => 'primary', 'route' => route('bodeguero.productos.index')],
                ['id' => 'entradasHoy', 'icon' => 'check-circle', 'text' => 'Entradas recientes', 'color' => 'success', 'route' => route('bodeguero.entradas.index')],
                ['id' => 'salidasHoy', 'icon' => 'box-arrow-up', 'text' => 'Salidas recientes', 'color' => 'danger', 'route' => route('bodeguero.salidas.index')],
                ['id' => 'alertasActivas', 'icon' => 'exclamation-triangle', 'text' => 'Alertas activas', 'color' => 'warning', 'route' => route('bodeguero.alertas.index')],
                ['id' => 'ubicacionesTotal', 'icon' => 'map', 'text' => 'Ubicaciones asignadas', 'color' => 'dark', 'route' => route('bodeguero.ubicaciones.index')],
            ];
        @endphp

        @foreach($items as $index => $item)
        <div class="col-md-6 col-xl-4" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
            <div class="status-card p-3">
                <i class="bi bi-{{ $item['icon'] }} text-{{ $item['color'] }} status-icon"></i>
                <div class="status-title">{{ $item['text'] }}</div>
                <div id="{{ $item['id'] }}" class="status-value">0</div>
                <a href="{{ $item['route'] }}" class="stretched-link" title="Ir a {{ strtolower($item['text']) }}"></a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/countup.js@2.0.7/dist/countUp.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    AOS.init();

    const countOptions = { duration: 2 };
    new countUp.CountUp('stockTotal', {{ $stockTotal ?? 150 }}, countOptions).start();
    new countUp.CountUp('entradasHoy', {{ $entradasHoy ?? 12 }}, countOptions).start();
    new countUp.CountUp('salidasHoy', {{ $salidasHoy ?? 8 }}, countOptions).start();
    new countUp.CountUp('alertasActivas', {{ $alertasActivas ?? 3 }}, countOptions).start();
    new countUp.CountUp('ubicacionesTotal', {{ $ubicacionesTotal ?? 12 }}, countOptions).start();

    // Gráfico 1: Stock por almacén
    new Chart(document.getElementById('chartStockAlmacen'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($almacenesNombres ?? ['A', 'B', 'C']) !!},
            datasets: [{
                label: 'Stock',
                data: {!! json_encode($almacenesStock ?? [120, 90, 60]) !!},
                backgroundColor: '#0d6efd'
            }]
        },
        options: {
            responsive: true,
            animation: { duration: 1000 },
            plugins: { legend: { display: false } }
        }
    });

    // Gráfico 2: Entradas vs Salidas
    new Chart(document.getElementById('chartMovimientos'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($dias ?? ['Lun','Mar','Mié','Jue','Vie','Sáb','Dom']) !!},
            datasets: [
                {
                    label: 'Entradas',
                    data: {!! json_encode($entradasSemana ?? [10, 12, 8, 9, 11, 5, 3]) !!},
                    backgroundColor: '#198754'
                },
                {
                    label: 'Salidas',
                    data: {!! json_encode($salidasSemana ?? [7, 10, 6, 4, 8, 3, 2]) !!},
                    backgroundColor: '#dc3545'
                }
            ]
        },
        options: {
            responsive: true,
            animation: { duration: 1000 },
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush
