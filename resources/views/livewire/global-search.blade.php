<div class="p-4">
    <div class="flex gap-2 items-center">
        <input
            wire:model.defer="query"
            type="text"
            placeholder="Buscar..."
            class="flex-grow px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white rounded-md focus:outline-none"
            wire:keydown.enter="search"
        />

        <button
            wire:click.prevent="search"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
        >
            Buscar
        </button>
    </div>

    {{-- Clientes --}}
    @if(!empty($results['clientes']) && $results['clientes']->count())
        <h3 class="mt-4 font-semibold text-lg">Clientes</h3>
        <ul class="mt-2 space-y-2">
            @foreach($results['clientes'] as $cliente)
                <li class="p-2 bg-white dark:bg-gray-600 rounded shadow">
                    <a href="{{ route('customers', $cliente->id) }}" class="block">
                        {{ $cliente->name }} {{ $cliente->lastname }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

    {{-- Mascotas --}}
    @if(!empty($results['mascotas']) && $results['mascotas']->count())
        <h3 class="mt-4 font-semibold text-lg">Mascotas</h3>
        <ul class="mt-2 space-y-2">
            @foreach($results['mascotas'] as $mascota)
                <li class="p-2 bg-white dark:bg-gray-600 rounded shadow">
                    <a href="{{ route('pets', $mascota->id) }}" class="block">
                        {{ $mascota->name }} {{ $mascota->breed }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

    {{-- Consultas --}}
    @if(!empty($results['consultas']) && $results['consultas']->count())
        <h3 class="mt-4 font-semibold text-lg">Consultas</h3>
        <ul class="mt-2 space-y-2">
            @foreach($results['consultas'] as $consulta)
                <li class="p-2 bg-white dark:bg-gray-600 rounded shadow">
                    <a href="{{ route('consultations', $consulta->id) }}" class="block">
                        <strong>ID:</strong> {{ $consulta->id }} <br>
                        <strong>Motivo:</strong> {{ $consulta->motivo_consulta }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

    {{-- Mensaje si no hay resultados --}}
    @if(strlen($query) > 1 && collect($results)->pluck('count')->sum() === 0)
        <p class="mt-4 text-gray-500 dark:text-gray-400">Sin resultados.</p>
    @endif
</div>
