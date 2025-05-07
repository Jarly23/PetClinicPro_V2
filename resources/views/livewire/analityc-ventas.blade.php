<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total de Productos -->
        <div class="p-4 bg-white shadow rounded-lg">
            <h3 class="text-lg font-semibold">Total de Productos</h3>
            <p class="text-3xl">{{ $totalProducts }}</p>
        </div>
        
        <!-- Productos con Stock Bajo -->
        <div class="p-4 bg-white shadow rounded-lg">
            <h3 class="text-lg font-semibold">Productos con Stock Bajo</h3>
            <p class="text-3xl">{{ $lowStockProducts }}</p>
        </div>

        <!-- Ventas de Hoy -->
        <div class="p-4 bg-white shadow rounded-lg">
            <h3 class="text-lg font-semibold">Ventas de Hoy</h3>
            <p class="text-3xl">${{ number_format($totalSales, 2) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <!-- Gráfico de Ventas -->
        <div class="p-4 bg-white shadow rounded-lg">
            <h3 class="text-lg font-semibold">Ventas por Mes</h3>
            {!! $salesChart->container() !!}
        </div>
        
        <!-- Entradas y Salidas de Productos -->
        <div class="p-4 bg-white shadow rounded-lg">
            <h3 class="text-lg font-semibold">Entradas y Salidas de Productos Hoy</h3>
            <p>Entradas: {{ $entriesToday }}</p>
            <p>Salidas: {{ $exitsToday }}</p>
        </div>
    </div>
</div>

<!-- Scripts de Charts -->
{!! $salesChart->script() !!}
