<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pet;
use App\Models\Customer;
use App\Models\AnimalType;
use Illuminate\Support\Facades\Log;

class PetCrud extends Component
{
    use WithPagination;
    public $open = false;
    public $search = '';
    public $showNewOwnerForm = false;
    public $owner_found = false;
    public $pet_id, $name, $species, $breed, $age, $owner_id, $animal_type_id;
    protected $listeners = ['ownerSelected', 'savePet'];

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

    protected $rules = [
        'name' => 'required|string|max:255',
        'breed' => 'required|string|max:255',
        'age' => 'required|integer|min:0',
        'owner_id' => 'required|exists:customers,id',
        'animal_type_id' => 'required|exists:animal_types,id',
    ];
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $pets = Pet::with(['owner', 'animaltype'])
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhereHas('animaltype', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orWhere('breed', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.pet-crud', [
            'pets' => $pets,
            'owners' => Customer::all(),
            'animalTypes' => AnimalType::all(),
        ]);
    }

    public function searchPets()
    {
        $this->resetPage();
    }
    public function create()
    {
        $this->reset(['name', 'animal_type_id', 'breed', 'age', 'owner_id']);
        $this->open = true;
    }

    public function store()
    {
        $this->validate();

        Pet::create([
            'name' => $this->name,
            'animal_type_id' => $this->animal_type_id,
            'breed' => $this->breed,
            'age' => $this->age,
            'owner_id' => $this->owner_id,
        ]);

        session()->flash('message', 'Mascota registrada exitosamente.');
        $this->reset(['open', 'name', 'animal_type_id', 'breed', 'age', 'owner_id']);
    }
    public function edit(Pet $pet)
    {
        $this->pet_id = $pet->id;
        $this->name = $pet->name;
        $this->animal_type_id = $pet->animal_type_id;
        $this->breed = $pet->breed;
        $this->age = $pet->age;
        $this->owner_id = $pet->owner_id;
        $this->open = true;
    }

    public function update()
    {
        $this->validate();
        Pet::find($this->pet_id)->update([
            'name' => $this->name,
            'animal_type_id' => $this->animal_type_id,
            'breed' => $this->breed,
            'age' => $this->age,
            'owner_id' => $this->owner_id,
        ]);
        session()->flash('message', 'Mascota actualizada exitosamente.');
        $this->reset(['open', 'pet_id', 'name', 'animal_type_id', 'breed', 'age', 'owner_id']);
    }

    public function delete(Pet $pet)
    {
        $pet->delete();
    }
    public function createNewOwner()
    {
        $this->validate([
            'new_owner_name' => 'required|string|max:255',
            'new_owner_email' => 'required|email|unique:customers,email',
            'new_owner_phone' => 'required|string|max:255',
        ]);

        $owner = Customer::create([
            'name' => $this->new_owner_name,
            'email' => $this->new_owner_email,
            'phone' => $this->new_owner_phone,
        ]);

        $this->owner_id = $owner->id;
        $this->owner_found = true;
        $this->showNewOwnerForm = false;
    }
}
