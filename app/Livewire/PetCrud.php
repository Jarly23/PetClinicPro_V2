<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pet;
use App\Models\Customer;

class PetCrud extends Component
{
    use WithPagination;
    public $open = false;
    public $pet_id, $name, $species, $breed, $age, $weight, $owner_id;

    protected $rules = [
        'name' => 'required|string|max:255',
        'species' => 'required|string|max:255',
        'breed' => 'required|string|max:255',
        'age' => 'required|integer|min:0',
        'weight' => 'required|numeric|min:0',
        'owner_id' => 'required|exists:customers,id',
    ];


    public function render()
    {

        return view('livewire.pet-crud', [
            'pets' => Pet::with('owner')->paginate(10),
            'owners' => Customer::all(), // Lista de propietarios
        ]);

    }
    public function create()
    {
        $this->reset(['name', 'species', 'breed', 'age', 'weight', 'owner_id']);
        $this->open = true;
    }

    public function store()
    {
        $this->validate();
        Pet::create([
            'name' => $this->name,
            'species' => $this->species,
            'breed' => $this->breed,
            'age' => $this->age,
            'weight' => $this->weight,
            'owner_id' => $this->owner_id,
        ]);
        $this->reset(['open', 'name', 'species', 'breed', 'age', 'weight', 'owner_id']);
    }

    public function edit(Pet $pet)
    {
        $this->pet_id = $pet->id;
        $this->name = $pet->name;
        $this->species = $pet->species;
        $this->breed = $pet->breed;
        $this->age = $pet->age;
        $this->weight = $pet->weight;
        $this->owner_id = $pet->owner_id;
        $this->open = true;
    }

    public function update()
    {
        $this->validate();
        Pet::find($this->pet_id)->update([
            'name' => $this->name,
            'species' => $this->species,
            'breed' => $this->breed,
            'age' => $this->age,
            'weight' => $this->weight,
            'owner_id' => $this->owner_id,
        ]);
        $this->reset(['open', 'pet_id', 'name', 'species', 'breed', 'age', 'weight', 'owner_id']);
    }

    public function delete(Pet $pet)
    {
        $pet->delete();
    }
}
