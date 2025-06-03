@extends('layouts.bodega')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-primary">Productos - Vista Administrador de Bodega</h2>

    {{-- Aquí va el contenido exclusivo para el rol administrador de bodega --}}
    <p>Listado de productos, solo visible para el administrador de bodega.</p>

    {{-- Ejemplo de tabla --}}
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Stock</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>
                        <a href="{{ route('bodega.productos.edit', $producto->id) }}" class="btn btn-sm btn-primary">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
