<div class="px-6 py-4" x-data="{ tab: 'details' }">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Mascota: {{ $pet->name }}</h2>

    <!-- Tabs -->
    <div class="flex space-x-4 border-b mb-4">
        <button class="py-2 px-4 border-b-2" wire:click="setTab('details')" 
                :class="{ 'border-blue-500 font-bold': tab === 'details' }" @click="tab = 'details'">Ficha Médica</button>
        <button class="py-2 px-4 border-b-2" wire:click="setTab('consultations')"
                :class="{ 'border-blue-500 font-bold': tab === 'consultations' }" @click="tab = 'consultations'">Consultas</button>
        <button class="py-2 px-4 border-b-2" wire:click="setTab('vaccines')"
                :class="{ 'border-blue-500 font-bold': tab === 'vaccines' }" @click="tab = 'vaccines'">Vacunas</button>
    </div>

    <!-- Contenido dinámico -->
    <div>
        @if ($tab === 'details')
            @livewire('pets.detail', ['pet' => $pet], key('details-'.$pet->id))
        @elseif ($tab === 'consultations')
            @livewire('pets.consultations', ['petId' => $pet->id])
        @elseif ($tab === 'vaccines')
            @livewire('pets.vaccines', ['petId' => $pet->id])
        @endif
    </div>
</div>
