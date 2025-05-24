<?php

namespace App\Livewire\Pets;

use Livewire\Component;
use App\Models\Pet;

class Consultations extends Component
{
    public $petId;
    public $consultations;
    public function mount($petId)
    {
        $this->petId = $petId;
        $this->loadConsultations();
    }
    public function loadConsultations()
    {
        $this->consultations = Pet::with(['consultations.user', 'consultations.services'])
            ->findOrFail($this->petId)
            ->consultations;
    }

    public function render()
    {
        $pet = Pet::findOrFail($this->petId);
        return view('livewire.pets.consultations', [
            'pet' => $pet,
            'consultations' => $this->consultations,
        ]);
    }
}
