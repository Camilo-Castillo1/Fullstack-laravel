@extends('layouts.app')

@section('header', 'Editar Política de Inventario')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0 animate__animated animate__fadeInUp">
        <div class="card-body">
            <form action="{{ route('admin.politicas.update', $politica->id) }}" method="POST">
                @csrf
                @method('PUT')

                @include('politicas.partials.form', [
                    'politica' => $politica,
                    'ubicaciones' => $ubicaciones,
                    'categorias' => $categorias,
                    'almacenes' => $almacenes
                ])

                <div class="text-end">
                    <a href="{{ route('admin.politicas.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save me-1"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
