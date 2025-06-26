<div class="relative mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1 dark:text-gray-100">Buscar cliente</label>

    <div class="relative">
        <div class="flex gap-2">
            <div class="relative flex-1">
                <input wire:model.live.debounce.300ms="search" 
                       type="text" 
                       class="w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100 pr-10"
                       placeholder="Nombre, apellido, email, DNI o teléfono" />

                @if($selectedClient)
                    <button wire:click="clearSelection" 
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                            title="Limpiar selección">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                @endif
            </div>

            <x-buttons.search type="button" wire:click="searchClients"
                class="px-3 py-1 rounded-md bg-indigo-600 text-white text-sm hover:bg-indigo-700">
                Buscar
            </x-buttons.search>
        </div>

        {{-- Sugerencias en tiempo real --}}
        @if($showSuggestions && !empty($results))
            <div class="absolute z-50 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 mt-1 w-full rounded-lg shadow-lg max-h-60 overflow-y-auto">
                @foreach ($results as $client)
                    <div wire:click="selectClient({{ $client['id'] }})"
                         class="px-4 py-3 hover:bg-indigo-50 dark:hover:bg-gray-700 cursor-pointer border-b border-gray-100 dark:border-gray-600 last:border-b-0 transition-colors duration-150">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $client['name'] }} {{ $client['lastname'] ?? '' }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    DNI: {{ $client['dniruc'] }} | Tel: {{ $client['phone'] ?? 'N/A' }}
                                </div>
                                @if($client['email'])
                                    <div class="text-xs text-gray-500 dark:text-gray-500">
                                        {{ $client['email'] }}
                                    </div>
                                @endif
                            </div>
                            <div class="text-indigo-600 dark:text-indigo-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if($showSuggestions && $noResults && strlen($search) >= 2)
            <div class="absolute z-50 mt-1 w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg px-4 py-3">
                <div class="flex items-center text-gray-600 dark:text-gray-400">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33"></path>
                    </svg>
                    <span class="text-sm">No se encontró ningún cliente con "{{ $search }}"</span>
                </div>
            </div>
        @endif
    </div>

    {{-- Cliente seleccionado --}}
    @if ($selectedClient)
        <div class="mt-3 p-4 border border-green-200 dark:border-green-700 rounded-lg bg-green-50 dark:bg-green-900/20">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <h4 class="text-sm font-medium text-green-800 dark:text-green-200">Cliente Seleccionado</h4>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Nombre:</span>
                            <span class="text-gray-900 dark:text-gray-100">{{ $selectedClient['name'] }} {{ $selectedClient['lastname'] ?? '' }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">DNI:</span>
                            <span class="text-gray-900 dark:text-gray-100">{{ $selectedClient['dniruc'] }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-700 dark:text-gray-300">Teléfono:</span>
                            <span class="text-gray-900 dark:text-gray-100">{{ $selectedClient['phone'] ?? 'N/A' }}</span>
                        </div>
                        @if($selectedClient['email'])
                            <div>
                                <span class="font-medium text-gray-700 dark:text-gray-300">Email:</span>
                                <span class="text-gray-900 dark:text-gray-100">{{ $selectedClient['email'] }}</span>
                            </div>
                        @endif
                        @if($selectedClient['address'])
                            <div class="sm:col-span-2">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Dirección:</span>
                                <span class="text-gray-900 dark:text-gray-100">{{ $selectedClient['address'] }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                <button wire:click="clearSelection" 
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 ml-2"
                        title="Cambiar cliente">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cerrar sugerencias al hacer clic fuera del área de búsqueda
    document.addEventListener('click', function(event) {
        const searchContainer = document.querySelector('[wire\\:model\\.live\\.debounce\\.300ms="search"]')?.closest('.relative');
        const suggestions = document.querySelector('.absolute.z-50.bg-white');
        
        if (suggestions && searchContainer && !searchContainer.contains(event.target)) {
            @this.set('showSuggestions', false);
        }
    });
});
</script>
