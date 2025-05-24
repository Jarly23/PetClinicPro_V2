<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-3xl mx-auto">
        @if (session('info'))
            <div class="mb-4 text-green-600 font-semibold bg-green-100 border border-green-300 p-3 rounded">
                {{ session('info') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Editar Usuario y Asignar Roles</h2>

            {{-- Formulario de edición --}}
            {!!Form::model($user, ['route' => ['admin.users.update', $user], 'method' => 'put']) !!}

            {{-- Nombre --}}
            <div class="mb-4">
                {!!Form::label('name', 'Nombre:', ['class' => 'block text-gray-700 font-medium']) !!}
                {!!Form::text('name', null, ['class' => 'mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500']) !!}
            </div>

            {{-- Correo --}}
            <div class="mb-4">
                {!!Form::label('email', 'Correo:', ['class' => 'block text-gray-700 font-medium']) !!}
                {!!Form::email('email', null, ['class' => 'mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500']) !!}
            </div>

            {{-- Teléfono (si lo manejas como campo adicional) --}}
            <div class="mb-4">
                {!!Form::label('telefono', 'Teléfono:', ['class' => 'block text-gray-700 font-medium']) !!}
                {!!Form::text('telefono', $user->telefono ?? '', ['class' => 'mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500']) !!}
            </div>

            {{-- Contraseña (opcional, solo si desea cambiarla) --}}
            <div class="mb-4">
                {!!Form::label('password', 'Nueva Contraseña (opcional):', ['class' => 'block text-gray-700 font-medium']) !!}
                {!!Form::password('password', ['class' => 'mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500']) !!}
            </div>

            {{-- Roles --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Asignar Roles:</label>
                @foreach ($roles as $role)
                    <div class="flex items-center mb-2">
                        {!!Form::checkbox('roles[]', $role->id, $user->roles->contains($role->id), ['id' => 'role-' . $role->id, 'class' => 'mr-2']) !!}
                        {!!Form::label('role-' . $role->id, ucfirst($role->name), ['class' => 'text-gray-700']) !!}
                    </div>
                @endforeach
            </div>

            {{-- Botón --}}
            <div class="mt-6">
                {!!Form::submit('Actualizar Usuario', ['class' => 'px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-200']) !!}
            </div>

            {!!Form::close() !!}
        </div>
    </div>
</x-app-layout>
