<div class="max-w-xl mx-auto p-6 bg-white rounded shadow-md">

    {{-- Mensaje de éxito --}}
    @if (session()->has('message'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 border border-green-300 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-5">
        {{-- Nombre --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" wire:model="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        {{-- Correo --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Correo</label>
            <input type="email" wire:model="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        {{-- Teléfono --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Teléfono</label>
            <input type="text" wire:model="telefono" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('telefono') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        {{-- Contraseña --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Contraseña</label>
            <input type="password" wire:model="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            @error('password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        {{-- Rol --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Rol</label>
            <select wire:model="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Seleccionar rol</option>
                @foreach($roles as $role)
                    <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                @endforeach
            </select>
            @error('role') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        {{-- Botón --}}
        <div class="text-right">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Crear Usuario
            </button>
        </div>
    </form>
</div>
