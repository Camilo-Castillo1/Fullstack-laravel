@extends('layouts.bodega')

@section('content')
<div class="text-center mb-5 animate-on-scroll">
    <h1 class="display-5 fw-bold text-success">
        <i class="bi bi-warehouse me-2"></i> Panel del Administrador de Bodega
    </h1>
    <p class="lead text-muted mt-2">
        Administra fácilmente los recursos de inventario, entradas, salidas y más desde un solo lugar.
    </p>
</div>

<div class="row g-4">
    @include('components.bodega-card', [
        'title' => 'Productos',
        'text' => 'Gestión completa del inventario disponible.',
        'icon' => 'bi-box-seam',
        'image' => 'https://cdn-icons-png.flaticon.com/512/1047/1047711.png',
        'color' => 'primary',
        'url' => route('bodega.productos.index'),
        'delay' => '1',
        'disabled' => false
    ])

    @include('components.bodega-card', [
        'title' => 'Lotes',
        'text' => 'Controla cada lote y su trazabilidad.',
        'icon' => 'bi-layers-fill',
        'image' => 'https://cdn-icons-png.flaticon.com/512/3043/3043318.png',
        'color' => 'secondary',
        'url' => route('bodega.lotes.index'),
        'delay' => '2',
        'disabled' => false
    ])

    @include('components.bodega-card', [
        'title' => 'Entradas',
        'text' => 'Registra ingreso de materiales fácilmente.',
        'icon' => 'bi-box-arrow-in-down',
        'image' => 'https://cdn-icons-png.flaticon.com/512/2311/2311524.png',
        'color' => 'success',
        'url' => route('bodega.entradas.index'),
        'delay' => '3',
        'disabled' => false
    ])

    @include('components.bodega-card', [
        'title' => 'Salidas',
        'text' => 'Controla el egreso de inventario con orden.',
        'icon' => 'bi-box-arrow-up',
        'image' => 'https://cdn-icons-png.flaticon.com/512/4462/4462845.png',
        'color' => 'warning',
        'url' => route('bodega.salidas.index'),
        'delay' => '4',
        'disabled' => false
    ])

    @include('components.bodega-card', [
        'title' => 'Alertas',
        'text' => 'Productos próximos a vencer y acciones urgentes.',
        'icon' => 'bi-exclamation-triangle-fill',
        'image' => 'https://cdn-icons-png.flaticon.com/512/463/463574.png',
        'color' => 'danger',
        'url' => route('bodega.alertas.index'),
        'delay' => '5',
        'disabled' => false
    ])

    @include('components.bodega-card', [
        'title' => 'Ubicaciones',
        'text' => 'Organiza el almacén por zonas y estanterías.',
        'icon' => 'bi-map',
        'image' => 'https://cdn-icons-png.flaticon.com/512/2991/2991130.png',
        'color' => 'info',
        'url' => route('bodega.ubicaciones.index'),
        'delay' => '6',
        'disabled' => false
    ])

    @include('components.bodega-card', [
        'title' => 'Temperatura',
        'text' => 'Supervisa condiciones térmicas del entorno.',
        'icon' => 'bi-thermometer-half',
        'image' => 'https://cdn-icons-png.flaticon.com/512/2913/2913465.png',
        'color' => 'dark',
        'url' => route('bodega.temperaturas.index'),
        'delay' => '7',
        'disabled' => false
    ])
</div>
@endsection

@push('styles')
<style>
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(40px);
        transition: all 0.6s ease-out;
    }
    .animate-on-scroll.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const elements = document.querySelectorAll('.animate-on-scroll');
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.1 });

        elements.forEach(el => observer.observe(el));
    });
</script>
@endpush
