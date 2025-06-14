<?php

namespace App\Livewire\Pets;

use Livewire\Component;
use App\Models\Vaccine;
use App\Models\VaccineApplication;
use App\Models\Pet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Vaccines extends Component
{
    public $petId;
    public $vaccineId;
    public $application_date;
    public $notes;
    public $with_deworming = false;

    public $availableVaccines = [];

    public function mount($petId)
    {
        $this->petId = $petId;
        $this->application_date = now()->format('Y-m-d');
        $this->availableVaccines = Vaccine::all(); // Ya no se necesita 'with(product)'
    }

    public function applyVaccine()
    {
        $this->validate([
            'vaccineId' => 'required|exists:vaccines,id',
            'application_date' => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            // Ya no se necesita cargar el producto ni verificar stock
            VaccineApplication::create([
                'pet_id' => $this->petId,
                'vaccine_id' => $this->vaccineId,
                'application_date' => $this->application_date,
                'user_id' => Auth::id(),
                'notes' => $this->notes,
                'with_deworming' => $this->with_deworming,
            ]);

            DB::commit();

            session()->flash('success', 'Vacuna aplicada correctamente.');
            $this->reset(['vaccineId', 'application_date', 'notes', 'with_deworming']);
            $this->application_date = now()->format('Y-m-d');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Hubo un error al aplicar la vacuna: ' . $e->getMessage());
        }
    }
    public function render()
    {
        $pet = Pet::with('vaccineApplications.vaccine')->findOrFail($this->petId);
        return view('livewire.pets.vaccines', [
            'pet' => $pet,
        ]);
    }
}
