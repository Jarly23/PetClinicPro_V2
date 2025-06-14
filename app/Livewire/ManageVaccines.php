<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Vaccine;
use App\Models\Disease;
use App\Models\Product;

class ManageVaccines extends Component
{
    public $vaccine_id, $name, $description, $application_interval_days, $disease_ids = [];
    public $editMode = false;
    public $productosVacuna = [];

    public function mount()
    {
        $this->loadProductosVacuna();
    }

    public function loadProductosVacuna()
    {
        $this->productosVacuna = Product::whereHas('category', function ($q) {
            $q->where('name', 'like', '%Vacunas%');
        })->orderBy('name')->get();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string',
            'application_interval_days' => 'required|integer|min:1',
        ]);

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'application_interval_days' => $this->application_interval_days,
      
        ];

        if ($this->editMode) {
            $vaccine = Vaccine::findOrFail($this->vaccine_id);
            $vaccine->update($data);
        } else {
            $vaccine = Vaccine::create($data);
        }

        $vaccine->diseases()->sync($this->disease_ids);

        $this->resetForm();
        session()->flash('success', 'Vacuna ' . ($this->editMode ? 'actualizada' : 'creada') . ' correctamente.');
    }

    public function edit($id)
    {
        $vaccine = Vaccine::findOrFail($id);
        $this->vaccine_id = $vaccine->id;
        $this->name = $vaccine->name;
        $this->description = $vaccine->description;
        $this->application_interval_days = $vaccine->application_interval_days;
        $this->disease_ids = $vaccine->diseases->pluck('id')->toArray();
    
        $this->editMode = true;
    }

    public function delete($id)
    {
        Vaccine::findOrFail($id)->delete();
        session()->flash('success', 'Vacuna eliminada.');
    }

    public function resetForm()
    {
        $this->reset([
            'vaccine_id',
            'name',
            'description',
            'application_interval_days',
            'disease_ids',

            'editMode'
        ]);
    }


    public function render()
    {
        return view('livewire.manage-vaccines',  [
            'vaccines' => Vaccine::with(['diseases'])->orderBy('name')->get(),
            'diseases' => Disease::orderBy('name')->get(),
        ]);
    }
}
