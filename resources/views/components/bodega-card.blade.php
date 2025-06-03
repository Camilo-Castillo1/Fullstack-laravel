@props([
    'title',
    'text',
    'icon',
    'image',
    'color' => 'primary',
    'delay' => '',
    'url' => '#',
    'disabled' => true
])

<div class="col-md-4 animate-on-scroll {{ $delay ? 'delay-' . $delay : '' }}">
    <div class="card h-100 shadow-sm border-0 text-center card-lacteos">

        {{-- Imagen clicable --}}
        <a href="{{ $disabled ? '#' : $url }}" class="{{ $disabled ? 'disabled pe-none' : '' }}">
            <img src="{{ $image }}" alt="{{ $title }}" class="card-img-top p-4" style="height: 160px; object-fit: contain;">
        </a>

        {{-- Cuerpo --}}
        <div class="card-body d-flex flex-column justify-content-between">
            <div>
                <h5 class="card-title fw-bold text-{{ $color }}">
                    <i class="bi {{ $icon }} me-2"></i>{{ $title }}
                </h5>
                <p class="card-text text-muted small">{{ $text }}</p>
            </div>

            <a
                href="{{ $disabled ? '#' : $url }}"
                class="btn btn-outline-{{ $color }} rounded-pill mt-3 {{ $disabled ? 'disabled' : '' }}">
                {{ $disabled ? 'Próximamente' : 'Ir al módulo' }}
            </a>
        </div>
    </div>
</div>

@once
    @push('styles')
    <style>
        .card-lacteos {
            background-color: #f8fbff;
            border: 1px solid #d9e9f7;
            border-radius: 16px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-lacteos:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 18px rgba(0, 123, 255, 0.1);
        }
        .card-lacteos img {
            filter: drop-shadow(0 1px 2px rgba(0,0,0,0.1));
        }
        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }
        .delay-3 { transition-delay: 0.3s; }
        .delay-4 { transition-delay: 0.4s; }
        .delay-5 { transition-delay: 0.5s; }
        .delay-6 { transition-delay: 0.6s; }
        .delay-7 { transition-delay: 0.7s; }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const elements = document.querySelectorAll('.animate-on-scroll');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });

            elements.forEach(el => observer.observe(el));
        });
    </script>
    @endpush
@endonce
