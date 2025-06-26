<div class="container mx-auto p-6 max-w-7xl">
    <!-- Título -->
    <div class="text-center mb-10">
        <h2 class="text-4xl font-extrabold text-indigo-700 tracking-tight">Gestión de Egresos Operativos</h2>
        <p class="text-lg text-indigo-500 mt-2">Registra y administra los gastos de la clínica veterinaria</p>
    </div>

    <!-- Resumen y gráfico lado a lado -->
    <div class="flex flex-col lg:flex-row gap-6 mb-8">
        <!-- Resumen Financiero del Mes -->
        <div class="flex-1 bg-indigo-50 border border-indigo-300 rounded-lg p-6 shadow-sm">
            <h3 class="text-2xl font-semibold text-indigo-800 mb-4">Resumen del Mes</h3>
            <ul class="space-y-2 text-indigo-700 text-lg font-medium">
                <li><span class="font-semibold">Servicios:</span> ${{ number_format($totalServicios, 2) }}</li>
                <li><span class="font-semibold">Ganancia por Productos:</span> ${{ number_format($gananciaProductos, 2) }}</li>
                <li><span class="font-semibold">Total Egresos:</span> ${{ number_format($egresosMes, 2) }}</li>
                <li class="text-indigo-900 text-2xl font-extrabold mt-4"><span>Balance:</span> ${{ number_format($balance, 2) }}</li>
            </ul>
        </div>

        <!-- Gráfico -->
        <div class="flex-1 bg-white shadow-md rounded-lg p-6">
            <h4 class="text-xl font-bold text-gray-800 mb-4">Visualización</h4>
            <div class="relative w-full h-64">
                <canvas id="resumenChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <div class="flex items-center space-x-3 w-full sm:w-auto">
            <select wire:model="filtroMes"
                class="w-52 sm:w-64 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                <option value="">Mes actual</option>
                @foreach(range(1, 12) as $m)
                    <option value="{{ now()->year }}-{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>

            <button wire:click="$refresh"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-lg transition shadow-md">
                Filtrar
            </button>

            <button wire:click="$set('filtroMes', null)" title="Limpiar filtro"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-3 py-2 rounded-lg transition shadow-sm">
                ✕
            </button>
        </div>

        <x-danger-button wire:click="openModal"
            class="w-full sm:w-auto px-6 py-2 font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-md transition">
            Registrar Egreso
        </x-danger-button>
    </div>

    <!-- Mensaje éxito -->
    @if (session()->has('message'))
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition
            class="bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded-lg mb-6 shadow-md text-center font-semibold"
        >
            {{ session('message') }}
        </div>
    @endif

    <!-- Modal Crear/Editar -->
    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            {{ $egresoId ? 'Editar Egreso' : 'Registrar Egreso' }}
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="save" class="space-y-5">
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input wire:model="nombre" type="text" id="nombre"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-indigo-400 focus:ring-2"
                        placeholder="Ej: Alquiler local">
                    @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea wire:model="descripcion" id="descripcion" rows="3"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-indigo-400 focus:ring-2"
                        placeholder="Detalle del egreso..."></textarea>
                    @error('descripcion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="monto" class="block text-sm font-medium text-gray-700">Monto</label>
                    <input wire:model="monto" type="number" step="0.01" id="monto"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-indigo-400 focus:ring-2"
                        placeholder="0.00">
                    @error('monto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                    <input wire:model="fecha" type="date" id="fecha"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-indigo-400 focus:ring-2">
                    @error('fecha') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="closeModal"
                class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg transition mr-3">
                Cancelar
            </button>
            <button wire:click="save"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg transition"
                wire:loading.attr="disabled">
                Guardar
            </button>
        </x-slot>
    </x-dialog-modal>

    <!-- Modal Confirmación Eliminación -->
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
            <button wire:click="delete"
                class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg transition"
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
                    <th class="p-4 text-left text-sm font-semibold text-indigo-700 border border-indigo-300">Nombre</th>
                    <th class="p-4 text-left text-sm font-semibold text-indigo-700 border border-indigo-300">Monto</th>
                    <th class="p-4 text-left text-sm font-semibold text-indigo-700 border border-indigo-300">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($egresos as $egreso)
                    <tr class="border-b border-indigo-200 hover:bg-indigo-50 transition">
                        <td class="p-4 text-sm text-indigo-800 border border-indigo-300">{{ $egreso->fecha->format('d/m/Y') }}</td>
                        <td class="p-4 text-sm text-indigo-800 border border-indigo-300">{{ $egreso->nombre }}</td>
                        <td class="p-4 text-sm text-indigo-800 border border-indigo-300">${{ number_format($egreso->monto, 2) }}</td>
                        <td class="p-4 text-sm text-indigo-800 border border-indigo-300 space-x-2">
                            <button wire:click="edit({{ $egreso->id }})"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition shadow-sm">
                                Editar
                            </button>
                            <button wire:click="confirmDelete({{ $egreso->id }})"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition shadow-sm">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-indigo-500 py-8 font-semibold">No hay egresos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 bg-indigo-50 border-t border-indigo-200">
            {{ $egresos->links() }}
        </div>
    </div>

    <script>
    document.addEventListener('livewire:load', () => {
        drawResumenChart();

        // Cada vez que Livewire actualiza el DOM, redibuja la gráfica
        Livewire.hook('message.processed', () => {
            drawResumenChart();
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
                    legend: { display: false },
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
</script>


</div>
