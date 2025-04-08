<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Editar Usuario</h2>
    </x-slot>

    <div class="py-6 px-6">
        <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nombre --}}
            <div class="mb-4">
                <x-input-label for="nombre" value="Nombre" />
                <x-text-input id="nombre" name="nombre" type="text" value="{{ old('nombre', $usuario->nombre) }}" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>

            {{-- Apellido --}}
            <div class="mb-4">
                <x-input-label for="apellido" value="Apellido" />
                <x-text-input id="apellido" name="apellido" type="text" value="{{ old('apellido', $usuario->apellido) }}" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('apellido')" class="mt-2" />
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <x-input-label for="correo" value="Correo Electrónico" />
                <x-text-input id="correo" name="correo" type="correo" value="{{ old('correo', $usuario->correo) }}" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('correo')" class="mt-2" />
            </div>

            {{-- Nueva contraseña (opcional) --}}
            <div class="mb-4">
                <x-input-label for="password" value="Nueva Contraseña (opcional)" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Roles --}}
            <div class="mb-4">
                <x-input-label for="roles" value="Rol(es)" />
                <select name="roles[]" id="roles" class="mt-1 block w-full" multiple required>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->name }}" {{ in_array($rol->name, $usuario->roles->pluck('name')->toArray()) ? 'selected' : '' }}>
                            {{ $rol->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('roles')" class="mt-2" />
            </div>

            <x-primary-button class="mt-4">
                Actualizar Usuario
            </x-primary-button>

            <a href="{{ route('usuarios.index') }}" class="ml-4 text-sm text-gray-600 hover:underline">Cancelar</a>
        </form>
    </div>
</x-app-layout>
