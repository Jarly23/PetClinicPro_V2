<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        @if (@session('info'))
            <div class="mb-4 text-green-600 font-semibold">
                {{ session('info') }}
            </div>
        @endif
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Asignar un rol al usuario</h2>
            
            <!-- Nombre del usuario en un input -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium">Nombre:</label>
                <input type="text" id="name" name="name" value="{{ $user->name }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" disabled>
            </div>

            <!-- Formulario para asignar roles -->
            {!! Form::model($user, ['route' => ['admin.users.update', $user], 'method' => 'put']) !!}
            @foreach ($roles as $role)
                <div class="mb-2 flex items-center">
                    <label for="role-{{ $role->id }}" class="flex items-center text-gray-700">
                        {!! Form::checkbox('roles[]', $role->id, $user->roles->contains($role->id), ['class' => 'mr-2', 'id' => 'role-' . $role->id]) !!}
                        <span>{{ $role->name }}</span>
                    </label>
                </div>
            @endforeach

            <!-- Botón de enviar -->
            <div class="mt-4">
                {!! Form::submit('Asignar rol', ['class' => 'px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200']) !!}
                {!! Form::close() !!}
            </div>
          
        </div>
    </div>
</x-app-layout>
