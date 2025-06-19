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
                            <td class="px-4 py-3 font-semibold text-green-600">${{ number_format($venta->total, 2) }}</td>
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
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
            <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-xl animate-fade-in">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">🧾 Detalles de Venta #{{ $ventaSeleccionada->id_venta }}</h3>
                    <button wire:click="cerrarModal" class="text-red-500 hover:text-red-700 text-lg">✖</button>
                </div>

                <div class="text-sm text-gray-600 space-y-2">
                    <p><strong>Cliente:</strong> {{ $ventaSeleccionada->cliente->name }} {{ $ventaSeleccionada->cliente->lastname }}</p>
                    <p><strong>Fecha:</strong> {{ $ventaSeleccionada->fecha }}</p>
                    <p><strong>Total:</strong> <span class="text-green-600 font-semibold">${{ number_format($ventaSeleccionada->total, 2) }}</span></p>
                </div>

                <h4 class="mt-6 mb-2 font-semibold text-gray-700">🛒 Productos vendidos</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-3 py-2 text-left">Producto</th>
                                <th class="px-3 py-2 text-left">Cantidad</th>
                                <th class="px-3 py-2 text-left">P. Unitario</th>
                                <th class="px-3 py-2 text-left">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ventaSeleccionada->detalles as $detalle)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-3 py-2">{{ $detalle->product->name ?? '🗑 Eliminado' }}</td>
                                    <td class="px-3 py-2">{{ $detalle->cantidad }}</td>
                                    <td class="px-3 py-2">${{ number_format($detalle->p_unitario, 2) }}</td>
                                    <td class="px-3 py-2 font-semibold">${{ number_format($detalle->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-right mt-6">
                    <button wire:click="cerrarModal" class="px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded-lg shadow">
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
