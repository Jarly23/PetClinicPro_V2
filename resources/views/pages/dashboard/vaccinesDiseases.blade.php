<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-7xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 dark:text-gray-100">Configuración de Vacunas y Enfermedades</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Enfermedades -->
            <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800">
                @livewire('manage-diseases')
            </div>

            <!-- Vacunas -->
            <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800">
                @livewire('manage-vaccines')
            </div>
        </div>
    </div>
</x-app-layout>
