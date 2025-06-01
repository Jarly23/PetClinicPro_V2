<div class="relative mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">Buscar cliente</label>

    <div class="flex gap-2">
        <input wire:model.debounce.300ms="search" type="text" class="flex-1 rounded-md shadow-sm border-gray-300"
            placeholder="Nombre, email o DNI" />

        <button type="button" wire:click="searchClients"
            class="px-3 py-1 rounded-md bg-indigo-600 text-white text-sm hover:bg-indigo-700">
            Buscar
        </button>
    </div>

    @if (!empty($results))
        <ul class="absolute z-20 bg-white border mt-1 w-full rounded shadow max-h-60 overflow-auto">
            @foreach ($results as $client)
                <li wire:click="selectClient({{ $client['id'] }})"
                    class="px-4 py-2 hover:bg-indigo-100 cursor-pointer text-sm">
                    {{ $client['name'] }} {{ $client['lastname'] ?? '' }} - {{ $client['dni'] }}
                </li>
            @endforeach
        </ul>
    @endif

    @if ($selectedClient)
        <div class="mt-3 p-3 border rounded bg-gray-50 text-sm text-gray-700 space-y-1">
            <p><strong>Nombre:</strong> {{ $selectedClient['name'] }} {{ $selectedClient['lastname'] ?? '' }}</p>
            <p><strong>DNI:</strong> {{ $selectedClient['dni'] }}</p>
            <p><strong>Teléfono:</strong> {{ $selectedClient['phone'] ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $selectedClient['email'] ?? 'N/A' }}</p>
        </div>
    @endif
</div>
