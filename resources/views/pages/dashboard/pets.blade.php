<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Gestión de Mascotas</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Administra, confirma o inicia las mascotas registradas.</p>
        <div>
            {{-- The best athlete wants his opponent at his best. --}}
            @livewire('pets.index')
        </div>
    </div>

</x-app-layout>