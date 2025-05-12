@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Gestión de Roles</h3>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">Crear Rol</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Guard</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $rol)
                    <tr>
                        <td>{{ $rol->nombre }}</td>
                        <td>{{ $rol->descripcion }}</td>
                        <td>{{ $rol->guard_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
