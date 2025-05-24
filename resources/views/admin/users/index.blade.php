<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-7xl mx-auto">
        <div class="bg-white p-6 rounded shadow-md">
            {{-- Título y botón --}}
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Gestión de Usuarios</h2>
                <a href="{{ route('users.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    + Crear Usuario
                </a>
            </div>

            {{-- Componente Livewire --}}
            @livewire('admin.users-index')
        </div>
    </div>
</x-app-layout>
