<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div>
            <h2>Editar roles</h2>
        </div>
        <div class="bg-white p-6 shadow rounded-lg">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Editar rol</h2>
            @if (session('info'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('info') }}</p>
                </div>
            @endif
            <div>
                {!! Form::model($role, ['route' => ['admin.roles.update', $role], 'method' => 'PUT', 'class' => 'space-y-4']) !!}
                <div>
                    {!! Form::label('name', 'Nombre del rol', ['class' => 'block text-sm font-medium text-gray-700']) !!}
                    {!! Form::text('name', null, [
                        'class' =>
                            'form-input block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500',
                    ]) !!}
                    @error('name')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <h3>Lista de permisos</h3>
                @foreach ($permissions as $permission)
                    <div>
                        <label for="permission-{{ $permission->id }}" class="flex items-center">
                            {!! Form::checkbox('permissions[]', $permission->id, null, [
                                'class' => 'mr-2',
                                'id' => 'permission-' . $permission->id,
                            ]) !!}
                            <span>{{ $permission->description }}</span>
                        </label>
                    </div>
                @endforeach
                <div>
                    {!! Form::submit('Actualizar Rol', ['class' => 'bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>

</x-app-layout>
