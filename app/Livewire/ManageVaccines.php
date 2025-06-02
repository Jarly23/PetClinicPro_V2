<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Vaccine;
use App\Models\Disease;

class ManageVaccines extends Component
{
        public $vaccine_id, $name, $description, $application_interval_days, $disease_ids = [];
    public $editMode = false;

    public function save()
    {
        $this->validate([
            'name' => 'required|string',
            'application_interval_days' => 'required|integer|min:1',
        ]);

        if ($this->editMode) {
            $vaccine = Vaccine::find($this->vaccine_id);
            $vaccine->update([
                'name' => $this->name,
                'description' => $this->description,
                'application_interval_days' => $this->application_interval_days,
            ]);
        } else {
            $vaccine = Vaccine::create([
                'name' => $this->name,
                'description' => $this->description,
                'application_interval_days' => $this->application_interval_days,
            ]);
        }

        $vaccine->diseases()->sync($this->disease_ids);

        $this->resetForm();
    }

    public function edit($id)
    {
        $vaccine = Vaccine::find($id);
        $this->vaccine_id = $vaccine->id;
        $this->name = $vaccine->name;
        $this->description = $vaccine->description;
        $this->application_interval_days = $vaccine->application_interval_days;
        $this->disease_ids = $vaccine->diseases->pluck('id')->toArray();
        $this->editMode = true;
    }

    public function delete($id)
    {
        Vaccine::find($id)->delete();
    }

    public function resetForm()
    {
        $this->reset([
            'vaccine_id', 'name', 'description', 'application_interval_days', 'disease_ids', 'editMode'
        ]);
    }

    public function render()
    {
        return view('livewire.manage-vaccines', [
            'vaccines' => Vaccine::with('diseases')->orderBy(column: 'name')->get(),
            'diseases' => Disease::orderBy('name')->get(),
        ]);
    }
}
