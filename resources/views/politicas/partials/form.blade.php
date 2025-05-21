<div class="mb-3">
    <label for="nombre" class="form-label">Nombre</label>
    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $politica->nombre ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="tipo" class="form-label">Tipo</label>
    <select name="tipo" class="form-select" required>
        <option value="">Seleccione...</option>
        @foreach (['PEPS', 'UEPS', 'FIFO'] as $op)
            <option value="{{ $op }}" {{ (old('tipo', $politica->tipo ?? '') == $op) ? 'selected' : '' }}>{{ $op }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="aplicable_a" class="form-label">Aplicable a</label>
    <select name="aplicable_a" class="form-select" required>
        <option value="">Seleccione...</option>
        @foreach (['producto', 'lote', 'almacen'] as $op)
            <option value="{{ $op }}" {{ (old('aplicable_a', $politica->aplicable_a ?? '') == $op) ? 'selected' : '' }}>
                {{ ucfirst($op) }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="tipo_producto" class="form-label">Tipo de Producto</label>
    <select name="tipo_producto" class="form-select">
        <option value="">No aplica</option>
        @foreach (['refrigerado', 'seco', 'congelado'] as $tp)
            <option value="{{ $tp }}" {{ (old('tipo_producto', $politica->tipo_producto ?? '') == $tp) ? 'selected' : '' }}>{{ ucfirst($tp) }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="valor" class="form-label">Valor</label>
    <input type="number" name="valor" class="form-control" value="{{ old('valor', $politica->valor ?? '') }}" step="0.01" required>
</div>

<div class="mb-3">
    <label for="fecha_implementacion" class="form-label">Fecha de Implementación</label>
    <input type="date" name="fecha_implementacion" class="form-control" value="{{ old('fecha_implementacion', isset($politica->fecha_implementacion) ? \Carbon\Carbon::parse($politica->fecha_implementacion)->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
</div>

<div class="mb-3">
    <label for="ubicacion_id" class="form-label">Ubicación</label>
    <select name="ubicacion_id" class="form-select" required>
        <option value="">Seleccione...</option>
        @foreach ($ubicaciones as $ubicacion)
            <option value="{{ $ubicacion->id }}" {{ old('ubicacion_id', $politica->ubicacion_id ?? '') == $ubicacion->id ? 'selected' : '' }}>
                {{ $ubicacion->codigo_ubicacion }} ({{ $ubicacion->almacen->nombre ?? 'Sin almacén' }})
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="categoria_id" class="form-label">Categoría (opcional)</label>
    <select name="categoria_id" class="form-select">
        <option value="">Sin categoría</option>
        @foreach ($categorias as $cat)
            <option value="{{ $cat->id }}" {{ old('categoria_id', $politica->categoria_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->nombre }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="almacen_id" class="form-label">Almacén (opcional)</label>
    <select name="almacen_id" class="form-select">
        <option value="">Sin almacén</option>
        @foreach ($almacenes as $alm)
            <option value="{{ $alm->id }}" {{ old('almacen_id', $politica->almacen_id ?? '') == $alm->id ? 'selected' : '' }}>
                {{ $alm->nombre }}
            </option>
        @endforeach
    </select>
</div>
