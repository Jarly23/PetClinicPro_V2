<?php

namespace App\Livewire\Pets;

use Livewire\Component;
use App\Models\AnimalType;
use App\Models\Customer;
use App\Models\Pet;
use Illuminate\Support\Facades\Log;

class Form extends Component
{
    public $open = false;
    public $pet_id, $name, $breed, $weight, $owner_id, $animal_type_id;
    public $birth_date, $sex, $color, $sterilized = false;
    public $owner_found = false;

    protected $listeners = ['editPet', 'deletePet', 'ownerSelected', 'savePet'];

    public function savePet()
    {
        $this->store();
    }

    public function ownerSelected($ownerId)
    {
        Log::debug("Evento ownerSelected recibido con ID: {$ownerId}");
        $this->owner_id = $ownerId;
        $this->owner_found = true;
    }
    public function render()
    {
        return view('livewire.pets.form', [
            'animalTypes' => AnimalType::all(),
            'owners' => Customer::all(),
        ]);
    }
    public function create()
    {
        $this->resetForm();
        $this->open = true;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'sex' => 'required|in:Macho,Hembra',
            'color' => 'nullable|string|max:100',
            'sterilized' => 'boolean',
            'owner_id' => 'required|exists:customers,id',
            'animal_type_id' => 'required|exists:animal_types,id',
        ]);

        $data = $this->only([
            'name',
            'breed',
            'birth_date',
            'sex',
            'color',
            'sterilized',
            'owner_id',
            'animal_type_id',
        ]);

        if ($this->pet_id) {
            Pet::findOrFail($this->pet_id)->update($data);
            session()->flash('message', 'Mascota actualizada.');
        } else {
            Pet::create($data);
            session()->flash('message', 'Mascota registrada.');
        }

        $this->resetForm();
        $this->dispatch('refreshPets');
    }

    public function editPet($petId)
    {
        $pet = Pet::findOrFail($petId);

        $this->pet_id = $pet->id;
        $this->name = $pet->name;
        $this->animal_type_id = $pet->animal_type_id;
        $this->breed = $pet->breed;
        $this->birth_date = $pet->birth_date;
        $this->sex = $pet->sex;
        $this->color = $pet->color;
        $this->sterilized = $pet->sterilized;
        $this->owner_id = $pet->owner_id;

        $this->open = true;
    }

    public function deletePet($petId)
    {
        Pet::findOrFail($petId)->delete();
        session()->flash('message', 'Mascota eliminada exitosamente.');
        $this->dispatch('refreshPetList');
    }

    public function resetForm()
    {
        $this->reset([
            'open',
            'pet_id',
            'name',
            'breed',
            'birth_date',
            'sex',
            'color',
            'sterilized',
            'owner_id',
            'animal_type_id',
        ]);
    }
}
