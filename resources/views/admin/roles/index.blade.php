<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="mb-6">
            @if (session('info'))
                <div class="text-green-500">{{ session('info') }}</div>
            @endif
            <h2 class="text-2xl font-semibold text-gray-800">Lista de Roles</h2>
            <a href="{{ route('admin.roles.create') }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">Crear nuevo rol</a>
        </div>
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full table-auto border-collapse border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b border-gray-200">Id</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b border-gray-200">Nombre Rol</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 border-b border-gray-200">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr class="{{ $loop->even ? 'bg-gray-50' : '' }}">
                            <td class="px-6 py-4 text-sm text-gray-800 border-b border-gray-200">{{ $role->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 border-b border-gray-200">{{ $role->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800 border-b border-gray-200">
                                <a href="{{ route('admin.roles.edit', $role) }}" class="hover:underline text-blue-600">Editar</a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800 border-b border-gray-200">
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
