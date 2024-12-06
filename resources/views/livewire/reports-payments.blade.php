<div>
    <h1 class="text-[28px] mb-4">GENERAR REPORTE</h1>

    <!-- Buscador de cliente -->
    <div class="mb-4 flex">
        <div class="flex-grow mr-2">
            <label for="search" class="block text-sm font-medium text-gray-700">Buscar cliente (DNI o RUC)</label>
            <div class="mt-1 flex">
                <input type="text" wire:model="search" id="search" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm" placeholder="Buscar cliente...">
                <button wire:click="searchCustomer" class="px-4 py-3 bg-indigo-600 text-white rounded-md shadow-sm mx-1 hover:bg-blue-700">Buscar</button>
            </div>
        </div>
    </div>

    <!-- Mostrar información del cliente encontrado -->
    @if($selectedCustomer)
        <div class="mb-4 p-4 border border-gray-300 rounded-md">
            <h3 class="text-lg font-medium text-gray-900">Información del Cliente</h3>
            <p><strong>Nombre:</strong> {{ $selectedCustomer->name }}</p>
            <p><strong>DNI/RUC:</strong> {{ $selectedCustomer->dniruc }}</p>
            <p><strong>Correo:</strong> {{ $selectedCustomer->email }}</p>
            <p><strong>Teléfono:</strong> {{ $selectedCustomer->phone }}</p>
        </div>

        <!-- Selección de consulta -->
        <div class="mb-4">
            <label for="consultation_id" class="block text-sm font-medium text-gray-700">Seleccionar consulta</label>
            <select wire:model="consultation_id" id="consultation_id" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm">
                <option value="">Selecciona una consulta</option>
                @foreach($consultations as $consultation)
                    <option value="{{ $consultation->id }}">{{ $consultation->consultation_date }} - {{ $consultation->pet->name }}</option>
                @endforeach
            </select>
        </div>
    @elseif($search && !$selectedCustomer)
        <p class="text-red-600">No se encontró un cliente con ese DNI o RUC.</p>
    @endif

    <!-- Detalles de la consulta seleccionada -->
    @if($selectedConsultation)
        <div class="mb-4 p-4 border border-gray-300 rounded-md">
            <h3 class="text-lg font-medium text-gray-900">Detalles de la Consulta</h3>
            <p><strong>Fecha de Consulta:</strong> {{ $selectedConsultation->consultation_date }}</p>
            <p><strong>Servicio:</strong> {{ $selectedConsultation->service->name }}</p>
            <p><strong>Detalles del Servicio:</strong> {{ $selectedConsultation->service->description }}</p>
            <p><strong>Precio:</strong> ${{ $selectedConsultation->service->price }}</p>
        </div>

        <!-- Botón para generar PDF -->
        <button wire:click="generatePDF" class="px-4 py-2 bg-green-600 text-white rounded-md shadow-sm hover:bg-green-700 mt-4">
            Descargar Reporte en PDF
        </button>
    @endif
</div>
