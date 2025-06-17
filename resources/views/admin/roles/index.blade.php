<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-7xl mx-auto">

        {{-- Encabezado y botón --}}
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">Lista de Roles</h2>

                @if (session('info'))
                    <p class="mt-2 text-sm text-green-600 bg-green-100 border border-green-300 rounded px-4 py-2">
                        {{ session('info') }}
                    </p>
                @endif
            </div>

            <a href="{{ route('admin.roles.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                + Crear nuevo rol
            </a>
        </div>

        {{-- Tabla de roles --}}
        <div class="bg-white shadow-md rounded-lg overflow-x-auto dark:bg-gray-800">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 font-semibold text-gray-700 dark:text-gray-100">ID</th>
                        <th class="px-6 py-3 font-semibold text-gray-700 dark:text-gray-100">Nombre del Rol</th>
                        <th class="px-6 py-3 font-semibold text-gray-700 dark:text-gray-100 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($roles as $role)
                        <tr class="hover:bg-gray-50 transition dark:hover:bg-gray-600">
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-100">{{ $role->id }}</td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-100">{{ ucfirst($role->name) }}</td>
                            <td class="px-6 py-4 flex gap-4 justify-center">
                                <a href="{{ route('admin.roles.edit', $role) }}"
                                   class="text-indigo-600 hover:text-indigo-800 font-medium">Editar</a>
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este rol?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-800 font-medium">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                No hay roles registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
