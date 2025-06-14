<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="bg-white p-6 shadow rounded-lg">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Crear nuevo rol</h2>
            <div>
                {!! Form::open(['route' => 'admin.roles.store', 'method' => 'POST', 'class' => 'space-y-4']) !!}
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
                <h3 class="text-lg font-semibold mt-6 mb-2 text-gray-700">Permisos disponibles</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($permissions as $permission)
                        <div
                            class="flex items-center justify-between p-3 bg-gray-50 border border-gray-200 rounded-md shadow-sm hover:bg-gray-100 transition">
                            <span class="text-sm text-gray-700">{{ $permission->description }}</span>

                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                    class="sr-only peer" id="permission-{{ $permission->id }}">
                                <div
                                    class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 transition-colors duration-300">
                                </div>
                                <div
                                    class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform duration-300 transform peer-checked:translate-x-5">
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
                <div>
                    {!! Form::submit('Crear Rol', ['class' => 'bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</x-app-layout>
