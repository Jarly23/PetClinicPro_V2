<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Lista de Usuarios
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-center mb-4">
                    <a href="{{ route('admin.users.create') }}" 
                       class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 transition">
                        Crear Usuario
                    </a>
                </div>

                {{-- Mensajes flash --}}
                @foreach (['success', 'info', 'warning'] as $msg)
                    @if(session($msg))
                        <div class="p-4 mb-6 text-{{ $msg === 'warning' ? 'yellow' : ($msg === 'success' ? 'green' : 'blue') }}-700 bg-{{ $msg === 'warning' ? 'yellow' : ($msg === 'success' ? 'green' : 'blue') }}-100 rounded">
                            {{ session($msg) }}
                        </div>
                    @endif
                @endforeach

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roles</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $user->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        {{ $user->roles->pluck('name')->join(', ') ?: '—' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm flex space-x-2">
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="px-3 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600 transition">
                                            Editar
                                        </a>

                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700 transition">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay usuarios registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
