<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Gestión de Consultas</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Administra inicia las consultas registradas.</p>
        <div>
            @livewire('consultation-crud')
        </div>
    </div>
</x-app-layout>