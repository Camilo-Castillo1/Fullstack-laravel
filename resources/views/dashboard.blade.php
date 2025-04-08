<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Bienvenido, {{ Auth::user()->nombre }}
        </h2>
    </x-slot>

    <div class="py-6 px-6">
        @role('admin')
            <div class="mb-4">
                <p class="text-green-600 font-bold">Eres administrador.</p>
                <a href="{{ route('usuarios.index') }}" class="text-blue-600 underline">Gestionar usuarios</a>
            </div>
        @else
            <div class="mb-4">
                <p class="text-gray-600">Eres un usuario regular. No tienes permisos para administrar usuarios.</p>
            </div>
        @endrole

        {{-- Contenido común para todos --}}
        <p>Tu dashboard personalizado aparecerá aquí.</p>
    </div>
</x-app-layout>
