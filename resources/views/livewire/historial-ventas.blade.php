<div>
    <div class="p-6 bg-gray-50 min-h-screen">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">🧾 Historial de Ventas</h2>

        {{-- ✅ Mensajes --}}
        @if (session()->has('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- 🔍 Filtros --}}
        <div class="flex flex-wrap gap-4 items-end mb-6 bg-white p-4 rounded-xl shadow-md">
            <div>
                <label class="block text-sm font-semibold text-gray-700">Filtrar por:</label>
                <select wire:model="filtroFecha" class="border-gray-300 rounded px-2 py-1">
                    <option value="todas">Todas</option>
                    <option value="hoy">Hoy</option>
                    <option value="ayer">Ayer</option>
                    <option value="rango">Rango de Fechas</option>
                </select>
            </div>

            @if ($filtroFecha === 'rango')
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Desde:</label>
                    <input type="date" wire:model="fechaInicio" class="border-gray-300 rounded px-2 py-1" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700">Hasta:</label>
                    <input type="date" wire:model="fechaFin" class="border-gray-300 rounded px-2 py-1" />
                </div>
            @endif

            <button wire:click="aplicarFiltroFechas" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                Filtrar
            </button>

            <div class="ml-auto w-full sm:w-1/3">
                <label class="block text-sm font-semibold text-gray-700">Buscar Cliente:</label>
                <div class="flex">
                    <input type="text" wire:model="busquedaCliente" placeholder="Nombre o Apellido" class="flex-1 border-gray-300 rounded-l px-2 py-1" />
                    <button wire:click="buscarCliente" class="bg-green-600 hover:bg-green-700 text-white px-4 rounded-r shadow">
                        Buscar
                    </button>
                </div>
            </div>
        </div>

        {{-- 🧾 Tabla de ventas --}}
        <div class="overflow-x-auto bg-white shadow-xl rounded-2xl">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-200 text-gray-700 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Cliente</th>
                        <th class="px-4 py-3 text-left">Fecha</th>
                        <th class="px-4 py-3 text-left">Total</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($ventas as $venta)
                        <tr class="hover:bg-gray-50 transition duration-200">
                            <td class="px-4 py-3">{{ $venta->id_venta }}</td>
                            <td class="px-4 py-3">{{ $venta->cliente->name }} {{ $venta->cliente->lastname }}</td>
                            <td class="px-4 py-3">{{ $venta->fecha }}</td>
                            <td class="px-4 py-3 font-semibold text-green-600">S/{{ number_format($venta->total, 2) }}</td>
                            <td class="px-4 py-3 text-center">
                                <x-buttons.view wire:click="verDetalles({{ $venta->id_venta }})">
                                    <span class="hidden md:inline">Ver Detalles</span>
                                </x-buttons.view>
                                @can('historial.destroy')
                                <x-buttons.delete wire:click="confirmarEliminar({{ $venta->id_venta }})">
                                     <span class="hidden md:inline">Eliminar</span>
                                </x-buttons.delete>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">No se encontraron ventas con los filtros aplicados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Detalles --}}
    @if ($ventaSeleccionada)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm z-50">
            <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-3xl animate-fade-in border border-gray-200">
                <div class="flex justify-between items-center mb-6 border-b border-gray-200 pb-3">
                    <h3 class="text-2xl font-extrabold text-gray-900">🧾 Detalles de Venta #{{ $ventaSeleccionada->id_venta }}</h3>
                    <button wire:click="cerrarModal" class="text-red-600 hover:text-red-800 text-2xl font-bold transition-colors duration-200">✖</button>
                </div>

                <div class="text-gray-700 space-y-3 text-base">
                    <p><strong>Cliente:</strong> {{ $ventaSeleccionada->cliente->name }} {{ $ventaSeleccionada->cliente->lastname }}</p>
                    <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($ventaSeleccionada->fecha)->format('d/m/Y') }}</p>
                    <p><strong>Total:</strong> <span class="text-green-700 font-semibold text-lg">S/{{ number_format($ventaSeleccionada->total, 2) }}</span></p>
                </div>

                <h4 class="mt-8 mb-4 text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">🛒 Productos vendidos</h4>
                <div class="overflow-x-auto max-h-72">
                    <table class="min-w-full text-sm text-gray-800">
                        <thead class="bg-gray-100 text-gray-700 sticky top-0">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Producto</th>
                                <th class="px-4 py-3 text-left font-semibold">Cantidad</th>
                                <th class="px-4 py-3 text-left font-semibold">P. Unitario</th>
                                <th class="px-4 py-3 text-left font-semibold">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ventaSeleccionada->detalles as $detalle)
                                <tr class="border-b hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-4 py-3">{{ $detalle->product->name ?? '🗑 Eliminado' }}</td>
                                    <td class="px-4 py-3">{{ $detalle->cantidad }}</td>
                                    <td class="px-4 py-3">S/{{ number_format($detalle->p_unitario, 2) }}</td>
                                    <td class="px-4 py-3 font-semibold">S/{{ number_format($detalle->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-right mt-8">
                    <button wire:click="cerrarModal" class="px-6 py-3 bg-gray-800 hover:bg-gray-900 text-white rounded-xl shadow-lg font-semibold transition duration-200">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Confirmar Eliminación --}}
    @if ($ventaAEliminar)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
            <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md animate-fade-in">
                <h3 class="text-lg font-bold text-gray-800 mb-4">❗ Confirmar Eliminación</h3>
                <p class="text-gray-600">¿Seguro que deseas eliminar la venta #{{ $ventaAEliminar }}? Esta acción restaurará el stock automáticamente.</p>

                <div class="flex justify-end gap-3 mt-6">
                    <button wire:click="eliminarVenta({{ $ventaAEliminar }})" class="bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700">
                        Sí, eliminar
                    </button>
                    <button wire:click="cerrarModal" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    @endif

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
</div>
