<form wire:submit.prevent="guardarVenta" class="bg-white p-6 rounded-2xl shadow-md space-y-6 max-w-8xl mx-auto">
    <div class="text-center mb-4">
        <h1 class="text-2xl font-bold text-blue-900 uppercase tracking-wide">
            🧾 Nota de Venta
        </h1>
    </div>

    {{-- Sección de Cliente --}}
    <div class="space-y-4">
        <h2 class="text-xl font-semibold text-blue-800 flex items-center gap-2 border-l-4 border-blue-500 pl-3">
            👤 Información del Cliente
        </h2>

        {{-- Tipo de cliente --}}
        <div>
            <label class="text-sm font-medium text-blue-700">Tipo de Cliente</label>
            <select wire:model="tipo_cliente" wire:change="$refresh"
                class="w-full mt-1 border-blue-400 rounded-lg shadow-sm p-2 focus:ring-2 focus:ring-blue-300 focus:border-blue-600">
                <option value="">Seleccione una opción</option>
                <option value="nuevo">🆕 Registrar Nuevo</option>
                <option value="existente">👤 Cliente Existente</option>
            </select>
        </div>

        {{-- Formulario nuevo cliente --}}
        @if ($tipo_cliente === 'nuevo')
            <div class="grid md:grid-cols-2 gap-4">
                <input type="text" wire:model="nuevo_cliente_nombre" placeholder="Nombre"
                    class="w-full border-blue-300 rounded-lg shadow-sm p-2 focus:ring-1 focus:ring-blue-400 focus:border-blue-500">
                @error('nuevo_cliente_nombre')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                <input type="text" wire:model="nuevo_cliente_apellido" placeholder="Apellido"
                    class="w-full border-blue-300 rounded-lg shadow-sm p-2 focus:ring-1 focus:ring-blue-400 focus:border-blue-500">
                @error('nuevo_cliente_apellido')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                <input type="email" wire:model="nuevo_cliente_email" placeholder="Correo Electrónico"
                    class="w-full border-blue-300 rounded-lg shadow-sm p-2 focus:ring-1 focus:ring-blue-400 focus:border-blue-500">
                @error('nuevo_cliente_email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                <input type="text" wire:model="nuevo_cliente_phone" placeholder="Teléfono"
                    class="w-full border-blue-300 rounded-lg shadow-sm p-2 focus:ring-1 focus:ring-blue-400 focus:border-blue-500">
                @error('nuevo_cliente_phone')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                <!-- Selección de tipo de documento -->
                <select wire:model="nuevo_cliente_tipo_documento" class="border-blue-300 rounded-lg shadow-sm p-2 focus:ring-1 focus:ring-blue-400 focus:border-blue-500">
                    <option value="">Seleccionar Tipo de Documento</option>
                    <option value="DNI">DNI</option>
                    <option value="RUC">RUC</option>
                </select>

                @error('nuevo_cliente_tipo_documento')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                <input type="text" wire:model="nuevo_cliente_documento" placeholder="Número de documento"
                    class="w-full border-blue-300 rounded-lg shadow-sm p-2 focus:ring-1 focus:ring-blue-400 focus:border-blue-500">
                @error('nuevo_cliente_documento')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                <input type="text" wire:model="nuevo_cliente_address" placeholder="Dirección"
                    class="md:col-span-2 w-full border-blue-300 rounded-lg shadow-sm p-2 focus:ring-1 focus:ring-blue-400 focus:border-blue-500">
                @error('nuevo_cliente_address')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Botón para guardar cliente --}}
            <div class="mt-4">
                <button type="button" wire:click="guardarNuevoCliente"
                    class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-md shadow-sm transition duration-200">
                    💾 Guardar Cliente
                </button>
            </div>
        @endif

        {{-- Cliente existente --}}
        @if ($tipo_cliente === 'existente')
            <div x-data="{ open: @entangle('mostrarLista') }" @click.away="open = false" class="relative">
                <label class="text-sm font-medium text-blue-700 mb-1 block">Buscar y Seleccionar Cliente</label>

                <div class="flex items-center gap-2">
                    <!-- Input de búsqueda -->
                    <input type="text" wire:model="search" @focus="open = true"
                        class="w-full border-blue-300 rounded-lg shadow-sm p-2 focus:ring-2 focus:ring-blue-300 focus:border-blue-600"
                        placeholder="Escribe el nombre o apellido del cliente...">

                    <!-- Botón de búsqueda -->
                    <button type="button" wire:click="buscarCliente"
                        class="px-4 py-2 bg-blue-700 text-white rounded hover:bg-blue-800 transition duration-200">
                        Buscar
                    </button>
                </div>

                <!-- Lista desplegable de coincidencias -->
                <div x-show="open"
                    class="absolute z-10 w-full bg-white border border-blue-300 mt-1 rounded shadow max-h-60 overflow-auto">
                    @if (!empty($clientes))
                        <ul>
                            @foreach ($clientes as $cliente)
                                <li wire:click="seleccionarCliente({{ $cliente->id }})" @click="open = false"
                                    class="px-4 py-2 cursor-pointer hover:bg-blue-100 text-blue-900 font-medium transition duration-150">
                                    {{ $cliente->name }} {{ $cliente->lastname }}
                                </li>
                            @endforeach
                        </ul>
                    @elseif(!empty($search))
                        <ul>
                            <li class="px-4 py-2 text-gray-500">No se encontraron clientes</li>
                        </ul>
                    @endif
                </div>
            </div>
        @endif

        {{-- Fecha --}}
        <div>
            <label class="text-sm font-medium text-blue-700">Fecha y Hora</label>
            <input type="datetime-local" wire:model="fecha"
                class="w-full mt-1 border-blue-300 rounded-lg shadow-sm p-2 focus:ring-2 focus:ring-blue-300 focus:border-blue-600">
        </div>

        <hr class="border-t-2 border-blue-200 my-4">

        {{-- Sección de Productos --}}
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-blue-800 flex items-center gap-2 border-l-4 border-blue-500 pl-3">
                🛒 Agregar Productos a la Venta
            </h2>

            <div class="grid md:grid-cols-3 gap-4 mb-24">
                <select wire:model="producto_id" class="w-full border-blue-300 rounded-lg shadow-sm p-2 focus:ring-2 focus:ring-blue-300 focus:border-blue-600">
                    <option value="">Seleccione un producto</option>
                    @foreach ($productos as $producto)
                        <option value="{{ $producto->id_product }}">{{ $producto->name }}</option>
                    @endforeach
                </select>
                <input type="number" wire:model="cantidad" placeholder="Cantidad"
                    class="w-full border-blue-300 rounded-lg shadow-sm p-2 focus:ring-2 focus:ring-blue-300 focus:border-blue-600">
                <button wire:click="agregarProducto" type="button"
                    class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow transition duration-200">
                    ➕ Agregar
                </button>
            </div>

            {{-- Tabla de productos --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border border-blue-200 rounded-lg overflow-hidden">
                    <thead class="bg-blue-50 text-blue-800">
                        <tr>
                            <th class="p-2 text-left">Producto</th>
                            <th class="p-2 text-left">Categoría</th>
                            <th class="p-2 text-left">Cantidad</th>
                            <th class="p-2 text-left">Precio Unitario</th>
                            <th class="p-2 text-left">Total</th>
                            <th class="p-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos_seleccionados as $item)
                            <tr class="border-t border-blue-100 hover:bg-blue-50 transition duration-150">
                                <td class="p-2 text-blue-900 font-medium">{{ $item['producto']->name }}</td>
                                <td class="p-2 text-blue-700">{{ $item['producto']->category->name }}</td>
                                <td class="p-2">{{ $item['cantidad'] }}</td>
                                <td class="p-2">S/{{ number_format($item['producto']->sale_price, 2) }}</td>
                                <td class="p-2 font-semibold">S/{{ number_format($item['total'], 2) }}</td>
                                <td class="p-2">
                                    <button type="button" wire:click="eliminarProducto({{ $item['producto']->id_product }})"
                                        class="text-red-600 hover:text-red-800 font-semibold transition duration-150">
                                        ❌ Eliminar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Total --}}
            <div class="text-right text-lg font-semibold text-blue-900">
                Total: S/{{ number_format($total_venta, 2) }}
            </div>
        </div>

        <hr class="border-t-2 border-blue-200 my-4">

        {{-- Botones para registrar venta y ver historial --}}
        <div class="text-right flex justify-end gap-4">
            @can('ventas.create')
            <a href="{{ route('historial') }}"
                class="bg-gray-700 hover:bg-gray-800 text-white px-6 py-3 rounded-lg shadow flex items-center justify-center transition duration-200">
                📜 Ver Historial
            </a>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow transition duration-200">
                💾 Registrar Venta
            </button>
            @endcan
        </div>

        {{-- Mensaje de éxito --}}
        @if (session()->has('message'))
            <div 
                x-data="{ show: true }" 
                x-init="setTimeout(() => show = false, 3000)" 
                x-show="show"
                x-transition
                class="mt-4 p-4 rounded-md border text-sm
                    @if(str_contains(session('message'), 'correctamente') || str_contains(session('message'), 'registrado')) 
                        text-green-700 bg-green-100 border-green-300 
                    @else 
                        text-red-700 bg-red-100 border-red-300 
                    @endif
                "
            >
                {{ session('message') }}
            </div>
        @endif
</form>
