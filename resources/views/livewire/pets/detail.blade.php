<div class="bg-white shadow-md rounded-lg p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Foto de la mascota -->
    <div class="col-span-1 flex justify-center items-start">
        <img src="{{ $pet->photo ? Storage::url($pet->photo) : '' }}" 
             alt="Foto de {{ $pet->name }}" 
             class="w-48 h-48 object-cover rounded-full border-2 border-blue-400 shadow-md">
    </div>

    <!-- Formulario para subir foto -->
    <div class="col-span-1 flex flex-col justify-center items-center space-y-4">
        <form wire:submit.prevent="savePhoto" class="flex flex-col items-center space-y-4">
            <input type="file" wire:model="photo" class="border p-2 rounded" accept="image/*">
            @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Subir Foto</button>
        </form>
        @if (session()->has('message'))
            <div class="text-green-600 mt-4">{{ session('message') }}</div>
        @endif
    </div>

    <!-- Datos de la mascota -->
    <div class="col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <h3 class="text-gray-600 font-semibold">Nombre</h3>
            <p class="text-lg text-gray-800">{{ $pet->name }}</p>
        </div>

        <div>
            <h3 class="text-gray-600 font-semibold">Especie</h3>
            <p class="text-lg text-gray-800">{{ $pet->animaltype->name ?? '-' }}</p>
        </div>

        <div>
            <h3 class="text-gray-600 font-semibold">Raza</h3>
            <p class="text-lg text-gray-800">{{ $pet->breed }}</p>
        </div>

        <div>
            <h3 class="text-gray-600 font-semibold">Edad</h3>
            <p class="text-lg text-gray-800">{{ $pet->age }} años</p>
        </div>

        <div>
            <h3 class="text-gray-600 font-semibold">Peso</h3>
            <p class="text-lg text-gray-800">{{ $pet->weight }} kg</p>
        </div>

        <div>
            <h3 class="text-gray-600 font-semibold">Género</h3>
            <p class="text-lg text-gray-800">{{ $pet->sex }}</p>
        </div>
    </div>

    <!-- Datos del dueño -->
    <div class="col-span-3 mt-6 border-t pt-4">
        <h3 class="text-blue-600 text-lg font-bold mb-2">Datos del Propietario</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <h4 class="text-gray-600 font-semibold">Nombre</h4>
                <p class="text-gray-800">{{ $pet->owner->name }}</p>
            </div>
            <div>
                <h4 class="text-gray-600 font-semibold">Teléfono</h4>
                <p class="text-gray-800">{{ $pet->owner->phone }}</p>
            </div>
            <div>
                <h4 class="text-gray-600 font-semibold">Email</h4>
                <p class="text-gray-800">{{ $pet->owner->email }}</p>
            </div>
        </div>
    </div>
</div>
    