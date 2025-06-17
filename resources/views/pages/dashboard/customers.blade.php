<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Gestión de Clientes</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Administra los clientes registrados.</p>
        <div>
            @livewire('customer-crud')
        </div>
    </div>
</x-app-layout>