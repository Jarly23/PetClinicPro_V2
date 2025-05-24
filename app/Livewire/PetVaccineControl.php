<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pet;
use App\Models\User;
use App\Models\Vaccine;
use App\Models\VaccineApplication;
use Illuminate\Support\Facades\Auth;

class PetVaccineControl extends Component
{
    public $pet;
    public $vaccine_id, $application_date, $notes , $with_deworming = false;

    public function mount(Pet $pet)
    {
        $this->application_date = now()->format('d-m-Y');
    }
    public function save()
    {
        $this->vadate([
            'vaccine_id' => 'required|exists:vaccines_id',
            'application_date' => 'required|date'
        ]);

        VaccineApplication::created([
            'pet_id' => $this->pet->id,
            'vaccine_id' => $this-> vaccine_id,
            'application_date' => $this->application_date,
            'user_id' => Auth::id(),
            'notes' => $this->notes,
            'with_deworming' => $this -> with_deworming,
        ]);
        $this->reset(['vaccine_id','application_date', 'notes', 'with_deworming']);;
        $this->application_date = now()->format('d-m-Y');
    }
    public function render()
    {
        return view('livewire.pet-vaccine-control',[
            'vaccines' => Vaccine::orderBy('name')->get(),
            'applications' => $this->pet->vaccineApplications()->with('vaccine', 'user')->orderBy('application_date', 'desc')->get(),

        ]);
    }
}
