<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Dashboard actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">

            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Dashboard</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1 text-sm">
                    Panel con métricas clave, estadísticas diarias y actividad reciente.
                </p>
            </div>

        </div>

        <!-- Cards -->
        <div class="grid grid-cols-12 gap-6">

            @livewire('dashboard.stats.clients-today')
            @livewire('dashboard.stats.pets-total')
            @livewire('dashboard.stats.services-today')
            @livewire('dashboard.stats.pending-bookings')

            @livewire('dashboard.stats.total-income')
            @livewire('dashboard.charts.most-consumed-services')

            @livewire('dashboard.tables.pending-reservations')
            @livewire('dashboard.charts.monthly-consultations-chart')
            @livewire('dashboard.tables.pending-vaccinations'   )
            @livewire('dashboard.charts.customer-stats-chart')

        </div>

    </div>
</x-app-layout>
