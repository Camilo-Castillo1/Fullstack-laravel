<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <a href="{{ route('usuarios.create') }}"
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
                Crear Usuario
            </a>

            <table class="table-auto w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">#</th>
                        <th class="border px-4 py-2">Nombre</th>
                        <th class="border px-4 py-2">Correo</th>
                        <th class="border px-4 py-2">Rol</th>
                        <th class="border px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td class="border px-4 py-2">{{ $usuario->id }}</td>
                            <td class="border px-4 py-2">{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
                            <td class="border px-4 py-2">{{ $usuario->correo }}</td>
                            <td class="border px-4 py-2">
                                {{ $usuario->roles->pluck('name')->implode(', ') }}
                            </td>
                            <td class="border px-4 py-2">
                                <a href="{{ route('usuarios.edit', $usuario->id) }}"
                                   class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                    Editar
                                </a>
                                <form action="{{ route('usuarios.destroy', $usuario->id) }}"
                                      method="POST" class="inline-block"
                                      onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($usuarios->isEmpty())
                <p class="text-center text-gray-500 mt-4">No hay usuarios registrados.</p>
            @endif

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
