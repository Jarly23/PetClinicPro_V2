<form wire:submit.prevent="guardarVenta" class="bg-white p-6 rounded-2xl shadow-md space-y-6">
    <div class="text-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800 uppercase tracking-wide">
            🧾 Nota de Venta
        </h1>
    </div>
    {{-- Sección de Cliente --}}
    <div class="space-y-4">
        <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
            👤 Información del Cliente
        </h2>

        {{-- Tipo de cliente --}}
        <div>
            <label class="text-sm font-medium text-gray-600">Tipo de Cliente</label>
            <select wire:model="tipo_cliente" wire:change="$refresh"
                class="w-full mt-1 border-gray-300 rounded-lg shadow-sm p-2">
                <option value="">Seleccione una opción</option>
                <option value="nuevo">🆕 Registrar Nuevo</option>
                <option value="existente">👤 Cliente Existente</option>
            </select>
        </div>

        {{-- Formulario nuevo cliente --}}
        @if ($tipo_cliente === 'nuevo')
            <div class="grid md:grid-cols-2 gap-4">
                <input type="text" wire:model="nuevo_cliente_nombre" placeholder="Nombre"
                    class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                @error('nuevo_cliente_nombre')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                <input type="text" wire:model="nuevo_cliente_apellido" placeholder="Apellido"
                    class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                @error('nuevo_cliente_apellido')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                <input type="email" wire:model="nuevo_cliente_email" placeholder="Correo Electrónico"
                    class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                @error('nuevo_cliente_email')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                <input type="text" wire:model="nuevo_cliente_phone" placeholder="Teléfono"
                    class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                @error('nuevo_cliente_phone')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                <!-- Selección de tipo de documento -->
                <select wire:model="nuevo_cliente_tipo_documento" class="form-control">
                    <option value="">Seleccionar Tipo de Documento</option>
                    <option value="DNI">DNI</option>
                    <option value="RUC">RUC</option>
                </select>

                <!-- Campo para el número de documento -->

                @error('nuevo_cliente_tipo_documento')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                <input type="text" wire:model="nuevo_cliente_documento" placeholder="Número de documento"
                    class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                @error('nuevo_cliente_documento')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                <input type="text" wire:model="nuevo_cliente_address" placeholder="Dirección"
                    class="md:col-span-2 w-full border-gray-300 rounded-lg shadow-sm p-2">
                @error('nuevo_cliente_address')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Botón para guardar cliente --}}
            <div class="mt-4">
                <button type="button" wire:click="guardarNuevoCliente"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow-sm">
                    💾 Guardar Cliente
                </button>
            </div>
        @endif


        {{-- Cliente existente --}}
        @if ($tipo_cliente === 'existente')
            <div x-data="{ open: @entangle('mostrarLista') }" @click.away="open = false" class="relative">
                <label class="text-sm font-medium text-gray-600 mb-1 block">Buscar y Seleccionar Cliente</label>

                <div class="flex items-center gap-2">
                    <!-- Input de búsqueda -->
                    <input type="text" wire:model="search" @focus="open = true"
                        class="w-full border-gray-300 rounded-lg shadow-sm p-2"
                        placeholder="Escribe el nombre o apellido del cliente...">

                    <!-- Botón de búsqueda -->
                    <button type="button" wire:click="buscarCliente"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Buscar
                    </button>
                </div>

                <!-- Lista desplegable de coincidencias -->
                <div x-show="open"
                    class="absolute z-10 w-full bg-white border border-gray-300 mt-1 rounded shadow max-h-60 overflow-auto">
                    @if (!empty($clientes))
                        <ul>
                            @foreach ($clientes as $cliente)
                                <li wire:click="seleccionarCliente({{ $cliente->id }})" @click="open = false"
                                    class="px-4 py-2 cursor-pointer hover:bg-blue-100">
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
            <label class="text-sm font-medium text-gray-600">Fecha y Hora</label>
            <input type="datetime-local" wire:model="fecha"
                class="w-full mt-1 border-gray-300 rounded-lg shadow-sm p-2">
        </div>

        <hr class="border-t-2 border-gray-200 my-4">

        {{-- Sección de Productos --}}
        <div class="space-y-4">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                🛒 Agregar Productos a la Venta
            </h2>

            <div class="grid md:grid-cols-3 gap-4">
                <select wire:model="producto_id" class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                    <option value="">Seleccione un producto</option>
                    @foreach ($productos as $producto)
                        <option value="{{ $producto->id_product }}">{{ $producto->name }}</option>
                    @endforeach
                </select>
                <input type="number" wire:model="cantidad" placeholder="Cantidad"
                    class="w-full border-gray-300 rounded-lg shadow-sm p-2">
                <button wire:click="agregarProducto" type="button"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                    ➕ Agregar
                </button>
            </div>

            {{-- Tabla de productos --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 text-gray-700">
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
                            <tr class="border-t">
                                <td class="p-2">{{ $item['producto']->name }}</td>
                                <td class="p-2">{{ $item['producto']->category->name }}</td>
                                <td class="p-2">{{ $item['cantidad'] }}</td>
                                <td class="p-2">S/{{ number_format($item['producto']->sale_price, 2) }}</td>
                                <td class="p-2">S/{{ number_format($item['total'], 2) }}</td>
                                <td class="p-2">
                                    <button wire:click="eliminarProducto({{ $item['producto']->id_product }})"
                                        class="text-red-600 hover:text-red-800 font-semibold">
                                        ❌ Eliminar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Total --}}
            <div class="text-right text-lg font-semibold text-gray-800">
                Total: S/{{ number_format($total_venta, 2) }}
            </div>
        </div>

        <hr class="border-t-2 border-gray-200 my-4">


        {{-- Botón para registrar venta --}}
        <div class="text-right">
            @can('ventas.create')
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow">
                💾 Registrar Venta
            </button>
            @endcan
        </div>

        {{-- Mensaje de éxito --}}
        @if (session()->has('message'))
            <div class="mt-4 text-red-700 bg-red-100 p-4 rounded-md border border-green-300">
                {{ session('message') }}
            </div>
        @endif

</form>
