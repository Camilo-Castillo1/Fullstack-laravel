<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Crear Usuario</h2>
    </x-slot>

    <div class="py-6 px-6">
        <form action="{{ route('usuarios.store') }}" method="POST">
            @csrf

            {{-- Nombre --}}
            <div class="mb-4">
                <x-input-label for="nombre" value="Nombre" />
                <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" required autofocus />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>

            {{-- Apellido --}}
            <div class="mb-4">
                <x-input-label for="apellido" value="Apellido" />
                <x-text-input id="apellido" name="apellido" type="text" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('apellido')" class="mt-2" />
            </div>

            {{-- Correo --}}
            <div class="mb-4">
                <x-input-label for="correo" value="Correo Electrónico" />
                <x-text-input id="correo" name="correo" type="email" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('correo')" class="mt-2" />
            </div>

            {{-- Contraseña --}}
            <div class="mb-4">
                <x-input-label for="password" value="Contraseña" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Confirmación de contraseña --}}
            <div class="mb-4">
                <x-input-label for="password_confirmation" value="Confirmar Contraseña" />
                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
            {{-- Teléfono (opcional) --}}
            <div class="mb-4">
                <x-input-label for="telefono" value="Teléfono" />
                <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
            </div>

            {{-- Roles --}}
            <div class="mb-4">
                <x-input-label for="roles" value="Rol(es)" />
                <select name="roles[]" id="roles" class="mt-1 block w-full" multiple required>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->name }}">{{ $rol->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('roles')" class="mt-2" />
            </div>

            <x-primary-button class="mt-4">
                Guardar Usuario
            </x-primary-button>

            <a href="{{ route('usuarios.index') }}" class="ml-4 text-sm text-gray-600 hover:underline">Cancelar</a>
        </form>
    </div>
</x-app-layout>
