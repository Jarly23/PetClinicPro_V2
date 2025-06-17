<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="bg-white p-6 shadow rounded-lg dark:bg-gray-800">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Editar rol</h2>

            @if (session('info'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('info') }}</p>
                </div>
            @endif

            <div>
                {!!Form::model($role, ['route' => ['admin.roles.update', $role], 'method' => 'PUT', 'class' => 'space-y-4']) !!}

                <div>
                    {!!Form::label('name', 'Nombre del rol', [
                        'class' => 'block text-sm font-medium text-gray-700 dark:text-gray-100',
                    ]) !!}
                    {!!Form::text('name', null, [
                        'class' =>
                            'form-input block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100',
                    ]) !!}
                    @error('name')
                        <span class="text-sm text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <h3 class="text-lg font-semibold mt-6 mb-2 text-gray-700 dark:text-gray-100">Permisos disponibles</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($groupedPermissions as $module => $permissions)
                    <div class="mb-6">
                        <h4 class="text-md font-bold mb-2 capitalize text-gray-800 dark:text-gray-100">
                            {{ ucfirst($module) }}
                        </h4>
                
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach ($permissions as $permission)
                                <div class="flex items-center justify-between p-3 bg-gray-50 border border-gray-200 rounded-md shadow-sm hover:bg-gray-100 transition dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100">
                                    <span class="text-sm text-gray-700 dark:text-gray-100">
                                        {{ $permission->description ?? $permission->name }}
                                    </span>
                
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        {!! Form::checkbox(
                                            'permissions[]',
                                            $permission->id,
                                            isset($role) ? $role->permissions->contains($permission->id) : false,
                                            ['class' => 'sr-only peer', 'id' => 'permission-' . $permission->id]
                                        ) !!}
                                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 dark:bg-gray-800 dark:peer-checked:bg-blue-600 transition-colors duration-300"></div>
                                        <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform duration-300 transform peer-checked:translate-x-5"></div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                
                </div>

                <div>
                    {!!Form::submit('Actualizar Rol', [
                        'class' =>
                            'bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 dark:bg-blue-600 dark:text-white dark:hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500',
                    ]) !!}
                </div>

                {!!Form::close() !!}
            </div>
        </div>
    </div>
</x-app-layout>
