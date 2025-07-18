<div class="container mx-auto p-6 max-w-7xl">
    <!-- Título -->
    <div class="text-center mb-10">
        <h2 class="text-4xl font-extrabold text-indigo-700 tracking-tight">Gestión de Egresos Operativos</h2>
        <p class="text-lg text-indigo-500 mt-2">Registra y administra los gastos de la clínica veterinaria</p>
    </div>


    <!-- Resumen Financiero Mejorado -->
    <div class="bg-white border border-gray-200 rounded-xl p-8 shadow-lg mx-auto mb-10">
        <h3 class="text-3xl font-bold text-gray-900 mb-8 text-center">Resumen del Mes</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

            <!-- Servicios -->
            <div class="flex items-center space-x-4 p-4 bg-indigo-50 rounded-lg shadow-sm">
                <div class="p-3 bg-indigo-600 rounded-full text-white">
                    <i data-lucide="stethoscope" class="w-8 h-8"></i>
                </div>
                <div>
                    <p class="text-lg font-semibold text-indigo-700">Servicios</p>
                    <p class="text-2xl font-extrabold text-gray-900">S/{{ number_format($totalServicios, 2) }}</p>
                </div>
            </div>

            <!-- Ganancia por Productos -->
            <div class="flex items-center space-x-4 p-4 bg-green-50 rounded-lg shadow-sm">
                <div class="p-3 bg-green-600 rounded-full text-white">
                    <i data-lucide="package-plus" class="w-8 h-8"></i>
                </div>
                <div>
                    <p class="text-lg font-semibold text-green-700">Ganancia por Productos</p>
                    <p class="text-2xl font-extrabold text-gray-900">S/{{ number_format($gananciaProductos, 2) }}</p>
                </div>
            </div>

            <!-- Total Egresos -->
            <div class="flex items-center space-x-4 p-4 bg-red-50 rounded-lg shadow-sm">
                <div class="p-3 bg-red-600 rounded-full text-white">
                    <i data-lucide="credit-card" class="w-8 h-8"></i>
                </div>
                <div>
                    <p class="text-lg font-semibold text-red-700">Total Egresos</p>
                    <p class="text-2xl font-extrabold text-gray-900">S/{{ number_format($egresosMes, 2) }}</p>
                </div>
            </div>

            <!-- Balance -->
            <div class="flex items-center space-x-4 p-4 bg-yellow-50 rounded-lg shadow-sm">
                <div class="p-3 bg-yellow-500 rounded-full text-white">
                    <i data-lucide="scale" class="w-8 h-8"></i>
                </div>
                <div>
                    <p class="text-lg font-semibold text-yellow-700">Balance</p>
                    <p class="text-2xl font-extrabold text-gray-900">S/{{ number_format($balance, 2) }}</p>
                </div>

    <!-- Resumen y gráfico lado a lado -->
    <div class="flex flex-col lg:flex-row gap-6 mb-8">
        <!-- Resumen Financiero del Mes -->
        <div class="flex-1 bg-indigo-50 border border-indigo-300 rounded-lg p-6 shadow-sm">
            <h3 class="text-2xl font-semibold text-indigo-800 mb-4">Resumen del Mes</h3>
            <ul class="space-y-2 text-indigo-700 text-lg font-medium">
                <li><span class="font-semibold">Servicios:</span> ${{ number_format($totalServicios, 2) }}</li>
                <li><span class="font-semibold">Ganancia por Productos:</span>
                    ${{ number_format($gananciaProductos, 2) }}</li>
                <li><span class="font-semibold">Total Egresos:</span> ${{ number_format($egresosMes, 2) }}</li>
                <li class="text-indigo-900 text-2xl font-extrabold mt-4"><span>Balance:</span>
                    ${{ number_format($balance, 2) }}</li>
            </ul>

            <!-- Estadísticas comparativas -->
            <div class="mt-6 pt-4 border-t border-indigo-200">
                <h4 class="text-lg font-semibold text-indigo-800 mb-3">Comparación con
                    {{ $estadisticas['mes_anterior'] }}</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span>Balance anterior:</span>
                        <span
                            class="font-semibold">${{ number_format($estadisticas['balance_mes_anterior'], 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Diferencia:</span>
                        <span
                            class="font-semibold {{ $estadisticas['tendencia'] === 'positiva' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $estadisticas['tendencia'] === 'positiva' ? '+' : '' }}${{ number_format($estadisticas['diferencia'], 2) }}
                        </span>
                    </div>
                    <div class="flex items-center mt-2">
                        <span class="text-xs text-gray-600">Tendencia:</span>
                        <span
                            class="ml-2 px-2 py-1 text-xs rounded-full {{ $estadisticas['tendencia'] === 'positiva' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($estadisticas['tendencia']) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico -->
        <!-- Gráfico de Evolución Mensual -->
        <div class=" bg-white shadow-md rounded-lg p-6">
            <h4 class="text-xl font-bold text-gray-800 mb-4">Evolución Mensual</h4>
            <div class="relative w-full h-96">
                <canvas id="evolucionChart" class="w-full h-full"></canvas>

            </div>
        </div>

    </div>

    <!-- Filtros -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <div class="flex items-center space-x-3 w-full sm:w-auto">
            <select wire:model="filtroMes"
                class="w-52 sm:w-64 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                <option value="">Mes actual</option>
                @foreach (range(1, 12) as $m)
                    <option value="{{ now()->year }}-{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>

            <button wire:click="$refresh"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-lg transition shadow-md">
                Filtrar
            </button>

            <button wire:click="limpiarFiltro" title="Limpiar filtro"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-3 py-2 rounded-lg transition shadow-sm">
                ✕
            </button>
        </div>
        @can('egresos.create')
         <x-danger-button wire:click="openModal">
            Registrar Egreso
        </x-danger-button>

        @endcan


        <button wire:click="exportarEgresos"
            class="w-full sm:w-auto px-6 py-2 font-semibold text-white bg-green-600 hover:bg-green-700 rounded-lg shadow-md transition">
            Exportar CSV
        </button>

    </div>

    <!-- Mensaje éxito -->
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
            class="bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded-lg mb-6 shadow-md text-center font-semibold">
            {{ session('message') }}
        </div>
    @endif

    <!-- Modal Crear/Editar -->
    @if($open)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h2 class="text-xl font-bold mb-4">{{ $egresoId ? 'Editar Egreso' : 'Registrar Egreso' }}</h2>

            <form wire:submit.prevent="save" class="space-y-5">
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input wire:model="nombre" type="text" id="nombre"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-indigo-400 focus:ring-2"
                        placeholder="Ej: Alquiler local">
                    @error('nombre')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea wire:model="descripcion" id="descripcion" rows="3"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-indigo-400 focus:ring-2"
                        placeholder="Detalle del egreso..."></textarea>
                    @error('descripcion')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="monto" class="block text-sm font-medium text-gray-700">Monto</label>
                    <input wire:model="monto" type="number" step="0.01" id="monto"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-indigo-400 focus:ring-2"
                        placeholder="0.00">
                    @error('monto')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                    <input wire:model="fecha" type="date" id="fecha"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-indigo-400 focus:ring-2">
                    @error('fecha')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </form>

            <div class="mt-6 flex justify-end">
                <button wire:click="closeModal"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg transition mr-3">
                    Cancelar
                </button>
                <button wire:click="save"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg transition"
                    wire:loading.attr="disabled">
                    Guardar
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal Confirmación Eliminación -->

    @if($confirmingDelete)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm text-center">
            <h3 class="text-red-600 font-bold text-lg mb-4">Confirmar eliminación</h3>
            <p class="text-red-700 font-semibold mb-6">¿Estás seguro de eliminar este egreso?</p>

            <div class="flex justify-center space-x-4">
                <button wire:click="$set('confirmingDelete', false)"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg transition">
                    Cancelar
                </button>
                <button wire:click="delete"
                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg transition"
                    wire:loading.attr="disabled">
                    Eliminar
                </button>
            </div>
        </div>
    </div>
    @endif

    <x-dialog-modal wire:model="confirmingDelete">
        <x-slot name="title" class="text-red-600 font-bold">Confirmar eliminación</x-slot>
        <x-slot name="content">
            <p class="text-red-700 font-semibold">¿Estás seguro de eliminar este egreso?</p>
        </x-slot>
        <x-slot name="footer">
            <button wire:click="$set('confirmingDelete', false)"
                class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg transition mr-3">
                Cancelar
            </button>
            <button wire:click="delete" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg transition"
                wire:loading.attr="disabled">
                Eliminar
            </button>
        </x-slot>
    </x-dialog-modal>


    <!-- Tabla de Egresos -->
    <div class="mt-8 bg-white rounded-lg shadow-lg overflow-hidden">
        <table class="min-w-full table-auto border-collapse border border-gray-300">
            <thead class="bg-indigo-100">
                <tr>
                    <th class="p-4 text-left text-sm font-semibold text-indigo-700 border border-indigo-300">Fecha</th>
                    <th class="p-4 text-left text-sm font-semibold text-indigo-700 border border-indigo-300">Nombre
                    </th>
                    <th class="p-4 text-left text-sm font-semibold text-indigo-700 border border-indigo-300">Monto</th>
                    <th class="p-4 text-left text-sm font-semibold text-indigo-700 border border-indigo-300">Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($egresos as $egreso)
                    <tr class="border-b border-indigo-200 hover:bg-indigo-50 transition">

                        <td class="p-4 text-sm text-indigo-800 border border-indigo-300">{{ \Carbon\Carbon::parse($egreso->fecha)->format('d/m/Y') }}</td>
                        <td class="p-4 text-sm text-indigo-800 border border-indigo-300">{{ $egreso->nombre }}</td>
                        <td class="p-4 text-sm text-indigo-800 border border-indigo-300">S/{{ number_format($egreso->monto, 2) }}</td>

                        <td class="p-4 text-sm text-indigo-800 border border-indigo-300">
                            {{ $egreso->fecha->format('d/m/Y') }}</td>
                        <td class="p-4 text-sm text-indigo-800 border border-indigo-300">{{ $egreso->nombre }}</td>
                        <td class="p-4 text-sm text-indigo-800 border border-indigo-300">
                            ${{ number_format($egreso->monto, 2) }}</td>

                        <td class="p-4 text-sm text-indigo-800 border border-indigo-300 space-x-2">
                            @can('egresos.edit')
                            <button wire:click="edit({{ $egreso->id }})"
                                class="px-3 py-1 bg-blue-500 hover:bg-blue-400 text-white rounded transition">
                                Editar
                            </button>                               
                            @endcan
                            @can('egresos.destroy')
                            <button wire:click="confirmDelete({{ $egreso->id }})"
                                class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded transition">
                                Eliminar
                            </button>                               
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>

                        <td colspan="4" class="p-4 text-center text-indigo-600 font-semibold">No hay egresos registrados.</td>

                        <td colspan="4" class="text-center text-indigo-500 py-8 font-semibold">No hay egresos
                            registrados.</td>

                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $egresos->links() }}
        </div>
    </div>




    <script>
        document.addEventListener('livewire:load', () => {
            drawResumenChart();
            drawEvolucionChart();
            Livewire.hook('message.processed', () => {
                drawResumenChart();
                drawEvolucionChart();
            });
        });

        function drawResumenChart() {
            const ctx = document.getElementById('resumenChart')?.getContext('2d');
            if (!ctx) return;

            // Si ya existe el gráfico, lo destruimos para evitar sobreposición
            if (window.resumenChart) {
                window.resumenChart.destroy();
            }

            // Obtenemos los datos desde Blade (PHP)
            const dataServicios = @json($totalServicios);
            const dataGanancia = @json($gananciaProductos);
            const dataEgresos = @json($egresosMes);
            const dataBalance = @json($balance);

            window.resumenChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Servicios', 'Ganancia Productos', 'Egresos', 'Balance'],
                    datasets: [{
                        label: 'Montos en $',
                        data: [dataServicios, dataGanancia, dataEgresos, dataBalance],
                        backgroundColor: ['#4F46E5', '#10B981', '#EF4444', '#F59E0B'],
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => `$${ctx.parsed.y.toLocaleString()}`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: value => '$' + value.toLocaleString()
                            }
                        }
                    }
                }
            });
        }

        function drawEvolucionChart() {
            const ctx = document.getElementById('evolucionChart')?.getContext('2d');
            if (!ctx) return;
            if (window.evolucionChart) window.evolucionChart.destroy();

            const labels = @json($evolucion['labels']);
            const servicios = @json($evolucion['servicios']);
            const gananciaProductos = @json($evolucion['gananciaProductos']);
            const egresos = @json($evolucion['egresos']);
            const balance = @json($evolucion['balance']);

            window.evolucionChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Servicios',
                            data: servicios,
                            borderColor: '#4F46E5',
                            backgroundColor: 'rgba(79,70,229,0.1)',
                            fill: false,
                            tension: 0.3
                        },
                        {
                            label: 'Ganancia Productos',
                            data: gananciaProductos,
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16,185,129,0.1)',
                            fill: false,
                            tension: 0.3
                        },
                        {
                            label: 'Egresos',
                            data: egresos,
                            borderColor: '#EF4444',
                            backgroundColor: 'rgba(239,68,68,0.1)',
                            fill: false,
                            tension: 0.3
                        },
                        {
                            label: 'Balance',
                            data: balance,
                            borderColor: '#F59E0B',
                            backgroundColor: 'rgba(245,158,11,0.1)',
                            fill: false,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Evolución Mensual'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>

</div>
