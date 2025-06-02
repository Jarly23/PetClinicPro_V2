<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AnimalType;

class AnimalTypeCrud extends Component
{
    public $animal_type_id = null;
    public $name;
    public $editing = false;

    protected $rules = [
        'name' => 'required|string|unique:animal_types,name',
    ];

    public function render()
    {
        return view('livewire.animal-type-crud', [
            'types' => AnimalType::orderBy('name')->get()
        ]);
    }

    public function save()
    {
        $this->validate();

        AnimalType::create(['name' => $this->name]);

        $this->resetForm();
        session()->flash('message', 'Tipo de animal registrado.');
    }

    public function edit($id)
    {
        $type = AnimalType::findOrFail($id);
        $this->animal_type_id = $type->id;
        $this->name = $type->name;
        $this->editing = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|unique:animal_types,name,' . $this->animal_type_id,
        ]);

        AnimalType::findOrFail($this->animal_type_id)->update(['name' => $this->name]);

        $this->resetForm();
        session()->flash('message', 'Tipo de animal actualizado.');
    }

    public function delete($id)
    {
        AnimalType::destroy($id);
        session()->flash('message', 'Tipo de animal eliminado.');
    }

    public function resetForm()
    {
        $this->reset(['animal_type_id', 'name', 'editing']);
    }
}

