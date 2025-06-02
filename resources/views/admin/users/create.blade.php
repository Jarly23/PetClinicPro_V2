<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Crear Usuario
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">

                {{-- Mensajes flash --}}
                @if(session('success'))
                    <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('info'))
                    <div class="p-4 mb-4 text-blue-700 bg-blue-100 rounded">
                        {{ session('info') }}
                    </div>
                @endif
                @if(session('warning'))
                    <div class="p-4 mb-4 text-yellow-700 bg-yellow-100 rounded">
                        {{ session('warning') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="p-4 mb-4 text-red-700 bg-red-100 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium">Nombre</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full border-gray-300 rounded mt-1" required>
                        @error('name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Apellido</label>
                        <input type="text" name="lastname" value="{{ old('lastname') }}" class="w-full border-gray-300 rounded mt-1" required>
                        @error('lastname') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full border-gray-300 rounded mt-1" required>
                        @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Contraseña</label>
                        <input type="password" name="password" class="w-full border-gray-300 rounded mt-1" required>
                        @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Roles</label>
                        @foreach($roles as $role)
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="rounded"
                                        {{ (is_array(old('roles')) && in_array($role->name, old('roles'))) ? 'checked' : '' }}>
                                    <span class="ml-2">{{ $role->name }}</span>
                                </label>
                            </div>
                        @endforeach
                        @error('roles') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                            Crear
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="ml-4 text-gray-600 underline">Cancelar</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
