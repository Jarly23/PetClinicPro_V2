<?php

namespace App\Livewire\Pets;

use Livewire\Component;
use App\Models\Vaccine;
use App\Models\VaccineApplication;
use App\Models\Pet;
use Illuminate\Support\Facades\Auth;

class Vaccines extends Component
{
    public $petId;
    public $vaccineId;
    public $application_date;
    public $notes;
    public $with_deworming = false;

    public $availableVaccines = [];

    public function confirmApplication()
    {
        // Activamos el modal de confirmación
        $this->dispatchBrowserEvent('open-confirmation-modal');
    }
    public function mount($petId)
    {
        $this->petId = $petId;
        $this->application_date = now()->format('Y-m-d');
        $this->availableVaccines = Vaccine::all();
    }

    public function applyVaccine()
    {
        $this->validate([
            'vaccineId' => 'required|exists:vaccines,id',
            'application_date' => 'required|date',
        ]);

        VaccineApplication::create([
            'pet_id' => $this->petId,
            'vaccine_id' => $this->vaccineId,
            'application_date' => $this->application_date,
            'user_id' => Auth::id(), // Veterinario que aplica
            'notes' => $this->notes,
            'with_deworming' => $this->with_deworming,
        ]);

        session()->flash('success', 'Vacuna aplicada correctamente.');

        // Reiniciar campos
        $this->reset(['vaccineId', 'application_date', 'notes', 'with_deworming']);
        $this->application_date = now()->format('Y-m-d');
    }
    public function render()
    {
        $pet = Pet::with('vaccineApplications.vaccine')->findOrFail($this->petId);
        return view('livewire.pets.vaccines', [
            'pet' => $pet,
        ]);
    }
}
