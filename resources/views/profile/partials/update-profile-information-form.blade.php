<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Información del Perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Actualiza los datos de tu cuenta.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Nombre --}}
        <div>
            <x-input-label for="nombre" value="Nombre" />
            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full"
                value="{{ old('nombre', $user->nombre) }}" required autofocus autocomplete="nombre" />
            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
        </div>

        {{-- Apellido --}}
        <div>
            <x-input-label for="apellido" value="Apellido" />
            <x-text-input id="apellido" name="apellido" type="text" class="mt-1 block w-full"
                value="{{ old('apellido', $user->apellido) }}" required autocomplete="apellido" />
            <x-input-error class="mt-2" :messages="$errors->get('apellido')" />
        </div>

        {{-- Correo --}}
        <div>
            <x-input-label for="correo" value="Correo Electrónico" />
            <x-text-input id="correo" name="correo" type="email" class="mt-1 block w-full"
                value="{{ old('correo', $user->correo) }}" required autocomplete="correo" />
            <x-input-error class="mt-2" :messages="$errors->get('correo')" />
        </div>

        {{-- Teléfono --}}
        <div>
            <x-input-label for="telefono" value="Teléfono" />
            <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full"
                value="{{ old('telefono', $user->telefono) }}" autocomplete="telefono" />
            <x-input-error class="mt-2" :messages="$errors->get('telefono')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p class="text-sm text-gray-600">{{ __('Guardado correctamente.') }}</p>
            @endif
        </div>
    </form>
</section>
